<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use Carbon\Carbon;
session_start();

class PostController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | NGƯỜI DÙNG
    | - Tạo bài đăng mới(*),
    |--------------------------------------------------------------------------
    */

    /**
     * Kiểm tra đăng nhập
     */
    public function AuthLogin_ND(){
        $userLog = Session::get('userLog');
        if($userLog){
        }else{
            return Redirect::to('dang-nhap')->send();
        }
    }

    /**
     * Tạo bài đăng mới
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->AuthLogin_ND();

        $userLog = Session::get('userLog');
        //Bài viết
        $data = array();
        $data['ND_MA'] = $userLog->ND_MA;  
        $data['BV_TIEUDE'] = $request->BV_TIEUDE;
        $data['BV_NOIDUNG'] = $request->BV_NOIDUNG;
        $data['BV_TRANGTHAI'] = 0;
        $data['BV_THOIGIANTAO'] = Carbon::now('Asia/Ho_Chi_Minh');
        $data['BV_LUOTXEM'] = 0;
        if($request->HP_MA) $data['HP_MA'] = $request->HP_MA;
        DB::table('bai_viet')->insert($data);

        $bai_viet = DB::table('bai_viet')->where('ND_MA', $userLog->ND_MA)
                ->orderby('bai_viet.BV_MA','desc')->first();

        //Của bài viết
        $data2 = array();
        $data2['BV_MA']=$bai_viet->BV_MA;

        if ($request->has(['items', 'items_new'])) {
            // Lấy giá trị của "items" và "items_new" từ request
            $selectedItems = $request->input('items');
            $addItems = $request->input('items_new');

            foreach ($selectedItems as $item) {
                $data2['H_HASHTAG'] = $item;
                DB::table('cua_bai_viet')->insert($data2);
            }
            
            foreach ($addItems as $items_new) {
                DB::table('hashtag')->insert([
                    'H_HASHTAG' => $items_new
                ]);
                $data2['H_HASHTAG'] = $items_new;
                DB::table('cua_bai_viet')->insert($data2);
            }
        } elseif ($request->has('items')) {
            $selectedItems = $request->input('items');

            foreach ($selectedItems as $item) {
                $data2['H_HASHTAG'] = $item;
                DB::table('cua_bai_viet')->insert($data2);
            }
        } elseif ($request->has('items_new')) {
            $addItems = $request->input('items_new');
            
            foreach ($addItems as $items_new) {
                DB::table('hashtag')->insert([
                    'H_HASHTAG' => $items_new
                ]);
                $data2['H_HASHTAG'] = $items_new;
                DB::table('cua_bai_viet')->insert($data2);
            }
        } else {
            // Trường input "items" và "items_new" không được gửi
            //echo "Không có dữ liệu được gửi";
        }

        //File đính kèm
        $data3 = array();
        $data3['BV_MA']=$bai_viet->BV_MA;
        
        if($request->hasFile('FDK'))
        {   
            $files = $request->file('FDK');
            foreach ($files as $file) {
                // Lấy thời gian hiện tại để thêm vào tên file
                $currentDateTime = now()->format('YmdHis');
        
                // Lấy tên file gốc
                $originalFileName = $file->getClientOriginalName();
        
                // Tạo tên file mới bằng cách thêm ngày tháng và giờ
                $newFileName = pathinfo($originalFileName, PATHINFO_FILENAME) . '_' . $bai_viet->BV_MA .'_'. $currentDateTime . '.' . $file->getClientOriginalExtension();
                
                $file->move('public/file', $newFileName); 
        
                // Lưu thông tin tệp tin vào cơ sở dữ liệu
                $data3['FDK_TEN'] = $newFileName;
                DB::table('file_dinh_kem')->insert($data3);
            }
        }
        
        return Redirect::to('trang-chu');
    }

    /**
     * Xem chi tiết bài đăng
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Sửa bài đăng
     */
    public function edit(Post $post)
    {
        //
    }

    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Xoá bài đăng
     */
    public function destroy(Post $post)
    {
        //
    }

    /*
    |--------------------------------------------------------------------------
    | KIỂM DUYỆT
    |--------------------------------------------------------------------------
    */
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    
}
