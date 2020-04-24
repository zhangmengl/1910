<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>分类</title>
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
        <li class="active"><a href="{{url('/cate/index')}}">分类管理</a></li>
        <li><a href="{{url('/goods/index')}}">商品管理</a></li>
        <li><a href="{{url('/admin/index')}}">管理员</a></li>
        <li><a href="{{url('/link/index')}}">友情链接管理</a></li>
      </ul>
    </div>
  </div>
</nav>

<center><h2>分类编辑<a href="{{url('/cate/index')}}" style="float:right" class="btn btn-default">列表</a></h2></center><br>

<!-- @if ($errors->any())
<div class="alert alert-danger">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif -->

<form action="{{url('/cate/update',$res->cate_id)}}" method="post" class="form-horizontal" role="form">
@csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">分类名称</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="cate_name" value="{{$res->cate_name}}" id="firstname" 
           placeholder="请输入分类名称">
      <p style="color:red">{{$errors->first('cate_name')}}</p>     
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">父分类</label>
		<div class="col-sm-2">
            <select class="form-control" name="pid">
                <option value="0">顶级分类</option>
                @foreach ($cate as $v)
                <option value="{{$v->cate_id}}" {{$res->pid==$v->cate_id ? "selected" : ""}}>{{str_repeat("|—",$v->level)}}{{$v->cate_name}}</option>
                @endforeach
            </select>
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">分类是否显示</label>
		<div class="col-sm-8">
            <input type="radio" name="cate_show" value="1" {{$res->cate_show=="1" ? "checked" : "" }}>是
            <input type="radio" name="cate_show" value="2" {{$res->cate_show=="2" ? "checked" : "" }}>否
		</div>
    </div>
    <div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">分类是否在导航显示</label>
		<div class="col-sm-8">
            <input type="radio" name="cate_nav_show" value="1" {{$res->cate_nav_show=="1" ? "checked" : "" }}>是
            <input type="radio" name="cate_nav_show" value="2" {{$res->cate_nav_show=="2" ? "checked" : "" }}>否
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