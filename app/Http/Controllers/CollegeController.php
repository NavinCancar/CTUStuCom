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
    - Kiểm tra đăng nhập: Quản trị viên => (***)
    
    NGƯỜI DÙNG
    - Danh sách khoa trường, Chi tiết khoa trường

    QUẢN TRỊ VIÊN
    - Tất cả khoa trường (***), Thêm khoa trường (***), Sửa khoa trường (***), Xoá khoa trường (***)
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

    /**
     * Kiểm tra đăng nhập: Quản trị viên => (***)
     */
    public function AuthLogin_QTV(){ ///
        $userLog = Session::get('userLog');
        if($userLog){
            if ($userLog->VT_MA == 1){
            }
            else{
                return Redirect::to('/')->send();
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
     * Danh sách khoa trường
     */
    public function list(){///
        $college = DB::table('khoa_truong')->orderby('KT_TEN')->get();
        return view('main_content.college.list_college')->with('college', $college);
    }

    /**
     * Chi tiết khoa trường
     */
    public function show(Request $request, College $khoa_truong){ ///
        $userLog = Session::get('userLog');
        $college = DB::table('khoa_truong')->where('KT_MA', $khoa_truong->KT_MA)->first();
        $nguoi_dung_not_in3 = DB::table('nguoi_dung')->where('ND_TRANGTHAI', 0)->pluck('ND_MA')->toArray();

        $bv = DB::table('bai_viet')
        ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'bai_viet.ND_MA')
        ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
        ->where('bai_viet.BV_TRANGTHAI', '=', 'Đã duyệt')
        ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3);

        $count_bai_viet = $bv->clone()
        ->where('nguoi_dung.KT_MA', '=', $khoa_truong->KT_MA)->count();

        if($userLog){
            $bai_viet_not_in = DB::table('baiviet_baocao')->where('ND_MA', $userLog->ND_MA)->pluck('BV_MA')->toArray();
            $nguoi_dung_not_in = DB::table('chan')->where('ND_CHAN_MA', $userLog->ND_MA)->pluck('ND_BICHAN_MA')->toArray();
            $nguoi_dung_not_in2 = DB::table('chan')->where('ND_BICHAN_MA', $userLog->ND_MA)->pluck('ND_CHAN_MA')->toArray();
            
            $bai_viet_clone = DB::table('bai_viet')
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'bai_viet.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('bai_viet.BV_TRANGTHAI', '=', 'Đã duyệt')
            ->whereNotIn('bai_viet.BV_MA', $bai_viet_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in2)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3);
        }
        else{
            $bai_viet_clone = $bv;
        }

        $bai_viet = $bai_viet_clone->clone()
        ->where('nguoi_dung.KT_MA', '=', $khoa_truong->KT_MA)
        ->orderBy('bai_viet.BV_THOIGIANDANG', 'desc')->paginate(5);
        
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
        ->where('binh_luan.BL_TRANGTHAI', '!=', 'Đã xoá')
        ->groupBy('bai_viet.BV_MA')->select('bai_viet.BV_MA', DB::raw('count(*) as count'))
        ->get();

        $bai_viet_luu= DB::table('danh_dau');


        //NỔI BẬT START

        //Bài viết nổi bật Start
        //Sắp xếp nổi bật
        $sl_thich = DB::table('baiviet_thich')
            ->select('BV_MA', DB::raw('COUNT(*) as SL_THICH'))
            ->groupBy('BV_MA')
            ->get();
        $sl_binh_luan = DB::table('binh_luan')
            ->select('BV_MA', DB::raw('COUNT(*) as SL_BINHLUAN'))
            ->groupBy('BV_MA')
            ->get();
        
        $bv_hot = DB::table('bai_viet')
            ->leftJoin(DB::raw('(SELECT BV_MA, COUNT(*) AS SL_THICH FROM baiviet_thich GROUP BY BV_MA) AS tb_thich'), function ($join) {
                $join->on('bai_viet.BV_MA', '=', 'tb_thich.BV_MA');
            })
            ->leftJoin(DB::raw('(SELECT BV_MA, COUNT(*) SL_BINHLUAN FROM binh_luan GROUP BY BV_MA) AS tb_binhluan'), function ($join) {
                $join->on('bai_viet.BV_MA', '=', 'tb_binhluan.BV_MA');
            })
            ->groupBy('bai_viet.BV_MA')
            ->select('bai_viet.BV_MA as BV_MA_connect')
            ->selectRaw('SUM(IFNULL(SL_THICH, 0) * 3 + IFNULL(SL_BINHLUAN, 0) * 5 + IFNULL(BV_LUOTXEM, 0)) AS total_hot');

        $bai_viet_hot = $bai_viet_clone->clone()
        ->where('nguoi_dung.KT_MA', '=', $khoa_truong->KT_MA)
        ->joinSub($bv_hot, 'bv_hot', function ($join) {
            $join->on('bai_viet.BV_MA', '=', 'bv_hot.BV_MA_connect');
        })->orderBy('total_hot', 'desc')->limit(5)->get();
        //Bài viết nổi bật End

        $hashtag_hot = $bai_viet_clone->clone()
        ->join('cua_bai_viet', 'cua_bai_viet.BV_MA', '=', 'bai_viet.BV_MA')
        ->where('nguoi_dung.KT_MA', '=', $khoa_truong->KT_MA)
        ->groupby('H_HASHTAG')
        ->select('H_HASHTAG')->selectRaw('COUNT(*) as sl_bv')
        ->orderby('sl_bv', 'desc')->limit(10)->get();

        $hoc_phan_hot = $bai_viet_clone->clone()
        ->join('hoc_phan', 'hoc_phan.HP_MA', '=', 'bai_viet.HP_MA')
        ->where('hoc_phan.KT_MA', '=', $khoa_truong->KT_MA)
        ->groupby('hoc_phan.HP_MA')
        ->select('hoc_phan.HP_MA')->selectRaw('COUNT(*) as sl_bv')
        ->orderby('sl_bv', 'desc')->limit(5)->get();

        //NỔI BẬT END

        if ($request->ajax()) {//Chạy nút load-more
            $view = view('main_component.post_loadmore')->with('count_bai_viet', $count_bai_viet)
            ->with('bai_viet', $bai_viet)->with('hashtag', $hashtag_list)
            ->with('hashtag_bai_viet', $hashtag_bai_viet)->with('hoc_phan', $hoc_phan)->with('hoc_phanKT', $hoc_phanKT)
            ->with('count_thich', $count_thich)->with('count_binh_luan', $count_binh_luan)
            ->with('thich_no_get', $thich_no_get)->with('college', $college)->with('bai_viet_luu', $bai_viet_luu)
            ->with('bai_viet_hot', $bai_viet_hot)->with('hashtag_hot', $hashtag_hot)->with('hoc_phan_hot', $hoc_phan_hot)->render();
  
            return response()->json(['html' => $view]);
        }
        //Bài viết End

        return view('main_content.college.show_college')->with('count_bai_viet', $count_bai_viet)
        ->with('bai_viet', $bai_viet)->with('hashtag', $hashtag_list)
        ->with('hashtag_bai_viet', $hashtag_bai_viet)->with('hoc_phan', $hoc_phan)->with('hoc_phanKT', $hoc_phanKT)
        ->with('count_thich', $count_thich)->with('count_binh_luan', $count_binh_luan)
        ->with('thich_no_get', $thich_no_get)->with('college', $college)->with('bai_viet_luu', $bai_viet_luu)
        ->with('bai_viet_hot', $bai_viet_hot)->with('hashtag_hot', $hashtag_hot)->with('hoc_phan_hot', $hoc_phan_hot);
    }

    /*
    |--------------------------------------------------------------------------
    | QUẢN TRỊ VIÊN
    |--------------------------------------------------------------------------
    */
    /**
     * Tất cả khoa trường (***)
     */
    public function index(){ ///
        $this->AuthLogin_QTV();
        $all_college = DB::table('khoa_truong')->orderby('KT_MA');

        //SEARCH: http://localhost/ctustucom/bai-dang?tu-khoa=18%2F03%2F2024
        $keywordSearch = request()->query('tu-khoa');
        if($keywordSearch){
            $all_college = $all_college->where(function ($query) use ($keywordSearch) {
                $query->where('khoa_truong.KT_MA', 'like', '%'.$keywordSearch.'%')
                      ->orWhere('khoa_truong.KT_TEN', 'like', '%'.$keywordSearch.'%');
            });
        }

        $all_college = $all_college->paginate(10);

        //$all_college = DB::table('khoa_truong')->orderby('KT_MA')->paginate(10);
        return view('main_content.college.all_college')->with('all_college', $all_college);
    }


    /**
     * Thêm khoa trường (***)
     */
    public function create(){ ///
        $this->AuthLogin_QTV();
        return view('main_content.college.add_college');
    }

    public function store(Request $request){ ///
        $this->AuthLogin_QTV();
        //Dò rỗng
        if(trim($request->KT_MA) == ""){
            Session::put('alert', ['type' => 'warning', 'content' => 'Mã khoa/trường không thể rỗng!']);
            return Redirect::to('khoa-truong/create');
        }
        if(trim($request->KT_TEN) == ""){
            Session::put('alert', ['type' => 'warning', 'content' => 'Tên khoa/trường không thể rỗng!']);
            return Redirect::to('khoa-truong/create');
        }

        //Dò trùng
        $dskt=DB::table('khoa_truong')->get();
        foreach ($dskt as $ds){
            if (strtolower($ds->KT_MA)==strtolower(trim($request->KT_MA))) {
                Session::put('alert', ['type' => 'warning', 'content' => 'Mã khoa/trường không thể trùng!']);
                return Redirect::to('khoa-truong/create');
            }
            if (strtolower($ds->KT_TEN)==strtolower(trim($request->KT_TEN))) {
                Session::put('alert', ['type' => 'warning', 'content' => 'Tên khoa/trường không thể trùng!']);
                return Redirect::to('khoa-truong/create');
            }
        }

        DB::table('khoa_truong')->insert([
            'KT_MA' => trim($request->KT_MA),
            'KT_TEN' => trim($request->KT_TEN),
        ]);
        Session::put('alert', ['type' => 'success', 'content' => 'Thêm khoa/trường thành công!']);
        return Redirect::to('khoa-truong');
    }

    
    /**
     * Sửa khoa trường (***)
     */
    public function edit(College $khoa_truong){ ///
        $this->AuthLogin_QTV();
        $all_college = DB::table('khoa_truong')->where('KT_MA', $khoa_truong->KT_MA)->get();
        return view('main_content.college.edit_college')->with('all_college', $all_college);
    }

    public function update(Request $request, College $khoa_truong){ ///
        $this->AuthLogin_QTV();
        
        //Dò rỗng
        if(trim($request->KT_TEN) == ""){
            Session::put('alert', ['type' => 'warning', 'content' => 'Tên khoa/trường không thể rỗng!']);
            return Redirect::to('khoa-truong/'.$khoa_truong->KT_MA.'/edit');
        }

        //Dò trùng
        $dskt=DB::table('khoa_truong')->get();
        foreach ($dskt as $ds){
            if ($ds->KT_TEN != $khoa_truong->KT_TEN && strtolower($ds->KT_TEN)==strtolower(trim($request->KT_TEN))) {
                Session::put('alert', ['type' => 'warning', 'content' => 'Tên khoa/trường không thể trùng!']);
                return Redirect::to('khoa-truong/'.$khoa_truong->KT_MA.'/edit');
            }
        }

        DB::table('khoa_truong') 
        ->where('KT_MA', $khoa_truong->KT_MA)
        ->update([
            'KT_TEN' => trim($request->KT_TEN),
        ]);
        Session::put('alert', ['type' => 'success', 'content' => 'Cập nhật khoa/trường thành công!']);
        return Redirect::to('khoa-truong');
    }

    /**
     * Xoá khoa trường (***)
     */
    public function destroy(College $khoa_truong){ ///
        $this->AuthLogin_QTV();

        //Kiểm tra khoá ngoại
        $checkforeign = DB::table('nguoi_dung')
        ->where('nguoi_dung.KT_MA',$khoa_truong->KT_MA)->exists();

        if($checkforeign){
            Session::put('alert', ['type' => 'warning', 'content' => 'Có người dùng thuộc khoa/trường này, khoa/trường này không thể xoá!']);
            return Redirect::to('khoa-truong');
        }

        $checkforeign2 = DB::table('hoc_phan')
        ->where('hoc_phan.KT_MA',$khoa_truong->KT_MA)->exists();

        if($checkforeign2){
            Session::put('alert', ['type' => 'warning', 'content' => 'Có học phần thuộc khoa/trường này, khoa/trường này không thể xoá!']);
            return Redirect::to('khoa-truong');
        }

        DB::table('khoa_truong')->where('KT_MA', $khoa_truong->KT_MA)->delete();
        Session::put('alert', ['type' => 'success', 'content' => 'Xoá khoa/trường thành công!']);
        return Redirect::to('khoa-truong');
    }
}
