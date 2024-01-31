<?php

namespace App\Http\Controllers;

use App\Models\UserSys;
use Illuminate\Http\Request;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use MrShan0\PHPFirestore\FirestoreClient;

use Carbon\Carbon;
session_start();

class UserSysController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    HÀM HỖ TRỢ
    - Hàm xây dựng FireStore
    - Kiểm tra đăng nhập: Người dùng => (*)
    - Kiểm tra đăng nhập: Bản thân & quản trị viên => (****)
    
    NGƯỜI DÙNG
    - Đối với cá nhân: Đăng nhập tài khoản, Đăng xuất tài khoản(*), Đăng ký tài khoản, Cập nhật tài khoản người dùng (****)
    - Đối với người dùng khác: 
    |--------------------------------------------------------------------------
    */

    /**
     * Hàm xây dựng FireStore
     */
    public function __construct(){ ///
        $this->firestoreClient = new FirestoreClient('ctu-student-community', 'AIzaSyCM8jj3tql4LSIaPvjI6D9_BTLYnaspwks', [
            'database' => '(default)',
        ]);
    }

    /**
     * Kiểm tra đăng nhập: Người dùng => (*)
     */
    public function AuthLogin_ND(){ ///
        $userLog = Session::get('userLog');
        if($userLog){
        }else{
            return Redirect::to('dang-nhap')->send();
        }
    }

    /**
     * Kiểm tra đăng nhập: Bản thân & quản trị viên => (****)
     */
    public function AuthLogin_BTwQTV($ma){ ///
        $userLog = Session::get('userLog');
        if($userLog){
            if ($userLog->VT_MA == 1 || $userLog->ND_MA == $ma){
            }
            else{
                return Redirect::to('tai-khoan/'.$userLog->ND_MA.'/edit')->send();
            }
        }else{
            return Redirect::to('dang-nhap')->send();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | NGƯỜI DÙNG
    |--------------------------------------------------------------------------
    */

    //TÁC ĐỘNG TÀI KHOẢN CÁ NHÂN

    /**
     * Đăng nhập tài khoản
     */
    public function login(){ ///
        return view('login_content.login');
    }

    public function login_check(Request $request){ ///
    	$ND_EMAIL = $request->ND_EMAIL;
        $ND_MATKHAU = $request->ND_MATKHAU;
        
        $userLog = DB::table('nguoi_dung')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('ND_EMAIL', $request->ND_EMAIL)->where('ND_MATKHAU', md5($request->ND_MATKHAU))
            ->first();
        /*echo '<pre>';
        print_r ($result);
        echo '</pre>';*/
        
        if($userLog){
            if($userLog->ND_TRANGTHAI==1){
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
     * Đăng xuất tài khoản(*)
     */
    public function logout(){ ///
        $this->AuthLogin_ND();
        Session::put('userLog',null);
        return Redirect::to('/trang-chu');
    }
    
    /**
     * Đăng ký tài khoản
     */
    public function u_create(){ ///
        return view('login_content.register');
    }

    public function u_store(Request $request){ ///
        //Dò trùng
        $dsnd=DB::table('nguoi_dung')->get();
        foreach ($dsnd as $ds){
            if (strtolower($ds->ND_EMAIL)==strtolower($request->ND_EMAIL)) {
                Session::put('alert', ['type' => 'warning', 'content' => 'Email đã tồn tại trên hệ thống, vui lòng đăng ký với email khác!']);
                return Redirect::to('/dang-ky');
            }
        }

        DB::table('nguoi_dung')->insert([
            'VT_MA' => 3,
            'ND_HOTEN' => $request->ND_HOTEN,
            'ND_EMAIL' => $request->ND_EMAIL,
            'ND_MATKHAU' => md5($request->ND_MATKHAU),
            'ND_DIEMCONGHIEN' => 0,
            'ND_TRANGTHAI' => 1,
            'ND_NGAYTHAMGIA' => Carbon::now('Asia/Ho_Chi_Minh')
        ]);

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
        return Redirect::to('/tai-khoan/'.$userLog->ND_MA.'/edit');
    }

    /**
     * Danh sách người dùng gợi ý
     */
    public function u_index()
    {
        //
    }

    /**
     * Tài khoản cá nhân người dùng
     */
    public function show(UserSys $tai_khoan)
    {
        //
    }

    /**
     * Cập nhật tài khoản người dùng (****)
     */
    public function edit(UserSys $tai_khoan){
        $this->AuthLogin_BTwQTV($tai_khoan->ND_MA);

        $account_info = DB::table('nguoi_dung')
            ->where('ND_MA', $tai_khoan->ND_MA)->get();
        
        return view('main_content.personal_account.edit_personal_account')->with('account_info', $account_info);
    }

    public function update(Request $request, UserSys $tai_khoan)
    {
        $this->AuthLogin_BTwQTV($tai_khoan->ND_MA);

        //Dò trùng
        $dsnd=DB::table('nguoi_dung')->get();
        foreach ($dsnd as $ds){
            if (strtolower($ds->ND_EMAIL)==strtolower($request->ND_EMAIL) && ($ds->ND_MA != $tai_khoan->ND_MA)) {
                //Phải load lại trang mới xài
                Session::put('alert', ['type' => 'warning', 'content' => 'Email đã tồn tại trên hệ thống, vui lòng đăng ký với email khác!']);
                return response()->json(['ND_MA' => $tai_khoan->ND_MA], 200);
            }
        }

        DB::table('nguoi_dung')
        ->where('ND_MA', $tai_khoan->ND_MA)
        ->update([ 
            'ND_HOTEN' => $request->ND_HOTEN,
            'ND_EMAIL' => $request->ND_EMAIL,
            'ND_MOTA' => $request->ND_MOTA
        ]);

        if($request->downloadURL != ''){
            DB::table('nguoi_dung')
                ->where('ND_MA', $tai_khoan->ND_MA)
                ->update([ 
                    'ND_ANHDAIDIEN' => $request->downloadURL
                ]);
        }

        Session::put('alert', ['type' => 'success', 'content' => 'Cập nhật thành công!']);
        return response()->json(['ND_MA' => $tai_khoan->ND_MA], 200);
    }

    /**
     * Vô hiệu hoá tài khoản người dùng
     */
    public function destroy(UserSys $tai_khoan)
    {
        //
    }

     /**
     * Đổi mật khẩu
     */
    public function change_password(UserSys $tai_khoan)
    {
        //
    }


    //TÁC ĐỘNG TÀI KHOẢN HỆ THỐNG

    /**
     * Chặn người dùng
     */


     /**
     * Theo dõi người dùng khác
     */

    /*
    |--------------------------------------------------------------------------
    |   QUẢN TRỊ VIÊN
    |--------------------------------------------------------------------------
    */

    /**
     * Danh sách người dùng hệ thống
     */
    public function index()
    {
        //
    }

    /**
     * Thêm người dùng mới
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

}
