<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>品牌</title>
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
        <li class="active"><a href="{{url('/brand/index')}}">品牌管理</a></li>
        <li><a href="{{url('/cate/index')}}">分类管理</a></li>
        <li><a href="{{url('/goods/index')}}">商品管理</a></li>
        <li><a href="{{url('/admin/index')}}">管理员</a></li>
		<li><a href="{{url('/link/index')}}">友情链接管理</a></li>
      </ul>
    </div>
  </div>
</nav>

<center><h2>品牌编辑<a href="{{url('/brand/index')}}" style="float:right" class="btn btn-default">列表</a></h2></center><br>

@if ($errors->any())
<div class="alert alert-danger">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form action="{{url('brand/update',$res->brand_id)}}" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">品牌名称</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="brand_name" value="{{$res->brand_name}}" id="firstname" 
				   placeholder="请输入品牌名称">
			<b style="color:red">{{$errors->first('brand_name')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">品牌网址</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="brand_url" value="{{$res->brand_url}}" id="lastname" 
				   placeholder="请输入品牌网址">
			<b style="color:red">{{$errors->first('brand_url')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">品牌LOGO</label>
		<div class="col-sm-2">
			<input type="file" class="form-control" name="brand_logo" id="lastname">
        </div>
        @if($res->brand_logo)<img src="{{env('UPLOADS_URL')}}{{$res->brand_logo}}" width="45px" height="45px">
        @endif
    </div>
    <div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">品牌描述</label>
		<div class="col-sm-8">
			<textarea type="text" class="form-control" name="brand_desc" id="lastname" 
				   placeholder="请输入品牌描述">{{$res->brand_desc}}</textarea>
			<b style="color:red">{{$errors->first('brand_desc')}}</b>	   
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