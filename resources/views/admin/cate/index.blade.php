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

<center><h2>分类列表<a href="{{url('/cate/create')}}" style="float:right" class="btn btn-default">添加</a></h2></center><br>

<div class="table-responsive">

    @if (session("msg"))
        <div class="alert alert-danger">{{session("msg")}}</div>
    @endif

	  <table class="table">
		    <thead>
			      <tr>
				        <th>ID</th>
                <th>分类名称</th>
                <th>分类是否显示</th>
                <th>分类是否在导航显示</th>
                <th>操作</th>
			      </tr>
		    </thead>
		    <tbody>
            @foreach ($cate as $v) 
			      <tr>
				        <td>{{$v->cate_id}}</td>
                <td>{{str_repeat("|—",$v->level)}}{{$v->cate_name}}</td>
                <td>{{$v->cate_show=="1" ? "√" : "×"}}</td>
				        <td>{{$v->cate_nav_show=="1" ? "√" : "×"}}</td>
                <td>
                    <a href="{{url('/cate/edit/'.$v->cate_id)}}" class="btn btn-primary">编辑</a>
                    <a href="{{url('/cate/destroy/'.$v->cate_id)}}" class="btn btn-danger">删除</a>
                </td>
			      </tr>
		      	@endforeach
		    </tbody>
    </table>
</div>  	

</body>
</html>