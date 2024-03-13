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
    - Hiển thị trang chủ, Kho lưu trữ (*), Gợi ý hashtag, Lọc bài viết, Tìm bài viết
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
            
            $bai_viet_clone = DB::table('bai_viet')
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'bai_viet.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('bai_viet.BV_TRANGTHAI', '=', 'Đã duyệt')
            ->whereNotIn('BV_MA', $bai_viet_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in2)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3);

            $co_theo_doi = DB::table('theo_doi')
            ->where('ND_THEODOI_MA', $userLog->ND_MA)
            ->select('ND_DUOCTHEODOI_MA');

            $chua_hashtag_theo_doi = DB::table('cua_bai_viet')
            ->select('BV_MA', DB::raw('CASE WHEN cua_bai_viet.H_HASHTAG IN (SELECT H_HASHTAG FROM `theo_doi_boi` WHERE ND_MA = '.$userLog->ND_MA.') THEN 1 ELSE 0 END AS CBV_DIEM'));

            $subquery = $chua_hashtag_theo_doi->toSql();

            $sum_chua_hashtag_theo_doi = DB::table(DB::raw("($subquery) as temp_table"))
            ->groupBy('BV_MA')
            ->select(DB::raw('BV_MA AS BV_MA_GROUP_HASHTAG, SUM(CBV_DIEM) AS total_CBV_DIEM'));
            

            $bai_viet = $bai_viet_clone->clone()
            ->leftJoinSub($co_theo_doi, 'co_theo_doi', function ($join) {
                $join->on('bai_viet.ND_MA', '=', 'co_theo_doi.ND_DUOCTHEODOI_MA');
            })
            ->leftJoinSub($sum_chua_hashtag_theo_doi, 'hashtag_theo_doi', function ($join) {
                $join->on('bai_viet.BV_MA', '=', 'hashtag_theo_doi.BV_MA_GROUP_HASHTAG');
            })
            //->select('bai_viet.*', 'nguoi_dung.*', 'vai_tro.*', DB::raw('CASE WHEN co_theo_doi.ND_DUOCTHEODOI_MA IS NOT NULL THEN 1 ELSE 0 END + IFNULL(hashtag_theo_doi.total_CBV_DIEM, 0) AS BV_DIEM'))
            ->select('bai_viet.*', 'nguoi_dung.*', 'vai_tro.*', DB::raw('
                CASE 
                    WHEN bai_viet.BV_THOIGIANDANG >= NOW() - INTERVAL 7 DAY THEN 
                        CASE WHEN co_theo_doi.ND_DUOCTHEODOI_MA IS NOT NULL THEN 1 ELSE 0 END + IFNULL(hashtag_theo_doi.total_CBV_DIEM, 0)
                    ELSE 0
                END AS BV_DIEM'
            )) //Chỉ xét ưu tiên bài viết trong 7 ngày gần nhất
            ->orderBy('BV_DIEM', 'desc')->orderBy('BV_THOIGIANDANG', 'desc')
            ->paginate(5);

            /*echo '<pre>';
            print_r ($bai_viet);
            echo '</pre>';*/
        }
        else{
            $bai_viet_clone = DB::table('bai_viet')
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'bai_viet.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('bai_viet.BV_TRANGTHAI', '=', 'Đã duyệt')
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3);

            $bai_viet = $bai_viet_clone->clone()->orderBy('BV_THOIGIANDANG', 'desc')->paginate(5);
        }

        //$bai_viet = $bai_viet_clone->clone()->orderBy('BV_THOIGIANDANG', 'desc')->paginate(5);
        
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

        //Bài viết End


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
        ->joinSub($bv_hot, 'bv_hot', function ($join) {
            $join->on('bai_viet.BV_MA', '=', 'bv_hot.BV_MA_connect');
        })->orderBy('total_hot', 'desc')->limit(5)->get();
        //Bài viết nổi bật End

        $hashtag_hot = $bai_viet_clone->clone()
        ->join('cua_bai_viet', 'cua_bai_viet.BV_MA', '=', 'bai_viet.BV_MA')
        ->groupby('H_HASHTAG')
        ->select('H_HASHTAG')->selectRaw('COUNT(*) as sl_bv')
        ->orderby('sl_bv', 'desc')->limit(10)->get();

        $hoc_phan_hot = $bai_viet_clone->clone()->groupby('HP_MA')
        ->select('HP_MA')->selectRaw('COUNT(*) as sl_bv')
        ->orderby('sl_bv', 'desc')->limit(5)->get();

        //NỔI BẬT END

        $uSysAvatar = DB::table('nguoi_dung')->select('ND_MA', 'ND_HOTEN', 'ND_ANHDAIDIEN')->get();
        Session::put('uSysAvatar',$uSysAvatar->toArray());
        

        if ($request->ajax()) {//Chạy nút load-more
            $view = view('main_component.post_loadmore')->with('bai_viet', $bai_viet)->with('hashtag', $hashtag)
            ->with('hashtag_bai_viet', $hashtag_bai_viet)->with('hoc_phan', $hoc_phan)
            ->with('count_thich', $count_thich)->with('count_binh_luan', $count_binh_luan)
            ->with('thich_no_get', $thich_no_get)->with('bai_viet_luu', $bai_viet_luu)
            ->with('bai_viet_hot', $bai_viet_hot)->with('hashtag_hot', $hashtag_hot)->with('hoc_phan_hot', $hoc_phan_hot)->render();
  
            return response()->json(['html' => $view]);
        }

        return view('main_content.home')->with('bai_viet', $bai_viet)->with('hashtag', $hashtag)
        ->with('hashtag_bai_viet', $hashtag_bai_viet)->with('hoc_phan', $hoc_phan)
        ->with('count_thich', $count_thich)->with('count_binh_luan', $count_binh_luan)
        ->with('thich_no_get', $thich_no_get)->with('bai_viet_luu', $bai_viet_luu)
        ->with('bai_viet_hot', $bai_viet_hot)->with('hashtag_hot', $hashtag_hot)->with('hoc_phan_hot', $hoc_phan_hot);
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


    /**
     * Gợi ý hashtag
     */
    public function suggest_hashtag(Request $request){
        $hashtags = json_decode($request->input('hashtags'), true);

        if ($request->ajax()) {
        $output = '';

            if ($hashtags && is_array($hashtags)) {
                /*foreach ($hashtags as $item) {
                    $output .= $item['name'] .', ';
                }*/

                $initial_hashtag = '[';
                foreach ($hashtags as $item) {
                    $initial_hashtag .= $item['name'] . ', ';
                }
                // Loại bỏ dấu phẩy và khoảng trắng cuối cùng
                $initial_hashtag = rtrim($initial_hashtag, ', ');
                $initial_hashtag .= ']';

                // Chuyển đổi chuỗi thành mảng
                $initial_hashtag_array = explode(', ', substr($initial_hashtag, 1, -1));
                $count_initial_hashtag_array = count($initial_hashtag_array);

                //Lọc bài
                $nguoi_dung_not_in3 = DB::table('nguoi_dung')->where('ND_TRANGTHAI', 0)->pluck('ND_MA')->toArray();

                $bai_viet_not_in = DB::table('bai_viet')
                ->where('bai_viet.BV_TRANGTHAI', '!=', 'Đã duyệt')
                ->whereNotIn('ND_MA', $nguoi_dung_not_in3)->pluck('BV_MA')->toArray();

                // Những hashtag có khả năng sẽ gợi ý (diện hẹp)
                $post_have_initial_hashtag = DB::table('cua_bai_viet')
                ->whereIn('H_HASHTAG', $initial_hashtag_array)
                ->whereNotIn('BV_MA', $bai_viet_not_in)
                ->groupby('BV_MA')->havingRaw('COUNT(*) = ?', [$count_initial_hashtag_array])
                ->select('BV_MA')->distinct()->pluck('BV_MA')->toArray();

                // Những hashtag có khả năng sẽ gợi ý (diện rộng)
                /*$post_have_initial_hashtag = DB::table('cua_bai_viet')
                ->whereIn('H_HASHTAG', $initial_hashtag_array)
                ->whereNotIn('BV_MA', $bai_viet_not_in)
                ->select('BV_MA')->distinct()->pluck('BV_MA')->toArray();*/

                $maybe_suggest = DB::table('cua_bai_viet')
                ->whereIn('BV_MA', $post_have_initial_hashtag)
                ->whereNotIn('H_HASHTAG', $initial_hashtag_array)
                ->select('H_HASHTAG')->distinct()->get();

                $result_suggest = [];
                foreach($maybe_suggest as $maybe_suggest_tag){
                    //Tính số bài mà mỗi hashtag có thể gợi ý hay đi kèm
                    $number_of_post = DB::table('cua_bai_viet as c1')
                    ->join('cua_bai_viet as c2', 'c1.BV_MA', '=', 'c2.BV_MA')
                    ->where('c1.H_HASHTAG', '=', $maybe_suggest_tag->H_HASHTAG)
                    ->whereIn('c2.H_HASHTAG', $initial_hashtag_array)
                    ->select('c2.H_HASHTAG', DB::raw('COUNT(c2.BV_MA) as SLBV_DINHKEM'))
                    ->groupby('c2.H_HASHTAG')->get();
                    
                    $totalSLBV_DINHKEM = $number_of_post->sum('SLBV_DINHKEM');

                    $result_suggest[] = ['hashtag' => $maybe_suggest_tag->H_HASHTAG , 'number' => $totalSLBV_DINHKEM];
                }
                
                usort($result_suggest, function($a, $b) {
                    return $b['number'] - $a['number'];
                });

                return response()->json($result_suggest); //Kiểm tra kết quả select
            } 
            //return Response($output);
        }
    } 


    /**
     * Lọc bài viết
     */
    public function filter_post(Request $request){
        //Bài viết Start
        $nguoi_dung_not_in3 = DB::table('nguoi_dung')->where('ND_TRANGTHAI', 0)->pluck('ND_MA')->toArray();

        $userLog = Session::get('userLog');
        if($userLog){
            $bai_viet_not_in = DB::table('baiviet_baocao')->where('ND_MA', $userLog->ND_MA)->pluck('BV_MA')->toArray();
            $nguoi_dung_not_in = DB::table('chan')->where('ND_CHAN_MA', $userLog->ND_MA)->pluck('ND_BICHAN_MA')->toArray();
            $nguoi_dung_not_in2 = DB::table('chan')->where('ND_BICHAN_MA', $userLog->ND_MA)->pluck('ND_CHAN_MA')->toArray();
            
            $bai_viet_before_filter = DB::table('bai_viet')
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'bai_viet.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('bai_viet.BV_TRANGTHAI', '=', 'Đã duyệt')
            ->whereNotIn('BV_MA', $bai_viet_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in2)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3);
        }
        else{
            $bai_viet_before_filter = DB::table('bai_viet')
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'bai_viet.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('bai_viet.BV_TRANGTHAI', '=', 'Đã duyệt')
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3);
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
        //Bài viết End

        //FILTER START
        //Filter 1: Hashtag
        $hashtags = json_decode($request->input('hashtags2'), true);
        if ($hashtags && is_array($hashtags)) {
            $initial_hashtag = '[';
            foreach ($hashtags as $item) {
                $initial_hashtag .= $item['name'] . ', ';
            }
            // Loại bỏ dấu phẩy và khoảng trắng cuối cùng
            $initial_hashtag = rtrim($initial_hashtag, ', ');
            $initial_hashtag .= ']';

            // Chuyển đổi chuỗi thành mảng
            $initial_hashtag_array = explode(', ', substr($initial_hashtag, 1, -1));
            $count_initial_hashtag_array = count($initial_hashtag_array);

            // Những hashtag có khả năng sẽ gợi ý (diện hẹp)
            $post_have_initial_hashtag = DB::table('cua_bai_viet')
            ->whereIn('H_HASHTAG', $initial_hashtag_array)
            ->groupby('BV_MA')->havingRaw('COUNT(*) = ?', [$count_initial_hashtag_array])
            ->select('BV_MA')->distinct()->pluck('BV_MA')->toArray();

            $bai_viet_after_filter1 = $bai_viet_before_filter->whereIn('BV_MA', $post_have_initial_hashtag);
        } else $bai_viet_after_filter1 = $bai_viet_before_filter;

        //Filter 2: Học phần
        if($request->HP_MA){
            $bai_viet_after_filter2 = $bai_viet_after_filter1->where('HP_MA', $request->HP_MA);
        } else $bai_viet_after_filter2 = $bai_viet_after_filter1;

        //Filter 3: Khoa trường
        $kt_ten = "";
        if($request->KT_MA){
            $bai_viet_after_filter3 = $bai_viet_after_filter2->where('nguoi_dung.KT_MA', $request->KT_MA);
            $kt = DB::table('khoa_truong')->where('KT_MA', $request->KT_MA)->first();
            $kt_ten = $kt->KT_TEN;
        } else $bai_viet_after_filter3 = $bai_viet_after_filter2;

        //Filter 4: Từ khoá
        if($request->TU_KHOA != ""){
            if($request->TU_KHOA_TT == "phrase") {
                $bai_viet_after_filter4 = $bai_viet_after_filter3
                ->where(function ($query) use ($request) {
                    $query->where('BV_TIEUDE', 'like', '%' . $request->TU_KHOA . '%')
                          ->orWhere('BV_NOIDUNG', 'like', '%' . $request->TU_KHOA . '%');
                });
            }
            else if($request->TU_KHOA_TT == "word"){
                $words = explode(' ', $request->TU_KHOA);

                $bai_viet_after_filter4 = $bai_viet_after_filter3
                ->where(function ($query) use ($words) {
                    foreach ($words as $word) {
                        $query
                        ->where(function ($query) use ($word) {
                            $query->where('BV_TIEUDE', 'like', '%' . $word . '%')
                                  ->orWhere('BV_NOIDUNG', 'like', '%' . $word . '%');
                        });
                    }
                });
            }
            else $bai_viet_after_filter4 = $bai_viet_after_filter3;
        }
        else $bai_viet_after_filter4 = $bai_viet_after_filter3;
        
        //Filter 5: Sắp xếp
        if($request->BV_SAPXEP == "hot") {
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

            $bai_viet_after_filter5 = $bai_viet_after_filter4
            ->joinSub($bv_hot, 'bv_hot', function ($join) {
                $join->on('bai_viet.BV_MA', '=', 'bv_hot.BV_MA_connect');
            })->orderBy('total_hot', 'desc');
                
            //$bai_viet_after_filter5 = $bai_viet_after_filter4->orderBy('BV_THOIGIANDANG', 'desc');
        }
        else if($request->BV_SAPXEP == "new") $bai_viet_after_filter5 = $bai_viet_after_filter4->orderBy('BV_THOIGIANDANG', 'desc');
        else $bai_viet_after_filter5 = $bai_viet_after_filter4;

        /*echo '<pre>';
            print_r ('Sắp xếp: '.$request->BV_SAPXEP);
            $FDK_LOAI = $request->input('FDK_LOAI');
            if ($FDK_LOAI && is_array($FDK_LOAI)) {
                foreach ($FDK_LOAI as $loai) {
                    print_r ($loai);
                }
            } 
            print_r ('TT từ khoá: '.$request->TU_KHOA_TT);
            print_r ('Từ khoá: '.$request->TU_KHOA);
            print_r ('HP: '.$request->HP_MA);
            print_r ('KT: '.$request->KT_MA);
            print_r ($hashtags);
        echo '</pre>';*/

        $data_filter = [
            'BV_SAPXEP' => $request->BV_SAPXEP,
            'FDK_LOAI' => $request->input('FDK_LOAI'),
            'TU_KHOA_TT' => $request->TU_KHOA_TT,
            'TU_KHOA' => $request->TU_KHOA,
            'HP_MA' => $request->HP_MA,
            'KT_MA' => $request->KT_MA,
            'KT_TEN' => $kt_ten,
            'hashtags' => $request->input('hashtags2')
        ];
        
        $bai_viet = $bai_viet_after_filter5->get();
        
        return view('main_content.post.filter_post')->with('bai_viet', $bai_viet)->with('hashtag', $hashtag)
        ->with('hashtag_bai_viet', $hashtag_bai_viet)->with('hoc_phan', $hoc_phan)
        ->with('count_thich', $count_thich)->with('count_binh_luan', $count_binh_luan)
        ->with('thich_no_get', $thich_no_get)->with('bai_viet_luu', $bai_viet_luu)
        ->with('data_filter', $data_filter);/**/
    } 


    /**
     * Tìm bài viết
     */
    public function search_post(Request $request){
        //Bài viết Start
        $nguoi_dung_not_in3 = DB::table('nguoi_dung')->where('ND_TRANGTHAI', 0)->pluck('ND_MA')->toArray();

        $userLog = Session::get('userLog');
        if($userLog){
            $bai_viet_not_in = DB::table('baiviet_baocao')->where('ND_MA', $userLog->ND_MA)->pluck('BV_MA')->toArray();
            $nguoi_dung_not_in = DB::table('chan')->where('ND_CHAN_MA', $userLog->ND_MA)->pluck('ND_BICHAN_MA')->toArray();
            $nguoi_dung_not_in2 = DB::table('chan')->where('ND_BICHAN_MA', $userLog->ND_MA)->pluck('ND_CHAN_MA')->toArray();
            
            $bai_viet_before_search = DB::table('bai_viet')
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'bai_viet.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('bai_viet.BV_TRANGTHAI', '=', 'Đã duyệt')
            ->whereNotIn('BV_MA', $bai_viet_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in2)
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3);
        }
        else{
            $bai_viet_before_search = DB::table('bai_viet')
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'bai_viet.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('bai_viet.BV_TRANGTHAI', '=', 'Đã duyệt')
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3);
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
        //Bài viết End

        //SEARCH START

        $words = explode(' ', $request->keywords);

        $bai_viet_after_search = $bai_viet_before_search
        ->where(function ($query) use ($words) {
            foreach ($words as $word) {
                $query
                ->where(function ($query) use ($word) {
                    $query->where('BV_TIEUDE', 'like', '%' . $word . '%')
                            ->orWhere('BV_NOIDUNG', 'like', '%' . $word . '%');
                });
            }
        });
        
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

        $bai_viet = $bai_viet_after_search
        ->joinSub($bv_hot, 'bv_hot', function ($join) {
            $join->on('bai_viet.BV_MA', '=', 'bv_hot.BV_MA_connect');
        })->orderBy('total_hot', 'desc')->get();
        
        $keywords = $request->keywords;

        return view('main_content.post.search_post')->with('bai_viet', $bai_viet)->with('hashtag', $hashtag)
        ->with('hashtag_bai_viet', $hashtag_bai_viet)->with('hoc_phan', $hoc_phan)
        ->with('count_thich', $count_thich)->with('count_binh_luan', $count_binh_luan)
        ->with('thich_no_get', $thich_no_get)->with('bai_viet_luu', $bai_viet_luu)
        ->with('keywords', $keywords);/**/
    } 
}
