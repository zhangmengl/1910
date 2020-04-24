<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cate;
use Illuminate\Validation\Rule;
class CateController extends Controller
{
    /**
     * Display a listing of the resource.
     *列表展示
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cateInfo=Cate::get();
        $cate=getCateInfo($cateInfo);
        return view("admin.cate.index",['cate'=>$cate]);
    }
   
    /**
     * Show the form for creating a new resource.
     *添加列表
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cateInfo=Cate::all();
        $cate=getCateInfo($cateInfo);
        return view("admin.cate.create",['cate'=>$cate]);
    }

    /**
     * Store a newly created resource in storage.
     *执行添加
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //验证
        $request->validate([
            'cate_name' => 'required|unique:cate|max:20',
        ],[
            'cate_name.required' => '分类名称必填！',
            'cate_name.unique' => '分类名称已存在！',
            'cate_name.max' => '分类名称长度不超过20位！',
        ]);
        $post=request()->except("_token");
        $res=Cate::insert($post);
        if($res){
            return redirect("/cate/index");
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
        $res=Cate::find($id);
        $cateInfo=Cate::all();
        $cate=getCateInfo($cateInfo);
        return view("admin.cate.edit",['res'=>$res,'cate'=>$cate]);
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
            'cate_name' => ['required',
                            Rule::unique('cate')->ignore($id,'cate_id'),
                            'max:20'],
        ],[
            'cate_name.required' => '分类名称必填！',
            'cate_name.unique' => '分类名称已存在！',
            'cate_name.max' => '分类名称长度不超过20位！',
        ]);
        $post=request()->except("_token");
        $res=Cate::where("cate_id",$id)->update($post);
        if($res!==false){
            return redirect("/cate/index");
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
        $count=Cate::where("cate_id",$id)->count();
        if($count>0){
            return redirect("/cate/index")->with("msg","该分类下有子分类");
        }
        $res=Cate::destroy($id);
        if($res){
            return redirect("/cate/index");
        }
    }
}
