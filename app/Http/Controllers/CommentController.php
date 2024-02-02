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
    
    NGƯỜI DÙNG
    - Tạo bình luận mới(*)
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
                $fileSend = $fileSend = $this->firestoreClient->addDocument($collection, [
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
        //return Redirect::to('trang-chu');
        //return response()->json(['BL_MA' => $binh_luan->BL_MA]);
        return;
    }

    /**
     * Chi tiết bình luận
     */
    public function show(Comment $binh_luan){ //Không dùng
    }

    /**
     * Sửa comment
     */
    public function edit(Comment $binh_luan)
    {
        //
    }

    public function update(Request $request, Comment $binh_luan)
    {
        //
    }

    /**
     * Xoá comment
     */
    public function destroy(Comment $binh_luan)
    {
        //
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
