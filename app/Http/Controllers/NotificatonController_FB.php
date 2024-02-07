<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

use MrShan0\PHPFirestore\FirestoreClient;
use MrShan0\PHPFirestore\Fields\FirestoreTimestamp;
use MrShan0\PHPFirestore\Attributes\FirestoreDeleteAttribute;

class NotificatonController_FB extends Controller
{
    /*
    |--------------------------------------------------------------------------
    HÀM HỖ TRỢ
    - Hàm xây dựng FireStore
    - Kiểm tra đăng nhập: Người dùng => (*)
    
    NGƯỜI DÙNG
    - Thông báo(*)
    - Cập nhật thông báo thích(*), Cập nhật thông báo bình luận(*), Cập nhật thông báo báo cáo(*)
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
     * Thông báo(*)
     */

    public function index(){ ///
        $this->AuthLogin_ND();
        return view('main_content.notification');
    }

    /**
     * Cập nhật thông báo thích(*)
     */
    public function UpdateNotification_LikePost($BV_MA){ ///
        $this->AuthLogin_ND();

        $userLog = Session::get('userLog');
        $bai_viet = DB::table('bai_viet')
        ->where('BV_MA', $BV_MA)->select('bai_viet.ND_MA', 'bai_viet.BV_TIEUDE')->first();

        $baiviet_thich_count = DB::table('baiviet_thich')
        ->where('BV_MA', $BV_MA)->where('ND_MA', '!=', $bai_viet->ND_MA)->count();


        $baiviet_thich = DB::table('baiviet_thich')
        ->where('BV_MA', $BV_MA)
        ->orderBy('baiviet_thich.BVT_THOIDIEM', 'desc')
        ->select('baiviet_thich.ND_MA')->first();

        if($baiviet_thich != null && $baiviet_thich->ND_MA != $bai_viet->ND_MA){
            $nguoidung_thich = DB::table('nguoi_dung')
            ->where('ND_MA', $baiviet_thich->ND_MA)
            ->select('nguoi_dung.ND_MA', 'nguoi_dung.ND_HOTEN', 'nguoi_dung.ND_ANHDAIDIEN')->first();
                
            $string = $nguoidung_thich->ND_HOTEN.' đã thích bài viết "'.$bai_viet->BV_TIEUDE.'" của bạn';
            if ($baiviet_thich_count-1 > 0) $string .= ' cùng '.($baiviet_thich_count-1).' người khác'; //>1 vì trừ bản thân người like

            $documentRoot = 'THONG_BAO/'.$bai_viet->ND_MA.'thichbaiviet'.$BV_MA;
            $this->firestoreClient->updateDocument($documentRoot, [
                'ND_NHAN_MA' =>  $bai_viet->ND_MA,  
                'TB_ANHDINHKEM' => $nguoidung_thich->ND_ANHDAIDIEN,
                'TB_NOIDUNG' =>  $string,
                'TB_DUONGDAN'=> URL::to('/bai-dang/'.$BV_MA),
                'TB_LOAI' => 'thích bài viết',
                'TB_TRANGTHAI' => 0,
                'TB_REALTIME' => new FirestoreTimestamp,
            ]);
        }
    }

