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
/*
Route::get('/', function () {
    return view('welcome');
});
*/
//wechat
Route::any('/wechat', 'WeChatController@serve');
Route::any('/weixinmini', 'WeChatController@weixinmini')->name('weixinmini');


//wechat

//ciba
Route::get('/query/{word}', 'WordController@query')->name('query');
Route::get('/googlespeech', 'WordController@googlespeech')->name('googlespeech');
Route::get('/baiduspeech', 'WordController@baiduspeech')->name('baiduspeech');

Route::post('/search', 'WordController@search')->name('search');


Route::get('/ciba', 'PaChongController@ciba')->name('ciba');

Route::get('/ciba/list', 'PaChongController@list')->name('cibalist');
//Route::get('/cibadb', 'PaChongController@cibadb')->name('cibadb');
Route::get('/crawl/{word}', 'PaChongController@crawl')->name('crawl');

//endciba
Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

Route::get('signup', 'UsersController@create')->name('signup');

Route::resource('users', 'UsersController');

Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');

Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');

Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');
