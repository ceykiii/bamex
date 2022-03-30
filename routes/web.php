<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/roles', function (Request $request){
    dd(Auth::user());
    //Auth::logout();
                //Auth::attempt(['email' => "harsukh21@gmail.com", 'password' => "harsukh21"]);
});
Route::namespace('Admin')->prefix('admin')->group(function(){
    Route::get('/login','LoginController@index')->name("logout");
    Route::post('/login-attempt','LoginController@loginAttempt')->name("login.attempt");
    Route::group(['middleware' => 'role:admin'], function() {
        Route::get('/dashboard','DashboardController@index')->name("admin.dashboard");
        Route::get('/user_add','UserController@addUser')->name("admin.user.add");
        Route::post('/user_add_post','UserController@addUserPost')->name("admin.user.add.post");
        Route::get('/user_list','UserController@userList')->name("admin.user.list");
        Route::get('/user_add_post','UserController@userData')->name("admin.user.data");
        Route::get('/user_edit/{id}','UserController@userEdit')->name("admin.user.edit");
        Route::post('/user_edit_post','UserController@userEditPost')->name("admin.user.edit.post");
        Route::get('/user_change_password','UserController@userChangePassword')->name("admin.user.change.password");
        Route::post('/user_change_password_post','UserController@userChangePasswordPost')->name("admin.user.change.password.post");

    });
});
