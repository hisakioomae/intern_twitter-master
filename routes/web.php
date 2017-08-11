<?php

/*
|--------------------------------------------------------------------------
| Webルート
|--------------------------------------------------------------------------
|
| ここでアプリケーションのWebルートを登録できます。"web"ルートは
| ミドルウェアのグループの中へ、RouteServiceProviderによりロード
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('home', 'HomeController@index')->name('home');
    Route::post('home', 'HomeController@tweet')->name('home.tweet');
});


Route::get('account', 'AccountController@account')->name('account');
Route::put('account', 'AccountController@update')->name('account');

Route::get('profile', 'UserController@profile')->name('profile');
Route::put('profile', 'UserController@update');


Route::get('search', 'MockController@search')->name('search');

Route::get('user', 'MockController@user')->name('user');

Route::get('following', 'FollowingController@following')->name('following');
Route::get('following/{users}', 'FollowingController@following')->name('following.user');


Route::get('followers', 'MockController@followers')->name('followers');


