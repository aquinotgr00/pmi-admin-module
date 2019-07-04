<?php
    Route::post('admin/login', 'AuthController@login');
    
    Route::middleware('auth:admin')->get('admin/logout', 'AuthController@logout');
    Route::get('admin/{id}','UserController@show');
    Route::get('admin','UserController@index');
    
    