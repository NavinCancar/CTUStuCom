<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class HomeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    HÀM HỖ TRỢ
    - Kiểm tra đăng nhập: Người dùng => (*)
    
    NGƯỜI DÙNG
    - Hiển thị trang chủ, Kho lưu trữ (*)
    |--------------------------------------------------------------------------
    */

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
     * Hiển thị trang chủ
     */
    public function index(Request $request){ ///
        //Bài viết Start
        $nguoi_dung_not_in3 = DB::table('nguoi_dung')->where('ND_TRANGTHAI', 0)->pluck('ND_MA')->toArray();

        $userLog = Session::get('userLog');
        if($userLog){
            $bai_viet_not_in = DB::table('baiviet_baocao')->where('ND_MA', $userLog->ND_MA)->pluck('BV_MA')->toArray();
            $nguoi_dung_not_in = DB::table('chan')->where('ND_CHAN_MA', $userLog->ND_MA)->pluck('ND_BICHAN_MA')->toArray();
            $nguoi_dung_not_in2 = DB::table('chan')->where('ND_BICHAN_MA', $userLog->ND_MA)->pluck('ND_CHAN_MA')->toArray();
            
            $bai_viet = DB::table('bai_viet')
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'bai_viet.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('bai_viet.BV_TRANGTHAI', '=', 'Đã duyệt')
            ->orderBy('BV_THOIGIANDANG', 'desc')
            ->whereNotIn('BV_MA', $bai_viet_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in2)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3)->paginate(5);
        }
        else{
            $bai_viet = DB::table('bai_viet')
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'bai_viet.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('bai_viet.BV_TRANGTHAI', '=', 'Đã duyệt')
            ->orderBy('BV_THOIGIANDANG', 'desc')
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3)->paginate(5);
        }
        
        $hashtag_bai_viet = DB::table('hashtag')
        ->join('cua_bai_viet', 'cua_bai_viet.H_HASHTAG', '=', 'hashtag.H_HASHTAG')->get();
        $hoc_phan = DB::table('hoc_phan')->get();

        $hashtag = DB::table('hashtag')->get();

        $count_thich = DB::table('bai_viet')
        ->join('baiviet_thich', 'baiviet_thich.BV_MA', '=', 'bai_viet.BV_MA')
        ->groupBy('bai_viet.BV_MA')->select('bai_viet.BV_MA', DB::raw('count(*) as count'))
        ->get();

        $thich_no_get = DB::table('bai_viet')
        ->join('baiviet_thich', 'baiviet_thich.BV_MA', '=', 'bai_viet.BV_MA');
        
        $count_binh_luan = DB::table('bai_viet')
        ->join('binh_luan', 'binh_luan.BV_MA', '=', 'bai_viet.BV_MA')
        ->where('binh_luan.BL_TRANGTHAI', '!=', 'Đã xoá')
        ->groupBy('bai_viet.BV_MA')->select('bai_viet.BV_MA', DB::raw('count(*) as count'))
        ->get();

        $bai_viet_luu= DB::table('danh_dau');

        if ($request->ajax()) {//Chạy nút load-more
            $view = view('main_component.post_loadmore')->with('bai_viet', $bai_viet)->with('hashtag', $hashtag)
            ->with('hashtag_bai_viet', $hashtag_bai_viet)->with('hoc_phan', $hoc_phan)
            ->with('count_thich', $count_thich)->with('count_binh_luan', $count_binh_luan)
            ->with('thich_no_get', $thich_no_get)->with('bai_viet_luu', $bai_viet_luu)->render();
  
            return response()->json(['html' => $view]);
        }
        //Bài viết End

        return view('main_content.home')->with('bai_viet', $bai_viet)->with('hashtag', $hashtag)
        ->with('hashtag_bai_viet', $hashtag_bai_viet)->with('hoc_phan', $hoc_phan)
        ->with('count_thich', $count_thich)->with('count_binh_luan', $count_binh_luan)
        ->with('thich_no_get', $thich_no_get)->with('bai_viet_luu', $bai_viet_luu);
    }


    /**
     * Kho lưu trữ (*)
     */
    public function archive(){ ///
        $this->AuthLogin_ND();
        return view('main_content.archive.archive');
    }

    public function post_archive(Request $request){ ///
        $this->AuthLogin_ND();
        //Bài viết Start
        $nguoi_dung_not_in3 = DB::table('nguoi_dung')->where('ND_TRANGTHAI', 0)->pluck('ND_MA')->toArray();

        $userLog = Session::get('userLog');

        $bai_viet_not_in = DB::table('baiviet_baocao')->where('ND_MA', $userLog->ND_MA)->pluck('BV_MA')->toArray();
        $nguoi_dung_not_in = DB::table('chan')->where('ND_CHAN_MA', $userLog->ND_MA)->pluck('ND_BICHAN_MA')->toArray();
        $nguoi_dung_not_in2 = DB::table('chan')->where('ND_BICHAN_MA', $userLog->ND_MA)->pluck('ND_CHAN_MA')->toArray();
        
        $bai_viet = DB::table('bai_viet')
        ->join('danh_dau', 'danh_dau.BV_MA', '=', 'bai_viet.BV_MA')
        ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'bai_viet.ND_MA')
        ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
        ->where('danh_dau.ND_MA', '=', $userLog->ND_MA)
        ->where('bai_viet.BV_TRANGTHAI', '=', 'Đã duyệt')
        ->orderBy('BV_THOIGIANDANG', 'desc')
        ->whereNotIn('bai_viet.BV_MA', $bai_viet_not_in)
        ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in)
        ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in2)
        ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3)->paginate(5);

        $hashtag_bai_viet = DB::table('hashtag')
        ->join('cua_bai_viet', 'cua_bai_viet.H_HASHTAG', '=', 'hashtag.H_HASHTAG')->get();
        $hoc_phan = DB::table('hoc_phan')->get();

        $hashtag = DB::table('hashtag')->get();

        $count_thich = DB::table('bai_viet')
        ->join('baiviet_thich', 'baiviet_thich.BV_MA', '=', 'bai_viet.BV_MA')
        ->groupBy('bai_viet.BV_MA')->select('bai_viet.BV_MA', DB::raw('count(*) as count'))
        ->get();

        $thich_no_get = DB::table('bai_viet')
        ->join('baiviet_thich', 'baiviet_thich.BV_MA', '=', 'bai_viet.BV_MA');
        
        $count_binh_luan = DB::table('bai_viet')
        ->join('binh_luan', 'binh_luan.BV_MA', '=', 'bai_viet.BV_MA')
        ->where('binh_luan.BL_TRANGTHAI', '!=', 'Đã xoá')
        ->groupBy('bai_viet.BV_MA')->select('bai_viet.BV_MA', DB::raw('count(*) as count'))
        ->get();

        $bai_viet_luu= DB::table('danh_dau');

        if ($request->ajax()) {//Chạy nút load-more
            $view = view('main_component.post_loadmore')->with('bai_viet', $bai_viet)->with('hashtag', $hashtag)
            ->with('hashtag_bai_viet', $hashtag_bai_viet)->with('hoc_phan', $hoc_phan)
            ->with('count_thich', $count_thich)->with('count_binh_luan', $count_binh_luan)
            ->with('thich_no_get', $thich_no_get)->with('bai_viet_luu', $bai_viet_luu)->render();
  
            return response()->json(['html' => $view]);
        }
        //Bài viết End

        return view('main_content.archive.post_archive')->with('bai_viet', $bai_viet)->with('hashtag', $hashtag)
        ->with('hashtag_bai_viet', $hashtag_bai_viet)->with('hoc_phan', $hoc_phan)
        ->with('count_thich', $count_thich)->with('count_binh_luan', $count_binh_luan)
        ->with('thich_no_get', $thich_no_get)->with('bai_viet_luu', $bai_viet_luu);
    }

    public function comment_archive(Request $request){ ///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        $binh_luan_not_in = DB::table('binhluan_baocao')->where('ND_MA', $userLog->ND_MA)->pluck('BL_MA')->toArray();
        $nguoi_dung_not_in = DB::table('chan')->where('ND_CHAN_MA', $userLog->ND_MA)->pluck('ND_BICHAN_MA')->toArray();
        $nguoi_dung_not_in2 = DB::table('chan')->where('ND_BICHAN_MA', $userLog->ND_MA)->pluck('ND_CHAN_MA')->toArray();
        $nguoi_dung_not_in3 = DB::table('nguoi_dung')->where('ND_TRANGTHAI', 0)->pluck('ND_MA')->toArray();

        $binh_luan = DB::table('binh_luan')
        ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'binh_luan.ND_MA')
        ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
        ->join('danh_dau_boi', 'danh_dau_boi.BL_MA', '=', 'binh_luan.BL_MA')
        ->where('danh_dau_boi.ND_MA', $userLog->ND_MA)
        ->where('binh_luan.BL_TRANGTHAI', 'Đang hiển thị')
        ->whereNotIn('binh_luan.BL_MA', $binh_luan_not_in)
        ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in)
        ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in2)
        ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3)
        ->orderby('binh_luan.BL_THOIGIANTAO', 'desc')->paginate(5);

        $binh_luan_no_get= DB::table('binh_luan')->where('binh_luan.BL_TRANGTHAI', '!=', 'Đã xoá');
        $binh_luan_thich_no_get = DB::table('binh_luan')
        ->join('binhluan_thich', 'binhluan_thich.BL_MA', '=', 'binh_luan.BL_MA')
        ->where('binh_luan.BL_TRANGTHAI', '!=', 'Đã xoá');

        $binh_luan_luu= DB::table('danh_dau_boi');
        
        if ($request->ajax()) {//Chạy nút load-more
            $view = view('main_component.comment_loadmore')
            ->with('binh_luan', $binh_luan)->with('binh_luan_no_get', $binh_luan_no_get)
            ->with('binh_luan_thich_no_get', $binh_luan_thich_no_get)->with('binh_luan_luu', $binh_luan_luu)->render();
  
            return response()->json(['html' => $view]);
        }

        return view('main_content.archive.comment_archive')
        ->with('binh_luan', $binh_luan)->with('binh_luan_no_get', $binh_luan_no_get)
        ->with('binh_luan_thich_no_get', $binh_luan_thich_no_get)->with('binh_luan_luu', $binh_luan_luu);
    }

    public function file_archive(){ ///
        $this->AuthLogin_ND();
        return view('main_content.archive.file_archive');
    }
}
