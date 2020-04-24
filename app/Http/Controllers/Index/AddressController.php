<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cart;
use App\Address;
use App\Area;
use App\Goods;
use App\Order;
use App\OrderAddress;
use App\OrderGoods;
class AddressController extends Controller
{
    //确认结算
    public function jiesuan($goods_id){
        //接收商品id
        $goods_id=request()->goods_id;
        //获取用户id
        $user=session("reg_name");
        //where条件  
        $where=[
            ['user_id','=',$user->reg_id],
            ['cart_del','=',1]
        ];
        $goods_id = explode(",",$goods_id);
        //根据两表里共有的商品id  查找商品id，购买数量，商品名称，商品价格，商品库存，商品图片
        $cartInfo=Cart::leftjoin('goods','cart.goods_id','=','goods.goods_id')
                        ->where($where)
                        ->whereIn("goods.goods_id",$goods_id)
                        ->orderBy('addtime','desc')
                        ->get();
        // dd($cartInfo);
        //总价
        $money=0;            
        foreach($cartInfo as $k=>$v){
            $money+=$v['goods_price']*$v['buy_number'];
        }
        
        //收货地址
        $where = [
            ["user_id","=",$user->reg_id],
            ["is_del","=",1],
            ["is_default","=",1]
        ];
        $addressInfo = Address::where($where)->get();
        // dd($addressInfo);
        foreach($addressInfo as $k=>$v){
            //根据下表中 所指示的 等于设置的 城市表中根据条件 城市表中的id 等于收货地址表中的数据 查找值为name的
            $addressInfo[$k]->country = Area::where("id",$v->country)->value("name");
            $addressInfo[$k]->province = Area::where("id",$v->province)->value("name");
            $addressInfo[$k]->area = Area::where("id",$v->area)->value("name");
        }
        $goods_id=implode(",",$goods_id);
        
        return view("index.pay",['cartInfo'=>$cartInfo,'money'=>$money,'addressInfo'=>$addressInfo,"goods_id"=>$goods_id]);
    }
    //展示收货地址
    public function address(){
        $user_id = session("reg_name")->reg_id;
        // dd($user_id);
        $where = [
            ["user_id","=",$user_id],
            ["is_del","=",1]
        ];
        // dd($where);
        $addressInfo = Address::where($where)->get();
        // dd($addressInfo);
        foreach($addressInfo as $k=>$v){
            //根据下表中 所指示的 等于设置的 城市表中根据条件 城市表中的id 等于收货地址表中的数据 查找值为name的
            $addressInfo[$k]->country = Area::where("id",$v->country)->value("name");
            $addressInfo[$k]->province = Area::where("id",$v->province)->value("name");
            $addressInfo[$k]->area = Area::where("id",$v->area)->value("name");
        }
        // dd($addressInfo);
        return view("index.address",["addressInfo"=>$addressInfo]);
    }
    //收货地址渲染视图
    public function addressDo(){
        $area = Area::where(["pid"=>0])->get();
        // dd($area);
        // var_dump($area);die;
        //三级联动
        $areaInfo = $this->getAddress(0);
        // dd($areaInfo);
        return view("index.add_address",["areaInfo"=>$areaInfo]);
    }
    //获取地区
    public function getAddress($pid){
        $pid = explode(",",$pid);
        $res = Area::whereIn("pid",$pid)->get();
        // dd($res);
        return $res;
    }
    //Ajax内容改变事件
    public function getCity(){
        $id = request()->get("id");
        // dd($id);
        $cityInfo = $this->getaddress($id);
        // dd($cityInfo);
        echo json_encode($cityInfo);
    }
    //执行收货地址添加
    public function addressAdd(){
        $arr = request()->except("_token");
        // dd($arr);
        $ags = "/^1[358]\d{9}$/";
        if(empty($arr["country"])){
            return redirect("/address/address")->with("msg","省市不能为空");
        }else if(empty($arr["province"])){
            return redirect("/address/address")->with("msg","市区不能为空");
        }else if(empty($arr["area"])){
            return redirect("/address/address")->with("msg","县城不能为空");
        }else if(empty($arr["address_name"])){
            return redirect("/address/address")->with("msg","收货人不能为空");
        }else if(empty($arr["address_tel"])){
            return redirect("/address/address")->with("msg","手机号不能为空");
        }else if(!preg_match($ags,$arr["address_tel"])){
            return redirect("/address/address")->with("msg","手机号格式不正确");
        }else if(empty($arr["address_datail"])){
            return redirect("/address/address")->with("msg","详细地址不能为空");
        }
        $name = session("reg_name");
        $user_id = $name->reg_id;
        $arr["user_id"] = $name->reg_id;
        $arr["is_default"] = "1";
        // dd($user_id);
        // dd($arr);
        if(!empty($arr["is_default"])){
            //根据 用户id 是否删除 写where条件
            $where = [
                ["user_id","=",$user_id],
                ["is_del","=",1]
            ];
            //加上where条件将数据库中的迷人改为2
            Address::where($where)->update(["is_default"=>2]);
        }
        $res = Address::insert($arr);
        if($res){
            return redirect("/address/address");
        }

    }
    //提交订单
    public function orderPay(){
        $goods_id = request()->get("goods_id");
        $address_id = request()->get("address_id");
        $pay_type = request()->get("pay_type");
        // dd($goods_id);
        // print_r($address_id);
        // dump($pay_type);
        // dump($order_talk);

        //验证商品id是否为空
        if(empty($goods_id)){
            return json_encode(["code"=>"00004","msg"=>"至少选择一件商品进行下单"]);
        }else{
            $goodswhere = [
                ["goods_id","=",$goods_id]
            ];
            $goodsInfo = Goods::where($goodswhere)->get();
            if(empty($goodsInfo[0])){
                return json_encode(["code"=>"00004","msg"=>"商品信息有误"]);
            }
        }

        //验证收货地址是否为空
        if(empty($address_id)){
            return json_encode(["code"=>"00004","msg"=>"收货地址不能为空"]);
        }else{
            $addresswhere = [
                ["address_id","=",$address_id],
                ["is_del","=",1]
            ];
            $addressInfo = Address::where($addresswhere)->first();
            // dump($addressInfo);
            if(empty($addressInfo)){
                return json_encode(["code"=>"00004","msg"=>"此收货地址有误"]);
            }
        }
        //验证支付方式是否为空
        if(empty($pay_type)){
            return json_encode(["code"=>"00004","msg"=>"支付方式必填"]);
        }
         //获取用户id
         $user_id = session("reg_name")["reg_id"];
        //  dd($user_id);
         //定义用户id 是否删除为where条件
         $where = [
             ["user_id","=",$user_id],
             ["goods_del","=",1]
         ];
         $goods_id = explode(",",$goods_id);
         //写sql语句  根据where条件查询出购物车表个两表中商品表 
         $goodsInfo = Goods::leftjoin("cart","goods.goods_id","=","cart.goods_id")
                     ->where($where)
                     ->whereIn("goods.goods_id",$goods_id)
                     ->get(["goods.goods_id","goods.goods_img","goods.goods_name","goods.goods_price","buy_number"]);
        // dd($goodsInfo);

        //1.订单信息存入到订单表
        $money=0;
        //循环查询出的值
        foreach($goodsInfo as $k=>$v){
            // dump($v);
            //将价格乘以购买数量 赋值给空值
            $money += $v["goods_price"]*$v["buy_number"];//总价
            // dump($money);
        }
        // dump($money);
        //订单号
        $order_on = time().$pay_type.rand(1000,9999);
        //将数据存入数组
        $orderInfo = ["order_amount"=>$money,
                       "order_no"=>$order_on,
                       "order_time"=>time(),
                       "pay_type"=>$pay_type,
                       "user_id"=>$user_id,
                    ];
        // dump($orderInfo);
        //实例化订单表
        //将数据添加到库
        $res1 = Order::create($orderInfo);
        // dump($res1);
        if(empty($res1)){
            return json_encode(["code"=>"00004","msg"=>"添加订单信息失败"]);
        }


        //2.订单收货地址信息 存储到订单的收货地址表
        $order_id = $res1->order_id;
        // dump($order_id);exit;
        //获取订单id
        //将订单收货表转为数组
        $addressInfo = $addressInfo->toArray();
        //将订单表id 存入订单收货地址表中
        $addressInfo["order_id"] = $order_id;
        // dump($addressInfo);exit;
        //将订单内容添加到订单地址表中
        $res2 = OrderAddress::create($addressInfo);
        if(empty($res2)){
            return json_encode(["code"=>"00004","msg"=>"添加订单收货地址信息失败"]);
        }


        //3.订单商品信息 存储到订单的商品表
        // dump($goodsInfo);
        //循环商品表
        foreach($goodsInfo as $k=>$v){
            //将下表加一个用户id 和订单的id
            $goodsInfo[$k]["user_id"] = $user_id;
            $goodsInfo[$k]["order_id"] = $order_id;
        }
        //将订单商品表 转为数组
        $goodsInfo = $goodsInfo->toArray();
        // dump($goodsInfo);exit;
        //所有的订单商品加入数据库
        $res3 = OrderGoods::insert($goodsInfo);
        // dump($res3);
        if(empty($res3)){
            return json_encode(["code"=>"00004","msg"=>"添加订单商品信息失败"]);
        }

        //4.清除购物车表
        //根据商品id 是否删除 写where条件
        $cartwhere = [
            ["user_id","=",$user_id]
        ];
        //根据where条件修改
        $res4 = Cart::where($cartwhere)->whereIn("goods_id",$goods_id)->update(["cart_del"=>2]);
        // dump($res4);
        if(empty($res4)){
            return json_encode(["code"=>"00004","msg"=>"购物车清除失败"]);
        }


        //5.修改商品表的库存
        // dump($goodsInfo);exit;
        foreach($goodsInfo as $k=>$v){
            $res5 = Goods::where("goods_id",$v["goods_id"])->decrement("goods_num",$v["buy_number"]);
            if(empty($res5)){
                return json_encode(["code"=>"00004","msg"=>"修改商品库存失败"]);
            }
        }
        // dump($res5);


        // successly("下单成功");
        return json_encode(["font"=>"下单成功","code"=>1,"order_id"=>$order_id]);

    }
}
