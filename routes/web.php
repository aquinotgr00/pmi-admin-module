<?php
    
    Route::get('reset-password/{token}', function(string $token) {
        return view('admin::auth.admin.reset-password', compact('token'));
    })->name('admin.reset.password');

    Route::post('reset-password/{token}',function($token) {
        request()->validate(['password'=>'required|confirmed']);
        $resetPassword = DB::table('password_resets')->where('token',$token)->first();
        if($resetPassword->email) {
            $admin = BajakLautMalaka\PmiAdmin\Admin::where('email',$resetPassword->email)->first();
            $admin->password = request()->password;
            if($admin->save()) {
                DB::table('password_resets')->where('token',$token)->delete();
            }
        }
        return $token;
    });
    
    
    
    Route::get('email/preview', function() {
        return new BajakLautMalaka\PmiAdmin\Mail\ResetPasswordRequest(Str::uuid());
    });