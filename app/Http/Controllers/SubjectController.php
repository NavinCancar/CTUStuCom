<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use Carbon\Carbon;
session_start();

class SubjectController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    HÀM HỖ TRỢ
    - Kiểm tra đăng nhập: Người dùng => (*)
    - Kiểm tra đăng nhập: Quản trị viên => (***)
    
    NGƯỜI DÙNG
    - Danh sách học phần, Chi tiết học phần

    QUẢN TRỊ VIÊN
    - Tất cả học phần (***), Thêm học phần (***), Sửa học phần (***), Xoá học phần (***)
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
     * Danh sách học phần
     */
    public function list(){ ///
        $subject = DB::table('hoc_phan')->orderby('HP_TEN')->paginate(30);
        return view('main_content.subject.list_subject')->with('subject', $subject);
    }

    /**
     * Chi tiết học phần
     */
    public function show(Request $request, Subject $hoc_phan){ ///
        $userLog = Session::get('userLog');
        $subject_get = DB::table('hoc_phan')->where('HP_MA', $hoc_phan->HP_MA)->first();
        $nguoi_dung_not_in3 = DB::table('nguoi_dung')->where('ND_TRANGTHAI', 0)->pluck('ND_MA')->toArray();
                    
        if($userLog){
            $bai_viet_not_in = DB::table('baiviet_baocao')->where('ND_MA', $userLog->ND_MA)->pluck('BV_MA')->toArray();
            $nguoi_dung_not_in = DB::table('chan')->where('ND_CHAN_MA', $userLog->ND_MA)->pluck('ND_BICHAN_MA')->toArray();
            $nguoi_dung_not_in2 = DB::table('chan')->where('ND_BICHAN_MA', $userLog->ND_MA)->pluck('ND_CHAN_MA')->toArray();
            
            $bai_viet_clone = DB::table('bai_viet')
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'bai_viet.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('bai_viet.BV_TRANGTHAI', '=', 'Đã duyệt')
            ->where('bai_viet.HP_MA', '=', $hoc_phan->HP_MA)
            ->orderBy('bai_viet.BV_THOIGIANDANG', 'desc')
            ->whereNotIn('bai_viet.BV_MA', $bai_viet_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in2)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3);
        }
        else{
            $bai_viet_clone = DB::table('bai_viet')
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'bai_viet.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('bai_viet.BV_TRANGTHAI', '=', 'Đã duyệt')
            ->where('bai_viet.HP_MA', '=', $hoc_phan->HP_MA)
            ->orderBy('bai_viet.BV_THOIGIANDANG', 'desc')
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3);
        }
        
        $bai_viet = $bai_viet_clone->clone()->paginate(5);

        $hashtag_hot = $bai_viet_clone->clone()
        ->join('cua_bai_viet', 'cua_bai_viet.BV_MA', '=', 'bai_viet.BV_MA')
        ->groupby('H_HASHTAG')
        ->select('H_HASHTAG')->selectRaw('COUNT(*) as sl_bv')
        ->orderby('sl_bv', 'desc')->limit(7)->get();

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
        ->where('binh_luan.BL_TRANGTHAI', '!=', 'Đã xoá')
        ->groupBy('bai_viet.BV_MA')->select('bai_viet.BV_MA', DB::raw('count(*) as count'))
        ->get();

        $bai_viet_luu= DB::table('danh_dau');

        if ($request->ajax()) {//Chạy nút load-more
            $view = view('main_component.post_loadmore')->with('bai_viet', $bai_viet)->with('hashtag', $hashtag_list)
            ->with('hashtag_bai_viet', $hashtag_bai_viet)->with('hoc_phan', $hoc_phan)
            ->with('count_thich', $count_thich)->with('count_binh_luan', $count_binh_luan)
            ->with('thich_no_get', $thich_no_get)->with('subject_get', $subject_get)
            ->with('bai_viet_luu', $bai_viet_luu)->with('hashtag_hot', $hashtag_hot)->render();
  
            return response()->json(['html' => $view]);
        }
        //Bài viết End

        return view('main_content.subject.show_subject')->with('bai_viet', $bai_viet)->with('hashtag', $hashtag_list)
        ->with('hashtag_bai_viet', $hashtag_bai_viet)->with('hoc_phan', $hoc_phan)
        ->with('count_thich', $count_thich)->with('count_binh_luan', $count_binh_luan)
        ->with('thich_no_get', $thich_no_get)->with('subject_get', $subject_get)
        ->with('bai_viet_luu', $bai_viet_luu)->with('hashtag_hot', $hashtag_hot);
    }

    /*
    |--------------------------------------------------------------------------
    |  QUẢN TRỊ VIÊN
    |--------------------------------------------------------------------------
    */

    /**
     * Tất cả học phần (***)
     */
    public function index(){ ///
        $this->AuthLogin_QTV();
        $all_subject = DB::table('hoc_phan')
        ->join('khoa_truong', 'khoa_truong.KT_MA', '=', 'hoc_phan.KT_MA')->orderby('HP_MA')->paginate(10);
        return view('main_content.subject.all_subject')->with('all_subject', $all_subject);
    }


    /**
     * Thêm học phần (***)
     */
    public function create(){ ///
        $this->AuthLogin_QTV();
        $college = DB::table('khoa_truong')->get();
        return view('main_content.subject.add_subject')->with('college', $college);
    }

    public function store(Request $request){ ///
        $this->AuthLogin_QTV();
        //Dò rỗng
        if(trim($request->HP_MA) == ""){
            Session::put('alert', ['type' => 'warning', 'content' => 'Mã học phần không thể rỗng!']);
            return Redirect::to('hoc-phan/create');
        }
        if(trim($request->HP_TEN) == ""){
            Session::put('alert', ['type' => 'warning', 'content' => 'Tên học phần không thể rỗng!']);
            return Redirect::to('hoc-phan/create');
        }

        //Dò trùng
        $dshp=DB::table('hoc_phan')->get();
        foreach ($dshp as $ds){
            if (strtolower($ds->HP_MA)==strtolower(trim($request->HP_MA))) {
                Session::put('alert', ['type' => 'warning', 'content' => 'Mã học phần không thể trùng!']);
                return Redirect::to('hoc-phan/create');
            }
            if (strtolower($ds->HP_TEN)==strtolower(trim($request->HP_TEN))) {
                Session::put('alert', ['type' => 'warning', 'content' => 'Tên học phần không thể trùng!']);
                return Redirect::to('hoc-phan/create');
            }
        }

        DB::table('hoc_phan')->insert([
            'HP_MA' => trim($request->HP_MA),
            'HP_TEN' => trim($request->HP_TEN),
            'KT_MA' => $request->KT_MA,
        ]);
        Session::put('alert', ['type' => 'success', 'content' => 'Thêm học phần thành công!']);
        return Redirect::to('hoc-phan');
    }

    
    /**
     * Sửa học phần (***)
     */
    public function edit(Subject $hoc_phan){ ///
        $this->AuthLogin_QTV();
        $all_subject = DB::table('hoc_phan')->where('HP_MA', $hoc_phan->HP_MA)->get();
        $college = DB::table('khoa_truong')->get();
        return view('main_content.subject.edit_subject')
        ->with('all_subject', $all_subject)->with('college', $college);
    }

    public function update(Request $request, Subject $hoc_phan){ ///
        $this->AuthLogin_QTV();

        //Dò rỗng
        if(trim($request->HP_TEN) == ""){
            Session::put('alert', ['type' => 'warning', 'content' => 'Tên học phần không thể rỗng!']);
            return Redirect::to('hoc-phan/'.$hoc_phan->HP_MA.'/edit');
        }

        //Dò trùng
        $dshp=DB::table('hoc_phan')->get();
        foreach ($dshp as $ds){
            if ($ds->HP_TEN != $hoc_phan->HP_TEN && strtolower($ds->HP_TEN)==strtolower(trim($request->HP_TEN))) {
                Session::put('alert', ['type' => 'warning', 'content' => 'Tên học phần không thể trùng!']);
                return Redirect::to('hoc-phan/'.$hoc_phan->HP_MA.'/edit');
            }
        }

        DB::table('hoc_phan') 
        ->where('HP_MA', $hoc_phan->HP_MA)
        ->update([
            'HP_TEN' => trim($request->HP_TEN),
            'KT_MA' => $request->KT_MA,
        ]);
        Session::put('alert', ['type' => 'success', 'content' => 'Cập nhật học phần thành công!']);
        return Redirect::to('hoc-phan');
    }

    /**
     * Xoá học phần (***)
     */
    public function destroy(Subject $hoc_phan){ ///
        $this->AuthLogin_QTV();

        //Kiểm tra khoá ngoại
        $checkforeign = DB::table('bai_viet')
        ->where('bai_viet.HP_MA',$hoc_phan->HP_MA)->exists();

        if($checkforeign){
            Session::put('alert', ['type' => 'warning', 'content' => 'Có bài viết thuộc học phần này, học phần này không thể xoá!']);
            return Redirect::to('hoc-phan');
        }

        DB::table('hoc_phan')->where('HP_MA', $hoc_phan->HP_MA)->delete();
        Session::put('alert', ['type' => 'success', 'content' => 'Xoá học phần thành công!']);
        return Redirect::to('hoc-phan');
    }
}