<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Goods;
use App\Brand;
use App\Cate;
use Illuminate\Validation\Rule;
class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *列表展示
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all=request()->all();
        $goods_name=request()->goods_name;
        $brand_name=request()->brand_name;
        $cate_name=request()->cate_name;
        $where=[];
        if($goods_name){
            $where[]=["goods_name","like","%$goods_name%"];
        }
        if($brand_name){
            $where[]=["brand_name","like","%$brand_name%"];
        }
        if($cate_name){
            $where[]=["cate_name","like","%$cate_name%"];
        }
        //分页
        $pageSize=config("app.PageSize");
        $goods=Goods::leftjoin("brand","goods.brand_id","=","brand.brand_id")
                    ->leftjoin("cate","goods.cate_id","=","cate.cate_id")
                    ->where($where)->orderBy("goods_id","desc")->paginate($pageSize);
        $brand=Brand::all();
        $cateInfo=Cate::all();
        $cate=getCateInfo($cateInfo);

        //检测是否是ajax请求
        if(request()->ajax()){
            return view("admin.goods.ajaxpage",['goods'=>$goods,'brand'=>$brand,'cate'=>$cate,'all'=>$all]);
        }

        return view("admin.goods.index",['goods'=>$goods,'brand'=>$brand,'cate'=>$cate,'all'=>$all]);
    }

    /**
     * Show the form for creating a new resource.
     *添加列表
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brand=Brand::all();
        $cateInfo=Cate::all();
        $cate=getCateInfo($cateInfo);
        return view("admin.goods.create",['brand'=>$brand,'cate'=>$cate]);
    }

    /**
     * Store a newly created resource in storage.
     *执行添加
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //验证   alpha_dash  中文、字母、数字、下划线组成
        $request->validate([
            'goods_name' => 'required|unique:goods|regex:/^[\x{4e00}-\x{9fa5}\w]{2,50}$/u',
            'goods_price' => 'required|numeric',
            'goods_num' => 'required|numeric|regex:/^\d{1,8}$/',
            'goods_desc' => 'required',
            'goods_score' => 'required',
        ],[
            'goods_name.required' => '商品名称必填！',
            'goods_name.unique' => '商品名称已存在！',
            'goods_name.regex' => '商品名称格式不正确（中文/字母/数字/下划线组成），长度2-50位之间！',
            'goods_price.required' => '商品价格必填！',
            'goods_price.numeric' => '商品价格必须是数字！',
            'goods_num.required' => '商品库存必填！',
            'goods_num.numeric' => '商品库存必须是数字！',
            'goods_num.regex' => '商品库存不超过8位！',
            'goods_desc.required' => '商品详情必填！',
            'goods_score.required' => '商品货号必填！',
        ]);
        $post=request()->except("_token");
        //文件上传
        //判断文件在请求中是否存在
        if ($request->hasFile('goods_img')) {
            $post["goods_img"]=upload("goods_img");
        }
        //多文件上传
        //判断文件在请求中是否存在
        if ($request->hasFile('goods_imgs')) {
            $post["goods_imgs"]=MoreUpload("goods_imgs");
            $post["goods_imgs"]=implode("|",$post["goods_imgs"]);
        }
        //dd($post);
        $res=Goods::insert($post);
        if($res){
            return redirect("/goods/index");
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
     *修改列表
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $goods=Goods::find($id);
        $brand=Brand::all();
        $cateInfo=Cate::all();
        $cate=getCateInfo($cateInfo);
        return view("admin.goods.edit",['goods'=>$goods,'brand'=>$brand,'cate'=>$cate]);
    }

    /**
     * Update the specified resource in storage.
     *执行修改
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //验证   alpha_dash
        $request->validate([ 
            'goods_name' => ['required',
                             Rule::unique('goods')->ignore($id, 'goods_id'),
                             'regex:/^[\x{4e00}-\x{9fa5}\w]{2,50}$/u'
                            ],
            'goods_price' => 'required|numeric',
            'goods_num' => 'required|numeric|regex:/^\d{1,8}$/',
            'goods_desc' => 'required',
            'goods_score' => 'required',
        ],[
            'goods_name.required' => '商品名称必填！',
            'goods_name.unique' => '商品名称已存在！',
            'goods_name.regex' => '商品名称格式不正确（中文、字母、数字、下划线组成），长度2-50位之间！',
            'goods_price.required' => '商品价格必填！',
            'goods_price.numeric' => '商品价格必须是数字！',
            'goods_num.required' => '商品库存必填！',
            'goods_num.numeric' => '商品库存必须是数字！',
            'goods_num.regex' => '商品库存不超过8位！',
            'goods_desc.required' => '商品详情必填！',
            'goods_score.required' => '商品货号必填！',
        ]);
        $post=request()->except("_token");
        //文件上传
        //判断文件在请求中是否存在
        if ($request->hasFile('goods_img')) {
            $post["goods_img"]=upload("goods_img");
        }
        //多文件上传
        //判断文件在请求中是否存在
        if ($request->hasFile('goods_imgs')) {
            $post["goods_imgs"]=MoreUpload("goods_imgs");
            $post["goods_imgs"]=implode("|",$post["goods_imgs"]);
        }
        //dd($post);
        $res=Goods::where("goods_id",$id)->update($post);
        if($res!==false){
            return redirect("/goods/index");
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
        //删除图片
        // $goods_img=Goods::where("goods_id",$id)->value("goods_img");
        // if($goods_img){
        //     unlink(storage_path("app/".$goods_img));
        // }    
        //dd($goods_img);
        $res=Goods::destroy($id);
        if($res){
            return redirect("/goods/index");
        }
    }
}
