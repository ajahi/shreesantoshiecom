<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware' => ['cors']], function() {
    Route::post('/login', 'Api\LoginController@login');
    Route::get('/site', 'Site@index');
    Route::get('/post', 'Post@index');
    Route::get('/post/{id}', 'Post@show');
    Route::get('/category', 'Category@index');
    Route::get('/category/{id}', 'Category@show');
    Route::get('/menu', 'Menu@index');
    Route::get('/menu/{id}', 'Menu@show');

});


Route::group(['middleware' => ['cors','auth:api']], function() {

    Route::get('/logout', 'Api\LoginController@logout');
    Route::get('/auth/user', 'Api\LoginController@user');
    Route::resource('site', 'Site', array('except' => array('index','show','update','destroy')));
    Route::resource('user', 'User');
    Route::resource('role', 'Role');
    Route::resource('permission', 'Permission');
    Route::resource('post', 'Post', array('except' => array('index','show')));
    Route::resource('category', 'Category', array('except' => array('index','show')));
    Route::resource('menu', 'Menu', array('except' => array('index','show')));
    Route::post('/post/uploads', 'Post@uploads');
    Route::get('/media/{id}/{mediaID}', 'Post@deleteMedia');
    Route::post('/gallery/uploads', 'Site@uploadsGallery');
    Route::get('/gallery/{id}/{mediaID}', 'Site@deleteMediaGallery');
    Route::post('/site/upload', 'Site@uploadMedia');
    Route::post('/site/media/delete', 'Site@deleteMedia');

});
