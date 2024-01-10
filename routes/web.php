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

/*
|--------------------------------------------------------------------------
| NGƯỜI DÙNG
|--------------------------------------------------------------------------
*/

//Trang chủ
Route::get('/','App\Http\Controllers\HomeController@index'); 
Route::get('/trang-chu', 'App\Http\Controllers\HomeController@index'); 

//UserSys: Người dùng hệ thống
//--Đăng nhập
Route::get('/dang-nhap', 'App\Http\Controllers\UserSysController@login'); 
Route::get('/dang-xuat', 'App\Http\Controllers\UserSysController@logout'); 
Route::post('/kiem-tra-dang-nhap', 'App\Http\Controllers\UserSysController@login_check'); 

//--Đăng ký
Route::get('/dang-ky', 'App\Http\Controllers\UserSysController@u_create'); 
Route::post('/kiem-tra-dang-ky', 'App\Http\Controllers\UserSysController@u_store');