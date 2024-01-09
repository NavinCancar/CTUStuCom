<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class HomeController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function login(){
    	return view('login');
    }

    public function register (){
    	return view('register');
    }
    
}
