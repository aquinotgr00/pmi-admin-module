<?php
    Route::post('admin/login', 'AuthController@login');
    Route::get('admin/forgot_password','UserController@passwordReset');
    
    Route::middleware('auth:admin')->group(function() {
        Route::get('admin/logout', 'AuthController@logout');
    
        Route::apiResource('admin','UserController');
        Route::put('admin/{id}/{status}','UserController@statusUpdate');
        Route::put('admin/password','UserController@passwordUpdate');
        
    });
            
    
    
    