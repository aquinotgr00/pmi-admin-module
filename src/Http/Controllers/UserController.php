<?php

namespace BajakLautMalaka\PmiAdmin\Http\Controllers;

use BajakLautMalaka\PmiAdmin\Admin;
use BajakLautMalaka\PmiAdmin\Privilege;
use BajakLautMalaka\PmiAdmin\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use BajakLautMalaka\PmiAdmin\Http\Requests\StoreUser;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        //$this->authorize('index', Auth::user());
        
        $admins  = Admin::where('email', '<>', 'admin@mail.com')->paginate(15);
        
        return response()->success(compact('admins'));
    }

    /**
     * Display a resource.
     *
     * @return \Illuminate\View\View
     */
    public function show(Admin $admin)
    {
        return response()->success(compact('admin'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Modules\Admin\Http\Requests\StoreUser  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreUser $request)
    {
        //$this->authorize('create', Auth::user());
        $user = Admin::create($request->only(['name', 'email', 'password', 'role_id']));
        //$user->privileges()->createMany($request->privilege);
        return response()->success(compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \BajakLautMalaka\PmiAdmin\Admin  $admin
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function update(Admin $admin, Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>[
                'required',
                'email',
                Rule::unique('admins')->ignore($admin->id),
            ],
            'password'=>'sometimes|nullable|confirmed',
        ]);
        //$this->authorize('update', $user);
        $admin->fill($request->except('password'));
        if ($request->filled('password')) {
            $admin->password = $request->password;
        }
        $admin->save();
        /*
        if (Gate::allows('edit-user-privileges', $user)) {
            if ($request->has('privilege')) {
                $user->privileges()->delete();
                $user->privileges()->createMany($request->privilege);
            }
        }
        */
        return response()->success(compact('admin'));
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
        $request->validate([
            'password'=>'required|confirmed',
        ]);
        $admin = $request->user();
        $admin->password = $request->password;
        $admin->save();
        return response()->success(compact('admin'));
    }
    
    public function passwordReset(Request $request) {
        
    }
}
