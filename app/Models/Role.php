<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //Định nghĩa ban đầu
    protected $table = 'vai_tro';
    protected $primaryKey = 'VT_MA';

    public $timestamps = false;
    protected $fillable = ['VT_MA', 'VT_TEN'];
    use HasFactory;
}
