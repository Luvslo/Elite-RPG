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

Route::get('docs', function() {
    return view('docs');
});

Route::get('chat', function() {
    return view('chat');
})->middleware('auth');

Auth::routes();

Route::get('home', 'HomeController@index')->name('home');

Route::get('messages', 'MessageController@index');
Route::post('messages', 'MessageController@store');

Route::get('map', 'MapController@index')->name('map');
Route::get('loadmap', 'MapController@show');
Route::get('maps', 'MapController@map')->name('maps');

Route::get('/tmap', function() {
    return view('world.tmap');
});

Route::get('mobs/{id}/{x}/{y}', 'MobController@index');
