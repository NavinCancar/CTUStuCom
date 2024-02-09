<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use Illuminate\Http\Request;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use Carbon\Carbon;
session_start();

class HashtagController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    HÀM HỖ TRỢ
    - Kiểm tra đăng nhập: Người dùng => (*)
    
    NGƯỜI DÙNG
    - Danh sách hashtag, Chi tiết hashtag
    - Theo dõi hashtag (*)
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
     * Danh sách hashtag
     */
    public function list(){ ///
        $hashtag = DB::table('hashtag')->paginate(20);
        return view('main_content.hashtag.list_hashtag')->with('hashtag', $hashtag);
    }

    /**
     * Chi tiết hashtag
     */
    public function show(Request $request, Hashtag $hashtag){ ///
        $userLog = Session::get('userLog');
        $hashtag_get = DB::table('hashtag')->where('H_HASHTAG', $hashtag->H_HASHTAG)->first();
        $nguoi_dung_not_in3 = DB::table('nguoi_dung')->where('ND_TRANGTHAI', 0)->pluck('ND_MA')->toArray();

        if($userLog){
            $bai_viet_not_in = DB::table('baiviet_baocao')->where('ND_MA', $userLog->ND_MA)->pluck('BV_MA')->toArray();
            $nguoi_dung_not_in = DB::table('chan')->where('ND_CHAN_MA', $userLog->ND_MA)->pluck('ND_BICHAN_MA')->toArray();
            $nguoi_dung_not_in2 = DB::table('chan')->where('ND_BICHAN_MA', $userLog->ND_MA)->pluck('ND_CHAN_MA')->toArray();
            
            $bai_viet = DB::table('bai_viet')
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'bai_viet.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->join('cua_bai_viet', 'cua_bai_viet.BV_MA', '=', 'bai_viet.BV_MA')
            ->where('bai_viet.BV_TRANGTHAI', '=', 'Đã duyệt')
            ->where('cua_bai_viet.H_HASHTAG', '=', $hashtag->H_HASHTAG)
            ->orderBy('bai_viet.BV_THOIGIANDANG', 'desc')
            ->whereNotIn('bai_viet.BV_MA', $bai_viet_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in2)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3)->paginate(5);

            $isFollowHashtag = DB::table('theo_doi_boi')
            ->where("H_HASHTAG", $hashtag->H_HASHTAG)->where("ND_MA", $userLog->ND_MA)->exists();
        }
        else{
            $bai_viet = DB::table('bai_viet')
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'bai_viet.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->join('cua_bai_viet', 'cua_bai_viet.BV_MA', '=', 'bai_viet.BV_MA')
            ->where('bai_viet.BV_TRANGTHAI', '=', 'Đã duyệt')
            ->where('cua_bai_viet.H_HASHTAG', '=', $hashtag->H_HASHTAG)
            ->orderBy('bai_viet.BV_THOIGIANDANG', 'desc')
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3)->paginate(5);

            $isFollowHashtag = null;
        }
        
        $hashtag_bai_viet = DB::table('hashtag')
        ->join('cua_bai_viet', 'cua_bai_viet.H_HASHTAG', '=', 'hashtag.H_HASHTAG')->get();
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
            ->with('hashtag_bai_viet', $hashtag_bai_viet)->with('hoc_phan', $hoc_phan)
            ->with('count_thich', $count_thich)->with('count_binh_luan', $count_binh_luan)
            ->with('thich_no_get', $thich_no_get)->with('hashtag_get', $hashtag_get)
            ->with('isFollowHashtag', $isFollowHashtag)->render();
  
            return response()->json(['html' => $view]);
        }
        //Bài viết End

        return view('main_content.hashtag.show_hashtag')->with('bai_viet', $bai_viet)->with('hashtag', $hashtag_list)
        ->with('hashtag_bai_viet', $hashtag_bai_viet)->with('hoc_phan', $hoc_phan)
        ->with('count_thich', $count_thich)->with('count_binh_luan', $count_binh_luan)
        ->with('thich_no_get', $thich_no_get)->with('hashtag_get', $hashtag_get)
        ->with('isFollowHashtag', $isFollowHashtag);
    }


    /**
     * Theo dõi hashtag (*)
     */
    public function hashtag_theodoi(String $H_HASHTAG){ ///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        $isExist = DB::table('theo_doi_boi')
            ->where("H_HASHTAG", $H_HASHTAG)->where("ND_MA", $userLog->ND_MA)
            ->exists();

        if(!$isExist){
             DB::table('theo_doi_boi')->insert([
                'ND_MA' => $userLog->ND_MA,
                'H_HASHTAG' => $H_HASHTAG
            ]);
        }
    }

    public function destroy_hashtag_theodoi(String $H_HASHTAG){ ///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        $isExist = DB::table('theo_doi_boi')
            ->where("H_HASHTAG", $H_HASHTAG)->where("ND_MA", $userLog->ND_MA)
            ->exists();

        if($isExist){
            DB::table('theo_doi_boi')
            ->where('ND_MA',$userLog->ND_MA)->where("H_HASHTAG", $H_HASHTAG)
            ->delete();
        }
    }


    /*
    |--------------------------------------------------------------------------
    | KIỂM DUYỆT VIÊN
    |--------------------------------------------------------------------------
    */

    /**
     * Tất cả hashtag
     */
    public function index()
    {
    }
    /**
     * Thêm hashtag
     */
    public function create(){ //Không dùng
    }

    public function store(Request $request){ //Không dùng
    }

    /**
     * Sửa hashtag
     */
    public function edit(Hashtag $hashtag){ //Không dùng
    }

    public function update(Request $request, Hashtag $hashtag){ //Không dùng
    }

    /**
     * Xoá hashtag
     */
    public function destroy(Hashtag $hashtag)
    {
        //
    }
}
