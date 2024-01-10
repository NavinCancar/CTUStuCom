<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //Định nghĩa ban đầu
    protected $table = 'bai_viet';
    protected $primaryKey = 'BV_MA';

    public $timestamps = false;
    protected $fillable = ['BV_MA', 'ND_MA', 'HP_MA', 'BV_TIEUDE', 'BV_NOIDUNG', 'BV_TRANGTHAI', 'BV_THOIGIANTAO', 'BV_THOIGIANDANG', 'BV_LUOTXEM'];

    use HasFactory;
}
