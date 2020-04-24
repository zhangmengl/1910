     @extends("layouts.shop")
     @section("title",'列表')
     @section('content')
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <form action="#" method="get" class="prosearch"><input type="text" /></form>
      </div>
     </header>
     <ul class="pro-select">
      <li class="default pro-selCur"  field="is_new"><a href="javascript:;">新品</a></li>
      <li class="default"  field="is_best"><a href="javascript:;">精品</a></li>
      <li class="default" field="is_hot"><a href="javascript:;">热卖</a></li>
     </ul><!--pro-select/-->
     <div class="prolist" id="show">
      @foreach($prolist as $v)
      <dl>
       <dt><a href="{{url('/index/proinfo/'.$v->goods_id)}}"><img src="{{env('ADMINLOGO_URL')}}{{$v->goods_img}}" width="100" height="100" /></a></dt>
       <dd>
        <h3><a href="{{url('/index/proinfo/'.$v->goods_id)}}">{{$v->goods_name}}</a></h3>
        <div class="prolist-price"><strong>¥{{$v->goods_price}}</strong> <span>¥{{$v->goods_price}}</span></div>
        <div class="prolist-yishou"><span>5.0折</span> <em>已售：35</em></div>
       </dd>
       <div class="clearfix"></div>
      </dl>
      @endforeach
     </div><!--prolist/-->
     @include("index.public.footer");
     @endsection
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/static/index/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/static/index/js/bootstrap.min.js"></script>
    <script src="/static/index/js/style.js"></script>
    <!--焦点轮换-->
    <script src="/static/index/js/jquery.excoloSlider.js"></script>
    
<script>
    //页面加载事件
    $(function(){
        //点击默认
        $(document).on("click",".default",function(){
            //获取当前点击的对象
            var _this=$(this);
            //给当前点击的对象换背景色
            _this.addClass("pro-selCur").siblings("li").removeClass("pro-selCur");
        })
    })
</script>