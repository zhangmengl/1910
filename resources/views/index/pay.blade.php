     @extends("layouts.shop")
     @section("title",'购物车页面')
     @section('content')
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>购物车</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/static/index/images/head.jpg" />
     </div><!--head-top/-->
     <div class="dingdanlist" onClick="window.location.href='address.html'">
      <table>
       <tr>
        <td class="dingimg" width="75%" colspan="2">新增收货地址</td>
        <td align="right"><a href="{{url('/address/address')}}"><img src="/static/index/images/jian-new.png" /></a></td>
       </tr>
       @foreach($addressInfo as $v)
       <tr class="dingimg address" width="75%" colspan="2" address_id="{{$v->address_id}}">
        <td width="50%">
         <h3>{{$v->address_name}}&nbsp;{{$v->address_tel}}</h3>
         <time>{{$v->country}}{{$v->province}}{{$v->area}}{{$v->datail}}</time>
        </td>
       </tr>
       @endforeach
       <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
       <tr>
        <td class="dingimg" width="75%" colspan="1">选择收货时间</td>
        <td align="right"><img src="/static/index/images/jian-new.png" /></td>
       </tr>
       <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
       <tr>
        <td class="dingimg" width="75%" colspan="1">支付方式</td>
        <td align="right"><a class="ment" payment="1">支付宝</a></td>
       </tr>
       </tr>
       <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
       <tr>
        <td class="dingimg" width="75%" colspan="1">优惠券</td>
        <td align="right"><span class="hui">无</span></td>
       </tr>
       <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
       <tr>
        <td class="dingimg" width="75%" colspan="1">是否需要开发票</td>
        <td align="right"><a href="javascript:;" class="orange">是</a> &nbsp; <a href="javascript:;">否</a></td>
       </tr>
       <tr>
        <td class="dingimg" width="75%" colspan="1">发票抬头</td>
        <td align="right"><span class="hui">个人</span></td>
       </tr>
       <tr>
        <td class="dingimg" width="75%" colspan="1">发票内容</td>
        <td align="right"><a href="javascript:;" class="hui">请选择发票内容</a></td>
       </tr>
       <tr><td colspan="3" style="height:10px; background:#fff;padding:0;"></td></tr>
       <tr>
        <td class="dingimg" width="75%" colspan="3">商品清单</td>
       </tr>

       @foreach($cartInfo as $k=>$v)
       <tr>
        <td class="dingimg" width="15%"><img src="{{env('ADMINLOGO_URL')}}{{$v->goods_img}}" /></td>
        <td width="50%">
         <h3>{{$v->goods_name}}</h3>
         <time>下单时间：{{date("Y-m-d H:i:s",$v->addtime)}}</time>
         单价：¥{{$v->goods_price}}
        </td>
        <td align="right"><span class="qingdan">X {{$v->buy_number}}</span></td>
       </tr>
       <tr>
        <th colspan="3"><strong class="orange">小计：¥{{$v->goods_price*$v->buy_number}}</strong></th>
       </tr>
       @endforeach
       
       <tr>
        <td class="dingimg" width="75%" colspan="2">商品金额</td>
        <td align="right"><strong class="orange">¥{{$money}}</strong></td>
       </tr>
       <tr>
        <td class="dingimg" width="75%" colspan="2">折扣优惠</td>
        <td align="right"><strong class="green">¥0.00</strong></td>
       </tr>
       <tr>
        <td class="dingimg" width="75%" colspan="2">抵扣金额</td>
        <td align="right"><strong class="green">¥0.00</strong></td>
       </tr>
       <tr>
        <td class="dingimg" width="75%" colspan="2">运费</td>
        <td align="right"><strong class="orange">¥0.00</strong></td>
       </tr>
      </table>
     </div><!--dingdanlist/-->
     
     
    </div><!--content/-->
    
    <div class="height1"></div>
    <div class="gwcpiao">
     <table>
      <tr>
       <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
       <td width="50%">总计：<strong class="orange">¥{{$money}}</strong></td>
       <td width="40%"><a href="javascript:;" class="jiesuan" goods_id="{{$goods_id}}">提交订单</a></td>
      </tr>
      <!-- javascript::void(0) -->
     </table>
    </div><!--gwcpiao/-->
    </div><!--maincont-->
    <script>
    $(function(){
        $(document).on("click",".jiesuan",function(){
            //alert("123");
            //获取商品id
            var goods_id = $(this).attr("goods_id");;
            //获取默认收货地址
            var address_id = $(".address").attr("address_id");
            //获取支付方式
            var pay_type = $(".ment").attr("payment");
            $.get(
                "/address/orderPay", {
                    goods_id: goods_id,
                    address_id: address_id,
                    pay_type: pay_type,
                },
                function(res) {
                        // alert(res);
                    // console.log(res);
                    if (res.code == "00004") {
                        alert(res.msg);
                    } else {
                        alert(res.font);
                        location.href = "{{url('/order/orderSuccess')}}/"+res.order_id;
                    }
                }, "json"
            )
        })
    })
    </script>
@endsection