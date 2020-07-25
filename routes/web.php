<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', 'PostController@Index')->name('home');

Auth::routes(['register' => false]);

Route::middleware('auth')->group(function(){
	Route::get('posts/draft', 'PostController@Draft')->name('posts.draft');
	Route::get('posts/publish/{id}', 'PostController@Publish')->name('posts.publish');
	Route::get('post/{slug}', 'PostController@View')->name('posts.view');
	Route::get('posts/create', 'PostController@Create')->name('posts.create');
	Route::post('posts/store', 'PostController@Store')->name('posts.store');
	Route::get('posts/edit/{id}', 'PostController@Edit')->name('posts.edit');
	Route::get('posts/delete/{id}', 'PostController@Delete')->name('posts.delete');
});