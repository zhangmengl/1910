     @extends("layouts.shop")
     @section("title",'购物车列表')
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
     <table class="shoucangtab">
      <tr>
       <td width="75%"><span class="hui">购物车共有：<strong class="orange">{{$count}}</strong>件商品</span></td>
       <td width="25%" align="center" style="background:#fff url(/static/index/images/xian.jpg) left center no-repeat;">
        <span class="glyphicon glyphicon-shopping-cart" style="font-size:2rem;color:#666;"></span>
       </td>
      </tr>
     </table>
     <tr>
        <td width="100%" colspan="4"><a href="javascript:;"><input type="checkbox" name="" id="allBox"/> 全选</a></td>
     </tr>
     @foreach($cart as $v)
     <div class="dingdanlist">
      <table>
       <tr goods_id="{{$v->goods_id}}" goods_num="{{$v->goods_num}}">
        <td width="4%"><input type="checkbox" name="" class="box" /></td>
        <td class="dingimg" width="15%"><img src="{{env('ADMINLOGO_URL')}}{{$v->goods_img}}" /></td>
        <td width="50%">
         <h3>{{$v->goods_name}}</h3>
         <time>下单时间：{{date("Y-m-d H:i:s",$v->addtime)}}</time><br>
         单价：¥{{$v->goods_price}} 
        </td>
        <td align="right"><input type="text" id="buy_{{$v->cart_id}}" class="spinnerExample buy_number" /></td>
       </tr>
       <tr>
        <th colspan="4"><strong class="orange">小计：¥{{$v->goods_price*$v->buy_number}}</strong></th>
       </tr>
      </table>
     </div><!--dingdanlist/-->
     @endforeach
     <tr>
        <td width="100%" colspan="4"><a href="javascript:;"><input type="checkbox" name="1" id="delMoney" /> 删除</a></td>
     </tr>
     <div class="height1"></div>
     <div class="gwcpiao">
     <table>
      <tr>
       <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
       <td width="50%">总计：<strong class="orange" id="money">¥0</strong></td>
       <td width="40%"><a href="javascript::void(0)"  class="jiesuan">去结算</a></td>
      </tr>
     </table>
    </div><!--gwcpiao/-->
    </div><!--maincont-->
    <script>
        $(function(){
            //点击+
            $(document).on("click",".increase",function(){
                //当前点击的对象
                var _this=$(this);
                //购买数量
                var buy_number=parseInt(_this.prev("input").val());
                //库存
                var goods_num=parseInt(_this.parents("tr").attr("goods_num"));
                //判断购买数量
                if(buy_number>=goods_num){
                    _this.prev("input").val(goods_num);
                }
                // alert(buy_number);
                //获取商品id
                var goods_id=_this.parents("tr").attr("goods_id");
                //1.更改购买数据
                changeNumber(goods_id,buy_number); 
                //2.重新获取小计
                getTotal(goods_id,_this);             
                //3.给当前行复选框选中
                trChecked(_this);
                //4.重新获取总价
                getMoney()
            })
            //点击-
            $(document).on("click",".decrease",function(){
                //获取当前点击的对象
                var _this=$(this);
                //购买数量
                var buy_number=parseInt(_this.next("input").val());  
                //库存
                var goods_num=parseInt(_this.parents("tr").attr("goods_num"));
                // alert(goods_num);
                //判断购买数量
                if(buy_number<=1){
                    _this.next("input").val(1);
                }
                //获取商品id
                var goods_id=_this.parents("tr").attr("goods_id");
                //1.更改购买数据
                changeNumber(goods_id,buy_number); 
                //2.重新获取小计
                getTotal(goods_id,_this);             
                //3.给当前行复选框选中
                trChecked(_this);
                //4.重新获取总价
                getMoney()
            })
            //文本框失去焦点
            $(document).on("blur",".buy_number",function(){
                //获取当前失去焦点的文本框
                var _this=$(this);
                //获取购买数量
                var buy_number=_this.val();
                //获取库存
                var goods_num=parseInt(_this.parents("tr").attr("goods_num"));
                //正则
                var reg=/^\d{1,}$/;
                //判断购买数量=空
                if(buy_number==""){
                    //如果空  文本框赋值1
                    _this.val(1);
                }else if(buy_number<=0){
                    //小于等于0  文本框赋值1
                    _this.val(1);
                }else if(!reg.test(buy_number)){
                    //不符合正则  文本框赋值1
                    _this.val(1);
                }else if(parseInt(buy_number)>=goods_num){
                    //购买数量>=库存  文本框赋值库存
                    buy_number=_this.val(goods_num);
                }else{
                    _this.val(parseInt(buy_number));
                }
                var buy_number=_this.val();
                //获取商品id
                var goods_id=_this.parents("tr").attr("goods_id");
                //1.更改购买数据
                changeNumber(goods_id,buy_number); 
                //2.重新获取小计
                getTotal(goods_id,_this);             
                //3.给当前行复选框选中
                trChecked(_this);
                //4.重新获取总价
                getMoney()
            })  
            //复选框
            $(document).on("click",".box",function(){
              //当前点击的复选框
              var _this=$(this);
              //获取内置属性 checked
              var status=_this.prop("checked");  
              //重新获取总价
                getMoney();
            })
            //全选
            $(document).on("click","#allBox",function(){
                //获取内置属性 checked
                var status=$("#allBox").prop("checked");
                //给所有复选框选中
                $(".box").prop("checked",status);  
                getMoney();
            })
            //确认结算
            $(document).on("click",".jiesuan",function(){
                //获取选中复选框的商品id
                var _box=$(".box:checked");
                //判断用户是否选中复选框
                if(_box.length>0){
                    //定义一个空的字符串
                    var goods_id="";
                    //each循环
                    _box.each(function(index){
                        goods_id+=$(this).parents("tr").attr("goods_id")+",";
                    })
                    //截取
                    goods_id=goods_id.substr(0,goods_id.length-1);
                    location.href="{{url('/address/jiesuan')}}/"+goods_id;
                }else{
                    alert("请至少选择一件商品进行结算");
                    return false;
                }
            })

            //1.更改购买数据
            function changeNumber(goods_id,buy_number){
                $.ajax({
                    url:"{{url('/index/changeNumber')}}",
                    type:"get",
                    data:{goods_id:goods_id,buy_number:buy_number},
                    async:false,
                    dataType:'json',
                    success:function(res){
                        if(res.code=="00001"){
                            alert(res.msg);
                        }
                    }
                })
            }
            //2.重新获取小计
            function getTotal(goods_id,_this){
                $.get(
                    "{{url('/index/getTotal')}}",
                    {goods_id:goods_id},
                    function(res){
                        // console.log(res);
                        _this.parents("tr").next("tr").find("th").text("￥"+res);
                    }
                )
            }
            //3.给当前行复选框选中s
            function trChecked(_this){
                _this.parents("tr").find(".box").prop("checked",true);
            }
            //4.重新获取总价
            function getMoney(){
                //获取选中的复选框
                var _box=$(".box:checked");
                //循环复选框  得到每个复选框的商品id
                var goods_id='';
                _box.each(function(index){
                    //每个选中复选框的商品id
                    goods_id+=$(this).parents("tr").attr("goods_id")+",";
                })   
                //去除右边的逗号  截取本身的长度-1最后一位 
                goods_id=goods_id.substr(0,goods_id.length-1);
                // console.log(goods_id);
                $.get('/index/getMoney/'+goods_id,{goods_id:goods_id},function(res){
                    $("#money").text("￥"+res);
                })
            }
        })
    </script>

@endsection