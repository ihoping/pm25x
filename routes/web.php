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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'HomeController@index')->name('home');

Route::get('/news', 'NewsController@index');

Route::get('/news/{id?}', 'NewsController@detail');

Route::get('/rank/{type?}', 'RankController@index');

Route::get('/visual', 'VisualController@index');

Route::post('/changeArea', 'HomeController@changeArea')->name('changeArea');
Route::post('/checkArea', 'HomeController@checkArea')->name('checkArea');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::post('/Info/area_plus', 'InfoController@areaPlus')->name('areaPlus');
