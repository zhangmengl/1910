<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>商品</title>
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
  </div>
</nav>

<center><h2>商品编辑<a href="{{url('/goods/index')}}" style="float:right" class="btn btn-default">列表</a></h2></center><br>

<!-- @if ($errors->any())
<div class="alert alert-danger">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif -->

<form action="{{url('/goods/update',$goods->goods_id)}}" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">商品名称</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="goods_name" value="{{$goods->goods_name}}" id="firstname" 
           placeholder="请输入商品名称">
      <b style="color:red">{{$errors->first('goods_name')}}</b>     
		</div>
  </div>
  <div class="form-group">
	  <label for="firstname" class="col-sm-2 control-label">商品价格</label>
    <div class="col-sm-8">
			<input type="text" class="form-control" name="goods_price" value="{{$goods->goods_price}}" id="firstname" 
           placeholder="请输入商品价格">
      <b style="color:red">{{$errors->first('goods_price')}}</b>     
		</div>
  </div>
  <div class="form-group">
	  <label for="firstname" class="col-sm-2 control-label">商品库存</label>
    <div class="col-sm-8">
			<input type="text" class="form-control" name="goods_num" value="{{$goods->goods_num}}" id="firstname" 
           placeholder="请输入商品库存">
      <b style="color:red">{{$errors->first('goods_num')}}</b>     
		</div>
  </div>
  <div class="form-group">
	  <label for="firstname" class="col-sm-2 control-label">商品主图</label>
    <div class="col-sm-2">
			<input type="file" class="form-control" name="goods_img" id="firstname">     
    </div>
    @if($goods->goods_img)
       <img src="{{env('ADMINLOGO_URL')}}{{$goods->goods_img}}" width="45px" height="45px">
    @endif
  </div>
  <div class="form-group">
	  <label for="firstname" class="col-sm-2 control-label">商品相册</label>
    <div class="col-sm-2">
			<input type="file" class="form-control" name="goods_imgs[]" multiple="multiple" id="firstname">    
    </div>
    @if($goods->goods_imgs)
    @php $goods_imgs=explode('|',$goods->goods_imgs) @endphp
    @foreach($goods_imgs as $vv)
    <img src="{{env('ADMINLOGO_URL')}}{{$vv}}" width="45px" height="45px">
    @endforeach
    @endif 
  </div>
  <div class="form-group">
	  <label for="firstname" class="col-sm-2 control-label">商品详情</label>
    <div class="col-sm-8">
			<textarea class="form-control" name="goods_desc" id="firstname" 
           placeholder="请输入商品描述">{{$goods->goods_desc}}</textarea>
      <b style="color:red">{{$errors->first('goods_desc')}}</b>     
		</div>
  </div>
  <div class="form-group">
	  <label for="firstname" class="col-sm-2 control-label">商品积分</label>
    <div class="col-sm-8">
			<input type="text" class="form-control" name="goods_score" value="{{$goods->goods_score}}" id="firstname" 
           placeholder="请输入商品积分">
      <b style="color:red">{{$errors->first('goods_score')}}</b>     
		</div>
  </div>
  <div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">商品是否新品</label>
		<div class="col-sm-8">
            <input type="radio" name="is_new" value="1" {{$goods->is_new=="1" ? "checked" : ""}}>是
            <input type="radio" name="is_new" value="2" {{$goods->is_new=="2" ? "checked" : ""}}>否
		</div>
  </div>
  <div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">商品是否精品</label>
		<div class="col-sm-8">
            <input type="radio" name="is_best" value="1" {{$goods->is_best=="1" ? "checked" : ""}}>是
            <input type="radio" name="is_best" value="2" {{$goods->is_best=="2" ? "checked" : ""}}>否
		</div>
  </div>
  <div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">商品是否热销</label>
		<div class="col-sm-8">
            <input type="radio" name="is_hot" value="1" {{$goods->is_hot=="1" ? "checked" : ""}}>是
            <input type="radio" name="is_hot" value="2" {{$goods->is_hot=="2" ? "checked" : ""}}>否
		</div>
  </div>
  <div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">首页是否幻灯片显示</label>
		<div class="col-sm-8">
            <input type="radio" name="is_slide" value="1" {{$goods->is_slide=="1" ? "checked" : ""}}>是
            <input type="radio" name="is_slide" value="2" {{$goods->is_slide=="2" ? "checked" : ""}}>否
		</div>
  </div>
  <div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">商品是否上架</label>
		<div class="col-sm-8">
            <input type="radio" name="is_up" value="1" {{$goods->is_up=="1" ? "checked" : ""}}>是
            <input type="radio" name="is_up" value="2" {{$goods->is_up=="2" ? "checked" : ""}}>否
		</div>
  </div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">商品品牌</label>
		<div class="col-sm-2">
            <select class="form-control" name="brand_id"">
                <option value="0">请选择商品品牌</option>
                @foreach ($brand as $v)
                <option value="{{$v->brand_id}}" {{$v->brand_id==$goods->brand_id ? "selected" : ""}}>{{$v->brand_name}}</option>
                @endforeach
            </select>
		</div>
  </div>
  <div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">商品分类</label>
		<div class="col-sm-2">
            <select class="form-control" name="cate_id">
                <option value="0">顶级分类</option>
                @foreach ($cate as $v)
                <option value="{{$v->cate_id}}" {{$goods->cate_id==$v->cate_id ? "selected" : ""}}>{{str_repeat("|—",$v->level)}}{{$v->cate_name}}</option>
                @endforeach
            </select>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">编辑</button>
		</div>
	</div>
</form>

</body>
</html>