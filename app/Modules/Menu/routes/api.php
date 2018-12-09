<?php


Route::group(['module' => 'Menu', 'prefix'=>'api','middleware' => ['cors'], 'namespace' => 'App\Modules\Menu\Controllers'], function() {

    Route::get('/menu', 'MenuController@index');
    Route::get('/menu/{id}', 'MenuController@show');



});


Route::group(['module' => 'Menu', 'prefix'=>'api','middleware' => ['cors','api','auth:api'], 'namespace' => 'App\Modules\Menu\Controllers'], function() {

    Route::resource('menu', 'MenuController', array('except' => array('index','show')));

});
