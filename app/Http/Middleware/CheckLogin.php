<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //测试七天免登陆删除session
        //session(['admin_name'=>null]);
        //request()->session()->save();
        $admin_name=$request->session()->get("admin_name");
        // dd($admin_name);
        if(!$admin_name){
            //七天免登录   从cookie内取用户信息，如果有存入cookie
            $cookie_admin=request()->cookie('admin_name');
            if($cookie_admin){
                session(["admin_name"=>unserialize($admin_name)]);
            }else{
                return redirect("/login");
            }
        }
        return $next($request);
    }
}
