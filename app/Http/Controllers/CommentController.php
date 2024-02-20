<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

use MrShan0\PHPFirestore\FirestoreClient;

use Carbon\Carbon;
session_start();

class CommentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    HÀM HỖ TRỢ
    - Hàm xây dựng FireStore
    - Kiểm tra đăng nhập: Người dùng => (*)
    - Kiểm tra đăng nhập: Kiểm duyệt viên => (**)
    - Kiểm tra đăng nhập: Bản thân => (****)
    - Kiểm tra đăng nhập: Bản thân & kiểm duyệt viên => (*****)
    - Kiểm tra đăng nhập: Bản thân & quản trị viên => (******)
    

    NGƯỜI DÙNG
    - Tạo bình luận mới (*), Sửa bình luận (****), Xoá bình luận (*****)
    - Bình luận - thích (*), Bình luận - lưu (*), Bình luận - báo cáo (*)


    KIỂM DUYỆT VIÊN
    - Xem danh sách bình luận (**), Duyệt báo cáo bình luận (**)
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
    public function AuthLogin_BT($binh_luan){ ///
        $userLog = Session::get('userLog');
        if($userLog){
            if ($userLog->ND_MA == $binh_luan->ND_MA){
            }
            else{
                return Redirect::to('bai-dang/'.$binh_luan->BV_MA)->send();
            }
        }else{
            return Redirect::to('dang-nhap')->send();
        }
    }


    /**
     * Kiểm tra đăng nhập: Bản thân & kiểm duyệt viên => (*****)
     */
    public function AuthLogin_BTwKDV($binh_luan){ ///
        $userLog = Session::get('userLog');
        if($userLog){
            if ($userLog->VT_MA == 1 || $userLog->VT_MA == 2 || $userLog->ND_MA == $binh_luan->ND_MA){
            }
            else{
                return Redirect::to('bai-dang/'.$binh_luan->BV_MA)->send();
            }
        }else{
            return Redirect::to('dang-nhap')->send();
        }
    }

    
    /**
     * Kiểm tra đăng nhập: Bản thân & quản trị viên => (******)
     */
    public function AuthLogin_BTwQTV($binh_luan){ ///
        $userLog = Session::get('userLog');
        if($userLog){
            if ($userLog->VT_MA == 1 || $userLog->ND_MA == $binh_luan->ND_MA){
            }
            else{
                return Redirect::to('bai-dang/'.$binh_luan->BV_MA)->send();
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
     * Tạo bình luận mới (*)
     */
    public function create(){ //Không dùng
    }

    public function store(Request $request){///
        
        $this->AuthLogin_ND();

        $userLog = Session::get('userLog');

        $BL_TRALOI_MA = null;
        if($request->BL_TRALOI_MA != 0) $BL_TRALOI_MA = $request->BL_TRALOI_MA;

        //Bình luận
        DB::table('binh_luan')->insert([
            'ND_MA' => $userLog->ND_MA,
            'BV_MA' => $request->BV_MA,
            'BL_TRALOI_MA' => $BL_TRALOI_MA,
            'BL_NOIDUNG' => $request->BL_NOIDUNG,
            'BL_THOIGIANTAO' => Carbon::now('Asia/Ho_Chi_Minh')
        ]);

        $binh_luan = DB::table('binh_luan')->where('ND_MA', $userLog->ND_MA)
                ->orderby('binh_luan.BL_MA','desc')->first();

        //File đính kèm
        $linkFile = json_decode($request->input('linkFile'), true);
        $collection = 'FILE_DINH_KEM';
        
        if($linkFile && is_array($linkFile)){   
            foreach ($linkFile as $file) {
                $this->firestoreClient->addDocument($collection, [
                    'BV_MA' =>  0,  
                    'BL_MA' =>  $binh_luan->BL_MA,
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
        
        Session::put('BL_MA_Focus',$binh_luan->BL_MA);
        return Redirect::to('thong-bao-binh-luan/'.$binh_luan->BL_MA);
        //return response()->json(['BL_MA' => $binh_luan->BL_MA]);
        //return;
    }

    /**
     * Chi tiết bình luận
     */
    public function show(Comment $binh_luan){ //Không dùng
    }

    /**
     * Sửa comment (****)
     */
    public function edit(Comment $binh_luan){ //Không dùng
    }

    public function update(Request $request, Comment $binh_luan){ ///
        $this->AuthLogin_BT($binh_luan);

        $userLog = Session::get('userLog');

        //Bình luận
        DB::table('binh_luan')
        ->where('BL_MA', $binh_luan->BL_MA)
        ->update([ 
            'BL_NOIDUNG' => $request->BL_NOIDUNG
        ]);

        //File đính kèm
        $linkFile = json_decode($request->input('linkFile'), true);
        $collection = 'FILE_DINH_KEM';
        
        if($linkFile && is_array($linkFile)){   
            foreach ($linkFile as $file) {
                $this->firestoreClient->addDocument($collection, [
                    'BV_MA' =>  0,  
                    'BL_MA' =>  $binh_luan->BL_MA,
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

        Session::put('alert', ['type' => 'success', 'content' => 'Cập nhật bình luận thành công!']);
        return;
    }

    /**
     * Xoá comment (*****)
     */
    public function destroy(Comment $binh_luan){ ///
        $this->AuthLogin_BTwKDV($binh_luan);

        $userLog = Session::get('userLog');
        //Bài viết
        DB::table('binh_luan')
        ->where('BL_MA', $binh_luan->BL_MA)->delete();

        Session::put('alert', ['type' => 'success', 'content' => 'Xoá bình luận thành công!']);
        return;
    }

    /**
     * Bình luận - thích (*)
     */
    public function binhluan_thich($BL_MA){ ///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        $isExist = DB::table('binhluan_thich')
            ->where("BL_MA", $BL_MA)->where("ND_MA", $userLog->ND_MA)
            ->exists();

        if(!$isExist){
             DB::table('binhluan_thich')->insert([
                'ND_MA' => $userLog->ND_MA,
                'BL_MA' => $BL_MA,
                'BLT_THOIDIEM' => Carbon::now('Asia/Ho_Chi_Minh')
            ]);
        }
    }

    public function destroy_binhluan_thich($BL_MA){ ///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        $isExist = DB::table('binhluan_thich')
            ->where("BL_MA", $BL_MA)->where("ND_MA", $userLog->ND_MA)
            ->exists();

        if($isExist){
            DB::table('binhluan_thich')
            ->where('ND_MA',$userLog->ND_MA)->where('BL_MA',$BL_MA)
            ->delete();
        }
    }

    /**
     * Bình luận - lưu (*)
     */
    public function binhluan_luu($BL_MA){ ///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        $isExist = DB::table('danh_dau_boi')
            ->where("BL_MA", $BL_MA)->where("ND_MA", $userLog->ND_MA)
            ->exists();

        if(!$isExist){
             DB::table('danh_dau_boi')->insert([
                'ND_MA' => $userLog->ND_MA,
                'BL_MA' => $BL_MA
            ]);
        }
    }

    public function destroy_binhluan_luu($BL_MA){ ///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        $isExist = DB::table('danh_dau_boi')
            ->where("BL_MA", $BL_MA)->where("ND_MA", $userLog->ND_MA)
            ->exists();

        if($isExist){
            DB::table('danh_dau_boi')
            ->where('ND_MA',$userLog->ND_MA)->where('BL_MA',$BL_MA)
            ->delete();
        }
    }

    /**
     * Bình luận - báo cáo (*)
     */
    public function binhluan_baocao(Request $request, $BL_MA){ ///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        $isExist = DB::table('binhluan_baocao')
            ->where("BL_MA", $BL_MA)->where("ND_MA", $userLog->ND_MA)
            ->exists();

        if(!$isExist){
             DB::table('binhluan_baocao')->insert([
                'ND_MA' => $userLog->ND_MA,
                'BL_MA' => $BL_MA,
                'BLBC_THOIDIEM' => Carbon::now('Asia/Ho_Chi_Minh'),
                'BLBC_TRANGTHAI' => 0,
                'BLBC_NOIDUNG' => $request->BLBC_NOIDUNG,
            ]);
            Session::put('alert', ['type' => 'success', 'content' => 'Gửi báo cáo thành công!']);
        }
        else{
            DB::table('binhluan_baocao')
            ->where('ND_MA', $userLog->ND_MA)
            ->where('BL_MA', $BL_MA)
            ->update([
                'BLBC_THOIDIEM' => Carbon::now('Asia/Ho_Chi_Minh'),
                'BLBC_TRANGTHAI' => 0,
                'BLBC_NOIDUNG' => $request->BLBC_NOIDUNG,
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
     * Xem danh sách bình luận (**)
     */
    public function index(){ ///
        $this->AuthLogin_KDV();

        $userLog = Session::get('userLog');
        
        //Xử lý đường dẫn: http://localhost/ctustucom/binh-luan?binh-luan={binh_luan}
        $binhLuanMa = request()->query('binh-luan');
        if($binhLuanMa) Session::put('BL_MA_Focus', $binhLuanMa);
        $binhLuanMa = null;

        $nguoi_dung_not_in3 = DB::table('nguoi_dung')->where('ND_TRANGTHAI', 0)->pluck('ND_MA')->toArray();
        $binh_luan = DB::table('binh_luan')
            ->orderBy('BL_THOIGIANTAO', 'desc')
            ->whereNotIn('nguoi_dung.ND_MA', $nguoi_dung_not_in3)->paginate(10);

        $binhluan_baocao_noget = DB::table('binhluan_baocao')->where('BLBC_TRANGTHAI', 0);

        return view('main_content.comment.all_comment')
        ->with('binh_luan', $binh_luan)->with('binhluan_baocao_noget', $binhluan_baocao_noget);
    }

    public function index_detail(Request $request, $BL_MA){ ///
        $this->AuthLogin_KDV();

        $userLog = Session::get('userLog');

        if ($request->ajax()) {
            $bl = DB::table('binh_luan')
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'binh_luan.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
            ->where('binh_luan.BL_MA', '=', $BL_MA)->first();

            $count_thich = DB::table('binh_luan')
            ->join('binhluan_thich', 'binhluan_thich.BL_MA', '=', 'binh_luan.BL_MA')
            ->where('binh_luan.BL_MA', '=', $BL_MA)->count();

            $thich_no_get = DB::table('binh_luan')
            ->join('binhluan_thich', 'binhluan_thich.BL_MA', '=', 'binh_luan.BL_MA')
            ->where('binh_luan.BL_MA', '=', $BL_MA);

            //Bình luận
            $count_bl_traloi = DB::table('binh_luan')
            ->where('binh_luan.BL_TRALOI_MA', $BL_MA)->count();

            //Báo cáo
            $bao_cao_noget = DB::table('binhluan_baocao')->where('BLBC_TRANGTHAI', 0)->where('BL_MA', $bl->BL_MA); 
            $bao_cao = $bao_cao_noget->clone()
            ->join('nguoi_dung', 'nguoi_dung.ND_MA', '=', 'binhluan_baocao.ND_MA')
            ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')->orderby('BLBC_THOIDIEM', 'desc')->get(); 
            $count_bao_cao = $bao_cao_noget->clone()->count(); 

            $output = '';
            $output .= 
                '<!-- Modal Header -->
                    <div class="modal-header">
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
                    <div class="modal-body px-4 scroll-chat" style="height: auto; max-height: 320px;">
                        <div class="mb-3 mb-sm-0">
                            <div class="pb-2">
                            <a href="'. URL::to('/tai-khoan/'.$bl->ND_MA) .'" class="text-body">
                                <img src="'; if($bl->ND_ANHDAIDIEN) $output .= $bl->ND_ANHDAIDIEN; else $output .= 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2Fdefault.png?alt=media&token=16cbadb3-eed3-40d6-a6e5-f24f896b5c76'; $output .= '" alt="" width="36" height="36" class="rounded-circle">
                                <b>'. $bl->ND_HOTEN .'</b> 
                            </a>';
                            if($bl->VT_MA != 3) $output .='<span class="badge-sm bg-warning rounded-pill"><i>'. $bl->VT_TEN .'</i></span>';
                            $output .= ' đã gửi vào '. date('H:i', strtotime($bl->BL_THOIGIANTAO)) .' ngày '. date('d/m/Y', strtotime($bl->BL_THOIGIANTAO)) .'
                            <button type="button" class="btn btn-danger xoabinhluan-btn btn-sm float-end"><i class="fa fa-times text-white text"></i> Xoá bình luận</button>
                            </div>

                            <div class="mx-2">
                            <span style="font-size: 0.92rem;">'. nl2br(e($bl->BL_NOIDUNG)) .'</span>
                            </div>

                            <!-- Images Container -->
                            <div id="images-container" class="m-2 mt-3 mb-3 position-relative"></div>

                            <!-- File Container -->
                            <div id="files-container" class=" m-2 mt-3"></div>';
                            
                            
                $output .= '<div class="d-flex mt-2 pt-2 justify-content-end">
                                <a class="ms-3 text-muted"><i class="fas fa-heart"></i> Thích: <b>'; if($count_thich) $output .= $count_thich; else $output .= '0'; $output .='</b></a>';
                                if($bl->BL_TRALOI_MA  == null){
                                    $output .= '<a class="ms-3 text-muted"><i class="fas fa-reply"></i> Trả lời: <b>'; if($count_bl_traloi) $output .= $count_bl_traloi; else $output .= '0'; $output .='</b></a>';
                                }
                                $output .= '<a class="ms-3 text-muted"><i class="fas fa-flag"></i> Báo cáo: <b>'; if($count_bao_cao) $output .= $count_bao_cao; else $output .= '0'; $output .='</b></a>
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
                                        <i class="fas fa-check-square"></i> Duyệt báo cáo
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
                                                $output .= ' đã gửi vào '. date('H:i', strtotime($bc->BLBC_THOIDIEM)) .' ngày '. date('d/m/Y', strtotime($bc->BLBC_THOIDIEM)) .'

                                                <input class="form-check-input float-end" type="checkbox" name="BC_DUYET" value="'. $bc->ND_MA .'">
                                            </div>
                                            <span class="text-muted">'. $bc->BLBC_NOIDUNG .'</span>
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

            return Response($output);
        }
    }

    /**
     * Duyệt báo cáo bình luận (**)
     */
    public function duyet_binhluan_baocao(Request $request, $BL_MA){ ///
        $this->AuthLogin_KDV();
        $userLog = Session::get('userLog');

        $bcDuyetValues = json_decode($request->input('bcDuyetValues'), true);

        if ($bcDuyetValues && is_array($bcDuyetValues)) {
            foreach ($bcDuyetValues as $ND) {
                DB::table('binhluan_baocao')
                ->where('ND_MA', $ND)
                ->where('BL_MA', $BL_MA)
                ->update([
                    'BLBC_TRANGTHAI' => 1,
                ]);
            }
        } 
    }


    /*
    |--------------------------------------------------------------------------
    | QUẢN TRỊ VIÊN
    |--------------------------------------------------------------------------
    */
    
}
