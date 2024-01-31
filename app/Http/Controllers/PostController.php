<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use MrShan0\PHPFirestore\FirestoreClient;

use Carbon\Carbon;
session_start();

class PostController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    HÀM HỖ TRỢ
    - Hàm xây dựng FireStore
    - Kiểm tra đăng nhập: Người dùng => (*)
    
    NGƯỜI DÙNG
    - Tạo bài đăng mới(*)
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
     * Tạo bài đăng mới(*)
     */
    public function create(){ //Không dùng
    }

    public function store(Request $request){ ///

        $this->AuthLogin_ND();

        $userLog = Session::get('userLog');
        //Bài viết
        DB::table('bai_viet')->insert([
            'ND_MA' => $userLog->ND_MA,
            'BV_TIEUDE' => $request->BV_TIEUDE,
            'BV_NOIDUNG' => $request->BV_NOIDUNG,
            'BV_TRANGTHAI' => 'Chưa duyệt',
            'BV_THOIGIANTAO' => Carbon::now('Asia/Ho_Chi_Minh'),
            'BV_LUOTXEM' => 0,
            'HP_MA' => $request->HP_MA ? $request->HP_MA : null
        ]);

        $bai_viet = DB::table('bai_viet')->where('ND_MA', $userLog->ND_MA)
                ->orderby('bai_viet.BV_MA','desc')->first();

        //Của bài viết
        $hashtags = json_decode($request->input('hashtags'), true);
        $hashtagsNew = json_decode($request->input('hashtagsNew'), true);

        if ($hashtags && is_array($hashtags)) {
            foreach ($hashtags as $item) {
                DB::table('cua_bai_viet')->insert([
                    'BV_MA' => $bai_viet->BV_MA,
                    'H_HASHTAG' => $item['name']
                ]);
            }
        } 
        if ($hashtagsNew && is_array($hashtagsNew)) {
            foreach ($hashtagsNew as $items_new) {
                DB::table('hashtag')->insert([
                    'H_HASHTAG' => $items_new['name']
                ]);

                DB::table('cua_bai_viet')->insert([
                    'BV_MA' => $bai_viet->BV_MA,
                    'H_HASHTAG' => $items_new['name']
                ]);
            }
        } 

        //File đính kèm
        $linkFile = json_decode($request->input('linkFile'), true);
        $collection = 'FILE_DINH_KEM';
        
        if($linkFile && is_array($linkFile)){   
            foreach ($linkFile as $file) {
                $fileSend = $fileSend = $this->firestoreClient->addDocument($collection, [
                    'BV_MA' =>  $bai_viet->BV_MA,  
                    'BL_MA' =>  0,
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
        
        return Redirect::to('trang-chu');
        
        /*echo '<pre>';
        print_r ($dontUseArray);
        print_r ($request->file('TN_FDK'));
        echo '</pre>';*/
    }

    /**
     * Xem chi tiết bài đăng
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Sửa bài đăng
     */
    public function edit(Post $post)
    {
        //
    }

    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Xoá bài đăng
     */
    public function destroy(Post $post)
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
