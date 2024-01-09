<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/','App\Http\Controllers\HomeController@index'); 
Route::get('/trang-chu', 'App\Http\Controllers\HomeController@index'); 

Route::get('/dang-nhap', 'App\Http\Controllers\HomeController@login'); 
Route::get('/dang-ky', 'App\Http\Controllers\HomeController@register'); 