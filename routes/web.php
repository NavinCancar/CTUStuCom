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
Route::get('/dang-ky', 'App\Http\Controllers\UserSysController@create'); ///ok
Route::post('/kiem-tra-dang-ky', 'App\Http\Controllers\UserSysController@store'); ///ok

//--Đổi mật khẩu
Route::get('/doi-mat-khau', 'App\Http\Controllers\UserSysController@change_password'); ///ok
Route::post('/kiem-tra-mat-khau', 'App\Http\Controllers\UserSysController@password_check'); ///ok

//--Tài khoản
Route::resource('/tai-khoan', 'App\Http\Controllers\UserSysController')->except(['create', 'store']); ///ok: CUD_ND


//Post: Bài đăng
Route::resource('/bai-dang', 'App\Http\Controllers\PostController')->except(['create']); ///ok: C_ND

//-- Bài viết và thích
Route::get('/thich-bai-dang/{BV_MA}', 'App\Http\Controllers\PostController@baidang_thich');
Route::get('/huy-thich-bai-dang/{BV_MA}', 'App\Http\Controllers\PostController@destroy_baidang_thich');

//-- Bài viết và lưu: Đánh dâu
Route::get('/luu-bai-dang/{BV_MA}', 'App\Http\Controllers\PostController@baidang_luu');
Route::get('/huy-luu-bai-dang/{BV_MA}', 'App\Http\Controllers\PostController@destroy_baidang_luu');

//-- Bài viết và báo cáo
Route::post('/bao-cao-bai-dang/{BV_MA}', 'App\Http\Controllers\PostController@baidang_baocao');


//Comment: Bình luận
Route::resource('/binh-luan', 'App\Http\Controllers\CommentController')->except(['create']); ///ok: C_ND

//-- Bình luận và thích
Route::get('/thich-binh-luan/{BL_MA}', 'App\Http\Controllers\CommentController@binhluan_thich');
Route::get('/huy-thich-binh-luan/{BL_MA}', 'App\Http\Controllers\CommentController@destroy_binhluan_thich');

//-- Bình luận và lưu: Đánh dấu bởi
Route::get('/luu-binh-luan/{BL_MA}', 'App\Http\Controllers\CommentController@binhluan_luu');
Route::get('/huy-luu-binh-luan/{BL_MA}', 'App\Http\Controllers\CommentController@destroy_binhluan_luu');

//-- Bình luận và lưu: Đánh dấu bởi
Route::post('/bao-cao-binh-luan/{BL_MA}', 'App\Http\Controllers\CommentController@binhluan_baocao');


//Message: Tin nhắn
Route::resource('/tin-nhan', 'App\Http\Controllers\MessageController_FB')->only(['index', 'show']); ///ok

//Đánh dấu file: Người dùng và file đính kèm
Route::resource('/danh-dau-file', 'App\Http\Controllers\FileofUserController_FB')->only(['store']); ///ok: C_ND