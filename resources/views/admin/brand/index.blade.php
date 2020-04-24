<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>品牌</title>
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
        <li class="active"><a href="{{url('/brand/index')}}">品牌管理</a></li>
        <li><a href="{{url('/cate/index')}}">分类管理</a></li>
        <li><a href="{{url('/goods/index')}}">商品管理</a></li>
        <li><a href="{{url('/admin/index')}}">管理员</a></li>
        <li><a href="{{url('/link/index')}}">友情链接管理</a></li>
      </ul>
    </div>
  </div>
</nav>

<center><h2>品牌列表<a href="{{url('/brand/create')}}" style="float:right" class="btn btn-default">添加</a></h2></center><br>

<form action="{{url('/brand/index')}}">
    <input type="text" name="brand_name" value="{{$all['brand_name']??''}}" placeholder="请输入品牌名称关键字">
    <input type="text" name="brand_url" value="{{$all['brand_url']??''}}" placeholder="请输入品牌网址关键字">
    <button>搜索</button>
</form>
<hr>
<div class="table-responsive">
	  <table class="table">
		    <thead>
			      <tr>
				        <th>ID</th>
				        <th>品牌名称</th>
                <th>品牌网址</th>
                <th>品牌LOGO</th>
                <th>品牌描述</th>
                <th>操作</th>
			      </tr>
		    </thead>
		    <tbody>
            @foreach ($brand as $v) 
			      <tr>
				        <td>{{$v->brand_id}}</td>
				        <td>{{$v->brand_name}}</td>
                <td>{{$v->brand_url}}</td>
                <td>@if($v->brand_logo)<img src="{{env('ADMINLOGO_URL')}}{{$v->brand_logo}}" width="45px" height="45px">
                    @endif
                </td>
                <td>{{$v->brand_desc}}</td>
                <td>
                    <a href="{{url('/brand/edit/'.$v->brand_id)}}" class="btn btn-primary">编辑</a>
                    <a href="{{url('/brand/destroy/'.$v->brand_id)}}" class="btn btn-danger">删除</a>
                </td>
			      </tr>
			      @endforeach
            <tr><td colspan="6">{{$brand->appends($all)->links()}}</td></tr>
        </tbody>
    </table>
    
</div>  	
<script>
    //无刷新分页
    $(document).on("click",".pagination a",function(){
        //获取当前点击的超链接
        var url=$(this).attr("href");
        //第一种
        // $.get(url,function(result){
        //      $("tbody").html(result);
        // });
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.post(url,function(result){
             $("tbody").html(result);
        });
        return false;
    });
</script>

</body>
</html>