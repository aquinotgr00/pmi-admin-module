<?php

namespace BajakLautMalaka\PmiAdmin\Http\Controllers;

use BajakLautMalaka\PmiAdmin\Admin;
use BajakLautMalaka\PmiAdmin\Privilege;
use BajakLautMalaka\PmiAdmin\Role;
use BajakLautMalaka\PmiAdmin\Http\Requests\StoreUser;
use BajakLautMalaka\PmiAdmin\Http\Requests\UpdateUser;
use BajakLautMalaka\PmiAdmin\Jobs\SendResetPasswordEmailToAdmin;
use BajakLautMalaka\PmiAdmin\Jobs\SendWelcomeEmailToAdmin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(Request $request,Admin $admin)
    {

        $admin     = $this->handleSearch($request, $admin);
        $admin     = $admin->where('email', '<>', 'admin@mail.com');
        $admin     = $admin->with('role');
        $admins    = $admin->paginate(15);
        
        return response()->success(compact('admins'));
    }

    private function handleSearch(Request $request, Admin $admin)
    {
        if ($request->has('s')) {
            $admin = $admin->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->s . '%')
                ->orWhere('email', 'like', '%' . $request->s . '%');
            });
        }
        return $admin;
    }

    /**
     * Display a resource.
     *
     * @return \Illuminate\View\View
     */
    public function show(Admin $user)
    {
        return response()->success(compact('user'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Modules\Admin\Http\Requests\StoreUser  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreUser $request)
    {   
        $user = Admin::create($request->only(['name', 'email', 'password', 'role_id']));
        $user = $this->handleStorePrivileges($request,$user);

        SendWelcomeEmailToAdmin::dispatch((object) $request->only(['name', 'email', 'password']));
        
        return response()->success(compact('user'));
    }

    private function handleStorePrivileges(Request $request, $user)
    {
        if ($request->has('privileges')) {
            
            $privileges =  collect($request->privileges);
            $privileges = $privileges->filter(function ($value) {
                return !is_null($value);
            });

            $privileges = $privileges->toArray();
            
            $user->privileges()->createMany($privileges);
            $user->privileges;            
        }
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \BajakLautMalaka\PmiAdmin\Admin  $admin
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function update(UpdateUser $request, Admin $user)
    {

        //$this->authorize('update', $user);
        $user->fill($request->except('password'));
        if ($request->filled('password')) {
            $user->password = $request->password;
        }
        
        $user->save();
        /*
        if (Gate::allows('edit-user-privileges', $user)) {
            if ($request->has('privilege')) {
                $user->privileges()->delete();
                $user->privileges()->createMany($request->privilege);
            }
        }
        */
        return response()->success(compact('user'));
    }
    
    /**
     * Update status the specified resource in storage.
     *
     * @param  \BajakLautMalaka\PmiAdmin\Admin  $user
     * @return array
     */
    public function statusUpdate(Admin $user, string $status)
    {
        $user->active = $status==='enable';
        $user->save();
        return response()->success($user);
    }
    
    public function passwordUpdate(Request $request) {
        $request->validate(['password'=>'required|confirmed']);
        $admin = $request->user();
        $admin->password = $request->password;
        $admin->save();
        return response()->success(compact('admin'));
    }
    
    public function requestPasswordReset(Request $request) {
        $request->validate(['email'=>['required','email']]);
        $admin = Admin::where('email',$request->email)->first();
        if($admin) {
            SendResetPasswordEmailToAdmin::dispatch($request->email);
            return response()->success(['email'=>$request->email]);
        }
        return response()->fail(['email'=>$request->email]);
    }
}
