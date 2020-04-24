     @extends("layouts.shop")
     @section("title",'详情')
     @section('content')
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>产品详情</h1>
      </div>
     </header>
     <div id="sliderA" class="slider">
     @foreach($slide as $v)
     @if($v->goods_imgs)
     @php $goods_imgs=explode("|",$v->goods_imgs) @endphp
     @foreach($goods_imgs as $vv)
     <img src="{{env('ADMINLOGO_URL')}}{{$vv}}">
     @endforeach
     @endif
     </a>
     @endforeach 
     </div><!--sliderA/-->
     <table class="jia-len">
      <tr>
       <th><strong class="orange">{{$proinfo->goods_price}}</strong></th>
       <td>
        <input id="buy_number" type="text" class="spinnerExample" />
       </td>
      </tr>
      <tr>
       <td>
        <strong>{{$proinfo->goods_name}}</strong><br>
        <span>当前访问量：{{$visit}}</span>
       </td>
       <td align="right">
        <a href="javascript:;" class="shoucang"><span class="glyphicon glyphicon-star-empty"></span></a>
       </td>
      </tr>
     </table>
     
     <div class="height2"></div>
     <h3 class="proTitle">商品档次</h3>
     <ul class="guige">
      <li class="guigeCur"><a href="javascript:;">一般</a></li>
      <li><a href="javascript:;">精品</a></li>
      <div class="clearfix"></div>
     </ul><!--guige/-->
     <div class="height2"></div>
     <div class="zhaieq">
      <a href="javascript:;" class="zhaiCur">商品图片</a>
      <a href="javascript:;">商品简介</a>
      <a href="javascript:;" style="background:none;">商品库存</a>
      <div class="clearfix"></div>
     </div><!--zhaieq/-->
     <div class="proinfoList">
      <img src="{{env('ADMINLOGO_URL')}}{{$proinfo->goods_img}}" width="636" height="822" />
     </div><!--proinfoList/-->
     <div class="proinfoList">
      <center>{{$proinfo->goods_desc}}</center>
     </div><!--proinfoList/-->
     <div class="proinfoList">
      <center>{{$proinfo->goods_num}}</center>
     </div><!--proinfoList/-->
     <table class="jrgwc">
      <tr>
       <th>
        <a href="index.html"><span class="glyphicon glyphicon-home"></span></a>
       </th>
       <td><a class="addcar" href="javascript::void(0)">加入购物车</a></td>
      </tr>
     </table>
    </div><!--maincont-->
    
      <script>
         $(document).on("click",".addcar",function(){
            var goods_id={{$proinfo->goods_id}};
            var buy_number=$("#buy_number").val();
            //通过ajax技术传给控制器
            $.get("/index/addcar",{goods_id:goods_id,buy_number:buy_number},function(result){
               if(result.code=='00001'){
                  location.href="/login/login?refer="+window.location.href;
               }
               if(result.code=='00000'){
                  location.href="/index/carlist"
               }
            },'json')
         })
      </script>
    
@include("index.public.footer");
@endsection