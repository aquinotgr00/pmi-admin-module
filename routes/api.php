<?php
    Route::prefix(config('admin.prefix', 'admin'))->group(function() {
        Route::post('login', 'AuthController@login');
        Route::get('forgot_password','UserController@requestPasswordReset');

        Route::middleware('auth:admin')->group(function() {
            Route::put('users/password','UserController@passwordUpdate');
            Route::get('logout', 'AuthController@logout');
            Route::put('users/{user}/{status}','UserController@statusUpdate');

            Route::apiResource('users','UserController');

            Route::prefix('grant')->group(function() {
                Route::apiResource('categories','PrivilegeCategoryController');
                Route::apiResource('privileges','PrivilegeController');
                Route::apiResource('roles','RolesController');
                Route::apiResource('rolesprivileges','RolePrivilegeController');
                Route::apiResource('adminprivileges','AdminPrivilegeController');
            });
            
        });
    });

    Route::prefix('app')->group(function() {
        Route::middleware('auth:api')->group(function() {
            Route::get('logout', 'AuthController@logout');
        });
    });
    