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
        return view('main_content.message');
    }

    public function show(string $id){ ///
        $this->AuthLogin_ND();
        
        $userChat = DB::table('nguoi_dung')
        ->join('vai_tro', 'nguoi_dung.VT_MA', '=', 'vai_tro.VT_MA')
        ->where('ND_MA', $id)->first();

        Session::put('userChat',$userChat);
        return view('main_content.message');
    }
}
