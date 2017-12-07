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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/posts', 'PostsController@index')->name('posts');
Route::get('/create_post', 'PostsController@create_post')->name('create_post');
Route::post('create_post/save', 'PostsController@savePost')->name('save_post');
Route::get('/categories', 'CategoryController@index')->name('categories');
Route::post('/categories/save', 'CategoryController@saveCategory')->name('saveCategory');
Route::get('/posts/delete', 'PostsController@deletePost')->name('deletePost');