    public function UpdateNotification_LikeComment($BL_MA){ ///
        $this->AuthLogin_ND();

        $userLog = Session::get('userLog');
        $binh_luan = DB::table('binh_luan')
        ->join('bai_viet', 'bai_viet.BV_MA', '=', 'binh_luan.BV_MA')
        ->where('BL_MA', $BL_MA)->select('binh_luan.ND_MA', 'binh_luan.BV_MA' , 'bai_viet.BV_TIEUDE')->first();//ND chủ

        $binh_luan_nd = DB::table('binh_luan')
        ->where('BL_MA', $BL_MA)
        ->selectRaw('LEFT(BL_NOIDUNG, 20) AS BL_NOIDUNG_20')
        ->first();

        $binhluan_thich_count = DB::table('binhluan_thich')
        ->where('BL_MA', $BL_MA)->where('ND_MA', '!=', $binh_luan->ND_MA)->count();


        $binhluan_thich = DB::table('binhluan_thich')
        ->where('BL_MA', $BL_MA)
        ->orderBy('binhluan_thich.BLT_THOIDIEM', 'desc')
        ->select('binhluan_thich.ND_MA')->first();//ND thích

        if($binhluan_thich != null && $binhluan_thich->ND_MA != $binh_luan->ND_MA){
            $nguoidung_thich = DB::table('nguoi_dung')
            ->where('ND_MA', $binhluan_thich->ND_MA)
            ->select('nguoi_dung.ND_MA', 'nguoi_dung.ND_HOTEN', 'nguoi_dung.ND_ANHDAIDIEN')->first();//ND thích
                
            $string = $nguoidung_thich->ND_HOTEN.' đã thích bình luận "'.$binh_luan_nd->BL_NOIDUNG_20.'..." của bạn trong bài bài viết "'.$binh_luan->BV_TIEUDE.'"';
            if ($binhluan_thich_count-1 > 0) $string .= ' cùng '.($binhluan_thich_count-1).' người khác'; //>1 vì trừ bản thân người like

            $documentRoot = 'THONG_BAO/'.$binh_luan->ND_MA.'thichbinhluan'.$BL_MA;
            $this->firestoreClient->updateDocument($documentRoot, [
                'ND_NHAN_MA' =>  $binh_luan->ND_MA,  
                'TB_ANHDINHKEM' => $nguoidung_thich->ND_ANHDAIDIEN,
                'TB_NOIDUNG' =>  $string,
                'TB_DUONGDAN'=> URL::to('/bai-dang/'.$binh_luan->BV_MA.'?binh-luan='.$BL_MA),
                'TB_LOAI' => 'thích bình luận',
                'TB_TRANGTHAI' => 0,
                'TB_REALTIME' => new FirestoreTimestamp,
            ]);
        }
    }


    /**
     * Cập nhật thông báo bình luận(*)
     */
     public function UpdateNotification_CommentPost($BL_MA){ ///
        $this->AuthLogin_ND();

        $userLog = Session::get('userLog');
        $bv = DB::table('binh_luan')
        ->where('BL_MA', $BL_MA)->select('BV_MA', 'BL_TRALOI_MA')->first();
        $BV_MA = $bv->BV_MA;

        $bai_viet = DB::table('bai_viet')
        ->where('BV_MA', $BV_MA)->select('bai_viet.ND_MA', 'bai_viet.BV_TIEUDE')->first();

        $baiviet_binhluan_count = DB::table('binh_luan')
        ->where('BV_MA', $BV_MA)->where('ND_MA', '!=', $userLog->ND_MA)
        ->count(DB::raw('DISTINCT ND_MA'));

        $baiviet_binhluan = DB::table('binh_luan')
        ->where('BV_MA', $BV_MA)
        ->orderBy('binh_luan.BL_THOIGIANTAO', 'desc')
        ->select('binh_luan.ND_MA')->first();

        if($baiviet_binhluan != null){
            $nguoidung_top_binhluan = DB::table('nguoi_dung')
            ->where('ND_MA', $baiviet_binhluan->ND_MA)
            ->select('nguoi_dung.ND_MA', 'nguoi_dung.ND_HOTEN', 'nguoi_dung.ND_ANHDAIDIEN')->first();
                
            $string = $nguoidung_top_binhluan->ND_HOTEN.' đã tham gia thảo luận bài viết "'.$bai_viet->BV_TIEUDE.'" cùng bạn ';
            if ($baiviet_binhluan_count-1 > 0) $string .= ' và '.($baiviet_binhluan_count-1).' người khác'; //>1 vì trừ bản thân người bình luận

            $list_nguoidung_binhluan = DB::table('binh_luan')
            ->where('BV_MA', $BV_MA)->where('ND_MA', '!=', $nguoidung_top_binhluan->ND_MA)
            ->select(DB::raw('DISTINCT ND_MA'))->get();

            foreach ($list_nguoidung_binhluan as $nguoidung) {
                if($bai_viet->ND_MA == $nguoidung->ND_MA) {}
                $documentRoot = 'THONG_BAO/'.$nguoidung->ND_MA.'binhluan'.$BV_MA;
                $this->firestoreClient->updateDocument($documentRoot, [
                    'ND_NHAN_MA' =>  $nguoidung->ND_MA,  
                    'TB_ANHDINHKEM' => $nguoidung_top_binhluan->ND_ANHDAIDIEN,
                    'TB_NOIDUNG' =>  $string,
                    'TB_DUONGDAN'=> URL::to('/bai-dang/'.$BV_MA),
                    'TB_LOAI' => 'bình luận bài viết',
                    'TB_TRANGTHAI' => 0,
                    'TB_REALTIME' => new FirestoreTimestamp,
                ]);
            }




            //$bai_viet->ND_MA: Chủ bài viết
            $documentRoot = 'THONG_BAO/'.$bai_viet->ND_MA.'binhluan'.$BV_MA;
            $stringchu = $nguoidung_top_binhluan->ND_HOTEN.' đã tham gia thảo luận bài viết "'.$bai_viet->BV_TIEUDE.'" của bạn ';
            if ($baiviet_binhluan_count-1 > 0) $stringchu .= ' cùng '.($baiviet_binhluan_count-1).' người khác';
            $this->firestoreClient->updateDocument($documentRoot, [
                'ND_NHAN_MA' =>  $bai_viet->ND_MA,  
                'TB_ANHDINHKEM' => $nguoidung_top_binhluan->ND_ANHDAIDIEN,
                'TB_NOIDUNG' =>  $stringchu,
                'TB_DUONGDAN'=> URL::to('/bai-dang/'.$BV_MA),
                'TB_LOAI' => 'bình luận bài viết',
                'TB_TRANGTHAI' => 0,
                'TB_REALTIME' => new FirestoreTimestamp,
            ]);


            //bình luận trả lời
            if($bv->BL_TRALOI_MA != null){
                $bvgoc = DB::table('binh_luan')
                ->where('BL_MA', $bv->BL_TRALOI_MA)->select('ND_MA')->first();

                $documentRoot = 'THONG_BAO/'.$bvgoc->ND_MA.'binhluan'.$BV_MA;
                $stringchu = $nguoidung_top_binhluan->ND_HOTEN.' đã trả lời bình luận của bạn trong bài viết "'.$bai_viet->BV_TIEUDE.'"';
                if ($baiviet_binhluan_count-1 > 0) $stringchu .= ' và cùng thảo luận với '.($baiviet_binhluan_count-1).' người khác';
                $this->firestoreClient->updateDocument($documentRoot, [
                    'ND_NHAN_MA' =>  $bvgoc->ND_MA,  
                    'TB_ANHDINHKEM' => $nguoidung_top_binhluan->ND_ANHDAIDIEN,
                    'TB_NOIDUNG' =>  $stringchu,
                    'TB_DUONGDAN'=> URL::to('/bai-dang/'.$BV_MA),
                    'TB_LOAI' => 'bình luận bài viết',
                    'TB_TRANGTHAI' => 0,
                    'TB_REALTIME' => new FirestoreTimestamp,
                ]);
            }
        }
    }


