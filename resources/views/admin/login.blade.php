<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>后台登录</title>
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<center><h2>后台登录</h2><br>

<!-- @if ($errors->any())
<div class="alert alert-danger">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif -->

<b style="color:red">{{session("msg")}}</b>

<form action="{{url('login/loginDo')}}" method="post" class="form-horizontal" role="form">
@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-4 control-label">用户名</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" name="admin_name" id="firstname" 
				   placeholder="请输入用户名">		   
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-4 control-label">密码</label>
		<div class="col-sm-4">
			<input type="password" class="form-control" name="admin_pwd" id="lastname" 
				   placeholder="请输入密码">	   
		</div>
	</div>
	<div class="form-group" style="width:81%;">
		<label for="firstname" class="col-sm-2 control-label"></label>
	    <div class="col-sm-4">
		    <input type="checkbox" name="reme">七天免登录
	    </div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-1 col-sm-10">
			<button type="submit" class="btn btn-default">登录</button>
		</div>
	</div>
</form>
</center>
</body>
</html>