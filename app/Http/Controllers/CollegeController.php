<?php

namespace App\Http\Controllers;

use App\Models\College;
use Illuminate\Http\Request;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use Carbon\Carbon;
session_start();

class CollegeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    HÀM HỖ TRỢ
    - Kiểm tra đăng nhập: Người dùng => (*)
    
    NGƯỜI DÙNG
    - Danh sách khoa trường, Chi tiết khoa trường
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
     * Danh sách khoa trường
     */
    public function list(){///
        $college = DB::table('khoa_truong')->orderby('KT_TEN')->get();
        return view('main_content.college.list_college')->with('college', $college);
    }

    /**
     * Chi tiết khoa trường
     */
    public function show(Request $request, College $khoa_truong){
        $userLog = Session::get('userLog');
        $college = DB::table('khoa_truong')->where('KT_MA', $khoa_truong->KT_MA)->first();
        $nguoi_dung_not_in3 = DB::table('nguoi_dung')->where('ND_TRANGTHAI', 0)->pluck('ND_MA')->toArray();

        if($userLog){
            $bai_viet_not_in = DB::table('baiviet_baocao')->where('ND_MA', $userLog->ND_MA)->pluck('BV_MA')->toArray();
            $nguoi_dung_not_in = DB::table('chan')->where('ND_CHAN_MA', $userLog->ND_MA)->pluck('ND_BICHAN_MA')->toArray();
            $nguoi_dung_not_in2 = DB::table('chan')->where('ND_BICHAN_MA', $userLog->ND_MA)->pluck('ND_CHAN_MA')->toArray();
            
            $bai_viet = DB::table('bai_viet')
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'bai_viet.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('bai_viet.BV_TRANGTHAI', '=', 'Đã duyệt')
            ->where('nguoi_dung.KT_MA', '=', $khoa_truong->KT_MA)
            ->orderBy('bai_viet.BV_THOIGIANDANG', 'desc')
            ->whereNotIn('bai_viet.BV_MA', $bai_viet_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in2)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3)->paginate(5);
        }
        else{
            $bai_viet = DB::table('bai_viet')
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'bai_viet.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('bai_viet.BV_TRANGTHAI', '=', 'Đã duyệt')
            ->where('nguoi_dung.KT_MA', '=', $khoa_truong->KT_MA)
            ->orderBy('bai_viet.BV_THOIGIANDANG', 'desc')
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3)->paginate(5);
        }
        
        $hashtag_bai_viet = DB::table('hashtag')
        ->join('cua_bai_viet', 'cua_bai_viet.H_HASHTAG', '=', 'hashtag.H_HASHTAG')->get();

        $hoc_phanKT = DB::table('hoc_phan')
        ->where('KT_MA', '=', $khoa_truong->KT_MA)->get();
        $hoc_phan = DB::table('hoc_phan')->get();

        $hashtag_list = DB::table('hashtag')->get();

        $count_thich = DB::table('bai_viet')
        ->join('baiviet_thich', 'baiviet_thich.BV_MA', '=', 'bai_viet.BV_MA')
        ->groupBy('bai_viet.BV_MA')->select('bai_viet.BV_MA', DB::raw('count(*) as count'))
        ->get();

        $thich_no_get = DB::table('bai_viet')
        ->join('baiviet_thich', 'baiviet_thich.BV_MA', '=', 'bai_viet.BV_MA');
        
        $count_binh_luan = DB::table('bai_viet')
        ->join('binh_luan', 'binh_luan.BV_MA', '=', 'bai_viet.BV_MA')
        ->groupBy('bai_viet.BV_MA')->select('bai_viet.BV_MA', DB::raw('count(*) as count'))
        ->get();

        if ($request->ajax()) {//Chạy nút load-more
            $view = view('main_component.post_loadmore')->with('bai_viet', $bai_viet)->with('hashtag', $hashtag_list)
            ->with('hashtag_bai_viet', $hashtag_bai_viet)->with('hoc_phan', $hoc_phan)->with('hoc_phanKT', $hoc_phanKT)
            ->with('count_thich', $count_thich)->with('count_binh_luan', $count_binh_luan)
            ->with('thich_no_get', $thich_no_get)->with('college', $college)->render();
  
            return response()->json(['html' => $view]);
        }
        //Bài viết End

        return view('main_content.college.show_college')->with('bai_viet', $bai_viet)->with('hashtag', $hashtag_list)
        ->with('hashtag_bai_viet', $hashtag_bai_viet)->with('hoc_phan', $hoc_phan)->with('hoc_phanKT', $hoc_phanKT)
        ->with('count_thich', $count_thich)->with('count_binh_luan', $count_binh_luan)
        ->with('thich_no_get', $thich_no_get)->with('college', $college);
    }

    /*
    |--------------------------------------------------------------------------
    | QUẢN TRỊ VIÊN
    |--------------------------------------------------------------------------
    */
    /**
     * Tất cả khoa trường
     */
    public function index()
    {
        //
    }


    /**
     * Thêm khoa trường
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    
    /**
     * Sửa khoa trường
     */
    public function edit(College $khoa_truong)
    {
        //
    }

    public function update(Request $request, College $khoa_truong)
    {
        //
    }

    /**
     * Xoá khoa trường
     */
    public function destroy(College $khoa_truong)
    {
        //
    }
}
