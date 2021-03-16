<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 
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

Route::group(['middleware' => 'lang_check'], function(){
  Auth::routes();
  
  Route::group(['middleware' => ['auth']], function(){
    // home page
    Route::get('/', 'HomeController@index')->name('home');
    
    // users
    Route::prefix('users')->group(function(){
      Route::match(['get', 'post'], '/', 'UsersController@index')->name('users.index');
      Route::get('/{id}', 'UsersController@show')->name('users.show');
      Route::get('/edit/{id}', 'UsersController@edit')->name('users.edit');
      Route::post('/edit/{id}/update', 'UsersController@update')->name('users.update');
      
      //follow
      Route::post('{id}/follow', 'UserFollowController@store')->name('follow');
      Route::delete('{id}/unfollow', 'UserFollowController@delete')->name('unfollow');
    });
    
    //mutter
    Route::prefix('mutter')->group(function(){
      Route::get('/', 'MuttersController@index')->name('mutters.index');
      Route::post('store', 'MuttersController@store')->name('mutters.store');
      Route::get('edit/{id}', 'MuttersController@edit')->name('mutters.edit');
      Route::post('update/{id}', 'MuttersController@update')->name('mutters.update');
      Route::delete('delete/{id}', 'MuttersController@delete')->name('mutters.delete');
      // like , unlike
      Route::post('like/{id}', 'MuttersController@like_mutter')->name('mutters.like');
      Route::delete('unlike/{id}', 'MuttersController@unlike_mutter')->name('mutters.unlike');
    });
    
    // group
    Route::prefix('groups')->group(function() {
      Route::get('/', 'GroupController@index')->name('groups.index');
      Route::get('show/{id}', 'GroupController@show')->name('groups.show');
      // create group
      Route::get('create', function (){
        return view('groups.create');
      })->name('groups.create');
      Route::post('store','GroupController@store')->name('groups.store');
      // 
      Route::get('edit/{id}', 'GroupController@edit')->name('groups.edit');
      Route::post('update/{id}', 'GroupController@update')->name('groups.update');
      Route::delete('delete/{id}', 'GroupController@delete')->name('groups.delete');
      // join / exit 
      Route::post('join/{id}/{gid}', 'GroupController@join')->name('groups.join');
      Route::delete('exit/{id}/{gid}', 'GroupController@exit')->name('groups.exit');
      // chat
      Route::get('talk/{id}', 'GroupController@talk')->name('groups.talk');
      Route::post('chat/{id}', 'ChatController@store')->name('chat.store');
      Route::delete('chat/delete/{id}', 'ChatController@delete')->name('chat.delete');
    }); 
  });
});