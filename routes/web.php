<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Auth;

Route::get('/', 'Api\LoginController@login');

Route::get('/test',function(){
    return "this is test";
});
Route::get('/post', 'PostController@page');
Route::post('/login', 'Api\LoginController@login');
Route::post('/posts', 'PostController@store');
Route::get('/postcreate','PostController@create');
Route::get('/postshow','PostController@show');
Route::get('post/{id}','PostController@edit');
Route::put('post/{id}','PostController@update');
Route::delete('postdel/{id}','PostController@destroy');
// Route::post('/logout','Auth\LoginController@logout');

Route::get('/category','CategoryController@index');
Route::get('/categorycreate','CategoryController@create');
Route::post('/category','CategoryController@store');
Route::get('/category/{id}','CategoryController@edit');
Route::put('/category/{id}','CategoryController@update');
Route::delete('/categorydel/{id}','CategoryController@destroy');



Route::middleware('auth')->group(function(){
    Route::post('/category','CategoryController@store');

});
// Route::group(['middleware' => ['cors']], function() {
//     Route::post('/login', 'Api\LoginController@login');
//     Route::get('/site', 'SiteController@index');
//     Route::get('/post', 'PostController@index');
//     Route::get('/post/categories','PostController@getTitleByCategories');
//     Route::get('/post/quicklink','PostController@getPostByKeyIfTrue');
//     Route::get('/post/{id}', 'PostController@show');
//     Route::get('/post/slug/{slug}', 'PostController@slug');
//     Route::get('/category', 'CategoryController@index');
//     Route::get('/category/{id}', 'CategoryController@show');
//     Route::get('/menu', 'MenuController@index');
//     Route::get('/menu/{id}', 'MenuController@show');
//     Route::get('/tag','TagController@index');
//     Route::get('/tag/{id}','TagController@show');
//     Route::get('/slider','SliderController@index');
//     Route::get('/slider/{id}','SliderController@show');


// });

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
