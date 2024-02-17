<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use MrShan0\PHPFirestore\FirestoreClient;

use Carbon\Carbon;
session_start();

class CommentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    HÀM HỖ TRỢ
    - Hàm xây dựng FireStore
    - Kiểm tra đăng nhập: Người dùng => (*)
    - Kiểm tra đăng nhập: Bản thân & quản trị viên => (****)
    - Kiểm tra đăng nhập: Bản thân => (*****)

    NGƯỜI DÙNG
    - Tạo bình luận mới(*), Sửa bình luận (*****), Xoá bình luận (****)
    - Bình luận - thích (*), Bình luận - lưu (*), Bình luận - báo cáo (*)
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
     * Kiểm tra đăng nhập: Bản thân => (*****)
     */
    public function AuthLogin_BT($binh_luan){ ///
        $userLog = Session::get('userLog');
        if($userLog){
            if ($userLog->ND_MA == $binh_luan->ND_MA){
            }
            else{
                return Redirect::to('bai-dang/'.$binh_luan->BV_MA)->send();
            }
        }else{
            return Redirect::to('dang-nhap')->send();
        }
    }


    /**
     * Kiểm tra đăng nhập: Bản thân & quản trị viên => (****)
     */
    public function AuthLogin_BTwQTV($binh_luan){ ///
        $userLog = Session::get('userLog');
        if($userLog){
            if ($userLog->VT_MA == 1 || $userLog->ND_MA == $binh_luan->ND_MA){
            }
            else{
                return Redirect::to('bai-dang/'.$binh_luan->BV_MA)->send();
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

    /**
     * Tạo bình luận mới(*)
     */
    public function create(){ //Không dùng
    }

    public function store(Request $request){///
        
        $this->AuthLogin_ND();

        $userLog = Session::get('userLog');

        $BL_TRALOI_MA = null;
        if($request->BL_TRALOI_MA != 0) $BL_TRALOI_MA = $request->BL_TRALOI_MA;

        //Bình luận
        DB::table('binh_luan')->insert([
            'ND_MA' => $userLog->ND_MA,
            'BV_MA' => $request->BV_MA,
            'BL_TRALOI_MA' => $BL_TRALOI_MA,
            'BL_NOIDUNG' => $request->BL_NOIDUNG,
            'BL_THOIGIANTAO' => Carbon::now('Asia/Ho_Chi_Minh')
        ]);

        $binh_luan = DB::table('binh_luan')->where('ND_MA', $userLog->ND_MA)
                ->orderby('binh_luan.BL_MA','desc')->first();

        //File đính kèm
        $linkFile = json_decode($request->input('linkFile'), true);
        $collection = 'FILE_DINH_KEM';
        
        if($linkFile && is_array($linkFile)){   
            foreach ($linkFile as $file) {
                $this->firestoreClient->addDocument($collection, [
                    'BV_MA' =>  0,  
                    'BL_MA' =>  $binh_luan->BL_MA,
                    'FDK_DUONGDAN'=> $file['link'],
                    'FDK_TEN' => $file['name'],
                    'ND_GUI_MA' => 0,
                    'ND_NHAN_MA' =>  0,
                    'TN_REALTIME'=> null,
                    'TN_THOIGIANGUI' => null,
                ]);
                //if($fileSend) ; else báo lỗi
            }
        }
        
        Session::put('BL_MA_Focus',$binh_luan->BL_MA);
        return Redirect::to('thong-bao-binh-luan/'.$binh_luan->BL_MA);
        //return response()->json(['BL_MA' => $binh_luan->BL_MA]);
        //return;
    }

    /**
     * Chi tiết bình luận
     */
    public function show(Comment $binh_luan){ //Không dùng
    }

    /**
     * Sửa comment (*****)
     */
    public function edit(Comment $binh_luan){ //Không dùng
    }

    public function update(Request $request, Comment $binh_luan){ ///
        $this->AuthLogin_BT($binh_luan);

        $userLog = Session::get('userLog');

        //Bình luận
        DB::table('binh_luan')
        ->where('BL_MA', $binh_luan->BL_MA)
        ->update([ 
            'BL_NOIDUNG' => $request->BL_NOIDUNG
        ]);

        //File đính kèm
        $linkFile = json_decode($request->input('linkFile'), true);
        $collection = 'FILE_DINH_KEM';
        
        if($linkFile && is_array($linkFile)){   
            foreach ($linkFile as $file) {
                $this->firestoreClient->addDocument($collection, [
                    'BV_MA' =>  0,  
                    'BL_MA' =>  $binh_luan->BL_MA,
                    'FDK_DUONGDAN'=> $file['link'],
                    'FDK_TEN' => $file['name'],
                    'ND_GUI_MA' => 0,
                    'ND_NHAN_MA' =>  0,
                    'TN_REALTIME'=> null,
                    'TN_THOIGIANGUI' => null,
                ]);
                //if($fileSend) ; else báo lỗi
            }
        }

        Session::put('alert', ['type' => 'success', 'content' => 'Cập nhật bình luận thành công!']);
        return;
    }

    /**
     * Xoá comment (****)
     */
    public function destroy(Comment $binh_luan){ ///
        $this->AuthLogin_BTwQTV($binh_luan);

        $userLog = Session::get('userLog');
        //Bài viết
        DB::table('binh_luan')
        ->where('BL_MA', $binh_luan->BL_MA)->delete();

        Session::put('alert', ['type' => 'success', 'content' => 'Xoá bình luận thành công!']);
        return;
    }

    /**
     * Bình luận - thích (*)
     */
    public function binhluan_thich($BL_MA){ ///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        $isExist = DB::table('binhluan_thich')
            ->where("BL_MA", $BL_MA)->where("ND_MA", $userLog->ND_MA)
            ->exists();

        if(!$isExist){
             DB::table('binhluan_thich')->insert([
                'ND_MA' => $userLog->ND_MA,
                'BL_MA' => $BL_MA,
                'BLT_THOIDIEM' => Carbon::now('Asia/Ho_Chi_Minh')
            ]);
        }
    }

    public function destroy_binhluan_thich($BL_MA){ ///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        $isExist = DB::table('binhluan_thich')
            ->where("BL_MA", $BL_MA)->where("ND_MA", $userLog->ND_MA)
            ->exists();

        if($isExist){
            DB::table('binhluan_thich')
            ->where('ND_MA',$userLog->ND_MA)->where('BL_MA',$BL_MA)
            ->delete();
        }
    }

    /**
     * Bình luận - lưu (*)
     */
    public function binhluan_luu($BL_MA){ ///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        $isExist = DB::table('danh_dau_boi')
            ->where("BL_MA", $BL_MA)->where("ND_MA", $userLog->ND_MA)
            ->exists();

        if(!$isExist){
             DB::table('danh_dau_boi')->insert([
                'ND_MA' => $userLog->ND_MA,
                'BL_MA' => $BL_MA
            ]);
        }
    }

    public function destroy_binhluan_luu($BL_MA){ ///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        $isExist = DB::table('danh_dau_boi')
            ->where("BL_MA", $BL_MA)->where("ND_MA", $userLog->ND_MA)
            ->exists();

        if($isExist){
            DB::table('danh_dau_boi')
            ->where('ND_MA',$userLog->ND_MA)->where('BL_MA',$BL_MA)
            ->delete();
        }
    }

    /**
     * Bình luận - báo cáo (*)
     */
    public function binhluan_baocao(Request $request, $BL_MA){ ///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        $isExist = DB::table('binhluan_baocao')
            ->where("BL_MA", $BL_MA)->where("ND_MA", $userLog->ND_MA)
            ->exists();

        if(!$isExist){
             DB::table('binhluan_baocao')->insert([
                'ND_MA' => $userLog->ND_MA,
                'BL_MA' => $BL_MA,
                'BLBC_THOIDIEM' => Carbon::now('Asia/Ho_Chi_Minh'),
                'BLBC_TRANGTHAI' => 0,
                'BLBC_NOIDUNG' => $request->BLBC_NOIDUNG,
            ]);
            Session::put('alert', ['type' => 'success', 'content' => 'Gửi báo cáo thành công!']);
        }
    }
    /*
    |--------------------------------------------------------------------------
    | KIỂM DUYỆT VIÊN
    |--------------------------------------------------------------------------
    */

    /**
     * Xem danh sách bài đăng
     */
    public function index()
    {
        //
    }


    /*
    |--------------------------------------------------------------------------
    | QUẢN TRỊ VIÊN
    |--------------------------------------------------------------------------
    */
    
}
