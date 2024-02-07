<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{

    //Định nghĩa ban đầu
    protected $table = 'hashtag';
    protected $primaryKey = 'H_HASHTAG';
    protected $keyType = 'string'; 

    public $timestamps = false;
    protected $fillable = ['H_HASHTAG'];
    use HasFactory;
}
