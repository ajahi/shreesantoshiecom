<?php

Route::group(['module' => 'Site', 'prefix'=>'api','middleware' => ['cors'], 'namespace' => 'App\Modules\Site\Controllers'], function() {

    Route::get('/site', 'SiteController@index');
});


Route::group(['module' => 'Site', 'prefix'=>'api','middleware' => ['cors','api','auth:api'], 'namespace' => 'App\Modules\Site\Controllers'], function() {

    Route::resource('site', 'SiteController', array('except' => array('index','show','update','destroy')));

});
