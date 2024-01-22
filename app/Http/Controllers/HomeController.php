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
    | NGƯỜI DÙNG
    | - Hiển thị trang chủ
    |--------------------------------------------------------------------------
    */

    /**
     * Kiểm tra đăng nhập người dùng
     */
    public function AuthLogin_ND(){
        $userLog = Session::get('userLog');
        if($userLog){
        }else{
            return Redirect::to('dang-nhap')->send();
        }
    }

    /**
     * Hiển thị trang chủ
     */
    public function index(Request $request){
        //Bài viết Start
        $bai_viet = DB::table('bai_viet')
        ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'bai_viet.ND_MA')
        ->orderBy('BV_THOIGIANDANG', 'desc')->paginate(5);
        
        $hashtag_bai_viet = DB::table('hashtag')
        ->join('cua_bai_viet', 'cua_bai_viet.H_HASHTAG', '=', 'hashtag.H_HASHTAG')->get();
        $hoc_phan = DB::table('hoc_phan')->get();

        $hashtag = DB::table('hashtag')->get();

        $count_thich = DB::table('bai_viet')
        ->join('baiviet_thich', 'baiviet_thich.BV_MA', '=', 'bai_viet.BV_MA')
        ->groupBy('bai_viet.BV_MA')->select('bai_viet.BV_MA', DB::raw('count(*) as count'))
        ->get();

        
        $count_binh_luan = DB::table('bai_viet')
        ->join('binh_luan', 'binh_luan.BV_MA', '=', 'bai_viet.BV_MA')
        ->groupBy('bai_viet.BV_MA')->select('bai_viet.BV_MA', DB::raw('count(*) as count'))
        ->get();

        if ($request->ajax()) {
            $view = view('main_component.post_loadmore')->with('bai_viet', $bai_viet)->with('hashtag', $hashtag)
            ->with('hashtag_bai_viet', $hashtag_bai_viet)->with('hoc_phan', $hoc_phan)
            ->with('count_thich', $count_thich)->with('count_binh_luan', $count_binh_luan)->render();
  
            return response()->json(['html' => $view]);
        }
        //Bài viết End

        return view('main_content.home')->with('bai_viet', $bai_viet)->with('hashtag', $hashtag)
        ->with('hashtag_bai_viet', $hashtag_bai_viet)->with('hoc_phan', $hoc_phan)
        ->with('count_thich', $count_thich)->with('count_binh_luan', $count_binh_luan);
    }
}
