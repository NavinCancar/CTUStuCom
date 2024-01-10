<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSys extends Model
{
    //Định nghĩa ban đầu
    protected $table = 'nguoi_dung';
    protected $primaryKey = 'ND_MA';

    public $timestamps = false;
    protected $fillable = ['ND_MA', 'KT_MA', 'VT_MA', 'ND_HOTEN', 'ND_EMAIL', 'ND_MATKHAU', 'ND_MOTA', 'ND_ANHDAIDIEN', 'ND_DIEMCONGHIEN', 'ND_TRANGTHAI', 'ND_NGAYTHAMGIA'];

    use HasFactory;
}
