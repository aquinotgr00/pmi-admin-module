<?php

namespace BajakLautMalaka\PmiAdmin\Http\Controllers;

use BajakLautMalaka\PmiAdmin\Admin;
use BajakLautMalaka\PmiAdmin\Privilege;
use BajakLautMalaka\PmiAdmin\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use BajakLautMalaka\PmiAdmin\Http\Requests\StoreUser;
use BajakLautMalaka\PmiAdmin\Http\Requests\UpdateUser;

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
    public function show($id)
    {
        $admin = Admin::find($id);
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
        $request->validated();
        $user = Admin::create($request->only(['name', 'email', 'password', 'role_id']));
        $user->privileges()->createMany($request->privilege);
        return redirect_success('users.index', 'Success', "User {$user->name} created!");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\Admin\Http\Requests\UpdateUser  $request
     * @param  \Modules\Admin\Admin  $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateUser $request, Admin $user)
    {
        //$this->authorize('update', $user);
        $request->validated();
        $user->fill($request->except('password'));
        if ($request->filled('password')) {
            $user->password = $request->password;
        }
        $user->save();
        if (Gate::allows('edit-user-privileges', $user)) {
            if ($request->has('privilege')) {
                $user->privileges()->delete();
                $user->privileges()->createMany($request->privilege);
            }
        }
        return redirect_success('users.index', 'Success', "User {$user->name} updated!");
    }
    
    /**
     * Update status the specified resource in storage.
     *
     * @param  \Modules\Admin\Admin  $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function statusUpdate(Admin $user)
    {
        $this->authorize('statusUpdate', $user);
        $user->active = !(bool)$user->active;
        $user->save();
        $successMessage = 'User '."{$user->name} ".($user->active?'enabled':'disabled').'!';
        return redirect_success('users.index', 'Success', $successMessage);
    }
}
