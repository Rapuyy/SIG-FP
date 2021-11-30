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

Route::get('/map', function () {
    return view('map');
});
Route::get('/', 'MapController@index')->name('index');
Route::get('/getMapData', 'MapController@getMapData')->name('map.get');
Route::post('/store', 'MapController@store')->name('map.add');
// Route::get('{id}/edit', 'MapController@edit')->name('edit');
// Route::put('update', 'MapController@update')->name('update');
// Route::get('{id}/delete', 'MapController@delete')->name('delete');
// Route::post('/contact-form', 'ContactController@store');
// Route::get('/contact-form', 'ContactController@create');

// Route::get('/', function)
// Route::get('/pegawai', 'PegawaiController@index');
// Route::get('/pegawai/cari', 'PegawaiController@cari');