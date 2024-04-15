<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Kreait\Firebase\Contract\Database;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use Carbon\Carbon;
session_start();

class MessageController_FB extends Controller
{
    /*
    |--------------------------------------------------------------------------
    HÀM HỖ TRỢ
    - Kiểm tra đăng nhập: Người dùng => (*)
    
    NGƯỜI DÙNG
    - Nhắn tin (*)
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
     * Nhắn tin (*)
     */

    public function index(){ ///
        $this->AuthLogin_ND();
        $isBlocked = 0;
        $isBlock = 0;
        return view('main_content.message')
        ->with('isInactive', 0)->with('isBlock', 0)
        ->with('isBlocked', $isBlocked)->with('isBlock', $isBlock);
    }

    public function show(string $id){ ///
        $this->AuthLogin_ND();
        $userLog = Session::get('userLog');

        $userChat = DB::table('nguoi_dung')
        ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
        ->where('ND_MA', $id)->first();

        $isInactive = DB::table('nguoi_dung')->where('ND_MA', $id)->where('ND_TRANGTHAI', 0)->exists(); 
        /*$isBlock = DB::table('chan') 
        ->orWhere(function ( $query) use ($userChat, $userLog) { //Trong and
            $query->where('ND_CHAN_MA', $userChat->ND_MA)
                  ->where('ND_BICHAN_MA', $userLog->ND_MA);
        })
        ->orWhere(function ( $query) use ($userChat, $userLog) { //Trong and
            $query->where('ND_CHAN_MA', $userLog->ND_MA)
                  ->where('ND_BICHAN_MA', $userChat->ND_MA);
        })->exists();*/

        $isBlocked = DB::table('chan') 
        ->where('ND_CHAN_MA', $userChat->ND_MA)
        ->where('ND_BICHAN_MA', $userLog->ND_MA)->exists();
        
        $isBlock = DB::table('chan') 
        ->where('ND_CHAN_MA', $userLog->ND_MA)
        ->where('ND_BICHAN_MA', $userChat->ND_MA)->exists();

        Session::put('userChat',$userChat);
        return view('main_content.message')->with('isInactive', $isInactive)
        ->with('isBlocked', $isBlocked)->with('isBlock', $isBlock);
    }
}
