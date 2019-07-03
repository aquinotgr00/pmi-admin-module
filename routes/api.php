<?php
    Route::post('login', 'AuthController@login')->name('login.admin.api');
    
    Route::middleware('auth:admin')->get('logout', 'AuthController@logout')->name('logout.admin.api');