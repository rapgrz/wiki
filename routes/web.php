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
/*Route::resource('posts', 'PostsController');*/
Route::get('/posts/edit/{post_id}', 'PostsController@edit')->name('post_edit');
Route::post('/posts/delete/{post_id}', 'PostsController@destroy')->name('post_delete');
Route::post('/posts/post_update/{post_id}}', 'PostsController@update')->name('post_update');
Route::resource('categories', 'CategoryController');
Route::get('/posts', 'PostsController@index')->name('posts');
Route::get('/create_post', 'PostsController@create_post')->name('create_post');
Route::post('create_post/save', 'PostsController@savePost')->name('save_post');
Route::get('/categories', 'CategoryController@index')->name('categories');
Route::post('/categories/save', 'CategoryController@saveCategory')->name('saveCategory');

