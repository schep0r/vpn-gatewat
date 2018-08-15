<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/companies', 'CompanyController@index');
Route::post('/companies', 'CompanyController@store');
Route::put('/companies/{id}', 'CompanyController@update');
Route::delete('/companies/{id}', 'CompanyController@destroy');
