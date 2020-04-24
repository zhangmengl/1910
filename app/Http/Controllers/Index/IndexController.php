<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Goods;
use App\Cate;
use App\Cart;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class IndexController extends Controller
{
    public function index(){
        //使用cache门面
        // $slide=Cache::get('slide');
        //使用Redis门面
        // $slide=Redis::del('slide');
        $slide=Redis::get('slide');
        //使用辅助函数
        // $slide=cache('slide');
        // dump($slide);
        if(!$slide){
            // echo "DB==";
            //首页幻灯片
            $slide=Goods::getIndexSlide();
            //使用cache门面
            // Cache::put('slide',$slide,60);
            //使用Redis门面
            $slide=serialize($slide);
            Redis::setex("slide",60,$slide);
            //使用辅助函数
            // cache(['slide'=>$slide],60);
        }
        //使用Redis门面
        $slide=unserialize($slide);
        // dd($slide);
        $cate=Cate::select("cate_name")->where("pid",0)->take(4)->get();
        $best=Goods::select("goods_name","goods_img","goods_price","goods_id")->where("is_best",1)->take(6)->get();
        $hot=Goods::select("goods_name","goods_img","goods_price","goods_id")->where("is_hot",1)->take(3)->get();
        return view("index.index",['slide'=>$slide,'cate'=>$cate,'best'=>$best,'hot'=>$hot]);
    }
    //列表
    public function prolist(){
        $prolist=Goods::get();
        return view("index.prolist",['prolist'=>$prolist]);
    }
    //详情
    public function proinfo($id){
        //详情页幻灯片
        $slide=Goods::select("goods_imgs","goods_id")->where("goods_id",$id)->get();
        //访问量
        $visit=Redis::setnx("visit_".$id,1)? 1 :Redis::incr("visit_".$id,1);
        // dd($visit);
        $proinfo=Goods::select("goods_name","goods_img","goods_price","goods_desc","goods_num","goods_id")->where("goods_id",$id)->first();
        return view("index.proinfo",['slide'=>$slide,'proinfo'=>$proinfo,'visit'=>$visit]);
    }
    //购物车
    public function addcar(){
        $goods_id=request()->goods_id;
        // dd($goods_id);
        $buy_number=request()->buy_number;
        //判断用户是否登录
        $user=session("reg_name");
        if(!$user){
            showMsg("00001","未登录");
        }
        //查商品的数据
        $goods=Goods::select("goods_id","goods_name","goods_img","goods_price","goods_num")->find($goods_id);
        //判断库存<购买数量
        if($goods->goods_num<$buy_number){
            showMsg("00002","商品库存不足");
        }
        $where=[
            'user_id'=>$user->reg_id,
            'goods_id'=>$goods_id
        ];
        //购物车数据
        $cart=Cart::where($where)->first();
        //判断用户是否将该商品加入购物车
        if($cart){
            //加入过购物车  累加
            $buy_number=$cart->buy_number+$buy_number;
            //判断库存<购买数量
            if($goods->goods_num<$buy_number){
                $buy_number=$goods->goods_num;
            }
            //修改购物车表里的购买数量
            $res=Cart::where("cart_id",$cart->cart_id)->update(['buy_number'=>$buy_number]);
        }else{
            //未加入购物车  添加
            $data=[
                'user_id'=>$user->reg_id,
                'buy_number'=>$buy_number,
                'addtime'=>time()
            ];
            $data=array_merge($data,$goods->toArray());
            unset($data["goods_num"]);
            $res=Cart::insert($data);
        }
        if($res!==false){
            showMsg("00000","加入购物车成功");
        }
    }
    
    //购物车列表
    public function carlist(){
        //获取用户id
        $user=session("reg_name");
        $where = [
            "user_id"=>$user->reg_id,
            "cart_del"=>1
        ];
        $cart=Cart::leftjoin("goods","cart.goods_id","=","goods.goods_id")->where($where)->get();
        $buy_number=array_column($cart->toArray(),'buy_number');
        // dump($buy_number);
        $count=array_sum($buy_number);
        $cart_id=array_column($cart->toArray(),'cart_id'); 
        $checkedbuynumber=array_combine($cart_id,$buy_number);
        // dd($checkedbuynumber); 
        // return view("index.carlist",['cart'=>$cart,"count"=>$count,"checkedbuynumber"=>$checkedbuynumber]);
        return view("index.carlist",compact("cart","count","checkedbuynumber"));
    }
    //更改购买数据
    public function changeNumber(){
        $goods_id=request()->goods_id;
        // dd($goods_id);
        $buy_number=request()->buy_number;
        // dd($buy_number);
        //获取用户id
        $user=session("reg_name");
        //where条件  商品id  用户id  购物未删除
        $where=[
            ["user_id","=",$user->reg_id],
            ["cart_del","=",1]
        ];
        // dd($where);
        $id = explode(",",$goods_id);
        //在购物车表中改购物车里的购买数量  原先的购买数量改为最新的购买数量
        $res=Cart::where($where)->whereIn("goods_id",$id)->update(["buy_number"=>$buy_number]);
        // dd($res);
        
        if($res===false){
            showMsg("00001","购买数据操作失败");
        }
    }
    //重新获取小计
    public function getTotal(){
        //获取商品id
        $goods_id=request()->goods_id;
        //获取商品价格
        $goods_price=Goods::where("goods_id",$goods_id)->value("goods_price");
        //获取用户id
        $user=session("reg_name");
        $where=[
            ["goods_id","=",$goods_id],
            ["user_id","=",$user->reg_id],
            ["cart_del","=",1]
        ];
        $buy_number=Cart::where($where)->value("buy_number");
        echo $goods_price*$buy_number;
    }
    //重新获取总价
    public function getMoney($id){
        //接收商品id
        $goods_id=request()->goods_id;
        //获取用户id
        $user=session("reg_name");
        //where条件
        $where=[
            ["user_id","=",$user->reg_id],
            ["cart_del","=",1]
        ];
        $id = explode(",",$goods_id);
        $info=Cart::leftjoin("goods","cart.goods_id","=","goods.goods_id")
                   ->where($where)
                   ->whereIn("goods.goods_id",$id)
                   ->get();
                //    dd($info);
        $money=0;
        foreach($info as $k=>$v){
            $money+=$v["goods_price"]*$v["buy_number"];
        }
        return $money;
    }
    
    
}
