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
    - Tạo bài đăng mới(*), Xem chi tiết bài đăng
    - Bài viết - thích (*), Bài viết - lưu (*), Bài viết - báo cáo (*)
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
    public function AuthLogin_BT($bai_dang){ ///
        $userLog = Session::get('userLog');
        if($userLog){
            if ($userLog->ND_MA == $bai_dang->ND_MA){
            }
            else{
                return Redirect::to('bai-dang/'.$bai_dang->BV_MA)->send();
            }
        }else{
            return Redirect::to('dang-nhap')->send();
        }
    }


    /**
     * Kiểm tra đăng nhập: Bản thân & quản trị viên => (****)
     */
    public function AuthLogin_BTwQTV($bai_dang){ ///
        $userLog = Session::get('userLog');
        if($userLog){
            if ($userLog->VT_MA == 1 || $userLog->ND_MA == $bai_dang->ND_MA){
            }
            else{
                return Redirect::to('bai-dang/'.$bai_dang->BV_MA)->send();
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
                $this->firestoreClient->addDocument($collection, [
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
        //Xử lý đường dẫn: http://localhost/ctustucom/bai-dang/{bai_dang}?binh-luan={binh_luan}\
        $binhLuanMa = request()->query('binh-luan');
        if($binhLuanMa) Session::put('BL_MA_Focus', $binhLuanMa);
        $binhLuanMa = null;

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
        ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
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

        $hashtag = DB::table('hashtag')->get();

        //Bình luận
        $count_binh_luan = DB::table('bai_viet')
        ->join('binh_luan', 'binh_luan.BV_MA', '=', 'bai_viet.BV_MA')
        ->where('bai_viet.BV_MA', '=', $bai_dang->BV_MA)->count();

        $userLog = Session::get('userLog');
        $isBlock=0;
        $nguoi_dung_not_in3 = DB::table('nguoi_dung')->where('ND_TRANGTHAI', 0)->pluck('ND_MA')->toArray();

        $checkBlockBVTT = DB::table('bai_viet')->where('BV_MA', '=', $bai_dang->BV_MA)->where('BV_TRANGTHAI', '!=', 'Đã duyệt')->exists();
        if($checkBlockBVTT) $isBlock=1;
        
        if($userLog){
            $checkBlockBV = DB::table('baiviet_baocao')->where('ND_MA', $userLog->ND_MA)->where('BV_MA', '=', $bai_dang->BV_MA)->exists();
            $checkBlockND = DB::table('chan')->where('ND_CHAN_MA', $userLog->ND_MA)->where('ND_BICHAN_MA', '=', $bai_dang->ND_MA)->exists(); 
            $checkBlockND2 = DB::table('chan')->where('ND_CHAN_MA', $bai_dang->ND_MA)->where('ND_BICHAN_MA', '=', $userLog->ND_MA)->exists(); 
            $checkBlockND3 = DB::table('nguoi_dung')->where('ND_MA', $bai_dang->ND_MA)->where('ND_TRANGTHAI', 0)->exists(); 
            if($checkBlockBV || $checkBlockND || $checkBlockND2 || $checkBlockND3) $isBlock=1;

            $binh_luan_not_in = DB::table('binhluan_baocao')->where('ND_MA', $userLog->ND_MA)->pluck('BL_MA')->toArray();
            $nguoi_dung_not_in = DB::table('chan')->where('ND_CHAN_MA', $userLog->ND_MA)->pluck('ND_BICHAN_MA')->toArray();
            $nguoi_dung_not_in2 = DB::table('chan')->where('ND_BICHAN_MA', $userLog->ND_MA)->pluck('ND_CHAN_MA')->toArray();
            
            $binh_luan_goc = DB::table('binh_luan')
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'binh_luan.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('binh_luan.BV_MA', '=', $bai_dang->BV_MA)
            ->where('binh_luan.BL_TRALOI_MA', '=', null)
            ->whereNotIn('BL_MA', $binh_luan_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in2)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3)->get();

            $binh_luan_traloi = DB::table('binh_luan')
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'binh_luan.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('binh_luan.BV_MA', '=', $bai_dang->BV_MA)
            ->where('binh_luan.BL_TRALOI_MA', '!=', null)
            ->whereNotIn('BL_MA', $binh_luan_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in2)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3)->get();
            }
        else{
            $binh_luan_goc = DB::table('binh_luan')
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'binh_luan.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('binh_luan.BV_MA', '=', $bai_dang->BV_MA)
            ->where('binh_luan.BL_TRALOI_MA', '=', null)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3)->get();

            $binh_luan_traloi = DB::table('binh_luan')
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'binh_luan.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('binh_luan.BV_MA', '=', $bai_dang->BV_MA)
            ->where('binh_luan.BL_TRALOI_MA', '!=', null)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3)->get();
        }

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
        ->with('count_thich', $count_thich)->with('thich_no_get', $thich_no_get)->with('isBlock', $isBlock)
        ->with('count_binh_luan', $count_binh_luan)->with('binh_luan_goc', $binh_luan_goc)
        ->with('binh_luan_traloi', $binh_luan_traloi)->with('binh_luan_bv', $binh_luan_bv)
        ->with('binh_luan_no_get', $binh_luan_no_get)->with('binh_luan_thich_no_get', $binh_luan_thich_no_get)
        ->with('bai_viet_luu', $bai_viet_luu)->with('binh_luan_luu_no_get', $binh_luan_luu_no_get)
        ->with('hashtag', $hashtag);
    }

    public function find_baidang_binhluan($BL_MA){ ///
        $binh_luan_bv= DB::table('binh_luan')
        ->where('binh_luan.BL_MA', '=', $BL_MA)->first();
        $ma_bv = $binh_luan_bv->BV_MA;
        return Redirect::to('/bai-dang/'.$ma_bv.'?binh-luan='.$BL_MA);
    }

    /**
     * Sửa bài đăng (*****)
     */
    public function edit(Post $bai_dang){ //Không dùng
    }

    public function update(Request $request, Post $bai_dang){ ///
        $this->AuthLogin_BT($bai_dang);

        $userLog = Session::get('userLog');
        //Bài viết
        DB::table('bai_viet')
        ->where('BV_MA', $bai_dang->BV_MA)
        ->update([ 
            'BV_TIEUDE' => $request->BV_TIEUDE,
            'BV_NOIDUNG' => $request->BV_NOIDUNG,
            'BV_TRANGTHAI' => 'Chưa duyệt',
            'HP_MA' => $request->HP_MA ? $request->HP_MA : null
        ]);

        //Của bài viết
        $hashtag_bai_viet = DB::table('cua_bai_viet')->where('BV_MA', $bai_dang->BV_MA)
        ->delete();

        $hashtags = json_decode($request->input('hashtags'), true);
        $hashtagsNew = json_decode($request->input('hashtagsNew'), true);

        if ($hashtags && is_array($hashtags)) {
            foreach ($hashtags as $item) {
                DB::table('cua_bai_viet')->insert([
                    'BV_MA' => $bai_dang->BV_MA,
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
                    'BV_MA' => $bai_dang->BV_MA,
                    'H_HASHTAG' => $items_new['name']
                ]);
            }
        } 

        //File đính kèm
        $linkFile = json_decode($request->input('linkFile'), true);
        $collection = 'FILE_DINH_KEM';
        
        if($linkFile && is_array($linkFile)){   
            foreach ($linkFile as $file) {
                $this->firestoreClient->addDocument($collection, [
                    'BV_MA' =>  $bai_dang->BV_MA,  
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
        Session::put('alert', ['type' => 'success', 'content' => 'Cập nhật bài viết thành công!']);
        return;
    }

    /**
     * Xoá bài đăng
     */
    public function destroy(Post $bai_dang){ ///
        $this->AuthLogin_BTwQTV($bai_dang);

        $userLog = Session::get('userLog');
        //Bài viết
        DB::table('bai_viet')
        ->where('BV_MA', $bai_dang->BV_MA)
        ->update([ 
            'BV_TRANGTHAI' => 'Đã xoá'
        ]);

        Session::put('alert', ['type' => 'success', 'content' => 'Xoá bài viết thành công!']);
        return;
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
