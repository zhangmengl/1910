<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Link;
use Illuminate\Validation\Rule;
class LinkController extends Controller
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
        $link_name=request()->link_name;
        $link_url=request()->link_url;
        $where=[];
        if($link_name){
            $where[]=["link_name","like","%$link_name%"];
        }
        if($link_url){
            $where[]=["link_url","like","%$link_url%"];
        }
        //分页
        $pageSize=config("app.PageSize");
        $link=Link::where($where)->paginate($pageSize);

        //无刷新分页   检测是否是ajax请求
        if(request()->ajax()){
            return view("admin.link.ajaxpage",["link"=>$link,"all"=>$all]);
        }

        return view("admin.link.index",["link"=>$link,"all"=>$all]);
    }

    /**
     * Show the form for creating a new resource.
     *添加列表
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.link.create");
    }

    /**
     * Store a newly created resource in storage.
     *执行添加
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'link_name' => 'required|unique:link|regex:/^[\x{4e00}-\x{9fa5}\w]{1,}$/u',
            'link_url' => 'required|regex:/^http\:\/\/www\.\w*\.\w*$/',
            'link_man' => 'required',
            'link_desc' => 'required',
        ],[
            'link_name.required' => '网站名称必填！',
            'link_name.unique' => '网站名称已存在！',
            'link_name.regex' => '网站名称格式有误（中文/数字/字母/下划线组成）！',
            'link_url.required' => '网站网址必填！',
            'link_url.regex' => '网站网址格式有误（由http://开头）！',
            'link_man.required' => '网站联系人必填！',
            'link_desc.required' => '网站介绍必填！',
        ]);
        $post=request()->except("_token");
        //文件上传
        //判断文件在请求中是否存在：
        if ($request->hasFile('link_logo')) {
            $post["link_logo"]=upload("link_logo");
        }
        // dd($post);
        $res=Link::insert($post);
        if($res){
            return redirect("/link/index");
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
        $res=Link::find($id);
        return view("admin.link.edit",["res"=>$res]);
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
        $request->validate([
            'link_name' => ['required',
                             Rule::unique('link')->ignore($id, 'link_id'),
                             'regex:/^[\x{4e00}-\x{9fa5}\w]{1,}$/u'],
            'link_url' => 'required|regex:/^http\:\/\/www\.\w*\.\w*$/',
            'link_man' => 'required',
            'link_desc' => 'required',
        ],[
            'link_name.required' => '网站名称必填！',
            'link_name.unique' => '网站名称已存在！',
            'link_name.regex' => '网站名称格式有误（中文/数字/字母/下划线组成）！',
            'link_url.required' => '网站网址必填！',
            'link_url.regex' => '网站网址格式有误（由http://开头）！',
            'link_man.required' => '网站联系人必填！',
            'link_desc.required' => '网站介绍必填！',
        ]);
        $post=request()->except("_token");
        //文件上传
        //判断文件在请求中是否存在：
        if ($request->hasFile('link_logo')) {
            $post["link_logo"]=upload("link_logo");
        }
        // dd($post);
        $res=Link::where("link_id",$id)->update($post);
        if($res!==false){
            return redirect("/link/index");
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
        $res=Link::destroy($id);
        if($res){
            if(request()->ajax()){
                return json_encode(['code'=>'00000','msg'=>"删除成功！"]);
            }
        }
        return redirect("/link/index");
    }
}
