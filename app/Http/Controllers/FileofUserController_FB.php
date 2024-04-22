<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use MrShan0\PHPFirestore\FirestoreClient;

use Carbon\Carbon;
session_start();

class FileofUserController_FB extends Controller
{
    /*
    |--------------------------------------------------------------------------
    HÀM HỖ TRỢ
    - Hàm xây dựng FireStore
    - Kiểm tra đăng nhập: Người dùng => (*)
    
    NGƯỜI DÙNG
    - Lưu file đính kèm(*)

    CẬP NHẬT CƠ SỞ DỮ LIỆU
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
     * Lưu file đính kèm(*)
     */
    public function create(){ //Không dùng
    }

    public function store(Request $request){///
        
        $this->AuthLogin_ND();

        $userLog = Session::get('userLog');
        $collection = 'DANH_DAU_FILE';

        $this->firestoreClient->addDocument($collection, [
            'FDK_MA'=> $request->FDK_MA,
            'ND_MA' => $userLog->ND_MA,
        ]);
        
        //return response()->json(['fileSend' => $fileSend]);
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | KIỂM DUYỆT VIÊN
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | QUẢN TRỊ VIÊN
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | CẬP NHẬT CƠ SỞ DỮ LIỆU
    |--------------------------------------------------------------------------
    */

    public function database(){

        $now = Carbon::now('Asia/Ho_Chi_Minh');

        //|*****************************************************
        //DATETIME
        //|*****************************************************
        
        //|-----------------------------------------------------
        //BÌNH LUẬN

        $BL_TimeQuery = DB::table('binh_luan')
                ->orderBy('BL_THOIGIANTAO', 'desc')
                ->first();
        $BL_Time = Carbon::parse($BL_TimeQuery->BL_THOIGIANTAO);

        $BL_DiffTime = $now->diffInSeconds($BL_Time);
        //$BL_Time->addSeconds($BL_DiffTime);

        $binh_luan = DB::table('binh_luan')->get();
        foreach ($binh_luan as $bl) {
            $currentDataTime = Carbon::parse($bl->BL_THOIGIANTAO);
            $newDataTime = $currentDataTime->copy()->addSeconds($BL_DiffTime);
            DB::table('binh_luan')
                ->where('BL_MA', $bl->BL_MA)
                ->update(['BL_THOIGIANTAO' => $newDataTime]);
        }
        //|-----------------------------------------------------
        //|-----------------------------------------------------
        //BÀI VIẾT

        $BV_TimeQuery = DB::table('bai_viet')
                ->orderBy('BV_THOIGIANDANG', 'desc')
                ->first();
        $BV_Time = Carbon::parse($BV_TimeQuery->BV_THOIGIANDANG);

        $BV_DiffTime = $now->diffInSeconds($BV_Time);

        $bai_viet = DB::table('bai_viet')->get();
        foreach ($bai_viet as $bv) {
            $currentDataTime_T = Carbon::parse($bv->BV_THOIGIANTAO);
            $currentDataTime_D = Carbon::parse($bv->BV_THOIGIANDANG);

            $newDataTime_T = $currentDataTime_T->copy()->addSeconds($BV_DiffTime);
            $newDataTime_D = $currentDataTime_D->copy()->addSeconds($BV_DiffTime);
            DB::table('bai_viet')
                ->where('BV_MA', $bv->BV_MA)
                ->update([
                    'BV_THOIGIANTAO' => $newDataTime_T,
                    'BV_THOIGIANDANG' => $newDataTime_D
                ]);
        }
        //|-----------------------------------------------------
        //|-----------------------------------------------------
        //BÀI VIẾT THÍCH

        $BVT_TimeQuery = DB::table('baiviet_thich')
                ->orderBy('BVT_THOIDIEM', 'desc')
                ->first();
        $BVT_Time = Carbon::parse($BVT_TimeQuery->BVT_THOIDIEM);

        $BVT_DiffTime = $now->diffInSeconds($BVT_Time);

        $baiviet_thich = DB::table('baiviet_thich')->get();
        foreach ($baiviet_thich as $bvt) {
            $currentDataTime = Carbon::parse($bvt->BVT_THOIDIEM);
            $newDataTime = $currentDataTime->copy()->addSeconds($BVT_DiffTime);
            DB::table('baiviet_thich')
                ->where('ND_MA', $bvt->ND_MA)
                ->where('BV_MA', $bvt->BV_MA)
                ->update(['BVT_THOIDIEM' => $newDataTime]);
        }
        //|-----------------------------------------------------
        //|-----------------------------------------------------
        //BÀI VIẾT BÁO CÁO

        $BVBC_TimeQuery = DB::table('baiviet_baocao')
                ->orderBy('BVBC_THOIDIEM', 'desc')
                ->first();
        $BVBC_Time = Carbon::parse($BVBC_TimeQuery->BVBC_THOIDIEM);

        $BVBC_DiffTime = $now->diffInSeconds($BVBC_Time);

        $baiviet_baocao = DB::table('baiviet_baocao')->get();
        foreach ($baiviet_baocao as $bvbc) {
            $currentDataTime = Carbon::parse($bvbc->BVBC_THOIDIEM);
            $newDataTime = $currentDataTime->copy()->addSeconds($BVBC_DiffTime);
            DB::table('baiviet_baocao')
                ->where('ND_MA', $bvbc->ND_MA)
                ->where('BV_MA', $bvbc->BV_MA)
                ->update(['BVBC_THOIDIEM' => $newDataTime]);
        }
        //|-----------------------------------------------------
        //|-----------------------------------------------------
        //BÌNH LUẬN THÍCH

        $BLT_TimeQuery = DB::table('binhluan_thich')
                ->orderBy('BLT_THOIDIEM', 'desc')
                ->first();
        $BLT_Time = Carbon::parse($BLT_TimeQuery->BLT_THOIDIEM);

        $BLT_DiffTime = $now->diffInSeconds($BLT_Time);

        $binhluan_thich = DB::table('binhluan_thich')->get();
        foreach ($binhluan_thich as $blt) {
            $currentDataTime = Carbon::parse($blt->BLT_THOIDIEM);
            $newDataTime = $currentDataTime->copy()->addSeconds($BLT_DiffTime);
            DB::table('binhluan_thich')
                ->where('ND_MA', $blt->ND_MA)
                ->where('BL_MA', $blt->BL_MA)
                ->update(['BLT_THOIDIEM' => $newDataTime]);
        }
        //|-----------------------------------------------------
        //|-----------------------------------------------------
        //BÌNH LUẬN BÁO CÁO

        $BLBC_TimeQuery = DB::table('binhluan_baocao')
                ->orderBy('BLBC_THOIDIEM', 'desc')
                ->first();
        $BLBC_Time = Carbon::parse($BLBC_TimeQuery->BLBC_THOIDIEM);

        $BLBC_DiffTime = $now->diffInSeconds($BLBC_Time);

        $binhluan_baocao = DB::table('binhluan_baocao')->get();
        foreach ($binhluan_baocao as $blbc) {
            $currentDataTime = Carbon::parse($blbc->BLBC_THOIDIEM);
            $newDataTime = $currentDataTime->copy()->addSeconds($BLBC_DiffTime);
            DB::table('binhluan_baocao')
                ->where('ND_MA', $blbc->ND_MA)
                ->where('BL_MA', $blbc->BL_MA)
                ->update(['BLBC_THOIDIEM' => $newDataTime]);
        }
        //|-----------------------------------------------------


        //|*****************************************************
        //DATE
        //|*****************************************************

        //|-----------------------------------------------------
        //NGƯỜI DÙNG

        $ND_TimeQuery = DB::table('nguoi_dung')
                ->orderBy('ND_NGAYTHAMGIA', 'desc')
                ->first();
        $ND_Time = Carbon::parse($ND_TimeQuery->ND_NGAYTHAMGIA);

        $ND_DiffTime = $now->diffInSeconds($ND_Time);

        $nguoi_dung = DB::table('nguoi_dung')->get();
        foreach ($nguoi_dung as $nd) {
            $currentDataTime = Carbon::parse($nd->ND_NGAYTHAMGIA);
            $newDataTime = $currentDataTime->copy()->addSeconds($ND_DiffTime);
            DB::table('nguoi_dung')
                ->where('ND_MA', $nd->ND_MA)
                ->update(['ND_NGAYTHAMGIA' => $newDataTime]);
        }
        //|-----------------------------------------------------



        echo '<pre>';
        /*print_r ($now);
        print_r ($BL_Time);
        print_r ($BL_DiffTime);*/
        print_r ('----------------------------------------------------<br>');
        print_r ('OK<br>');
        print_r ('----------------------------------------------------<br>');
        echo '</pre>';
    }
    
}
