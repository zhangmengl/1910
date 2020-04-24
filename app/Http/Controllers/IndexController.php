<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
class IndexController extends Controller
{
    //设置cookie
    public function setcookie(){
        //第一种
        //return response('设置cookie')->cookie("name","小呆呆",1);
        //第二种
        //Cookie::queue(Cookie::make('age', '99', 1));
        //第三种
        Cookie::queue('num', '111', 1);
    }
    //获取cookie
    public function getcookie(){
        //第一种
        //echo request()->cookie('name');
        //第二种
        echo cookie::get('num');
    }

    public function index(){
        //echo "控制器的index的方法";
        return view('index');
    }
    public function add(){
        $post=request()->all();
        dd($post);
    }
    public function goods($id){
        echo "$id";
    }
    public function show($id='null',$name='null'){
        echo "$id"."-"."$name";
    }
    public function good($id,$name='null'){
        echo "$id"."-"."$name";
    }
}
