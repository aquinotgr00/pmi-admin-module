<?php

namespace BajakLautMalaka\PmiAdmin\Http\Controllers;

use BajakLautMalaka\PmiAdmin\Admin;
use BajakLautMalaka\PmiAdmin\Privilege;
use BajakLautMalaka\PmiAdmin\Role;
use BajakLautMalaka\PmiAdmin\Http\Requests\StoreUser;
use BajakLautMalaka\PmiAdmin\Http\Requests\UpdateUser;
use BajakLautMalaka\PmiAdmin\Mail\ResetPasswordRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


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
            $resetToken = Str::uuid();
            DB::table('password_resets')->insert([
                'email'=>$admin->email,
                'token'=>$resetToken,
                'created_at'=> \Carbon\Carbon::now()
            ]);
            Mail::to($request->email)->send(new ResetPasswordRequest($resetToken));
            return response()->success(['email'=>$request->email]);
        }
        return response()->fail(['email'=>$request->email]);
    }
}
