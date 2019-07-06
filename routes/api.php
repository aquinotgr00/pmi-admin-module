<?php
    
    Route::post('login', 'AuthController@login');
    Route::get('forgot_password','UserController@requestPasswordReset');
    
    Route::middleware('auth:admin')->group(function() {
        Route::put('users/password','UserController@passwordUpdate');
        Route::get('logout', 'AuthController@logout');
        Route::put('users/{user}/{status}','UserController@statusUpdate');
        
        Route::apiResource('users','UserController');
        
    });
    
    
    