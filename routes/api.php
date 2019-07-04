<?php
    Route::prefix('admin')->group(function() {
        Route::post('login', 'AuthController@login');
        Route::get('forgot_password','UserController@passwordReset');
    });
    
    Route::middleware(['auth:admin','bindings'])->group(function() {
        Route::put('admin/password','UserController@passwordUpdate');
        Route::get('admin/logout', 'AuthController@logout');
        Route::put('admin/{user}/{status}','UserController@statusUpdate');
        
        Route::apiResource('admin','UserController');
        
    });
    
    
    