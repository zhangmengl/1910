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

<center><h2>管理员列表<a href="{{url('/admin/create')}}" style="float:right" class="btn btn-default">添加</a></h2></center><br>

<form action="{{url('/admin/index')}}">
    <input type="text" name="admin_name" value="{{$all['admin_name']??''}}" placeholder="请输入管理员名称关键字">
    <input type="text" name="admin_tel" value="{{$all['admin_tel']??''}}" placeholder="请输入管理员电话关键字">
    <button>搜索</button>
</form>
<hr>
<div class="table-responsive">
	  <table class="table">
		    <thead>
			      <tr>
				        <th>ID</th>
				        <th>管理员名称</th>
                <th>管理员电话</th>
                <th>管理员邮箱</th>
                <th>添加时间</th>
                <th>操作</th>
			      </tr>
		    </thead>
		    <tbody>
            @foreach ($admin as $v) 
			      <tr>
				        <td>{{$v->admin_id}}</td>
				        <td>{{$v->admin_name}}</td>
                <td>{{$v->admin_tel}}</td>
                <td>{{$v->admin_email}}</td>
                <td>{{date("Y-m-d H:i:s",$v->admin_time)}}</td>
                <td>
                    <a href="{{url('/admin/edit/'.$v->admin_id)}}" class="btn btn-primary">编辑</a>
                    <a href="{{url('/admin/destroy/'.$v->admin_id)}}" class="btn btn-danger">删除</a>
                </td>
			      </tr>
			      @endforeach
        </tbody>
    </table>
    {{ $admin->appends($all)->links() }}
</div>  	

</body>
</html>