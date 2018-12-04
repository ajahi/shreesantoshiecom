<?php


Route::group(['module' => 'Category', 'prefix'=>'api','middleware' => ['cors'], 'namespace' => 'App\Modules\Category\Controllers'], function() {

    Route::get('/category', 'CategoryController@index');
    Route::get('/category/{id}', 'CategoryController@show');



});


Route::group(['module' => 'Category', 'prefix'=>'api','middleware' => ['cors','api','auth:api'], 'namespace' => 'App\Modules\Category\Controllers'], function() {

    Route::resource('category', 'CategoryController', array('except' => array('index','show')));

});

