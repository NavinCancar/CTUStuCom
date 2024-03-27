<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use Carbon\Carbon;
session_start();

class RoleController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    HÀM HỖ TRỢ
    - Kiểm tra đăng nhập: Người dùng => (*)
    - Kiểm tra đăng nhập: Quản trị viên => (***)

    QUẢN TRỊ VIÊN
    - Tất cả vai trò (***), Thêm vai trò (***), Sửa vai trò (***), Xoá vai trò (***)
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
    | QUẢN TRỊ VIÊN
    |--------------------------------------------------------------------------
    */
    /**
     * Tất cả vai trò (***)
     */
    public function index(){ ///
        $this->AuthLogin_QTV();
        $all_role = DB::table('vai_tro')->orderby('VT_MA');

        //SEARCH: http://localhost/ctustucom/bai-dang?tu-khoa=18%2F03%2F2024
        $keywordSearch = request()->query('tu-khoa');
        if($keywordSearch){
            $all_role = $all_role->where(function ($query) use ($keywordSearch) {
                $query->where('vai_tro.VT_MA', 'like', '%'.$keywordSearch.'%')
                      ->orWhere('vai_tro.VT_TEN', 'like', '%'.$keywordSearch.'%');
            });
        }

        $all_role = $all_role->paginate(10);

        //$all_role = DB::table('vai_tro')->orderby('VT_MA')->paginate(10);
        return view('main_content.role.all_role')->with('all_role', $all_role);
    }


    /**
     * Thêm vai trò (***)
     */
    public function create(){ ///
        $this->AuthLogin_QTV();
        return view('main_content.role.add_role');
    }

    public function store(Request $request){ ///
        $this->AuthLogin_QTV();
        
        //Dò rỗng
        if(trim($request->VT_TEN) == ""){
            Session::put('alert', ['type' => 'warning', 'content' => 'Tên vai trò không thể rỗng!']);
            return Redirect::to('vai-tro/create');
        }

        //Dò trùng
        $dsvt=DB::table('vai_tro')->get();
        foreach ($dsvt as $ds){
            if (strtolower($ds->VT_TEN)==strtolower(trim($request->VT_TEN))) {
                Session::put('alert', ['type' => 'warning', 'content' => 'Tên vai trò không thể trùng!']);
                return Redirect::to('vai-tro/create');
            }
        }

        DB::table('vai_tro')->insert([
            'VT_TEN' => trim($request->VT_TEN),
        ]);
        Session::put('alert', ['type' => 'success', 'content' => 'Thêm vai trò thành công!']);
        return Redirect::to('vai-tro');
    }

    
    /**
     * Sửa vai trò (***)
     */
    public function edit(Role $vai_tro){ ///
        $this->AuthLogin_QTV();
        $all_role = DB::table('vai_tro')->where('VT_MA', $vai_tro->VT_MA)->get();
        return view('main_content.role.edit_role')->with('all_role', $all_role);
    }

    public function update(Request $request, Role $vai_tro){ ///
        $this->AuthLogin_QTV();
        
        //Dò rỗng
        if(trim($request->VT_TEN) == ""){
            Session::put('alert', ['type' => 'warning', 'content' => 'Tên vai trò không thể rỗng!']);
            return Redirect::to('vai-tro/'.$vai_tro->VT_MA.'/edit');
        }

        //Dò trùng
        $dsvt=DB::table('vai_tro')->get();
        foreach ($dsvt as $ds){
            if ($ds->VT_TEN != $vai_tro->VT_TEN && strtolower($ds->VT_TEN)==strtolower(trim($request->VT_TEN))) {
                Session::put('alert', ['type' => 'warning', 'content' => 'Tên vai trò không thể trùng!']);
                return Redirect::to('vai-tro/'.$vai_tro->VT_MA.'/edit');
            }
        }

        DB::table('vai_tro') 
        ->where('VT_MA', $vai_tro->VT_MA)
        ->update([
            'VT_TEN' => trim($request->VT_TEN),
        ]);
        Session::put('alert', ['type' => 'success', 'content' => 'Cập nhật vai trò thành công!']);
        return Redirect::to('vai-tro');
    }

    /**
     * Xoá vai trò (***)
     */
    public function destroy(Role $vai_tro){ ///
        $this->AuthLogin_QTV();

        //Kiểm tra khoá ngoại
        $checkforeign = DB::table('nguoi_dung')
        ->where('nguoi_dung.VT_MA',$vai_tro->VT_MA)->exists();

        if($checkforeign){
            Session::put('alert', ['type' => 'warning', 'content' => 'Có người dùng thuộc vai trò này, vai trò này không thể xoá!']);
            return Redirect::to('vai-tro');
        }

        DB::table('vai_tro')->where('VT_MA', $vai_tro->VT_MA)->delete();
        Session::put('alert', ['type' => 'success', 'content' => 'Xoá vai trò thành công!']);
        return Redirect::to('vai-tro');
    }
}
