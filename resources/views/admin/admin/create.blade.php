<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>管理员</title>
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
        <li class="active"><a href="{{url('/admin/index')}}">管理员</a></li>
		<li><a href="{{url('/link/index')}}">友情链接管理</a></li>
      </ul>
    </div>
  </div>
</nav>

<center><h2>管理员添加<a href="{{url('/admin/index')}}" style="float:right" class="btn btn-default">列表</a></h2></center><br>

<!-- @if ($errors->any())
<div class="alert alert-danger">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif -->

<form action="{{url('admin/store')}}" method="post" class="form-horizontal" role="form">
@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">管理员名称</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="admin_name" id="firstname" 
				   placeholder="请输入管理员名称">
		    <b style="color:red">{{$errors->first('admin_name')}}</b>		   
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">管理员电话</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="admin_tel" id="lastname" 
				   placeholder="请输入管理员电话">
			<b style="color:red">{{$errors->first('admin_tel')}}</b>	   
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">管理员邮箱</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="admin_email" id="lastname" 
				   placeholder="请输入管理员邮箱">
			<b style="color:red">{{$errors->first('admin_email')}}</b>	   
		</div>
    </div>
    <div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">管理员密码</label>
		<div class="col-sm-8">
			<input type="password" class="form-control" name="admin_pwd" id="lastname" 
				   placeholder="请输入管理员密码">
			<b style="color:red">{{$errors->first('admin_pwd')}}</b>	   
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">确认密码</label>
		<div class="col-sm-8">
			<input type="password" class="form-control" name="pwd" id="lastname" 
				   placeholder="请重新输入管理员密码">
			<b style="color:red">{{session("msg")}}</b>	   
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