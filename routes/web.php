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

//Home
//--Trang chủ
Route::get('/','App\Http\Controllers\HomeController@index'); ///ok
Route::get('/trang-chu', 'App\Http\Controllers\HomeController@index'); ///ok


//UserSys: Người dùng hệ thống
//--Đăng nhập
Route::get('/dang-nhap', 'App\Http\Controllers\UserSysController@login'); ///ok
Route::get('/dang-xuat', 'App\Http\Controllers\UserSysController@logout'); ///ok
Route::post('/kiem-tra-dang-nhap', 'App\Http\Controllers\UserSysController@login_check'); ///ok

//--Đăng ký
Route::get('/dang-ky', 'App\Http\Controllers\UserSysController@u_create'); ///ok
Route::post('/kiem-tra-dang-ky', 'App\Http\Controllers\UserSysController@u_store'); ///

//--Tài khoản
Route::resource('/tai-khoan', 'App\Http\Controllers\UserSysController'); ///ok: CU_ND


//Post: Bài đăng
Route::resource('/bai-dang', 'App\Http\Controllers\PostController')->except(['create']); ///ok: C_ND


//Message: Tin nhắn
Route::resource('/tin-nhan', 'App\Http\Controllers\MessageController_FB')->only(['index', 'show']); ///ok