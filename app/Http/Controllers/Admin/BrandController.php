<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Brand;
use App\Http\Requests\StoreBrandPost;
use Validator;
use Illuminate\Validation\Rule;
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *列表展示
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$brand=DB::table("brand")->get();
        //orm
        $all=request()->all();
        $brand_name=request()->brand_name;
        $brand_url=request()->brand_url;
        $where=[];
        if($brand_name){
            $where[]=["brand_name","like","%$brand_name%"];
        }
        if($brand_url){
            $where[]=["brand_url","like","%$brand_url%"];
        }
        $pageSize=config('app.PageSize');
        $brand=Brand::where($where)->orderBy("brand_id","desc")->paginate($pageSize);

        //无刷新分页
        if(request()->ajax()){
            return view("admin.brand.ajaxpage",['brand'=>$brand,'all'=>$all]);
        }

        return view("admin.brand.index",['brand'=>$brand,'all'=>$all]);
    }

    /**
     * Show the form for creating a new resource.
     *添加列表
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.brand.create");
    }

    /**
     * Store a newly created resource in storage.
     *执行添加
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //第二种验证
    //public function store(StoreBrandPost $request)
    public function store(Request $request)
    {
        //第一种验证
        // $request->validate([
        //     'brand_name' => 'required|unique:brand|max:20',
        //     'brand_url' => 'required',
        //     'brand_desc' => 'required',
        // ],[
        //     'brand_name.required' => '品牌名称必填！',
        //     'brand_name.unique' => '品牌名称已存在！',
        //     'brand_name.max' => '品牌长度不超过20位！',
        //     'brand_url.required' => '品牌网址必填！',
        //     'brand_desc.required' => '品牌描述必填！',
        // ]);
        //获取所有值
        //$post=$request->all();
        //$post=request()->all();
        //$post=request()->input();
        //接收post传过来的值
        //$post=request()->post();
        //只接收……
        //$post=request()->only(['_token','brand_logo']);
        //排除接收……
        $post=request()->except("_token");
        // //第三种验证
        // $validator = Validator::make($post,[
        //     'brand_name' => 'required|unique:brand|max:20',
        //     'brand_url' => 'required',
        //     'brand_desc' => 'required',
        // ],[
        //     'brand_name.required' => '品牌名称必填！',
        //     'brand_name.unique' => '品牌名称已存在！',
        //     'brand_name.max' => '品牌长度不超过20位！',
        //     'brand_url.required' => '品牌网址必填！',
        //     'brand_desc.required' => '品牌描述必填！',
        // ]);
        // //判断validator是否有错误信息
        // if ($validator->fails()) {
        //     return redirect('brand/create')->withErrors($validator)->withInput();
        // }
        //dd($post);
        //dd($request->hasFile('brand_logo'));
        //文件上传
        //判断文件在请求中是否存在
        if ($request->hasFile('brand_logo')) {
            $post['brand_logo']=upload("brand_logo");
        } 

        //$res=DB::table("brand")->insert($post);
        //orm
        //$res=Brand::create($post);
        $res=Brand::insert($post);
        if($res){
            return redirect('/brand/index');
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
        //$res=DB::table("brand")->where("brand_id",$id)->first();
        //orm
        $res=Brand::find($id);
        $res=Brand::where("brand_id",$id)->first();
        return view("admin.brand.edit",["res"=>$res]);
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
            'brand_name' => [
                             'required',
                             Rule::unique('brand')->ignore($id,"brand_id"),
                             'max:20'
                            ],
            'brand_url' => 'required',
            'brand_desc' => 'required',
        ],[
            'brand_name.required' => '品牌名称必填！',
            'brand_name.unique' => '品牌名称已存在！',
            'brand_name.max' => '品牌长度不超过20位！',
            'brand_url.required' => '品牌网址必填！',
            'brand_desc.required' => '品牌描述必填！',
        ]);
        $post=request()->except("_token");
        //dd($post);
        //文件上传
        //判断文件在请求中是否存在
        if ($request->hasFile('brand_logo')) {
            $post['brand_logo']=upload("brand_logo");
        }
        //$res=DB::table("brand")->where("brand_id",$id)->update($post);
        //orm
        $res=Brand::where("brand_id",$id)->update($post);
        if($res!==false){
            return redirect('/brand/index');
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
        // $brand_logo=DB::table("brand")->where("brand_id",$id)->value("brand_logo");
        // //dd(storage_path('app/'.$brand_logo));
        // if($brand_logo){
        //     unlink(storage_path('app/'.$brand_logo));
        // }
        //$res=DB::table("brand")->where("brand_id",$id)->delete();
        //orm
        //$res=Brand::where("brand_id",$id)->delete();
        $res=Brand::destroy($id);
        if($res){
            return redirect('/brand/index');
        }
    }
}
