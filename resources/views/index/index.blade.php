     @extends("layouts.shop")
     @section("title",'首页')
     @section('content')
     <div class="head-top">
      <img src="/static/index/images/head.jpg" />
      <dl>
       <dt><a href="user.html"><img src="/static/index/images/touxiang.jpg" /></a></dt>
       <dd>
        <h1 class="username">三级分销终身荣誉会员</h1>
        <ul>
         <li><a href="prolist.html"><strong>34</strong><p>全部商品</p></a></li>
         <li><a href="javascript:;"><span class="glyphicon glyphicon-star-empty"></span><p>收藏本店</p></a></li>
         <li style="background:none;"><a href="javascript:;"><span class="glyphicon glyphicon-picture"></span><p>二维码</p></a></li>
         <div class="clearfix"></div>
        </ul>
       </dd>
       <div class="clearfix"></div>
      </dl>
     </div><!--head-top/-->
     <form action="#" method="get" class="search">
      <input type="text" class="seaText fl" />
      <input type="submit" value="搜索" class="seaSub fr" />
     </form><!--search/-->
     <ul class="reg-login-click">
      @if(session("reg_name")=="")
      <li><a href="{{url('/login/login')}}">登录</a></li>
      <li><a href="{{url('/login/reg')}}" class="rlbg">注册</a></li>
      @else
      <li><a align="center">欢迎@php echo session("reg_name.reg_name") @endphp登录</a></li>
      <li><a href="{{url('/login/quit')}}" class="rlbg">退出</a></li>
      @endif
      <div class="clearfix"></div>
     </ul><!--reg-login-click/-->
     <div id="sliderA" class="slider">
     @foreach($slide as $v)
     <a href="{{url('/index/prolist')}}"><img src="{{env('ADMINLOGO_URL')}}{{$v->goods_img}}" width="1000px"></a>
     @endforeach 
     </div><!--sliderA/-->
     <ul class="pronav">
      @foreach($cate as $v1)
      <li><a href="{{url('/index/prolist')}}">{{$v1->cate_name}}</a></li>
      @endforeach
      <div class="clearfix"></div>
     </ul><!--pronav/-->
     <div class="index-pro1">
     @foreach($best as $vv)
      <div class="index-pro1-list">
       <dl>
        @if($vv->goods_img)<dt><a href="{{url('/index/proinfo/'.$vv->goods_id)}}"><img src="{{env('ADMINLOGO_URL')}}{{$vv->goods_img}}" /></a></dt>@endif
        <dd class="ip-text"><a href="{{url('/index/proinfo/'.$vv->goods_id)}}">{{$vv->goods_name}}</a></dd>
        <dd class="ip-price"><strong>¥{{$vv->goods_price}}</strong> <span>¥{{$vv->goods_price}}</span></dd>
       </dl>
      </div>
      @endforeach
      <div class="clearfix"></div>
     </div><!--index-pro1/-->
     <div class="prolist">
      @foreach($hot as $v3)    
      <dl>
       <dt><a href="{{url('/index/proinfo/'.$v3->goods_id)}}"><img src="{{env('ADMINLOGO_URL')}}{{$v3->goods_img}}" width="100" height="100" /></a></dt>
       <dd>
        <h3><a href="{{url('/index/proinfo/'.$v3->goods_id)}}">{{$v3->goods_name}}</a></h3>
        <div class="prolist-price"><strong>¥{{$v3->goods_price}}</strong> <span>¥{{$v3->goods_price}}</span></div>
        <div class="prolist-yishou"><span>5.0折</span> <em>已售：35</em></div>
       </dd>
       <div class="clearfix"></div>
      </dl>
      @endforeach
     </div><!--prolist/-->
     <div class="joins"><a href="fenxiao.html"><img src="/static/index/images/jrwm.jpg" /></a></div>
     <div class="copyright">Copyright &copy; <span class="blue">这是就是三级分销底部信息</span></div>
     @include("index.public.footer");
     @endsection
   