    /**
     * Cập nhật thông báo báo cáo(*)
     */
    public function UpdateNotification_ReportPost($BV_MA){ ///
        $this->AuthLogin_ND();

        $userLog = Session::get('userLog');
        $bai_viet = DB::table('bai_viet')
        ->where('BV_MA', $BV_MA)->select('bai_viet.ND_MA', 'bai_viet.BV_TIEUDE')->first();

        $baiviet_baocao_count = DB::table('baiviet_baocao')
        ->where('BV_MA', $BV_MA)->where('ND_MA', '!=', $bai_viet->ND_MA)->count();


        $baiviet_baocao = DB::table('baiviet_baocao')
        ->where('BV_MA', $BV_MA)
        ->orderBy('baiviet_baocao.BVBC_THOIDIEM', 'desc')
        ->select('baiviet_baocao.ND_MA')->first();

        if($baiviet_baocao != null && $baiviet_baocao->ND_MA != $bai_viet->ND_MA){
            $nguoidung_baocao = DB::table('nguoi_dung')
            ->where('ND_MA', $baiviet_baocao->ND_MA)
            ->select('nguoi_dung.ND_MA', 'nguoi_dung.ND_HOTEN', 'nguoi_dung.ND_ANHDAIDIEN')->first();
                
            $string = $nguoidung_baocao->ND_HOTEN.' đã báo cáo bài viết "'.$bai_viet->BV_TIEUDE.'"';
            if ($baiviet_baocao_count-1 > 0) $string .= ' cùng '.($baiviet_baocao_count-1).' người khác'; //>1 vì trừ bản thân người like


            $list_nguoidung_kduyet = DB::table('nguoi_dung')
            ->where(function($query) {
                $query->where('VT_MA', 1)
                    ->orWhere('VT_MA', 2);
            })
            ->where('ND_MA', '!=', $nguoidung_baocao->ND_MA)
            ->where('ND_MA', '!=', $bai_viet->ND_MA)
            ->select(DB::raw('DISTINCT ND_MA'))
            ->get();

            foreach ($list_nguoidung_kduyet as $nguoidung) {
                $documentRoot = 'THONG_BAO/'.$nguoidung->ND_MA.'baocaobaiviet'.$BV_MA;
                $this->firestoreClient->updateDocument($documentRoot, [
                    'ND_NHAN_MA' =>  $nguoidung->ND_MA,  
                    'TB_ANHDINHKEM' => $nguoidung_baocao->ND_ANHDAIDIEN,
                    'TB_NOIDUNG' =>  $string,
                    'TB_DUONGDAN'=> URL::to('/bai-dang/'.$BV_MA),
                    'TB_LOAI' => 'báo cáo bài viết',
                    'TB_TRANGTHAI' => 0,
                    'TB_REALTIME' => new FirestoreTimestamp,
                ]);
            }
        }
    }

