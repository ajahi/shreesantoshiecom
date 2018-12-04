<?php

Route::group(['module' => 'Post', 'prefix'=>'api','middleware' => ['cors'], 'namespace' => 'App\Modules\Post\Controllers'], function() {

    Route::get('/post', 'PostController@index');
    Route::get('/post/{id}', 'PostController@show');



});


Route::group(['module' => 'Post', 'prefix'=>'api','middleware' => ['cors','api','auth:api'], 'namespace' => 'App\Modules\Post\Controllers'], function() {

    Route::resource('post', 'PostController', array('except' => array('index','show')));

});
