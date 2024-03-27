<?php

namespace App\Http\Controllers;

use App\Models\UserSys;
use Illuminate\Http\Request;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use MrShan0\PHPFirestore\FirestoreClient;
use MrShan0\PHPFirestore\Attributes\FirestoreDeleteAttribute;

use Carbon\Carbon;
session_start();

class UserSysController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    HÀM HỖ TRỢ
    - Hàm xây dựng FireStore
    - Kiểm tra đăng nhập: Người dùng => (*)
    - Kiểm tra đăng nhập: Quản trị viên => (***)
    - Kiểm tra đăng nhập: Bản thân => (****)
    - Kiểm tra đăng nhập: Bản thân & quản trị viên => (******)
    
    NGƯỜI DÙNG
    Đối với cá nhân: 
    - Đăng nhập tài khoản, Đăng xuất tài khoản (*), Đăng ký tài khoản, Tài khoản cá nhân người dùng
    - Cập nhật tài khoản người dùng (******), Vô hiệu hoá tài khoản người dùng (******), Đổi mật khẩu (*)

    Đối với người dùng khác: 
    - Chặn người dùng (*), Theo dõi người dùng khác (*),
      Danh sách người dùng, Danh sách theo dõi, Danh sách người theo dõi, Danh sách chặn (*)

    QUẢN TRỊ VIÊN
    - Danh sách người dùng hệ thống (***)
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
     * Kiểm tra đăng nhập: Quản trị viên => (***)
     */
    public function AuthLogin_QTV(){ ///
        $userLog = Session::get('userLog');
        if($userLog){
            if ($userLog->VT_MA == 1){
            }
            else{
                return Redirect::to('/')->send();
            }
        }else{
            return Redirect::to('dang-nhap')->send();
        }
    }

    /**
     * Kiểm tra đăng nhập: Bản thân => (****)
     */
    public function AuthLogin_BT($ma){ ///
        $userLog = Session::get('userLog');
        if($userLog){
            if ($userLog->ND_MA == $ma){
            }
            else{
                return Redirect::to('tai-khoan/'.$userLog->ND_MA.'/edit')->send();
            }
        }else{
            return Redirect::to('dang-nhap')->send();
        }
    }

    /**
     * Kiểm tra đăng nhập: Bản thân & quản trị viên => (******)
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

                $uSysAvatar = DB::table('nguoi_dung')->select('ND_MA', 'ND_HOTEN', 'ND_ANHDAIDIEN')->get();
                Session::put('uSysAvatar',$uSysAvatar->toArray());

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
     * Đăng xuất tài khoản (*)
     */
    public function logout(){ ///
        $this->AuthLogin_ND();
        Session::put('userLog',null);
        Session::put('uSysAvatar',null);
        return Redirect::to('/trang-chu');
    }
    
    /**
     * Đăng ký tài khoản
     */
    public function create(){ ///
        return view('login_content.register');
    }

    public function store(Request $request){ ///
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

        $uSysAvatar = DB::table('nguoi_dung')->select('ND_MA', 'ND_HOTEN', 'ND_ANHDAIDIEN')->get();
        Session::put('uSysAvatar',$uSysAvatar->toArray());

        return Redirect::to('/tai-khoan/'.$userLog->ND_MA.'/edit');
    }

    /**
     * Tài khoản cá nhân người dùng
     */
    public function show(UserSys $tai_khoan){ ///
        $userLog = Session::get('userLog');
        $checkBlockND = 0;
        $checkBlockND2 = 0;
        $checkBlockND3 = 0;
        if($userLog){
            $checkBlockND = DB::table('chan')->where('ND_CHAN_MA', $userLog->ND_MA)->where('ND_BICHAN_MA', '=', $tai_khoan->ND_MA)->exists(); 
            $checkBlockND2 = DB::table('chan')->where('ND_CHAN_MA', $tai_khoan->ND_MA)->where('ND_BICHAN_MA', '=', $userLog->ND_MA)->exists(); 
        }
        $checkBlockND3 = DB::table('nguoi_dung')->where('ND_MA', $tai_khoan->ND_MA)->where('ND_TRANGTHAI', 0)->exists(); 
        
        $account_info = DB::table('nguoi_dung')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('ND_MA', $tai_khoan->ND_MA)->get();

        $college = DB::table('khoa_truong')->get();

        //Theo dõi
        $nguoi_theo_doi = DB::table('theo_doi')->where('ND_DUOCTHEODOI_MA', $tai_khoan->ND_MA)->count(); //được theo
        $dang_theo_doi = DB::table('theo_doi')->where('ND_THEODOI_MA', $tai_khoan->ND_MA)->count();
        $nguoi_theo_doi_no_get = DB::table('theo_doi')->where('ND_DUOCTHEODOI_MA', $tai_khoan->ND_MA);


        $nguoi_bi_chan_no_get = DB::table('chan')->where('ND_BICHAN_MA', $tai_khoan->ND_MA);

        //Bài viết nổi bật
        $bai_viet_notget = DB::table('bai_viet')->where('ND_MA', $tai_khoan->ND_MA)->where('bai_viet.BV_TRANGTHAI', '=', 'Đã duyệt');
        $bai_viet_count = $bai_viet_notget->clone()->count();
        if($userLog){
            $bai_viet_not_in = DB::table('baiviet_baocao')->where('ND_MA', $userLog->ND_MA)->pluck('BV_MA')->toArray();
            $bai_viet = $bai_viet_notget->clone()->whereNotIn('bai_viet.BV_MA', $bai_viet_not_in)->take(5)->get();
        }
        else{
            $bai_viet = $bai_viet_notget->clone()->take(5)->get();
        }

        //Bình luân nổi bật
        $binh_luan_notget = DB::table('binh_luan')
        ->where('ND_MA', $tai_khoan->ND_MA)->where('binh_luan.BL_TRANGTHAI', 'Đang hiển thị');
        $binh_luan_count = $binh_luan_notget->clone()->count();
        if($userLog){
            $binh_luan_not_in = DB::table('binhluan_baocao')->where('ND_MA', $userLog->ND_MA)->pluck('BL_MA')->toArray();
            $binh_luan = $binh_luan_notget->clone()->whereNotIn('BL_MA', $binh_luan_not_in)->take(5)->get();
        }
        else{
            $binh_luan = $binh_luan_notget->clone()->take(5)->get();
        }

        $binh_luan_no_get= DB::table('binh_luan')->where('binh_luan.BL_TRANGTHAI', '!=', 'Đã xoá');
        $binh_luan_thich_no_get = DB::table('binh_luan')
        ->join('binhluan_thich', 'binhluan_thich.BL_MA', '=', 'binh_luan.BL_MA')
        ->where('binh_luan.ND_MA', $tai_khoan->ND_MA)->where('binh_luan.BL_TRANGTHAI', '!=', 'Đã xoá');
        

        //Hashtag nổi bật
        $Total_hashtag_BL = DB::table('binh_luan')
        ->join('cua_bai_viet', 'cua_bai_viet.BV_MA', '=', 'binh_luan.BV_MA')
        ->where('binh_luan.ND_MA', $tai_khoan->ND_MA)
        ->where('binh_luan.BL_TRANGTHAI', 'Đang hiển thị')
        ->whereNull('binh_luan.BL_TRALOI_MA')
        ->groupBy('cua_bai_viet.H_HASHTAG')
        ->select('cua_bai_viet.H_HASHTAG', DB::raw('COUNT(*) * 3 AS Total_hashtag'))
        ->get();


        $Total_hashtag_BLTL = DB::table('binh_luan')
        ->join('cua_bai_viet', 'cua_bai_viet.BV_MA', '=', 'binh_luan.BV_MA')
        ->where('binh_luan.ND_MA', $tai_khoan->ND_MA)
        ->where('binh_luan.BL_TRANGTHAI', 'Đang hiển thị')
        ->whereNotNull('binh_luan.BL_TRALOI_MA')
        ->groupBy('cua_bai_viet.H_HASHTAG')
        ->select('cua_bai_viet.H_HASHTAG', DB::raw('COUNT(*) AS Total_hashtag'))
        ->get();


        $Total_hashtag_BV = DB::table('bai_viet')
        ->join('cua_bai_viet', 'cua_bai_viet.BV_MA', '=', 'bai_viet.BV_MA')
        ->where('bai_viet.ND_MA', $tai_khoan->ND_MA)
        ->where('bai_viet.BV_TRANGTHAI', 'Đã duyệt')
        ->groupBy('cua_bai_viet.H_HASHTAG')
        ->select('cua_bai_viet.H_HASHTAG', DB::raw('COUNT(*) * 6 AS Total_hashtag'))
        ->get();


        //Tổng kết quả
        $Total_hashtag_result = $Total_hashtag_BV->map(function ($item) {
            return [
                'hashtag' => $item->H_HASHTAG,
                'Total_hashtag' => $item->Total_hashtag
            ];
        })->toArray();

        foreach ($Total_hashtag_BL as $item) {
            $hashtag = $item->H_HASHTAG;
            $Total_hashtag_item = $item->Total_hashtag;
            
            // Kiểm tra xem hashtag đã tồn tại chưa
            $index = array_search($hashtag, array_column($Total_hashtag_result, 'hashtag'));
        
            if ($index !== false) { //Tồn tại
                $Total_hashtag_result[$index]["Total_hashtag"] += $Total_hashtag_item;
            } else { //Không tồn tại
                $Total_hashtag_result[] = [
                    'hashtag' => $hashtag,
                    'Total_hashtag' => $Total_hashtag_item
                ];
            }
        }

        foreach ($Total_hashtag_BLTL as $item) {
            $hashtag = $item->H_HASHTAG;
            $Total_hashtag_item = $item->Total_hashtag;
            
            // Kiểm tra xem hashtag đã tồn tại chưa
            $index = array_search($hashtag, array_column($Total_hashtag_result, 'hashtag'));
        
            if ($index !== false) { //Tồn tại
                $Total_hashtag_result[$index]["Total_hashtag"] += $Total_hashtag_item;
            } else { //Không tồn tại
                $Total_hashtag_result[] = [
                    'hashtag' => $hashtag,
                    'Total_hashtag' => $Total_hashtag_item
                ];
            }
        }

        usort($Total_hashtag_result, function($a, $b) {
            return $b['Total_hashtag'] - $a['Total_hashtag'];
        });

        $total_hashtag = array_slice($Total_hashtag_result, 0, 7);

        /*echo '<pre>';
        print_r ($Total_hashtag);
        print_r ("-------BV------");
        print_r ($Total_hashtag_BV);
        print_r ("-------BL------");
        print_r ($Total_hashtag_BL);
        print_r ("-------BLTL------");
        print_r ($Total_hashtag_BLTL);
        echo '</pre>';*/

        return view('main_content.user.show_user')
        ->with('account_info', $account_info)->with('college', $college)
        ->with('checkBlockND', $checkBlockND)->with('checkBlockND2', $checkBlockND2)->with('checkBlockND3', $checkBlockND3)
        ->with('nguoi_theo_doi', $nguoi_theo_doi)->with('dang_theo_doi', $dang_theo_doi)
        ->with('nguoi_theo_doi_no_get', $nguoi_theo_doi_no_get)->with('nguoi_bi_chan_no_get', $nguoi_bi_chan_no_get)
        ->with('bai_viet_count', $bai_viet_count)->with('bai_viet', $bai_viet)
        ->with('binh_luan_count', $binh_luan_count)->with('binh_luan', $binh_luan)
        ->with('binh_luan_no_get', $binh_luan_no_get)->with('binh_luan_thich_no_get', $binh_luan_thich_no_get)
        ->with('total_hashtag', $total_hashtag);
    }

    /**
     * Cập nhật tài khoản người dùng (****)
     */
    public function edit(UserSys $tai_khoan){///
        $this->AuthLogin_BT($tai_khoan->ND_MA);

        $account_info = DB::table('nguoi_dung')
            ->where('ND_MA', $tai_khoan->ND_MA)->get();

        $college = DB::table('khoa_truong')->get();

        $role = DB::table('vai_tro')->get();
        
        return view('main_content.user.edit_user')->with('role', $role)
        ->with('account_info', $account_info)->with('college', $college);
    }

    public function update(Request $request, UserSys $tai_khoan){///
        $this->AuthLogin_BTwQTV($tai_khoan->ND_MA);
        $userLog = Session::get('userLog');
        //Dò trùng
        $dsnd=DB::table('nguoi_dung')->get();
        foreach ($dsnd as $ds){
            if (strtolower($ds->ND_EMAIL)==strtolower($request->ND_EMAIL) && ($ds->ND_MA != $tai_khoan->ND_MA)) {
                //Phải load lại trang mới xài
                Session::put('alert', ['type' => 'warning', 'content' => 'Email đã tồn tại trên hệ thống, vui lòng đăng ký với email khác!']);
                return;
            }
        }

        DB::table('nguoi_dung')
        ->where('ND_MA', $tai_khoan->ND_MA)
        ->update([ 
            'ND_HOTEN' => $request->ND_HOTEN,
            'ND_EMAIL' => $request->ND_EMAIL,
            'ND_MOTA' => $request->ND_MOTA
        ]);

        if ($tai_khoan->ND_MA != $userLog->ND_MA) {
            DB::table('nguoi_dung')
            ->where('ND_MA', $tai_khoan->ND_MA)
            ->update([ 
                'VT_MA' => $request->VT_MA,
            ]);
        }

        if($request->downloadURL != ''){
            DB::table('nguoi_dung')
                ->where('ND_MA', $tai_khoan->ND_MA)
                ->update([ 
                    'ND_ANHDAIDIEN' => $request->downloadURL
                ]);
        }

        if($request->KT_MA != ''){
            DB::table('nguoi_dung')
                ->where('ND_MA', $tai_khoan->ND_MA)
                ->update([ 
                    'KT_MA' => $request->KT_MA
                ]);
        }

        if ($tai_khoan->ND_MA == $userLog->ND_MA){
            $userLogUpdate = DB::table('nguoi_dung')
                ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
                ->where('ND_MA', $userLog->ND_MA)->first();
                
            Session::put('userLog',$userLogUpdate);
        }
        
        Session::put('alert', ['type' => 'success', 'content' => 'Cập nhật tài khoản thành công!']);
        //return response()->json(['ND_MA' => $tai_khoan->ND_MA], 200);
        //return response()->json($responseData);
        return;
    }

    /**
     * Vô hiệu hoá tài khoản người dùng (******)
     */
    public function destroy(UserSys $tai_khoan){ ///
        $this->AuthLogin_BTwQTV($tai_khoan->ND_MA);
        $userLog = Session::get('userLog');
        
        DB::table('nguoi_dung')
        ->where('ND_MA', $tai_khoan->ND_MA)
        ->update([ 
            'ND_TRANGTHAI' => 0
        ]);

        if ($tai_khoan->ND_MA == $userLog->ND_MA) {
            Session::put('alert', ['type' => 'success', 'content' => 'Tài khoản bị vô hiệu hoá thành công!']);
            Session::put('userLog',null); 
            Session::put('uSysAvatar',null); 
            return;
        }
        else{
            Session::put('alert', ['type' => 'success', 'content' => 'Tài khoản bị vô hiệu hoá thành công!']);
            return Redirect::back()->send();
        }
    }

     /**
     * Đổi mật khẩu (*)
     */
    public function change_password(){///
        $this->AuthLogin_ND();

        return view('main_content.user.change_password');
    }

    public function password_check(Request $request){///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        if ($userLog->ND_MATKHAU!=md5($request->ND_MATKHAUCU)){
            Session::put('alert', ['type' => 'warning', 'content' => 'Mật khẩu cũ sai, vui lòng kiểm tra lại!']);
            return Redirect::to('doi-mat-khau');
        }
        if ($request->ND_MATKHAUMOI1!=$request->ND_MATKHAUMOI2){
            Session::put('alert', ['type' => 'warning', 'content' => 'Mật khẩu mới nhập lại sai, vui lòng kiểm tra lại!']);
            return Redirect::to('doi-mat-khau');
        }
        if ($request->ND_MATKHAUMOI1==$request->ND_MATKHAUCU){
            Session::put('alert', ['type' => 'warning', 'content' => 'Mật khẩu cũ và mật khẩu mới phải khác nhau, vui lòng kiểm tra lại!']);
            return Redirect::to('doi-mat-khau');
        }

        DB::table('nguoi_dung')
        ->where('ND_MA', $userLog->ND_MA)
        ->update([ 
            'ND_MATKHAU' => md5($request->ND_MATKHAUMOI1)
        ]);

        Session::put('alert', ['type' => 'success', 'content' => 'Đổi mật khẩu thành công!']);
        return Redirect::to('doi-mat-khau');
    }


    /**
     * Nhìn lại quá trình (*)
     */

     public function chart(){ ///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        //http://localhost/ctustucom/nhin-lai-qua-trinh?TGBDau=2024-02-17&TGKThuc=2024-03-17
        if(request()->query('TGBDau') && request()->query('TGKThuc')){
            $TGBDau = date('Y-m-d 00:00:00', strtotime(request()->query('TGBDau')));
            $TGKThuc = date('Y-m-d 23:59:59', strtotime(request()->query('TGKThuc')));
        }
        else{
            $TGBDau = Carbon::now('Asia/Ho_Chi_Minh')->subMonths(1)->startOfDay();
            $TGKThuc = Carbon::now('Asia/Ho_Chi_Minh')->endOfDay();
        }

        if($TGBDau < $userLog->ND_NGAYTHAMGIA){
            $TGBDau = date('Y-m-d 00:00:00', strtotime($userLog->ND_NGAYTHAMGIA));
        }

        $homnay = Carbon::now('Asia/Ho_Chi_Minh')->endOfDay();
        $now = Carbon::now('Asia/Ho_Chi_Minh');

        if ($TGBDau && $TGKThuc && $TGBDau <= $TGKThuc && $TGKThuc <= $homnay){

            $allDates = []; //Mảng thời điểm
            $currentDate = strtotime($TGBDau);
            $endDate = strtotime($TGKThuc);

            if ((($endDate - $currentDate) / 3600) <= 24) {
                $minUnit = "gio"; //đơn vị: giây => giờ
                while ($currentDate <= $endDate) {
                    $allDates[] = date('Y-m-d H', $currentDate);
                    $currentDate = strtotime('+1 hour', $currentDate); // Tăng thêm 1 giờ
                }
            } 
            else if(strtotime('+3 months', $currentDate) < $endDate) {
                $minUnit = "thang";
                while ($currentDate <= $endDate) {
                    $allDates[] = date('Y-m', $currentDate);
                    $currentDate = strtotime('+1 month', $currentDate); // Tăng thêm 1 tháng
                }
            } 
            else {
                $minUnit = "ngay";
                while ($currentDate <= $endDate) {
                    $allDates[] = date('Y-m-d', $currentDate);
                    $currentDate = strtotime('+1 day', $currentDate); // Tăng thêm 1 ngày
                }
            } 

            //---------------------------------------------------------
            //---------------------------------------------------------
            
            $tt_bv = DB::table('bai_viet')
            ->whereBetween('BV_THOIGIANTAO', [$TGBDau, $TGKThuc])
            ->where('bai_viet.ND_MA', $userLog->ND_MA)
            ->groupBy('thoi_diem')->orderBy('thoi_diem');
            
            if($minUnit == "gio"){ //GIỜ NGÀY THÁNG NĂM (trong 1 ngày)
                $tt_bv = $tt_bv->select(
                    DB::raw('DATE_FORMAT(BV_THOIGIANTAO, "%Y-%m-%d %H") as thoi_diem'),
                    DB::raw('COUNT(*) as so_luong')
                )->get();
            }
            else if($minUnit == "thang"){ //THÁNG NĂM (trên 3 tháng)
                $tt_bv = $tt_bv->select(
                    DB::raw('DATE_FORMAT(BV_THOIGIANTAO, "%Y-%m") as thoi_diem'),
                    DB::raw('COUNT(*) as so_luong')
                )->get();
            }
            else{ //NGÀY THÁNG NĂM (trong 30 ngày)
                $tt_bv = $tt_bv->select(
                    DB::raw('DATE_FORMAT(BV_THOIGIANTAO, "%Y-%m-%d") as thoi_diem'),
                    DB::raw('COUNT(*) as so_luong')
                )->get();
            }



            $tt_bl = DB::table('binh_luan')
            ->whereBetween('BL_THOIGIANTAO', [$TGBDau, $TGKThuc])
            ->where('binh_luan.ND_MA', $userLog->ND_MA)
            ->groupBy('thoi_diem')->orderBy('thoi_diem');

            if($minUnit == "gio"){ //GIỜ NGÀY THÁNG NĂM (trong 1 ngày)
                $tt_bl = $tt_bl->select(
                    DB::raw('DATE_FORMAT(BL_THOIGIANTAO, "%Y-%m-%d %H") as thoi_diem'),
                    DB::raw('COUNT(*) as so_luong')
                )->get();
            }
            else if($minUnit == "thang"){ //THÁNG NĂM (trên 3 tháng)
                $tt_bl = $tt_bl->select(
                    DB::raw('DATE_FORMAT(BL_THOIGIANTAO, "%Y-%m") as thoi_diem'),
                    DB::raw('COUNT(*) as so_luong')
                )->get();
            }
            else{ //NGÀY THÁNG NĂM (trong 30 ngày)
                $tt_bl = $tt_bl->select(
                    DB::raw('DATE_FORMAT(BL_THOIGIANTAO, "%Y-%m-%d") as thoi_diem'),
                    DB::raw('COUNT(*) as so_luong')
                )->get();
            }
            

            //---------------------------------------------------------
            //---------------------------------------------------------
            //Hashtag nổi bật----------------------------------------------------------
            $Total_hashtag_BL = DB::table('binh_luan')
            ->join('cua_bai_viet', 'cua_bai_viet.BV_MA', '=', 'binh_luan.BV_MA')
            //->where('binh_luan.ND_MA', $userLog->ND_MA)
            ->where('binh_luan.BL_TRANGTHAI', 'Đang hiển thị')
            ->whereNull('binh_luan.BL_TRALOI_MA')
            ->whereBetween('BL_THOIGIANTAO', [$TGBDau, $TGKThuc])
            ->groupBy('binh_luan.ND_MA')->groupBy('cua_bai_viet.H_HASHTAG')
            ->orderBy('binh_luan.ND_MA')
            ->select('binh_luan.ND_MA', 'cua_bai_viet.H_HASHTAG', DB::raw('COUNT(*) * 3 AS Total_hashtag'))
            ->get();

            $Total_hashtag_BLTL = DB::table('binh_luan')
            ->join('cua_bai_viet', 'cua_bai_viet.BV_MA', '=', 'binh_luan.BV_MA')
            //->where('binh_luan.ND_MA', $userLog->ND_MA)
            ->where('binh_luan.BL_TRANGTHAI', 'Đang hiển thị')
            ->whereNotNull('binh_luan.BL_TRALOI_MA')
            ->whereBetween('BL_THOIGIANTAO', [$TGBDau, $TGKThuc])
            ->groupBy('binh_luan.ND_MA')->groupBy('cua_bai_viet.H_HASHTAG')
            ->orderBy('binh_luan.ND_MA')
            ->select('binh_luan.ND_MA', 'cua_bai_viet.H_HASHTAG', DB::raw('COUNT(*) AS Total_hashtag'))
            ->get();

            $Total_hashtag_BV = DB::table('bai_viet')
            ->join('cua_bai_viet', 'cua_bai_viet.BV_MA', '=', 'bai_viet.BV_MA')
            //->where('bai_viet.ND_MA', $userLog->ND_MA)
            ->where('bai_viet.BV_TRANGTHAI', 'Đã duyệt')
            ->whereBetween('BV_THOIGIANTAO', [$TGBDau, $TGKThuc])
            ->groupBy('bai_viet.ND_MA')->groupBy('cua_bai_viet.H_HASHTAG')
            ->orderBy('bai_viet.ND_MA')
            ->select('bai_viet.ND_MA', 'cua_bai_viet.H_HASHTAG', DB::raw('COUNT(*) * 6 AS Total_hashtag'))
            ->get();

            $Total_hashtag_result = $Total_hashtag_BV->map(function ($item) {
                return [
                    'user' => $item->ND_MA,
                    'hashtag' => $item->H_HASHTAG,
                    'Total_hashtag' => $item->Total_hashtag
                ];
            })->toArray();

            foreach ($Total_hashtag_BL as $item) {
                $user = $item->ND_MA;
                $hashtag = $item->H_HASHTAG;
                $Total_hashtag_item = $item->Total_hashtag;
                
                // Kiểm tra xem hashtag đã tồn tại chưa
                $index = false;
                foreach ($Total_hashtag_result as $key => $result_item) {
                    if ($result_item['user'] == $user && $result_item['hashtag'] == $hashtag) {
                        $index = $key; 
                        break; 
                    }
                }
            
                if ($index !== false) { //Tồn tại
                    $Total_hashtag_result[$index]["Total_hashtag"] += $Total_hashtag_item;
                } else { //Không tồn tại
                    $Total_hashtag_result[] = [
                        'user' => $user,
                        'hashtag' => $hashtag,
                        'Total_hashtag' => $Total_hashtag_item
                    ];
                }
            }

            foreach ($Total_hashtag_BLTL as $item) {
                $user = $item->ND_MA;
                $hashtag = $item->H_HASHTAG;
                $Total_hashtag_item = $item->Total_hashtag;
                
                // Kiểm tra xem hashtag đã tồn tại chưa
                $index = false;
                foreach ($Total_hashtag_result as $key => $result_item) {
                    if ($result_item['user'] == $user && $result_item['hashtag'] == $hashtag) {
                        $index = $key; 
                        break; 
                    }
                }
            
                if ($index !== false) { //Tồn tại
                    $Total_hashtag_result[$index]["Total_hashtag"] += $Total_hashtag_item;
                } else { //Không tồn tại
                    $Total_hashtag_result[] = [
                        'user' => $user,
                        'hashtag' => $hashtag,
                        'Total_hashtag' => $Total_hashtag_item
                    ];
                }
            }


            //Hashtag của chủ tài khoản
            $Total_hashtag_result_user = collect($Total_hashtag_result)->filter(function ($item) use ($userLog) {
                return $item['user'] == $userLog->ND_MA;
            })->map(function ($item) {
                return [
                    'hashtag' => $item['hashtag'],
                    'Total_hashtag' => $item['Total_hashtag']
                ];
            })->toArray();


            usort($Total_hashtag_result_user, function($a, $b) {
                return $b['Total_hashtag'] - $a['Total_hashtag'];
            });


            //---------------------------------------------------------
            //---------------------------------------------------------
            //Gợi ý hashtag----------------------------------------------------------
            $hashtags_only = array_column($Total_hashtag_result_user, 'hashtag');
            $initial_hashtag_array = array_slice($hashtags_only, 0, 5);
            //$count_initial_hashtag_array = count($initial_hashtag_array);

            $nguoi_dung_not_in3 = DB::table('nguoi_dung')->where('ND_TRANGTHAI', 0)->pluck('ND_MA')->toArray();
            $hashtag_not_in = DB::table('theo_doi_boi')->where('ND_MA', $userLog->ND_MA)->pluck('H_HASHTAG')->toArray();

            $hashtag_should_fl = array_diff($hashtags_only, $hashtag_not_in);
            $hashtag_should_fl = array_slice($hashtag_should_fl, 0, 6);

            $bai_viet_not_in = DB::table('bai_viet')
            ->where('bai_viet.BV_TRANGTHAI', '!=', 'Đã duyệt')
            ->orWhereIn('ND_MA', $nguoi_dung_not_in3)->pluck('BV_MA')->toArray();

            // Những hashtag có khả năng sẽ gợi ý (diện rộng)
            $post_have_initial_hashtag = DB::table('cua_bai_viet')
            ->whereIn('H_HASHTAG', $initial_hashtag_array)
            ->whereNotIn('BV_MA', $bai_viet_not_in)
            ->select('BV_MA')->distinct()->pluck('BV_MA')->toArray();

            $maybe_suggest = DB::table('cua_bai_viet')
            ->whereIn('BV_MA', $post_have_initial_hashtag)
            ->whereNotIn('H_HASHTAG', $initial_hashtag_array)
            ->whereNotIn('H_HASHTAG', $hashtag_not_in)
            ->select('H_HASHTAG')->distinct()->get();

            $result_suggest = [];
            foreach($maybe_suggest as $maybe_suggest_tag){
                //Tính số bài mà mỗi hashtag có thể gợi ý hay đi kèm
                $number_of_post = DB::table('cua_bai_viet as c1')
                ->join('cua_bai_viet as c2', 'c1.BV_MA', '=', 'c2.BV_MA')
                ->where('c1.H_HASHTAG', '=', $maybe_suggest_tag->H_HASHTAG)
                ->whereIn('c2.H_HASHTAG', $initial_hashtag_array)
                ->select('c2.H_HASHTAG', DB::raw('COUNT(c2.BV_MA) as SLBV_DINHKEM'))
                ->groupby('c2.H_HASHTAG')->get();
                
                $totalSLBV_DINHKEM = $number_of_post->sum('SLBV_DINHKEM');

                $result_suggest[] = ['hashtag' => $maybe_suggest_tag->H_HASHTAG , 'number' => $totalSLBV_DINHKEM];
            }
            
            usort($result_suggest, function($a, $b) {
                return $b['number'] - $a['number'];
            });
            $result_suggest = array_slice($result_suggest, 0, 6);


            //---------------------------------------------------------
            //---------------------------------------------------------
            //Gợi ý người dùng----------------------------------------------------------

            $account_info_not_in = DB::table('theo_doi')->where('ND_THEODOI_MA', $userLog->ND_MA)->pluck('ND_DUOCTHEODOI_MA')->toArray();
            $nguoi_dung_not_in = DB::table('chan')->where('ND_CHAN_MA', $userLog->ND_MA)->pluck('ND_BICHAN_MA')->toArray();
            $nguoi_dung_not_in2 = DB::table('chan')->where('ND_BICHAN_MA', $userLog->ND_MA)->pluck('ND_CHAN_MA')->toArray();
            
            
            $Total_hashtag_result_another_user = collect($Total_hashtag_result)->filter(
                function ($item) use ($userLog, $initial_hashtag_array, $account_info_not_in, $nguoi_dung_not_in, $nguoi_dung_not_in2, $nguoi_dung_not_in3) {
                    return $item['user'] != $userLog->ND_MA 
                    && !in_array($item['user'], $account_info_not_in)
                    && !in_array($item['user'], $nguoi_dung_not_in)
                    && !in_array($item['user'], $nguoi_dung_not_in2)
                    && !in_array($item['user'], $nguoi_dung_not_in3)
                    && in_array($item['hashtag'], $initial_hashtag_array);
            })->map(function ($item) {
                return [
                    'user' => $item['user'],
                    'hashtag' => $item['hashtag'],
                    'Total_hashtag' => $item['Total_hashtag']
                ];
            })->toArray();

            $Total_user = collect($Total_hashtag_result_another_user)->groupBy('user')->map(function ($grouped) {
                return [
                    'user' => $grouped->first()['user'],
                    'Total_user' => $grouped->sum('Total_hashtag')
                ];
            })->values()->toArray();

            usort($Total_user, function($a, $b) {
                return $b['Total_user'] - $a['Total_user'];
            });

            $Total_user = array_slice($Total_user, 0, 6);
            $Total_user_only_user = array_column($Total_user, 'user');

            $account_info = DB::table('nguoi_dung')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->whereIn('ND_MA', $Total_user_only_user)->get();

            $college = DB::table('khoa_truong')->get();
            
            //---------------------------------------------------------
            //---------------------------------------------------------

            /*echo '<pre>';
            print_r ($Total_user);
            echo '</pre>';*/

            $hashtag_theodoi_noget = DB::table('theo_doi_boi')->where("ND_MA", $userLog->ND_MA);
            
            return view('main_content.user.chart_user')->with('now', $now)
            ->with('minUnit', $minUnit)->with('allDates', $allDates)
            ->with('TGBDau', $TGBDau)->with('TGKThuc', $TGKThuc)
            ->with('tt_bv', $tt_bv)->with('tt_bl', $tt_bl)
            ->with('total_hashtag', $Total_hashtag_result_user)->with('result_suggest', $result_suggest)
            ->with('hashtag_theodoi_noget', $hashtag_theodoi_noget)->with('hashtag_should_fl', $hashtag_should_fl)
            ->with('total_user', $Total_user)->with('account_info', $account_info)->with('college', $college);
        }
            
        Session::put('alert', ['type' => 'danger', 'content' => 'Xin kiểm tra lại dữ liệu đầu vào!']);
        return Redirect::back()->send();
    }

    //TÁC ĐỘNG TÀI KHOẢN HỆ THỐNG

    /**
     * Chặn người dùng (*)
     */

     public function chan($ND_MA){ ///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        $isExist = DB::table('chan')
            ->where('ND_BICHAN_MA', $ND_MA)->where("ND_CHAN_MA", $userLog->ND_MA)
            ->exists();

        if(!$isExist){
            DB::table('chan')->insert([
                'ND_BICHAN_MA' => $ND_MA,
                'ND_CHAN_MA' => $userLog->ND_MA
            ]);

            Session::put('alert', ['type' => 'success', 'content' => 'Chặn người dùng thành công!']);            
        }
    }

    public function destroy_chan($ND_MA){ ///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        $isExist = DB::table('chan')
            ->where('ND_BICHAN_MA', $ND_MA)->where("ND_CHAN_MA", $userLog->ND_MA)
            ->exists();

        if($isExist){
            DB::table('chan')
            ->where('ND_BICHAN_MA', $ND_MA)->where("ND_CHAN_MA", $userLog->ND_MA)
            ->delete();

            Session::put('alert', ['type' => 'success', 'content' => 'Bỏ chặn người dùng này thành công!']);    
        }
    }

     /**
     * Theo dõi người dùng khác (*)
     */

    public function theodoi($ND_MA){ ///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        $isExist = DB::table('theo_doi')
            ->where('ND_DUOCTHEODOI_MA', $ND_MA)->where("ND_THEODOI_MA", $userLog->ND_MA)
            ->exists();

        if(!$isExist){
            DB::table('theo_doi')->insert([
                'ND_THEODOI_MA' => $userLog->ND_MA,
                'ND_DUOCTHEODOI_MA' => $ND_MA
            ]);
        }
    }

    public function destroy_theodoi($ND_MA){ ///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        $isExist = DB::table('theo_doi')
            ->where('ND_DUOCTHEODOI_MA', $ND_MA)->where("ND_THEODOI_MA", $userLog->ND_MA)
            ->exists();

        if($isExist){
            DB::table('theo_doi')
            ->where('ND_DUOCTHEODOI_MA', $ND_MA)->where("ND_THEODOI_MA", $userLog->ND_MA)
            ->delete();
        }
    }

    /**
     * Danh sách người dùng
     */

    public function list_user(){ ///
        $userLog= Session::get('userLog');
        $nguoi_dung_not_in3 = DB::table('nguoi_dung')->where('ND_TRANGTHAI', 0)->pluck('ND_MA')->toArray();

        if($userLog){
            $account_info_not_in = DB::table('theo_doi')
            ->where('ND_THEODOI_MA', $userLog->ND_MA)
            ->pluck('ND_DUOCTHEODOI_MA')->toArray();
            $nguoi_dung_not_in = DB::table('chan')->where('ND_CHAN_MA', $userLog->ND_MA)->pluck('ND_BICHAN_MA')->toArray();
            $nguoi_dung_not_in2 = DB::table('chan')->where('ND_BICHAN_MA', $userLog->ND_MA)->pluck('ND_CHAN_MA')->toArray();
            
            $account_info = DB::table('nguoi_dung')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->whereNotIn('ND_MA', $account_info_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in2)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3)->get();
        }
        else{
            $account_info = DB::table('nguoi_dung')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3)->get();
        }

        $college = DB::table('khoa_truong')->get();

        return view('main_content.user.list_user')
        ->with('account_info', $account_info)->with('college', $college);
    }

    /**
     * Danh sách theo dõi
     */

    public function list_follow($ND_MA){ ///
        $userLog= Session::get('userLog');
        $nguoi_dung_not_in3 = DB::table('nguoi_dung')->where('ND_TRANGTHAI', 0)->pluck('ND_MA')->toArray();
        
        if($userLog){
            $nguoi_dung_not_in = DB::table('chan')->where('ND_CHAN_MA', $userLog->ND_MA)->pluck('ND_BICHAN_MA')->toArray();
            $nguoi_dung_not_in2 = DB::table('chan')->where('ND_BICHAN_MA', $userLog->ND_MA)->pluck('ND_CHAN_MA')->toArray();
            $account_info = DB::table('nguoi_dung')
            ->join('theo_doi', 'nguoi_dung.ND_MA', '=', 'theo_doi.ND_DUOCTHEODOI_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('ND_THEODOI_MA', $ND_MA)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in2)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3)->get();
        }
        else{
            $account_info = DB::table('nguoi_dung')
            ->join('theo_doi', 'nguoi_dung.ND_MA', '=', 'theo_doi.ND_DUOCTHEODOI_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('ND_THEODOI_MA', $ND_MA)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3)->get();
        }
        $nguoi_dung_no_get = DB::table('theo_doi');

        $college = DB::table('khoa_truong')->get();

        $name= 'Danh sách theo dõi';
        return view('main_content.user.list_follow')
        ->with('account_info', $account_info)->with('nguoi_dung_no_get', $nguoi_dung_no_get)
        ->with('college', $college)->with('name', $name);
    }

    /**
     * Danh sách người theo dõi
     */

     public function list_followme($ND_MA){ ///
        $userLog= Session::get('userLog');
        $nguoi_dung_not_in3 = DB::table('nguoi_dung')->where('ND_TRANGTHAI', 0)->pluck('ND_MA')->toArray();
        
        if($userLog){
            $nguoi_dung_not_in = DB::table('chan')->where('ND_CHAN_MA', $userLog->ND_MA)->pluck('ND_BICHAN_MA')->toArray();
            $nguoi_dung_not_in2 = DB::table('chan')->where('ND_BICHAN_MA', $userLog->ND_MA)->pluck('ND_CHAN_MA')->toArray();
            $account_info = DB::table('nguoi_dung')
            ->join('theo_doi', 'nguoi_dung.ND_MA', '=', 'theo_doi.ND_THEODOI_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('ND_DUOCTHEODOI_MA', $ND_MA)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in2)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3)->get();
        }
        else{
            $account_info = DB::table('nguoi_dung')
            ->join('theo_doi', 'nguoi_dung.ND_MA', '=', 'theo_doi.ND_THEODOI_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('ND_DUOCTHEODOI_MA', $ND_MA)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3)->get();
        }
        $nguoi_dung_no_get = DB::table('theo_doi');

        $college = DB::table('khoa_truong')->get();

        $name= 'Danh sách người theo dõi';
        return view('main_content.user.list_follow')
        ->with('account_info', $account_info)->with('nguoi_dung_no_get', $nguoi_dung_no_get)
        ->with('college', $college)->with('name', $name);
    }

    /**
     * Danh sách chặn (*)
     */

    public function list_block(){ ///
        $this->AuthLogin_ND();
        $userLog= Session::get('userLog');
        $nguoi_dung_not_in3 = DB::table('nguoi_dung')->where('ND_TRANGTHAI', 0)->pluck('ND_MA')->toArray();

        $account_info = DB::table('nguoi_dung')
        ->join('chan', 'nguoi_dung.ND_MA', '=', 'chan.ND_BICHAN_MA')
        ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
        ->where('ND_CHAN_MA', $userLog->ND_MA)
        ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3)->get();

        $college = DB::table('khoa_truong')->get();

        return view('main_content.user.list_block')
        ->with('account_info', $account_info)->with('college', $college);
    }

    /*
    |--------------------------------------------------------------------------
    |   QUẢN TRỊ VIÊN
    |--------------------------------------------------------------------------
    */

    /**
     * Danh sách người dùng hệ thống (***)
     */
    public function index(){ ///
        $this->AuthLogin_QTV();
        //FOCUS: http://localhost/ctustucom/bai-dang?bai-dang={bai_viet}
        $nguoiDungMa = request()->query('nguoi-dung');
        if($nguoiDungMa) Session::put('ND_MA_Focus', $nguoiDungMa);
        $nguoiDungMa = null;

        $all_user = DB::table('nguoi_dung')
        ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
        ->orderby('ND_MA');

        $all_vaitro = DB::table('vai_tro')->get();

        //-----------------------------------------------------------------
        //VAI TRÒ: http://localhost/ctustucom/tai-khoan?vai-tro={vai-tro}
        $filterRole = request()->query('vai-tro');
        if($filterRole) {
            $state = '';
            if($filterRole == 'quan-tri-vien') $state = 1;
            else if($filterRole == 'kiem-duyet-vien') $state = 2;
            else if($filterRole == 'nguoi-dung-thanh-vien') $state = 3;

            $all_user = DB::table('nguoi_dung')
            ->where('nguoi_dung.VT_MA', $state)
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->orderby('ND_MA');
        }
        $filterRole = null;

        //TRẠNG THÁI: http://localhost/ctustucom/tai-khoan?trang-thai={trang-thai}
        $filterState = request()->query('trang-thai');
        if($filterState) {
            $state = '';
            if($filterState == 'hoat-dong') $state = 1;
            else if($filterState == 'vo-hieu-hoa') $state = 0;

            $all_user = DB::table('nguoi_dung')
            ->where('ND_TRANGTHAI', $state)
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->orderby('ND_MA');
        }
        $filterState = null;

        //SEARCH: http://localhost/ctustucom/bai-dang?tu-khoa=18%2F03%2F2024
        $keywordSearch = request()->query('tu-khoa');
        if($keywordSearch){
            $all_user = $all_user->where(function ($query) use ($keywordSearch) {
                $query->where('nguoi_dung.ND_MA', 'like', '%'.$keywordSearch.'%')
                      ->orWhere('nguoi_dung.ND_HOTEN', 'like', '%'.$keywordSearch.'%');

                $datePattern = '/^\d{2}\/\d{2}\/\d{4}$/';
                if (preg_match($datePattern, $keywordSearch)) {
                    $query->orWhereDate('nguoi_dung.ND_NGAYTHAMGIA', Carbon::createFromFormat('d/m/Y', $keywordSearch)->format('Y-m-d'));
                }
            });
        }
        
        $all_user = $all_user->paginate(10);

        return view('main_content.user.all_user')
        ->with('all_user', $all_user)->with('all_vaitro', $all_vaitro);
    }

    public function role_update(Request $request){ ///
        $this->AuthLogin_QTV();
        DB::table('nguoi_dung')
        ->where('ND_MA', $request->ND_MA)
        ->update([ 
            'VT_MA' => $request->VT_MA,
        ]);
        Session::put('alert', ['type' => 'success', 'content' => 'Cập nhật vai trò thành công!']);
        return Redirect::to('tai-khoan?nguoi-dung='.$request->ND_MA);
    }
}
