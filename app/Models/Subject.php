<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //Định nghĩa ban đầu
    protected $table = 'hoc_phan';
    protected $primaryKey = 'HP_MA';
    protected $keyType = 'string'; 

    public $timestamps = false;
    protected $fillable = ['HP_MA', 'KT_MA', 'HP_TEN'];
    use HasFactory;
}
