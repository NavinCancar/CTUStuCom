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
    - Tạo bài đăng mới(*), Bài viết - thích (*)
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
        
        //return Redirect::to('trang-chu');
        return;

        //Gọi bằng ajax nên không cần return gì
        /*echo '<pre>';
        print_r ($dontUseArray);
        print_r ($request->file('TN_FDK'));
        echo '</pre>';*/
    }

    /**
     * Xem chi tiết bài đăng
     */
    public function show(Post $bai_dang){ ///
        //Tăng lượt xem
        $bv = DB::table('bai_viet')->where('bai_viet.BV_MA', '=', $bai_dang->BV_MA)->first();
        $bvluotxem = $bv->BV_LUOTXEM;
        $bvluotxem = $bvluotxem + 1;
        DB::table('bai_viet')
        ->where('bai_viet.BV_MA', '=', $bai_dang->BV_MA)
        ->update([ 
            'BV_LUOTXEM' => $bvluotxem
        ]);

        $bai_viet = DB::table('bai_viet')
        ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'bai_viet.ND_MA')
        ->where('bai_viet.BV_MA', '=', $bai_dang->BV_MA)->get();
        
        $hashtag_bai_viet = DB::table('hashtag')
        ->join('cua_bai_viet', 'cua_bai_viet.H_HASHTAG', '=', 'hashtag.H_HASHTAG')
        ->where('cua_bai_viet.BV_MA', '=', $bai_dang->BV_MA)->get();

        $hoc_phan = DB::table('hoc_phan')->get();

        $count_thich = DB::table('bai_viet')
        ->join('baiviet_thich', 'baiviet_thich.BV_MA', '=', 'bai_viet.BV_MA')
        ->where('bai_viet.BV_MA', '=', $bai_dang->BV_MA)->count();

        $thich_no_get = DB::table('bai_viet')
        ->join('baiviet_thich', 'baiviet_thich.BV_MA', '=', 'bai_viet.BV_MA')
        ->where('bai_viet.BV_MA', '=', $bai_dang->BV_MA);

        //Bình luận
        $count_binh_luan = DB::table('bai_viet')
        ->join('binh_luan', 'binh_luan.BV_MA', '=', 'bai_viet.BV_MA')
        ->where('bai_viet.BV_MA', '=', $bai_dang->BV_MA)->count();

        $binh_luan_not_in = DB::table('binhluan_baocao')->pluck('BL_MA')->toArray();
        $binh_luan_goc = DB::table('binh_luan')
        ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'binh_luan.ND_MA')
        ->where('binh_luan.BV_MA', '=', $bai_dang->BV_MA)
        ->where('binh_luan.BL_TRALOI_MA', '=', null)
        ->whereNotIn('BL_MA', $binh_luan_not_in)->get();

        $binh_luan_traloi = DB::table('binh_luan')
        ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'binh_luan.ND_MA')
        ->where('binh_luan.BV_MA', '=', $bai_dang->BV_MA)
        ->where('binh_luan.BL_TRALOI_MA', '!=', null)
        ->whereNotIn('BL_MA', $binh_luan_not_in)->get();

        $binh_luan_bv= DB::table('binh_luan')
        ->where('binh_luan.BV_MA', '=', $bai_dang->BV_MA)
        ->pluck('BL_MA')->toArray();

        $binh_luan_no_get= DB::table('binh_luan')
        ->where('binh_luan.BV_MA', '=', $bai_dang->BV_MA);

        $binh_luan_thich_no_get = DB::table('binh_luan')
        ->join('binhluan_thich', 'binhluan_thich.BL_MA', '=', 'binh_luan.BL_MA')
        ->where('binh_luan.BV_MA', '=', $bai_dang->BV_MA);

        $bai_viet_luu= DB::table('danh_dau')
        ->where('danh_dau.BV_MA', '=', $bai_dang->BV_MA);

        $binh_luan_luu_no_get= DB::table('danh_dau_boi');

        return view('main_content.post.show_post')->with('bai_viet', $bai_viet)
        ->with('hashtag_bai_viet', $hashtag_bai_viet)->with('hoc_phan', $hoc_phan)
        ->with('count_thich', $count_thich)->with('thich_no_get', $thich_no_get)
        ->with('count_binh_luan', $count_binh_luan)->with('binh_luan_goc', $binh_luan_goc)
        ->with('binh_luan_traloi', $binh_luan_traloi)->with('binh_luan_bv', $binh_luan_bv)
        ->with('binh_luan_no_get', $binh_luan_no_get)->with('binh_luan_thich_no_get', $binh_luan_thich_no_get)
        ->with('bai_viet_luu', $bai_viet_luu)->with('binh_luan_luu_no_get', $binh_luan_luu_no_get);
    }

    /**
     * Sửa bài đăng
     */
    public function edit(Post $bai_dang)
    {
        //
    }

    public function update(Request $request, Post $bai_dang)
    {
        //
    }

    /**
     * Xoá bài đăng
     */
    public function destroy(Post $bai_dang)
    {
        //
    }

    /**
     * Bài viết - thích (*)
     */
    public function baidang_thich($BV_MA){ ///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        $isExist = DB::table('baiviet_thich')
            ->where("BV_MA", $BV_MA)->where("ND_MA", $userLog->ND_MA)
            ->exists();

        if(!$isExist){
             DB::table('baiviet_thich')->insert([
                'ND_MA' => $userLog->ND_MA,
                'BV_MA' => $BV_MA,
                'BVT_THOIDIEM' => Carbon::now('Asia/Ho_Chi_Minh')
            ]);
        }
    }

    public function destroy_baidang_thich($BV_MA){ ///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        $isExist = DB::table('baiviet_thich')
            ->where("BV_MA", $BV_MA)->where("ND_MA", $userLog->ND_MA)
            ->exists();

        if($isExist){
            DB::table('baiviet_thich')
            ->where('ND_MA',$userLog->ND_MA)->where('BV_MA',$BV_MA)
            ->delete();
        }
    }

    /**
     * Bài viết - lưu (*)
     */
    public function baidang_luu($BV_MA){ ///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        $isExist = DB::table('danh_dau')
            ->where("BV_MA", $BV_MA)->where("ND_MA", $userLog->ND_MA)
            ->exists();

        if(!$isExist){
             DB::table('danh_dau')->insert([
                'ND_MA' => $userLog->ND_MA,
                'BV_MA' => $BV_MA
            ]);
        }
    }

    public function destroy_baidang_luu($BV_MA){ ///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        $isExist = DB::table('danh_dau')
            ->where("BV_MA", $BV_MA)->where("ND_MA", $userLog->ND_MA)
            ->exists();

        if($isExist){
            DB::table('danh_dau')
            ->where('ND_MA',$userLog->ND_MA)->where('BV_MA',$BV_MA)
            ->delete();
        }
    }


    /**
     * Bài viết - báo cáo (*)
     */
    public function baidang_baocao(Request $request, $BV_MA){ ///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        $isExist = DB::table('baiviet_baocao')
            ->where("BV_MA", $BV_MA)->where("ND_MA", $userLog->ND_MA)
            ->exists();

        if(!$isExist){
             DB::table('baiviet_baocao')->insert([
                'ND_MA' => $userLog->ND_MA,
                'BV_MA' => $BV_MA,
                'BVBC_THOIDIEM' => Carbon::now('Asia/Ho_Chi_Minh'),
                'BVBC_TRANGTHAI' => 0,
                'BVBC_NOIDUNG' => $request->BVBC_NOIDUNG,
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
