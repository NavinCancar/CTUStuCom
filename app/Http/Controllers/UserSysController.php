<?php

namespace App\Http\Controllers;

use App\Models\UserSys;
use Illuminate\Http\Request;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use Carbon\Carbon;
session_start();

class UserSysController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | NGƯỜI DÙNG
    |--------------------------------------------------------------------------
    */

    //TÁC ĐỘNG TÀI KHOẢN CÁ NHÂN

    /**
     * Đăng nhập
     */
    public function login()
    {
        return view('login_content.login');
    }

    public function login_check(Request $request)
    {
    	$ND_EMAIL = $request->ND_EMAIL;
        $ND_MATKHAU = $request->ND_MATKHAU;
        
        $result = DB::table('nguoi_dung')->where('ND_EMAIL', $ND_EMAIL)->where('ND_MATKHAU', $ND_MATKHAU)->first();
        /*echo '<pre>';
        print_r ($result);
        echo '</pre>';*/
        
        if($result){
            if($result->ND_TRANGTHAI==1){
                Session::put('ND_HOTEN',$result->ND_HOTEN);
                Session::put('ND_MA',$result->ND_MA);
                Session::put('ND_ANHDAIDIEN',$result->ND_ANHDAIDIEN);
                return Redirect::to('/trang-chu');
            }
            else{
                Session::put('alert', ['type' => 'danger', 'content' => 'Tài khoản này của bạn đã bị khoá!']);
                return Redirect::to('/dang-nhap');
            }
        }
        else{
            Session::put('alert', ['type' => 'warning', 'content' => 'Mật khẩu hoặc tài khoản sai. Vui lòng nhập lại!']);
            return Redirect::to('/dang-nhap');
        } 
    }

    /**
     * Đăng xuất
     */

    public function logout()
    {
        $this->AuthLogin();
        Session::put('ND_HOTEN',null);
        Session::put('ND_MA',null);
        Session::put('ND_ANHDAIDIEN',null);
        return Redirect::to('/trang-chu');
    }
    

    /**
     * Đăng ký
     */
    public function u_create()
    {
        return view('login_content.register');
    }

    public function u_store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function u_show(UserSys $userSys)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function u_edit(UserSys $userSys)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function u_update(Request $request, UserSys $userSys)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function u_destroy(UserSys $userSys)
    {
        //
    }

    /*
    |--------------------------------------------------------------------------
    |   QUẢN TRỊ
    |--------------------------------------------------------------------------
    */

    /**
     * Kiểm tra vai trò
     */
    public function AuthLogin(){
        $NV_MA = Session::get('NV_MA');
        $CV_MA = DB::table('nhan_vien')->where('NV_MA',$NV_MA)->first();
        if($NV_MA){
            if($CV_MA->CV_MA != 1){
                return Redirect::to('dashboard')->send();
            }
        }else{
            return Redirect::to('admin')->send();
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserSys $userSys)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserSys $userSys)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserSys $userSys)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserSys $userSys)
    {
        //
    }

}
