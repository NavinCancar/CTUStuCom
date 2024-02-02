<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //Định nghĩa ban đầu
    protected $table = 'binh_luan';
    protected $primaryKey = 'BL_MA';

    public $timestamps = false;
    protected $fillable = ['BL_MA', 'ND_MA', 'BV_MA', 'BL_TRALOI_MA', 'BL_NOIDUNG', 'BL_THOIGIANTAO'];

    use HasFactory;
}
