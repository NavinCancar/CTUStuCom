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
    | - Đối với cá nhân: Đăng nhập, đăng xuất(*), đăng ký
    | - Đối với người dùng khác: 
    |--------------------------------------------------------------------------
    */

    /**
     * Kiểm tra đăng nhập người dùng
     */
    public function AuthLogin_ND(){
        $userLog = Session::get('userLog');
        if($userLog){
        }else{
            return Redirect::to('dang-nhap')->send();
        }
    }

    //TÁC ĐỘNG TÀI KHOẢN CÁ NHÂN

    /**
     * Đăng nhập
     */
    public function login() ///ok
    {
        return view('login_content.login');
    }

    public function login_check(Request $request) ///ok
    {
    	$ND_EMAIL = $request->ND_EMAIL;
        $ND_MATKHAU = $request->ND_MATKHAU;
        
        $result = DB::table('nguoi_dung')->where('ND_EMAIL', $request->ND_EMAIL)->where('ND_MATKHAU', md5($request->ND_MATKHAU))->first();
        /*echo '<pre>';
        print_r ($result);
        echo '</pre>';*/
        
        if($result){
            if($result->ND_TRANGTHAI==1){
                $userLog = DB::table('nguoi_dung')
                    ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
                    ->where('ND_EMAIL', $request->ND_EMAIL)->where('ND_MATKHAU', md5($request->ND_MATKHAU))
                    ->first();
                Session::put('userLog',$userLog);
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
    public function logout() ///ok
    {
        $this->AuthLogin_ND();
        Session::put('userLog',null);
        return Redirect::to('/trang-chu');
    }
    
    /**
     * Đăng ký
     */
    public function u_create() ///ok
    {
        return view('login_content.register');
    }

    public function u_store(Request $request) ///ok
    {
        //Ghi nhận đăng ký, chưa xử lý ảnh đại diện
        $data = array();
        $data['VT_MA'] = 3;  
        $data['ND_HOTEN'] = $request->ND_HOTEN;
        $data['ND_EMAIL'] = $request->ND_EMAIL;
        $data['ND_MATKHAU'] = md5($request->ND_MATKHAU);
        $data['ND_DIEMCONGHIEN'] = 0;
        $data['ND_TRANGTHAI'] = 1;
        $data['ND_NGAYTHAMGIA'] = Carbon::now('Asia/Ho_Chi_Minh');

        //Dò trùng
        $dsnd=DB::table('nguoi_dung')->get();
        foreach ($dsnd as $ds){
            if (strtolower($ds->ND_EMAIL)==strtolower($request->ND_EMAIL)) {
                Session::put('alert', ['type' => 'warning', 'content' => 'Email đã tồn tại trên hệ thống, vui lòng đăng ký với email khác!']);
                return Redirect::to('/dang-ky');
            }
        }

        DB::table('nguoi_dung')->insert($data);

        /* 
        //Lấy mã để xử lý ảnh đại diện
        $ND = DB::table('nguoi_dung')->where('nguoi_dung.ND_EMAIL', $request->ND_EMAIL)
        ->orderby('nguoi_dung.ND_MA','desc')->first();
        $ND_MA = $ND->ND_MA;

        //Xử lý ảnh đại diện
        $get_image= $request->file('ND_ANHDAIDIEN');
        if($get_image){
            $new_image =  'nd_'.$ND_MA.'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/images/users',$new_image);
            DB::table('nguoi_dung')->where('ND_MA',$ND_MA)->update(['ND_ANHDAIDIEN' => $new_image]);
        }*/

        $userLog = DB::table('nguoi_dung')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('ND_EMAIL', $request->ND_EMAIL)->where('ND_MATKHAU', md5($request->ND_MATKHAU))
            ->first();
        Session::put('userLog',$userLog);
        return Redirect::to('/trang-chu');
    }

    /**
     * Chi tiết tài khoản cá nhân
     */
    public function u_show(UserSys $userSys)
    {
        //
    }

    /**
     * Cập nhật tài khoản cá nhân
     */
    public function u_edit(UserSys $userSys)
    {
        //
    }

    public function u_update(Request $request, UserSys $userSys)
    {
        //
    }

    /**
     * Vô hiệu hoá tài khoản cá nhân
     */
    public function u_destroy(UserSys $userSys)
    {
        //
    }

    //TÁC ĐỘNG TÀI KHOẢN HỆ THỐNG

    /**
     * Chặn người dùng
     */


     /**
     * Danh sách gợi ý người dùng
     */


     /**
     * Theo dõi người dùng khác
     */

    /*
    |--------------------------------------------------------------------------
    |   QUẢN TRỊ
    |--------------------------------------------------------------------------
    */

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
