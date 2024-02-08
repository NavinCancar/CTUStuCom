<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    //Định nghĩa ban đầu
    protected $table = 'khoa_truong';
    protected $primaryKey = 'KT_MA';
    protected $keyType = 'string'; 

    public $timestamps = false;
    protected $fillable = ['KT_MA', 'KT_TEN'];
    use HasFactory;
}
