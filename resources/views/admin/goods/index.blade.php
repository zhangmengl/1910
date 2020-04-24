<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>商品</title>
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">后台</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="{{url('/brand/index')}}">品牌管理</a></li>
        <li><a href="{{url('/cate/index')}}">分类管理</a></li>
        <li class="active"><a href="{{url('/goods/index')}}">商品管理</a></li>
        <li><a href="{{url('/admin/index')}}">管理员</a></li>
        <li><a href="{{url('/link/index')}}">友情链接管理</a></li>
      </ul>
    </div>
    <div class="navbar-header" style="float:right;color:#fff">
    欢迎登录
    </diV>
  </div>
</nav>

<center><h2>商品列表<a href="{{url('/goods/create')}}" style="float:right" class="btn btn-default">添加</a></h2></center><br>

<form action="{{url('/goods/index')}}">
    <input type="text" name="goods_name" value="{{$all['goods_name']??''}}" placeholder="请输入商品名称关键字">
    <select name="brand_name">
        <option value="0">请选择品牌</option>
        @foreach ($brand as $v)
        <option value="{{$v->brand_name}}" {{($all["brand_name"]??"")==$v->brand_name ? "selected" : ""}}>{{$v->brand_name}}</option>
        @endforeach
    </select>
    <select name="cate_name">
        <option value="0">请选择分类</option>
        @foreach ($cate as $v)
        <option value="{{$v->cate_name}}" {{($all["cate_name"]??"")==$v->cate_name ? "selected" : ""}}>{{str_repeat("|—",$v->level)}}{{$v->cate_name}}</option>
        @endforeach
    </select>
    <button>搜索</button>
</form>
<hr>
<div class="table-responsive">
	  <table class="table">
		    <thead>
			      <tr>
				        <th>ID</th>
				        <th>商品名称</th>
                <th>商品价格</th>
                <th>商品库存</th>
				        <th>商品主图</th>
                <th>商品相册</th>
                <th>商品详情</th>
                <th>商品积分</th>
                <th>商品是否新品</th>
				        <th>商品是否精品</th>
                <th>商品是否热销</th>
                <th>首页是否幻灯片显示</th>
                <th>商品是否上架</th>
				        <th>商品品牌</th>
                <th>商品分类</th>
                <th>操作</th>
			      </tr>
		    </thead>
		    <tbody>
            @foreach ($goods as $v) 
			      <tr>
				        <td>{{$v->goods_id}}</td>
				        <td>{{$v->goods_name}}</td>
                <td>{{$v->goods_price}}</td>
                <td>{{$v->goods_num}}</td>
                <td>
                    @if($v->goods_img)
                    <img src="{{env('ADMINLOGO_URL')}}{{$v->goods_img}}" width="45px" height="45px">
                    @endif
                </td>
                <td>
                    @if($v->goods_imgs)
                    @php $goods_imgs=explode('|',$v->goods_imgs) @endphp
                    @foreach($goods_imgs as $vv)
                    <img src="{{env('ADMINLOGO_URL')}}{{$vv}}" width="45px" height="45px">
                    @endforeach
                    @endif    
                </td>
                <td>{{$v->goods_desc}}</td>
                <td>{{$v->goods_score}}</td>
                <td>{{$v->is_new==1 ? "√" : "×"}}</td>
                <td>{{$v->is_best==1 ? "√" : "×"}}</td>
                <td>{{$v->is_hot==1 ? "√" : "×"}}</td>
                <td>{{$v->is_slide==1 ? "√" : "×"}}</td>
                <td>{{$v->is_up==1 ? "√" : "×"}}</td>
				        <td>{{$v->brand_name}}</td>
                <td>{{$v->cate_name}}</td>
                <td>
                    <a href="{{url('/goods/edit/'.$v->goods_id)}}" class="btn btn-primary">编辑</a>
                    <a href="{{url('/goods/destroy/'.$v->goods_id)}}" class="btn btn-danger">删除</a>
                </td>
			      </tr>
			      @endforeach
            <tr><td colspan="15">{{$goods->appends($all)->links()}}</td></tr>
        </tbody>
    </table>
</div>  	

<script>
    $(document).on("click",".pagination a",function(){
        var url=$(this).attr("href");
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.post(url,function(result){
            $("tbody").html(result);
        });
        return false;
    });
</script>

</body>
</html>