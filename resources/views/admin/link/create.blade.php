<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>友情链接</title>
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
        <li><a href="{{url('/goods/index')}}">商品管理</a></li>
        <li><a href="{{url('/admin/index')}}">管理员</a></li>
		<li class="active"><a href="{{url('/link/index')}}">友情链接管理</a></li>
      </ul>
    </div>
  </div>
</nav>

<center><h2>友情链接添加<a href="{{url('/link/index')}}" style="float:right" class="btn btn-default">列表</a></h2></center><br>

<!-- @if ($errors->any())
<div class="alert alert-danger">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif -->

<form action="{{url('link/store')}}" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">网站名称</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="link_name" id="firstname" 
				   placeholder="请输入网站名称">
		    <b style="color:red">{{$errors->first('link_name')}}</b>		   
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">网站网址</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="link_url" id="lastname" 
				   placeholder="请输入网站网址">
			
			<b style="color:red">{{$errors->first('link_url')}}</b>	   
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">链接类型</label>
		<div class="col-sm-8">
			<input type="radio" name="link_type" value="1" checked>LOGO链接  
			<input type="radio" name="link_type" value="2">文字链接 
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">图片LOGO</label>
		<div class="col-sm-8">
			<input type="file" class="form-control" name="link_logo" id="lastname">
		</div>
    </div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">网站联系人</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="link_man" id="lastname" 
				   placeholder="请输入网站联系人">
			<b style="color:red">{{$errors->first('link_man')}}</b>	   
		</div>
	</div>
    <div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">网站介绍</label>
		<div class="col-sm-8">
			<textarea type="text" class="form-control" name="link_desc" id="lastname" 
				   placeholder="请输入网站介绍"></textarea>
			<b style="color:red">{{$errors->first('link_desc')}}</b>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">是否显示</label>
		<div class="col-sm-8">
		    <input type="radio" name="link_show" value="1" checked>是  
			<input type="radio" name="link_show" value="2">否 	   
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">提交</button>
		</div>
	</div>
</form>

</body>
</html>