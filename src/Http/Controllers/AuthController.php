<?php

namespace BajakLautMalaka\PmiAdmin\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    use AuthenticatesUsers;
    
    /**
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    protected function guard()
    {
        return Auth::guard('admin-web');
    }
    
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return response()->fail(['account' => 'Account Locked']);
        }

        if ($this->guard()->validate($this->credentials($request))) {
            //show privilege name
            $admin = $this->guard()->getLastAttempted();
            foreach ($admin->privileges as $key => $value) {
                $value->privilege->name;
            }

            // Make sure the user is active
            if ($admin->active && $this->attemptLogin($request)) {
                // Send the normal successful login response
                Auth::logout();
                return response()->success([
                    'token'=>$admin->createToken('PMI')->accessToken,
                    'profile'=> $admin
                ]);
            }
            
            // Increment the failed login attempts and redirect back to the
            // login form with an error message.
            $this->incrementLoginAttempts($request);
            return response()->fail(['account' => 'Account disabled']);
        }

        $this->incrementLoginAttempts($request);
        return response()->fail(['account' => 'Invalid credentials']);
    }
    
    public function logout(Request $request)
    {
        if($request->user()->token()->revoke()) {
            return response()->success([]);
        }
        else {
            return response()->fail([]);
        }
    }
}
