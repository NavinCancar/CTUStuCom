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

//--Kho lưu trữ
Route::get('/kho-luu-tru','App\Http\Controllers\HomeController@archive'); ///
Route::get('/kho-bai-viet','App\Http\Controllers\HomeController@post_archive');
Route::get('/kho-binh-luan','App\Http\Controllers\HomeController@comment_archive');
Route::get('/kho-file','App\Http\Controllers\HomeController@file_archive');

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
Route::get('/danh-sach-nguoi-dung', 'App\Http\Controllers\UserSysController@list_user'); ///ok
Route::get('/danh-sach-theo-doi/{ND_MA}', 'App\Http\Controllers\UserSysController@list_follow'); ///ok
Route::get('/danh-sach-nguoi-theo-doi/{ND_MA}', 'App\Http\Controllers\UserSysController@list_followme'); ///ok
Route::get('/danh-sach-chan', 'App\Http\Controllers\UserSysController@list_block'); ///ok
Route::resource('/tai-khoan', 'App\Http\Controllers\UserSysController')->except(['create', 'store']); ///ok: CUD_ND

//-- Theo dõi
Route::get('/theo-doi/{ND_MA}', 'App\Http\Controllers\UserSysController@theodoi'); ///ok
Route::get('/huy-theo-doi/{ND_MA}', 'App\Http\Controllers\UserSysController@destroy_theodoi'); ///ok

//-- Chặn
Route::get('/chan/{ND_MA}', 'App\Http\Controllers\UserSysController@chan'); ///ok
Route::get('/bo-chan/{ND_MA}', 'App\Http\Controllers\UserSysController@destroy_chan'); ///ok


//Post: Bài đăng
Route::resource('/bai-dang', 'App\Http\Controllers\PostController')->except(['create','edit']); ///ok: C_ND
Route::get('/bai-dang-binh-luan={BL_MA}', 'App\Http\Controllers\PostController@find_baidang_binhluan');

//-- Bài viết và thích
Route::get('/thich-bai-dang/{BV_MA}', 'App\Http\Controllers\PostController@baidang_thich'); ///ok
Route::get('/huy-thich-bai-dang/{BV_MA}', 'App\Http\Controllers\PostController@destroy_baidang_thich'); ///ok

//-- Bài viết và lưu: Đánh dâu
Route::get('/luu-bai-dang/{BV_MA}', 'App\Http\Controllers\PostController@baidang_luu'); ///ok
Route::get('/huy-luu-bai-dang/{BV_MA}', 'App\Http\Controllers\PostController@destroy_baidang_luu'); ///ok

//-- Bài viết và báo cáo
Route::post('/bao-cao-bai-dang/{BV_MA}', 'App\Http\Controllers\PostController@baidang_baocao'); ///ok


//Comment: Bình luận
Route::resource('/binh-luan', 'App\Http\Controllers\CommentController')->except(['create']); ///ok: C_ND

//-- Bình luận và thích
Route::get('/thich-binh-luan/{BL_MA}', 'App\Http\Controllers\CommentController@binhluan_thich'); ///ok
Route::get('/huy-thich-binh-luan/{BL_MA}', 'App\Http\Controllers\CommentController@destroy_binhluan_thich'); ///ok

//-- Bình luận và lưu: Đánh dấu bởi
Route::get('/luu-binh-luan/{BL_MA}', 'App\Http\Controllers\CommentController@binhluan_luu'); ///ok
Route::get('/huy-luu-binh-luan/{BL_MA}', 'App\Http\Controllers\CommentController@destroy_binhluan_luu'); ///ok

//-- Bình luận và lưu: Đánh dấu bởi
Route::post('/bao-cao-binh-luan/{BL_MA}', 'App\Http\Controllers\CommentController@binhluan_baocao'); ///ok


//Hashtag
Route::get('/danh-sach-hashtag', 'App\Http\Controllers\HashtagController@list'); ///ok
Route::resource('/hashtag', 'App\Http\Controllers\HashtagController')->only(['show']);

//--Theo dõi hashtag
Route::get('/theo-doi-hashtag/{H_HASHTAG}', 'App\Http\Controllers\HashtagController@hashtag_theodoi'); ///ok
Route::get('/huy-theo-doi-hashtag/{H_HASHTAG}', 'App\Http\Controllers\HashtagController@destroy_hashtag_theodoi'); ///ok


//College: Khoa trường
Route::get('/danh-sach-khoa-truong', 'App\Http\Controllers\CollegeController@list'); ///ok
Route::resource('/khoa-truong', 'App\Http\Controllers\CollegeController'); ///ok


//Role: Vai trò
Route::resource('/vai-tro', 'App\Http\Controllers\RoleController')->except(['show']); ///ok


//Subject: Học phần
Route::get('/danh-sach-hoc-phan', 'App\Http\Controllers\SubjectController@list'); ///ok
Route::resource('/hoc-phan', 'App\Http\Controllers\SubjectController'); ///ok


//FIREBASE
//Message: Tin nhắn
Route::resource('/tin-nhan', 'App\Http\Controllers\MessageController_FB')->only(['index', 'show']); ///ok

//Đánh dấu file: Người dùng và file đính kèm
Route::resource('/danh-dau-file', 'App\Http\Controllers\FileofUserController_FB')->only(['store']); ///ok: C_ND

//Notificaton: Thông báo
Route::get('/thong-bao', 'App\Http\Controllers\NotificatonController_FB@index'); ///ok

//-- Cập nhật thông báo thích
Route::get('/thong-bao-thich-bai-dang/{BV_MA}', 'App\Http\Controllers\NotificatonController_FB@UpdateNotification_LikePost'); ///ok
Route::get('/thong-bao-thich-binh-luan/{BL_MA}', 'App\Http\Controllers\NotificatonController_FB@UpdateNotification_LikeComment'); ///ok

//-- Cập nhật thông báo bình luận
Route::get('/thong-bao-binh-luan/{BL_MA}', 'App\Http\Controllers\NotificatonController_FB@UpdateNotification_CommentPost'); ///ok

//-- Cập nhật thông báo báo cáo
Route::get('/thong-bao-bao-cao-bai-dang/{BV_MA}', 'App\Http\Controllers\NotificatonController_FB@UpdateNotification_ReportPost'); ///ok
Route::get('/thong-bao-bao-cao-binh-luan/{BL_MA}', 'App\Http\Controllers\NotificatonController_FB@UpdateNotification_ReportComment'); ///ok

//-- Cập nhật thông báo theo dõi
Route::get('/thong-bao-theo-doi/{ND_MA}', 'App\Http\Controllers\NotificatonController_FB@UpdateNotification_FollowUser');