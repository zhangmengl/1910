<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\admin;
use Illuminate\Validation\Rule;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *列表展示
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //搜索
        $all=request()->all();
        $admin_name=request()->admin_name;
        $admin_tel=request()->admin_tel;
        $where=[];
        if($admin_name){
            $where[]=["admin_name","like","%$admin_name%"];
        }
        if($admin_tel){
            $where[]=["admin_tel","like","%$admin_tel%"];
        }
        //分页
        $pageSize=config("app.PageSize");
        $admin=Admin::where($where)->paginate($pageSize);
        return view("admin.admin.index",['admin'=>$admin,"all"=>$all]);
    }

    /**
     * Show the form for creating a new resource.
     *添加列表
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.admin.create");
    }

    /**
     * Store a newly created resource in storage.
     *执行列表
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //验证
        $request->validate([
            'admin_name' => 'required|unique:admin|regex:/^[\x{4e00}-\x{9fa5}(a-zA-Z0-9)]{1,18}$/u',
            'admin_tel' => 'required|regex:/^1[357]\d{9}$/',
            'admin_email' => 'required|email',
            'admin_pwd' => 'required|regex:/^[a-zA-Z0-9]{6,12}$/',
        ],[
            'admin_name.required' => '管理员名称必填！',
            'admin_name.unique' => '管理员名称已存在！',
            'admin_name.regex' => '管理员名称由（中文/字母/数字）组成，长度1-18位！',
            'admin_tel.required' => '管理员电话必填！',
            'admin_tel.regex' => '管理员电话格式不正确！',
            'admin_email.required' => '管理员邮箱必填！',
            'admin_email.email' => '管理员邮箱格式不正确！',
            'admin_pwd.required' => '管理员密码必填！',
            'admin_pwd.regex' => '管理员密码由（字母、数字）组成，长度6-12位！',
        ]);
        $post=request()->all();
        if($post["pwd"]!=$post["admin_pwd"]){
            return redirect("/admin/create")->with("msg","确认密码与管理员密码不一致");
        }
        $post=request()->except("_token","pwd");
        $post["admin_time"] = time();
        $post["admin_pwd"]=encrypt($post["admin_pwd"]);
        $res=Admin::insert($post);
        if($res){
            return redirect("/admin/index");
        }
    }

    /**
     * Display the specified resource.
     *资源详情
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *编辑列表
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $res=Admin::find($id);
        return view("admin.admin.edit",["res"=>$res]);
    }

    /**
     * Update the specified resource in storage.
     *执行编辑
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //验证
        $request->validate([
            'admin_name' => ['required',
                              Rule::unique('admin')->ignore($id,'admin_id'),
                              'regex:/^[\x{4e00}-\x{9fa5}(a-zA-Z0-9)]{1,18}$/u'
                             ],
            'admin_tel' => 'required|regex:/^1[357]\d{9}$/',
            'admin_email' => 'required|email',
            'admin_pwd' => 'required|regex:/^[a-zA-Z0-9]{6,12}$/',
        ],[
            'admin_name.required' => '管理员名称必填！',
            'admin_name.unique' => '管理员名称已存在！',
            'admin_name.regex' => '管理员名称由（中文/字母/数字）组成，长度1-18位！',
            'admin_tel.required' => '管理员电话必填！',
            'admin_tel.regex' => '管理员电话格式不正确！',
            'admin_email.required' => '管理员邮箱必填！',
            'admin_email.email' => '管理员邮箱格式不正确！',
            'admin_pwd.required' => '管理员密码必填！',
            'admin_pwd.regex' => '管理员密码由（字母、数字）组成，长度6-12位！',
        ]);
        $post=request()->except("_token");
        $post["admin_time"]=time();
        $post["admin_pwd"]=encrypt($post["admin_pwd"]);
        $res=Admin::where("admin_id",$id)->update($post);
        if($res!==false){
            return redirect("/admin/index");
        }
    }

    /**
     * Remove the specified resource from storage.
     *删除
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res=Admin::destroy($id);
        if($res){
            return redirect("/admin/index");
        }
    }
}
