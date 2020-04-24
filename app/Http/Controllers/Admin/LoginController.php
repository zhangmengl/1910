<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use Illuminate\Support\Facades\Cookie;
class LoginController extends Controller
{
    public function loginDo(Request $request){
        $admin=request()->except("_token");
        $admin_name=Admin::where("admin_name",$admin["admin_name"])->first();
        //dd(decrypt($admin_name->admin_pwd));
        if(decrypt($admin_name->admin_pwd)!=$admin["admin_pwd"]){
              return redirect("/login")->with("msg","用户名或密码有误");
        }
        //七天免登陆
        if(isset($admin['reme'])){
            //存入cookie
            Cookie::queue('admin_name',serialize($admin_name), 7*24*60);
        }
        session(["admin_name"=>$admin_name]);
        return redirect("/goods/index");
    }
}
