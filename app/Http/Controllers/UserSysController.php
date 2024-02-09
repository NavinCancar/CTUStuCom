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
    - Kiểm tra đăng nhập: Bản thân & quản trị viên => (****)
    
    NGƯỜI DÙNG
    - Đối với cá nhân: Đăng nhập tài khoản, Đăng xuất tài khoản(*), Đăng ký tài khoản, 
        Tài khoản cá nhân người dùng,
        Cập nhật tài khoản người dùng (****), Vô hiệu hoá tài khoản người dùng (****),
        Đổi mật khẩu (*)
    - Đối với người dùng khác: Chặn người dùng (*), Theo dõi người dùng khác (*),
      Danh sách người dùng, Danh sách theo dõi (*), Danh sách chặn (*)
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


        //FIRESTORE
        $collection = 'ANH_DAI_DIEN';
        $this->firestoreClient->addDocument($collection, [
            'ND_MA' => $userLog->ND_MA,
            'ND_HOTEN' => $request->ND_HOTEN,  
            'ND_ANHDAIDIEN' =>  '',
            'ND_TRANGTHAI' =>  1,
        ]);
            
        Session::put('userLog',$userLog);
        return Redirect::to('/tai-khoan/'.$userLog->ND_MA.'/edit');
    }

    /**
     * Tài khoản cá nhân người dùng
     */
    public function show(UserSys $tai_khoan){ ///
        $userLog = Session::get('userLog');
        $checkBlockND = 0;
        $checkBlockND2 = 0;
        if($userLog){
            $checkBlockND = DB::table('chan')->where('ND_CHAN_MA', $userLog->ND_MA)->where('ND_BICHAN_MA', '=', $tai_khoan->ND_MA)->exists(); 
            $checkBlockND2 = DB::table('chan')->where('ND_CHAN_MA', $tai_khoan->ND_MA)->where('ND_BICHAN_MA', '=', $userLog->ND_MA)->exists(); 
        }
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
        $bai_viet = $bai_viet_notget->clone()->take(5)->get();

        //Bình luân nổi bật
        $binh_luan_notget = DB::table('binh_luan')->where('ND_MA', $tai_khoan->ND_MA);
        $binh_luan_count = $binh_luan_notget->clone()->count();
        $binh_luan = $binh_luan_notget->clone()->take(5)->get();

        $binh_luan_no_get= DB::table('binh_luan');
        $binh_luan_thich_no_get = DB::table('binh_luan')
        ->join('binhluan_thich', 'binhluan_thich.BL_MA', '=', 'binh_luan.BL_MA')
        ->where('binh_luan.ND_MA', $tai_khoan->ND_MA);
        
        return view('main_content.user.show_user')
        ->with('account_info', $account_info)->with('college', $college)
        ->with('checkBlockND', $checkBlockND)->with('checkBlockND2', $checkBlockND2)
        ->with('nguoi_theo_doi', $nguoi_theo_doi)->with('dang_theo_doi', $dang_theo_doi)
        ->with('nguoi_theo_doi_no_get', $nguoi_theo_doi_no_get)->with('nguoi_bi_chan_no_get', $nguoi_bi_chan_no_get)
        ->with('bai_viet_count', $bai_viet_count)->with('bai_viet', $bai_viet)
        ->with('binh_luan_count', $binh_luan_count)->with('binh_luan', $binh_luan)
        ->with('binh_luan_no_get', $binh_luan_no_get)->with('binh_luan_thich_no_get', $binh_luan_thich_no_get);
    }

    /**
     * Cập nhật tài khoản người dùng (****)
     */
    public function edit(UserSys $tai_khoan){///
        $this->AuthLogin_BTwQTV($tai_khoan->ND_MA);

        $account_info = DB::table('nguoi_dung')
            ->where('ND_MA', $tai_khoan->ND_MA)->get();

        $college = DB::table('khoa_truong')->get();
        
        return view('main_content.user.edit_user')
        ->with('account_info', $account_info)->with('college', $college);
    }

    public function update(Request $request, UserSys $tai_khoan){///
        $this->AuthLogin_BTwQTV($tai_khoan->ND_MA);

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

        //FIRESTORE
        $documentPath = 'ANH_DAI_DIEN/' . $request->idFirestore;
        $this->firestoreClient->updateDocument($documentPath, [
            'ND_HOTEN' => $request->ND_HOTEN
        ], true);
        //$responseData = ['message' => $documentPath];

        if($request->downloadURL != ''){
            DB::table('nguoi_dung')
                ->where('ND_MA', $tai_khoan->ND_MA)
                ->update([ 
                    'ND_ANHDAIDIEN' => $request->downloadURL
                ]);

            //FIRESTORE
            $this->firestoreClient->updateDocument($documentPath, [
                'ND_ANHDAIDIEN' => $request->downloadURL
            ], true);
        }

        if($request->KT_MA != ''){
            DB::table('nguoi_dung')
                ->where('ND_MA', $tai_khoan->ND_MA)
                ->update([ 
                    'KT_MA' => $request->KT_MA
                ]);
        }

        Session::put('alert', ['type' => 'success', 'content' => 'Cập nhật thành công!']);
        //return response()->json(['ND_MA' => $tai_khoan->ND_MA], 200);
        //return response()->json($responseData);
        return;
    }

    /**
     * Vô hiệu hoá tài khoản người dùng (****)
     */
    public function destroy(UserSys $tai_khoan){ ///
        $this->AuthLogin_BTwQTV($tai_khoan->ND_MA);
        DB::table('nguoi_dung')
        ->where('ND_MA', $tai_khoan->ND_MA)
        ->update([ 
            'ND_TRANGTHAI' => 0
        ]);

        //FIRESTORE
        $idFirestore = request('idFirestore');
        $documentPath = 'ANH_DAI_DIEN/' . $idFirestore;
        $this->firestoreClient->updateDocument($documentPath, [
            'ND_TRANGTHAI' => 0
        ], true);

        Session::put('userLog',null);
        Session::put('alert', ['type' => 'success', 'content' => 'Tài khoản bị vô hiệu hoá thành công!']);
        return;
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
        if($userLog){
            $account_info_not_in = DB::table('theo_doi')
            ->where('ND_THEODOI_MA', $userLog->ND_MA)
            ->pluck('ND_DUOCTHEODOI_MA')->toArray();

            $account_info = DB::table('nguoi_dung')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->whereNotIn('ND_MA', $account_info_not_in)->get();
        }
        else{
            $account_info = DB::table('nguoi_dung')
            ->get();
        }

        $college = DB::table('khoa_truong')->get();

        return view('main_content.user.list_user')
        ->with('account_info', $account_info)->with('college', $college);
    }

    /**
     * Danh sách theo dõi (*)
     */

    public function list_follow(){ ///
        $this->AuthLogin_ND();
        $userLog= Session::get('userLog');

        $account_info = DB::table('nguoi_dung')
        ->join('theo_doi', 'nguoi_dung.ND_MA', '=', 'theo_doi.ND_DUOCTHEODOI_MA')
        ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
        ->where('ND_THEODOI_MA', $userLog->ND_MA)->get();

        $college = DB::table('khoa_truong')->get();

        return view('main_content.user.list_follow')
        ->with('account_info', $account_info)->with('college', $college);
    }

    /**
     * Danh sách chặn (*)
     */

    public function list_block(){ ///
        $this->AuthLogin_ND();
        $userLog= Session::get('userLog');

        $account_info = DB::table('nguoi_dung')
        ->join('chan', 'nguoi_dung.ND_MA', '=', 'chan.ND_BICHAN_MA')
        ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
        ->where('ND_CHAN_MA', $userLog->ND_MA)->get();

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
     * Danh sách người dùng hệ thống
     */
    public function index()
    {
        //
    }

}
