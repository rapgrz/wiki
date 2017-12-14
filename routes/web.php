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
Route::get('/posts/edit/{post_id}', 'PostsController@edit')->name('post_edit');
Route::post('/posts/delete/{post_id}', 'PostsController@destroy')->name('post_delete');
Route::post('/posts/post_update/{post_id}', 'PostsController@update')->name('post_update');
Route::get('/categories/edit/{category_id}', 'CategoryController@edit')->name('category_edit');
Route::post('/categories/delete/{category_id}', 'CategoryController@destroy')->name('category_delete');
Route::post('/categories/update/{category_id}', 'CategoryController@update')->name('category_update');
Route::post('/posts/search', 'PostsController@search')->name('post_search');
Route::get('/posts', 'PostsController@index')->name('posts');
Route::get('/create_post', 'PostsController@create_post')->name('create_post');
Route::post('create_post/save', 'PostsController@savePost')->name('save_post');
Route::get('/categories', 'CategoryController@index')->name('categories');
Route::post('/categories/save', 'CategoryController@saveCategory')->name('saveCategory');
Route::get('/posts/search/category/{category_id}', 'PostsController@search_category')->name('search_category');
Route::get('/post/{post_id}', 'PostsController@postShow')->name('postShow');
Route::post('/post/{post_id}/comment', 'PostsController@addComment')->name('addComment');
Route::post('/post/comment/{comment_id}', 'PostsController@destroyComment')->name('destroyComment');
Route::get('/posts/edit/comment/{comment_id}', 'PostsController@editComment')->name('editComment');
Route::post('/posts/commentUpdate/{comment_id}', 'PostsController@updateComment')->name('updateComment');
Route::get('/users', 'UsersController@index')->name('users');
Route::post('/users/delete/{user_id}', 'UsersController@userDelete')->name('userDelete');
Route::get('/users/edit/{user_id}', 'UsersController@userEdit')->name('userEdit');
Route::post('/users/update/{user_id}', 'UsersController@userUpdate')->name('userUpdate');