    public function UpdateNotification_ReportComment($BL_MA){ ///
        $this->AuthLogin_ND();

        $userLog = Session::get('userLog');
        $binh_luan = DB::table('binh_luan')
        ->join('bai_viet', 'bai_viet.BV_MA', '=', 'binh_luan.BV_MA')
        ->where('BL_MA', $BL_MA)->select('binh_luan.ND_MA', 'binh_luan.BV_MA' , 'bai_viet.BV_TIEUDE')->first();//ND chủ

        $binh_luan_nd = DB::table('binh_luan')
        ->where('BL_MA', $BL_MA)
        ->selectRaw('LEFT(BL_NOIDUNG, 20) AS BL_NOIDUNG_20')
        ->first();

        $binhluan_baocao_count = DB::table('binhluan_baocao')
        ->where('BL_MA', $BL_MA)->where('ND_MA', '!=', $binh_luan->ND_MA)->count();


        $binhluan_baocao = DB::table('binhluan_baocao')
        ->where('BL_MA', $BL_MA)
        ->orderBy('binhluan_baocao.BLBC_THOIDIEM', 'desc')
        ->select('binhluan_baocao.ND_MA')->first();//ND thích

        if($binhluan_baocao != null && $binhluan_baocao->ND_MA != $binh_luan->ND_MA){
            $nguoidung_baocao = DB::table('nguoi_dung')
            ->where('ND_MA', $binhluan_baocao->ND_MA)
            ->select('nguoi_dung.ND_MA', 'nguoi_dung.ND_HOTEN', 'nguoi_dung.ND_ANHDAIDIEN')->first();//ND thích
                
            $string = $nguoidung_baocao->ND_HOTEN.' đã báo cáo bình luận "'.$binh_luan_nd->BL_NOIDUNG_20.'..." trong bài bài viết "'.$binh_luan->BV_TIEUDE.'"';
            if ($binhluan_baocao_count-1 > 0) $string .= ' cùng '.($binhluan_baocao_count-1).' người khác'; //>1 vì trừ bản thân người like


            $list_nguoidung_kduyet = DB::table('nguoi_dung')
            ->where(function($query) {
                $query->where('VT_MA', 1)
                    ->orWhere('VT_MA', 2);
            })
            ->where('ND_MA', '!=', $nguoidung_baocao->ND_MA)
            ->where('ND_MA', '!=', $binh_luan->ND_MA)
            ->select(DB::raw('DISTINCT ND_MA'))
            ->get();

            foreach ($list_nguoidung_kduyet as $nguoidung) {
                $documentRoot = 'THONG_BAO/'.$nguoidung->ND_MA.'baocaobinhluan'.$BL_MA;
                $this->firestoreClient->updateDocument($documentRoot, [
                    'ND_NHAN_MA' =>  $nguoidung->ND_MA,  
                    'TB_ANHDINHKEM' => $nguoidung_baocao->ND_ANHDAIDIEN,
                    'TB_NOIDUNG' =>  $string,
                    'TB_DUONGDAN'=> URL::to('/bai-dang/'.$binh_luan->BV_MA.'?binh-luan='.$BL_MA),
                    'TB_LOAI' => 'báo cáo bình luận',
                    'TB_TRANGTHAI' => 0,
                    'TB_REALTIME' => new FirestoreTimestamp,
                ]);
            }
        }
    }
}
