<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

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
    - Kiểm tra đăng nhập: Kiểm duyệt viên => (**)
    - Kiểm tra đăng nhập: Bản thân => (****)
    - Kiểm tra đăng nhập: Bản thân & quản trị viên => (******)
    
    NGƯỜI DÙNG
    - Tạo bài đăng mới (*), Xem chi tiết bài đăng, Sửa bài đăng (****), Xoá bài đăng (******)
    - Bài viết - thích (*), Bài viết - lưu (*), Bài viết - báo cáo (*)

    KIỂM DUYỆT VIÊN
    - Xem danh sách bài đăng (**), Bỏ qua báo cáo bài đăng (**), 
      Cập nhật trạng thái bài viết (**), Cập nhật hashtag bài viết (**)
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
     * Kiểm tra đăng nhập: Kiểm duyệt viên => (**)
     */
    public function AuthLogin_KDV(){ ///
        $userLog = Session::get('userLog');
        if($userLog){
            if ($userLog->VT_MA == 1 || $userLog->VT_MA == 2){
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
     * Kiểm tra đăng nhập: Bản thân & quản trị viên => (******)
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
     * Xem danh sách bài đăng của người dùng
     */
    public function list(){ ///
        $this->AuthLogin_ND();

        $userLog = Session::get('userLog');

        $bai_viet = DB::table('bai_viet')
            ->orderBy('BV_THOIGIANTAO', 'desc')
            ->where('ND_MA', $userLog->ND_MA)->paginate(10);

        return view('main_content.post.list_post')->with('bai_viet', $bai_viet);
    }

    /**
     * Tạo bài đăng mới (*)
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
        

        //Điểm cống hiến
        $userDCH = DB::table('nguoi_dung')->where('ND_MA', $userLog->ND_MA)->first();
        $DCH = $userDCH->ND_DIEMCONGHIEN + 1;
        DB::table('nguoi_dung')->where('ND_MA', $userDCH->ND_MA)
        ->update([
            'ND_DIEMCONGHIEN' => $DCH
        ]);

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
        //FOCUS: http://localhost/ctustucom/bai-dang/{bai_dang}?binh-luan={binh_luan}
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
        ->where('binh_luan.BL_TRANGTHAI', '!=', 'Đã xoá')
        ->where('bai_viet.BV_MA', '=', $bai_dang->BV_MA)->count();

        $userLog = Session::get('userLog');
        $isBlock=0;
        $nguoi_dung_not_in3 = DB::table('nguoi_dung')->where('ND_TRANGTHAI', 0)->pluck('ND_MA')->toArray();

        $checkBV = DB::table('bai_viet')->where('BV_MA', '=', $bai_dang->BV_MA)->first();
        if($checkBV->BV_TRANGTHAI != 'Đã duyệt') $isBlock=1;
        
        if($userLog){
            $checkBlockBV = DB::table('baiviet_baocao')->where('ND_MA', $userLog->ND_MA)->where('BV_MA', '=', $bai_dang->BV_MA)->exists();
            $checkBlockND = DB::table('chan')->where('ND_CHAN_MA', $userLog->ND_MA)->where('ND_BICHAN_MA', '=', $bai_dang->ND_MA)->exists(); 
            $checkBlockND2 = DB::table('chan')->where('ND_CHAN_MA', $bai_dang->ND_MA)->where('ND_BICHAN_MA', '=', $userLog->ND_MA)->exists(); 
            $checkBlockND3 = DB::table('nguoi_dung')->where('ND_MA', $bai_dang->ND_MA)->where('ND_TRANGTHAI', 0)->exists(); 
            if($checkBlockBV || $checkBlockND || $checkBlockND2 || $checkBlockND3) $isBlock=1;
            if($userLog->VT_MA == 1 || $userLog->VT_MA == 2 || ($checkBV->BV_TRANGTHAI != 'Đã duyệt' && $userLog->ND_MA == $checkBV->ND_MA)) $isBlock=0;

            $binh_luan_not_in = DB::table('binhluan_baocao')->where('ND_MA', $userLog->ND_MA)->pluck('BL_MA')->toArray();
            $nguoi_dung_not_in = DB::table('chan')->where('ND_CHAN_MA', $userLog->ND_MA)->pluck('ND_BICHAN_MA')->toArray();
            $nguoi_dung_not_in2 = DB::table('chan')->where('ND_BICHAN_MA', $userLog->ND_MA)->pluck('ND_CHAN_MA')->toArray();
            
            $binh_luan_goc = DB::table('binh_luan')
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'binh_luan.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('binh_luan.BV_MA', '=', $bai_dang->BV_MA)
            ->where('binh_luan.BL_TRANGTHAI', 'Đang hiển thị')
            ->where('binh_luan.BL_TRALOI_MA', '=', null)
            ->whereNotIn('BL_MA', $binh_luan_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in2)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3)->get();

            $binh_luan_traloi = DB::table('binh_luan')
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'binh_luan.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('binh_luan.BV_MA', '=', $bai_dang->BV_MA)
            ->where('binh_luan.BL_TRANGTHAI', 'Đang hiển thị')
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
            ->where('binh_luan.BL_TRANGTHAI', 'Đang hiển thị')
            ->where('binh_luan.BL_TRALOI_MA', '=', null)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3)->get();

            $binh_luan_traloi = DB::table('binh_luan')
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'binh_luan.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('binh_luan.BV_MA', '=', $bai_dang->BV_MA)
            ->where('binh_luan.BL_TRANGTHAI', 'Đang hiển thị')
            ->where('binh_luan.BL_TRALOI_MA', '!=', null)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3)->get();
        }

        $binh_luan_bv= DB::table('binh_luan')
        ->where('binh_luan.BV_MA', '=', $bai_dang->BV_MA)
        ->where('binh_luan.BL_TRANGTHAI', 'Đang hiển thị')
        ->pluck('BL_MA')->toArray();

        $binh_luan_no_get= DB::table('binh_luan')
        ->where('binh_luan.BV_MA', '=', $bai_dang->BV_MA)->where('binh_luan.BL_TRANGTHAI', '!=', 'Đã xoá');

        $binh_luan_thich_no_get = DB::table('binh_luan')
        ->join('binhluan_thich', 'binhluan_thich.BL_MA', '=', 'binh_luan.BL_MA')
        ->where('binh_luan.BV_MA', '=', $bai_dang->BV_MA)->where('binh_luan.BL_TRANGTHAI', '!=', 'Đã xoá');

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
     * Sửa bài đăng (****)
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
     * Xoá bài đăng (******)
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

        $bv = DB::table('bai_viet')->where('bai_viet.BV_MA', '=', $bai_dang->BV_MA)->first();
        //Điểm cống hiến
        $userDCH = DB::table('nguoi_dung')->where('ND_MA', $bv->ND_MA)->first();
        $DCH = $userDCH->ND_DIEMCONGHIEN - 1;
        DB::table('nguoi_dung')->where('ND_MA', $userDCH->ND_MA)
        ->update([
            'ND_DIEMCONGHIEN' => $DCH
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
                'BVBC_NOIDUNG' => $request->BVBC_NOIDUNG,
            ]);
            Session::put('alert', ['type' => 'success', 'content' => '<span class="px-4">Gửi báo cáo bài viết thành công, bài viết này sẽ bị ẩn đến bạn cho đến khi được kiểm duyệt viên xử lý</span>']);
        }
        else{
            DB::table('baiviet_baocao')
            ->where('ND_MA', $userLog->ND_MA)
            ->where('BV_MA', $BV_MA)
            ->update([
                'BVBC_THOIDIEM' => Carbon::now('Asia/Ho_Chi_Minh'),
                'BVBC_NOIDUNG' => $request->BVBC_NOIDUNG,
            ]);
            Session::put('alert', ['type' => 'success', 'content' => '<span class="px-4">Gửi báo cáo bài viết thành công, bài viết này sẽ bị ẩn đến bạn cho đến khi được kiểm duyệt viên xử lý</span>']);
        }
    }

    
    /*
    |--------------------------------------------------------------------------
    | KIỂM DUYỆT VIÊN
    |--------------------------------------------------------------------------
    */

    /**
     * Xem danh sách bài đăng (**)
     */
    public function index(){ ///
        $this->AuthLogin_KDV();

        $userLog = Session::get('userLog');

        //FOCUS: http://localhost/ctustucom/bai-dang?bai-dang={bai_viet}
        $baivietMa = request()->query('bai-dang');
        if($baivietMa) Session::put('BV_MA_Focus', $baivietMa);
        $baivietMa = null;

        //-----------------------------------------------------------------
        //MAIN
        $nguoi_dung_not_in3 = DB::table('nguoi_dung')->where('ND_TRANGTHAI', 0)->pluck('ND_MA')->toArray();
        $bai_viet = DB::table('bai_viet')
            ->orderBy('BV_THOIGIANTAO', 'desc')
            ->whereNotIn('ND_MA', $nguoi_dung_not_in3)->paginate(10);

        $baiviet_baocao_noget = DB::table('baiviet_baocao');

        //-----------------------------------------------------------------
        //BÁO CÁO: http://localhost/ctustucom/bai-dang?bao-cao={nhieu-nhat/gan-nhat}
        $filterReport = request()->query('bao-cao');
        if($filterReport == 'nhieu-nhat') {
            $bai_viet = DB::table('bai_viet')
            ->select('bai_viet.*', DB::raw('COUNT(baiviet_baocao.BV_MA) AS COUNT_BC'))
            ->leftJoin('baiviet_baocao', 'bai_viet.BV_MA', '=', 'baiviet_baocao.BV_MA')
            ->whereNotIn('bai_viet.ND_MA', $nguoi_dung_not_in3)
            ->groupBy('bai_viet.BV_MA', 
            'bai_viet.ND_MA', 'bai_viet.HP_MA', 'bai_viet.BV_TIEUDE', 'bai_viet.BV_NOIDUNG', 'bai_viet.BV_TRANGTHAI', 'bai_viet.BV_THOIGIANTAO', 'bai_viet.BV_THOIGIANDANG', 'bai_viet.BV_LUOTXEM')
            ->orderBy('COUNT_BC', 'desc')->paginate(10);
        }
        else if($filterReport == 'gan-nhat') {
            $bai_viet = DB::table('bai_viet')
            ->select('bai_viet.*')
            ->leftJoin('baiviet_baocao', 'bai_viet.BV_MA', '=', 'baiviet_baocao.BV_MA')
            ->whereNotIn('bai_viet.ND_MA', $nguoi_dung_not_in3)
            ->orderBy('BVBC_THOIDIEM', 'desc')->distinct()->paginate(10);
        }
        $filterReport = null;

        //TRẠNG THÁI: http://localhost/ctustucom/bai-dang?trang-thai={trang-thai}
        $filterState = request()->query('trang-thai');
        if($filterState) {
            $state = '';
            if($filterState == 'chua-duyet') $state = 'Chưa duyệt';
            else if($filterState == 'da-duyet') $state = 'Đã duyệt';
            else if($filterState == 'yeu-cau-chinh-sua') $state = 'Yêu cầu chỉnh sửa';
            else if($filterState == 'vi-pham-tieu-chuan') $state = 'Vi phạm tiêu chuẩn';
            else if($filterState == 'da-xoa') $state = 'Đã xoá';

            $bai_viet = DB::table('bai_viet')
            ->where('BV_TRANGTHAI', 'LIKE', $state.'%')
            ->orderBy('BV_THOIGIANTAO', 'desc')
            ->whereNotIn('ND_MA', $nguoi_dung_not_in3)->paginate(10);
        }
        $filterState = null;

        return view('main_content.post.all_post')
        ->with('bai_viet', $bai_viet)->with('baiviet_baocao_noget', $baiviet_baocao_noget);
    }

    public function index_detail(Request $request, $BV_MA){ ///
        $this->AuthLogin_KDV();

        $userLog = Session::get('userLog');

        if ($request->ajax()) {
            $bv = DB::table('bai_viet')
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'bai_viet.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('bai_viet.BV_MA', '=', $BV_MA)->first();

            $hashtag_bai_viet = DB::table('hashtag')
            ->join('cua_bai_viet', 'cua_bai_viet.H_HASHTAG', '=', 'hashtag.H_HASHTAG')
            ->where('cua_bai_viet.BV_MA', '=', $BV_MA)->get();

            $hoc_phan = DB::table('hoc_phan')->get();

            $count_thich = DB::table('bai_viet')
            ->join('baiviet_thich', 'baiviet_thich.BV_MA', '=', 'bai_viet.BV_MA')
            ->where('bai_viet.BV_MA', '=', $BV_MA)->count();

            $thich_no_get = DB::table('bai_viet')
            ->join('baiviet_thich', 'baiviet_thich.BV_MA', '=', 'bai_viet.BV_MA')
            ->where('bai_viet.BV_MA', '=', $BV_MA);

            $hashtag = DB::table('hashtag')->get();

            //Bình luận
            $count_binh_luan = DB::table('bai_viet')
            ->join('binh_luan', 'binh_luan.BV_MA', '=', 'bai_viet.BV_MA')
            ->where('bai_viet.BV_MA', '=', $BV_MA)
            ->where('binh_luan.BL_TRANGTHAI', '!=', 'Đã xoá')->count();

            //Báo cáo
            $bao_cao_noget = DB::table('baiviet_baocao')->where('BV_MA', $bv->BV_MA); 
            $bao_cao = $bao_cao_noget->clone()
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'baiviet_baocao.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')->orderby('BVBC_THOIDIEM', 'desc')->get(); 
            $count_bao_cao = $bao_cao_noget->clone()->count(); 

            $output = '';
            $output .= 
                '<!-- Modal Header -->
                    <div class="modal-header">
                        <form class="modal-title row" style="width: 95%">
                            <span class="d-flex justify-content-between align-items-center col-sm-9 mb-2">
                                <b>Trạng thái bài viết:</b>
                                <select name="BV_TRANGTHAI" ';
                                if($bv->BV_TRANGTHAI == 'Đã xoá') $output .=' disabled '; 
                                $output .= 'class="form-select w-75">';
                                    if($bv->BV_TRANGTHAI == 'Chưa duyệt') $output .='<option selected value="Chưa duyệt">Chưa duyệt</option>';
                        $output .= '<option';
                                        if($bv->BV_TRANGTHAI == 'Đã duyệt') $output .=' selected '; 
                                        $output .= ' value="Đã duyệt">Đã duyệt</option>
                                    <option';
                                        if(trim(strstr($bv->BV_TRANGTHAI, ':', true)) == 'Yêu cầu chỉnh sửa') $output .=' selected '; 
                                        $output .= ' value="Yêu cầu chỉnh sửa">Yêu cầu chỉnh sửa</option>
                                    <option'; 
                                        if(trim(strstr($bv->BV_TRANGTHAI, ':', true)) == 'Vi phạm tiêu chuẩn') $output .=' selected '; 
                                        $output .= ' value="Vi phạm tiêu chuẩn">Vi phạm tiêu chuẩn</option>';
                                    if($bv->BV_TRANGTHAI == 'Đã xoá') $output .='<option selected value="Đã xoá">Đã xoá</option>';    
                        $output .= '</select>
                            </span>
                            <span id="edit_BV_TRANGTHAI"'; 
                            if(trim(strstr($bv->BV_TRANGTHAI, ':', true)) != 'Yêu cầu chỉnh sửa') 
                            $output .= ' style="display: none;" '; $output .=' class="col-sm-9">

                                <span class="d-flex justify-content-between align-items-center">
                                    <b>Yêu cầu chỉnh sửa:</b>
                                    <input class="form-control w-75" name="BV_NOIDUNG_TRANGTHAI" value="'. ((trim(strstr($bv->BV_TRANGTHAI, ':', true)) == 'Yêu cầu chỉnh sửa') ? trim(strstr($bv->BV_TRANGTHAI, ':'), ': '):'') .'" list="datalistOptionsEdit" placeholder="Chọn hoăc nhập mới...">
                                    <datalist id="datalistOptionsEdit">
                                        <option value="Tiêu đề">
                                        <option value="Nội dung">
                                        <option value="File đính kèm">
                                        <option value="Ngôn từ">
                                        <option value="Viết tắt/teencode/chính tả">
                                    </datalist>
                                </span>
                            </span>
                            <span id="ban_BV_TRANGTHAI"'; 
                            if(trim(strstr($bv->BV_TRANGTHAI, ':', true)) != 'Vi phạm tiêu chuẩn') 
                            $output .= ' style="display: none;" '; $output .=' class="col-sm-9">

                                <span class="d-flex justify-content-between align-items-center">
                                    <b>Vi phạm tiêu chuẩn:</b>
                                    <input class="form-control w-75" name="BV_NOIDUNG_VIPHAM" value="'. ((trim(strstr($bv->BV_TRANGTHAI, ':', true)) == 'Vi phạm tiêu chuẩn') ? trim(strstr($bv->BV_TRANGTHAI, ':'), ': '):'') .'" list="datalistOptionsBan" placeholder="Chọn hoăc nhập mới...">
                                    <datalist id="datalistOptionsBan">
                                        <option value="Thông tin sai sự thật">
                                        <option value="Spam/Quảng cáo">
                                        <option value="Ngôn từ không phù hợp">
                                        <option value="Kích động, gây hiểu lầm">
                                        <option value="Phân biệt dân tộc/vùng miền/tôn giáo">
                                    </datalist>
                                </span>
                            </span>
                            <button type="button" id="update_BV_TRANGTHAI" class="btn btn-primary col-sm-3 mb-2">Cập nhật</button>
                        </form>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="text-notice text-notice-success alert alert-success mx-4" id="modal-alert-success" style="display: none">
                        <span></span>
                        <i class="fas fa-times-circle p-0 float-end" onclick="this.parentNode.style.display = \'none\'"></i>
                    </div>
                    <div class="text-notice text-notice-danger alert alert-danger mx-4" id="modal-alert-danger" style="display: none">
                        <span></span>
                        <i class="fas fa-times-circle p-0 float-end" onclick="this.parentNode.style.display = \'none\'"></i>
                    </div>';
            $output .='
                    <!-- Modal body -->
                    <div class="modal-body px-4 scroll-chat" style="height: auto; max-height: 430px;">
                        <div class="mb-3 mb-sm-0">
                            <div class="pb-2">
                            <a href="'. URL::to('/tai-khoan/'.$bv->ND_MA) .'" class="text-body">
                                <img src="'; if($bv->ND_ANHDAIDIEN) $output .= $bv->ND_ANHDAIDIEN; else $output .= 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2Fdefault.png?alt=media&token=16cbadb3-eed3-40d6-a6e5-f24f896b5c76'; $output .= '" alt="" width="36" height="36" class="rounded-circle">
                                <b>'. $bv->ND_HOTEN .'</b> 
                            </a>';
                            if($bv->VT_MA != 3) $output .='<span class="badge-sm bg-warning rounded-pill"><i>'. $bv->VT_TEN .'</i></span>';
                            if($bv->BV_THOIGIANDANG == null ) $output .= '<span class="thoigian"> đã gửi vào '. date('H:i', strtotime($bv->BV_THOIGIANTAO)) .' ngày '. date('d/m/Y', strtotime($bv->BV_THOIGIANTAO)).'</span>';
                            else $output .= '<span class="thoigian"> đã đăng vào '. date('H:i', strtotime($bv->BV_THOIGIANDANG)) .' ngày '. date('d/m/Y', strtotime($bv->BV_THOIGIANDANG)).'</span>';
                $output .= '</div>

                            <div class="mx-2">
                            <h5 class="card-title fw-semibold post-title">'. $bv->BV_TIEUDE .'</h5>
                            <span style="font-size: 0.92rem;">'. nl2br(e($bv->BV_NOIDUNG)) .'</span>
                            </div>

                            <!-- Images Container -->
                            <div id="images-container" class="m-2 mt-3 mb-3 position-relative"></div>

                            <!-- File Container -->
                            <div id="files-container" class=" m-2 mt-3"></div>
                            
                            <div class="m-2">';
                                if($bv->HP_MA){
                                    $hoc_phan_tim= $hoc_phan->where('HP_MA',$bv->HP_MA)->first();
                                    $output .= '<a href="'. URL::to('/hoc-phan/'.$bv->HP_MA) .'" previewlistener="true"><span class="badge bg-indigo rounded-3"><i class="fa fa-folder"></i> '. $hoc_phan_tim->HP_MA .' '. $hoc_phan_tim->HP_TEN .'</span></a> ';
                                } 
                                $output .= '<span class="listhashtag">';
                                foreach($hashtag_bai_viet as $key => $hbv){
                                    $output .= '<a href="'. URL::to('/hashtag/'.$hbv->H_HASHTAG) .'" previewlistener="true"><span class="badge bg-primary rounded-3 fw-semibold">#'. $hbv->H_HASHTAG .'</span></a> ';
                                }
                            $output .= '</span>&ensp;<a class="cursor-pointer" data-bs-toggle="collapse" data-bs-target="#them"><i class="far fa-edit text-muted"></i></a></div>
                            <form id="them" method="post" enctype="multipart/form-data" class="mb-3 pt-3 collapse">
                                <div class="output"></div>
                                <div class="d-flex">
                                    <input class="basic" name="BV_HASHTAG" placeholder="Hashtag đính kèm"/>

                                    <input type="hidden" name="hashtags" id="hashtagsInput" value="">
                                    <input type="hidden" name="hashtagsNew" id="hashtagsNewInput" value="">

                                    <button type="button" class="btn btn-primary w-25 float-sm-end" id="dangbai-btn">Cập nhật hashtag</button>
                                </div>
                            </form>
                            <div class="d-flex mt-2 pt-2 justify-content-end">
                                <a class="ms-3 text-muted"><i class="fas fa-eye"></i> Lượt xem: <b>'. $bv->BV_LUOTXEM .'</b></a></a>
                                <a class="ms-3 text-muted"><i class="fas fa-heart"></i> Thích: <b>'; if($count_thich) $output .= $count_thich; else $output .= '0'; $output .='</b></a>
                                <a class="ms-3 text-muted"><i class="fas fa-reply"></i> Trả lời: <b>'; if($count_binh_luan) $output .= $count_binh_luan; else $output .= '0'; $output .='</b></a>
                                <a class="ms-3 text-muted"><i class="fas fa-flag"></i> Báo cáo: <b>'; if($count_bao_cao) $output .= $count_bao_cao; else $output .= '0'; $output .='</b></a>
                            </div>
                        </div>';
                    if ($count_bao_cao != 0 && $bao_cao) {
                        $output .= 
                        '<!-- Báo cáo -->
                        <div id="modal-baocao">
                            <div class="mt-3 mb-3 mb-sm-0 d-sm-flex d-block align-items-center justify-content-between">
                                <h5 class="card-title fw-semibold">Danh sách báo cáo</h5>

                                <span class="align-items-center">
                                    <input class="form-check-input mt-1" id="check-all-BC_DUYET" type="checkbox">&ensp; Tất cả
                                    
                                    <a class="btn btn-danger btn-sm ms-4" previewlistener="true" id="check-BC_DUYET" >
                                        <i class="fas fa-times"></i> Bỏ qua báo cáo
                                    </a>
                                </span>
                            </div>
                            <hr>
                            <div class="form-check">';
                                foreach ($bao_cao as $key => $bc) {
                                    $output .= 
                                    '<div class="d-flex flex-row pb-3 pt-1" data-report-nd-value="'. $bc->ND_MA .'">
                                        <div>
                                        <a href="'. URL::to('/tai-khoan/'.$bc->ND_MA) .'" class="text-body" previewlistener="true">
                                            <img src="'; if($bc->ND_ANHDAIDIEN) $output .= $bc->ND_ANHDAIDIEN; else $output .= 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2Fdefault.png?alt=media&token=16cbadb3-eed3-40d6-a6e5-f24f896b5c76'; $output .= '" alt="" width="36" height="36" class="rounded-circle me-2">
                                        </a>
                                        </div>
                                        <div class="pt-1" style="width:100%">
                                            <div>
                                                <a href="'. URL::to('/tai-khoan/'.$bc->ND_MA) .'" class="text-muted" previewlistener="true"><span class="fw-bold mb-0">'. $bc->ND_HOTEN .'</span></a>';
                                                if($bc->VT_MA != 3) $output .='<span class="badge-sm bg-warning rounded-pill"><i>'. $bc->VT_TEN .'</i></span>';
                                                $output .= ' đã gửi vào '. date('H:i', strtotime($bc->BVBC_THOIDIEM)) .' ngày '. date('d/m/Y', strtotime($bc->BVBC_THOIDIEM)) .'

                                                <input class="form-check-input float-end" type="checkbox" name="BC_DUYET" value="'. $bc->ND_MA .'">
                                            </div>
                                            <span class="text-muted">'. $bc->BVBC_NOIDUNG .'</span>
                                        </div>
                                    </div>';
                                }
                            $output .='
                            </div>
                        </div>';
                    }    
                    $output .= 
                    '</div>
                    <!-- Data Loader -->
                    <div class="auto-load modal-auto-load text-center" style="display: none;">
                        <div class="spinner-border text-primary"></div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer"></div>';
            $output .= 
                '<!--XỬ LÝ HASHTAG START-->
                <script src="'. asset('public/js/tokenfield.web.js') .'"></script>
                
                <script>
                //Thêm bài
                var myItems = [';
                    foreach($hashtag as $key => $h){
                        $output .= "{ name: '".$h->H_HASHTAG."' }, ";
                    }
            $output .= '];
              var instance = new Tokenfield({
                el: document.querySelector(\'.basic\'),
                items: myItems,
        
                form: true, // Listens to reset event
                mode: \'tokenfield\', // tokenfield or list.
                addItemOnBlur: false,
                addItemsOnPaste: false,
                keepItemsOrder: true,
                setItems: [';
                  foreach($hashtag_bai_viet as $key => $hbvt){
                    $output .= "{ name: '".$hbvt->H_HASHTAG."' }, ";
                  }
            $output .= "], // array of pre-selected items
                newItems: true,
                multiple: true,
                maxItems: 5,
                minLength: 1,
                keys: {
                  17: 'ctrl',
                  16: 'shift',
                  91: 'meta',
                  8: 'delete', // Backspace
                  27: 'esc',
                  37: 'left',
                  38: 'up',
                  39: 'right',
                  40: 'down',
                  46: 'delete',
                  65: 'select', // A
                  67: 'copy', // C
                  88: 'cut', // X
                  32: 'delimiter', //Space
                  9: 'delimiter', // Tab
                  13: 'delimiter', // Enter
                  108: 'delimiter' // Numpad Enter
                },
                matchRegex: '{value}',
                matchFlags: 'i',
                matchStart: false,
                matchEnd: false,
                delimiters: [], // array of strings
                copyProperty: 'name',
                copyDelimiter: ', ',
                placeholder: null,
                inputType: 'text',
                minChars: 0,
                maxSuggest: 10,
                maxSuggestWindow: 10,
                filterSetItems: true,
                filterMatchCase: false,
                singleInput: false, // true, 'selector', or an element.
                singleInputValue: 'name',
                singleInputDelimiter: ', ',
                itemLabel: 'name',
                itemName: 'items',
                newItemName: 'items_new',
                itemValue: 'name',
                newItemValue: 'name',
                itemData: 'name',
                validateNewItem: null
              });
            
              //******** UPDATE FUTURE: Gợi ý hashtag chọn: Sự kiện thay đổi trạng thái của tokenfield, hiển thị cả item lẫn
              
            </script>
            <!--XỬ LÝ HASHTAG END-->";
            return Response($output);
        }
    }

    /**
     * Cập nhật trạng thái bài viết (**)
     */
    public function updateState(Request $request, $BV_MA){ ///
        $this->AuthLogin_KDV();

        $userLog = Session::get('userLog');
        //Bài viết
        DB::table('bai_viet')
        ->where('BV_MA', $BV_MA)
        ->update([ 
            'BV_TRANGTHAI' => $request->BV_TRANGTHAI,
        ]);

        if($request->BV_TRANGTHAI == 'Đã duyệt'){
            DB::table('bai_viet')
            ->where('BV_MA', $BV_MA)
            ->update([ 
                'BV_THOIGIANDANG' => Carbon::now('Asia/Ho_Chi_Minh'),
            ]);
        }

        $bv = DB::table('bai_viet')->where('bai_viet.BV_MA', '=', $BV_MA)->first();

        $output = '';
        $output .= 
        '<span class="d-flex justify-content-between align-items-center col-sm-9 mb-2">
                <b>Trạng thái bài viết:</b>
                <select name="BV_TRANGTHAI" ';
                if($bv->BV_TRANGTHAI == 'Đã xoá') $output .=' disabled '; 
                $output .= 'class="form-select w-75">';
                    if($bv->BV_TRANGTHAI == 'Chưa duyệt') $output .='<option selected value="Chưa duyệt">Chưa duyệt</option>';
        $output .= '<option';
                        if($bv->BV_TRANGTHAI == 'Đã duyệt') $output .=' selected '; 
                        $output .= ' value="Đã duyệt">Đã duyệt</option>
                    <option';
                        if(trim(strstr($bv->BV_TRANGTHAI, ':', true)) == 'Yêu cầu chỉnh sửa') $output .=' selected '; 
                        $output .= ' value="Yêu cầu chỉnh sửa">Yêu cầu chỉnh sửa</option>
                    <option'; 
                        if(trim(strstr($bv->BV_TRANGTHAI, ':', true)) == 'Vi phạm tiêu chuẩn') $output .=' selected '; 
                        $output .= ' value="Vi phạm tiêu chuẩn">Vi phạm tiêu chuẩn</option>';
                    if($bv->BV_TRANGTHAI == 'Đã xoá') $output .='<option selected value="Đã xoá">Đã xoá</option>';    
        $output .= '</select>
            </span>
            <span id="edit_BV_TRANGTHAI"'; 
            if(trim(strstr($bv->BV_TRANGTHAI, ':', true)) != 'Yêu cầu chỉnh sửa') 
            $output .= ' style="display: none;" '; $output .=' class="col-sm-9">

                <span class="d-flex justify-content-between align-items-center">
                    <b>Yêu cầu chỉnh sửa:</b>
                    <input class="form-control w-75" name="BV_NOIDUNG_TRANGTHAI" value="'. ((trim(strstr($bv->BV_TRANGTHAI, ':', true)) == 'Yêu cầu chỉnh sửa') ? trim(strstr($bv->BV_TRANGTHAI, ':'), ': '):'') .'" list="datalistOptionsEdit" placeholder="Chọn hoăc nhập mới...">
                    <datalist id="datalistOptionsEdit">
                        <option value="Tiêu đề">
                        <option value="Nội dung">
                        <option value="File đính kèm">
                        <option value="Ngôn từ">
                        <option value="Viết tắt/teencode/chính tả">
                    </datalist>
                </span>
            </span>
            <span id="ban_BV_TRANGTHAI"'; 
            if(trim(strstr($bv->BV_TRANGTHAI, ':', true)) != 'Vi phạm tiêu chuẩn') 
            $output .= ' style="display: none;" '; $output .=' class="col-sm-9">

                <span class="d-flex justify-content-between align-items-center">
                    <b>Vi phạm tiêu chuẩn:</b>
                    <input class="form-control w-75" name="BV_NOIDUNG_VIPHAM" value="'. ((trim(strstr($bv->BV_TRANGTHAI, ':', true)) == 'Vi phạm tiêu chuẩn') ? trim(strstr($bv->BV_TRANGTHAI, ':'), ': '):'') .'" list="datalistOptionsBan" placeholder="Chọn hoăc nhập mới...">
                    <datalist id="datalistOptionsBan">
                        <option value="Thông tin sai sự thật">
                        <option value="Spam/Quảng cáo">
                        <option value="Ngôn từ không phù hợp">
                        <option value="Kích động, gây hiểu lầm">
                        <option value="Phân biệt dân tộc/vùng miền/tôn giáo">
                    </datalist>
                </span>
            </span>
            <button type="button" id="update_BV_TRANGTHAI" class="btn btn-primary col-sm-3 mb-2">Cập nhật</button>';
        
        $thoiGianGui = '';
        if($request->BV_TRANGTHAI == 'Đã duyệt'){
            $thoiGianGui = ' đã đăng vào '. date('H:i', strtotime($bv->BV_THOIGIANDANG)) .' ngày '. date('d/m/Y', strtotime($bv->BV_THOIGIANDANG));
        }

        //Điểm cống hiến
        $userDCH = DB::table('nguoi_dung')->where('ND_MA', $bv->ND_MA)->first();
        if($bv->BV_TRANGTHAI == 'Đã duyệt'){
            $DCH = $userDCH->ND_DIEMCONGHIEN + 2;
            DB::table('nguoi_dung')->where('ND_MA', $userDCH->ND_MA)
            ->update([
                'ND_DIEMCONGHIEN' => $DCH
            ]);
        }
        else if(trim(strstr($bv->BV_TRANGTHAI, ':', true)) == 'Vi phạm tiêu chuẩn'){
            $DCH = $userDCH->ND_DIEMCONGHIEN - 3;
            DB::table('nguoi_dung')->where('ND_MA', $userDCH->ND_MA)
            ->update([
                'ND_DIEMCONGHIEN' => $DCH
            ]);
        }

        return Response()->json(['output' => $output, 'thoiGianGui' => $thoiGianGui]);
    }

    /**
     * Cập nhật hashtag bài viết (**)
     */
    public function updateHashtag(Request $request, $BV_MA){ ///
        $this->AuthLogin_KDV();

        $userLog = Session::get('userLog');
        //Của bài viết
        $hashtag_bai_viet = DB::table('cua_bai_viet')->where('BV_MA', $BV_MA)
        ->delete();

        $hashtags = json_decode($request->input('hashtags'), true);
        $hashtagsNew = json_decode($request->input('hashtagsNew'), true);

        if ($hashtags && is_array($hashtags)) {
            foreach ($hashtags as $item) {
                DB::table('cua_bai_viet')->insert([
                    'BV_MA' => $BV_MA,
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
                    'BV_MA' => $BV_MA,
                    'H_HASHTAG' => $items_new['name']
                ]);
            }
        } 
        
        $hashtag_bai_viet = DB::table('hashtag')
            ->join('cua_bai_viet', 'cua_bai_viet.H_HASHTAG', '=', 'hashtag.H_HASHTAG')
            ->where('cua_bai_viet.BV_MA', '=', $BV_MA)->get();

        $output = '';
        foreach($hashtag_bai_viet as $key => $hbv){
            $output .= '<a href="'. URL::to('/hashtag/'.$hbv->H_HASHTAG) .'" previewlistener="true"><span class="badge bg-primary rounded-3 fw-semibold">#'. $hbv->H_HASHTAG .'</span></a> ';
        }
        
        $hashtagGui = [];
        foreach($hashtag_bai_viet as $key => $hbvt){
            $hashtagGui[] = ["name" => $hbvt->H_HASHTAG];
        }
        $hashtagGuiJson = json_encode($hashtagGui);

        return Response()->json(['output' => $output, 'hashtagGui' => $hashtagGui]);
    }

    /**
     * Bỏ qua báo cáo bài đăng (**)
     */
    public function duyet_baidang_baocao(Request $request, $BV_MA){ ///
        $this->AuthLogin_KDV();
        $userLog = Session::get('userLog');

        $bcDuyetValues = json_decode($request->input('bcDuyetValues'), true);

        if ($bcDuyetValues && is_array($bcDuyetValues)) {
            foreach ($bcDuyetValues as $ND) {
                DB::table('baiviet_baocao')
                ->where('ND_MA', $ND)->where('BV_MA', $BV_MA)
                ->delete();
            }
        } 
    }

    /*
    |--------------------------------------------------------------------------
    | QUẢN TRỊ VIÊN
    |--------------------------------------------------------------------------
    */
    
}
