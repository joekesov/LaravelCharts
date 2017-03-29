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

Route::get('/', 'Web\DeviceController@index');

Route::get('/device', 'Web\DeviceController@create');

Route::post('/device', 'Web\DeviceController@store');

Route::get('/devices', 'Web\DeviceController@index');

Route::get('/device/{code?}', 'Web\DeviceController@show');

Route::get('/device/{code?}/edit','Web\DeviceController@edit');

Route::post('/device/{code?}/edit','Web\DeviceController@update');

Route::post('/device/{code?}/delete','Web\DeviceController@destroy');

//Route::get('api/v1/device/{code?}', 'Api\DeviceController@show');

Route::group(array('prefix' => 'api/v1'), function()
{
    Route::resource('device', 'Api\DeviceController', [
        'only' => ['show'],
        'parameters' => [
            'device' => 'code'
        ]
    ]);
});