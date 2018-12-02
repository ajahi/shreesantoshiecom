<?php

Route::group(['module' => 'User', 'middleware' => ['cors','api','auth:api'], 'prefix'=>'api', 'namespace' => 'App\Modules\User\Controllers'], function() {

    Route::resource('user', 'UserController');
    Route::resource('role', 'RoleController');
    Route::resource('permission', 'PermissionController');

});