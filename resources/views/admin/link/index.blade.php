<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>友情链接</title>
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
        <li><a href="{{url('/goods/index')}}">商品管理</a></li>
        <li><a href="{{url('/admin/index')}}">管理员</a></li>
        <li class="active"><a href="{{url('/link/index')}}">友情链接管理</a></li>
      </ul>
    </div>
  </div>
</nav>

<center><h2>友情链接列表<a href="{{url('/link/create')}}" style="float:right" class="btn btn-default">添加</a></h2></center><br>

<form action="{{url('/link/index')}}">
    <input type="text" name="link_name" value="{{$all['link_name']??''}}" placeholder="请输入网站名称关键字">
    <input type="text" name="link_url" value="{{$all['link_url']??''}}" placeholder="请输入网站网址关键字">
    <button>搜索</button>
</form>
<hr>
<div class="table-responsive">
	  <table class="table">
		    <thead>
			      <tr>
				        <th>ID</th>
				        <th>网站名称</th>
                <th>网站网址</th>
                <th>链接类型</th>
                <th>网站LOGO</th>
                <th>网站联系人</th>
                <th>网站介绍</th>
                <th>是否显示</th>
                <th>操作</th>
			      </tr>
		    </thead>
		    <tbody>
            @foreach ($link as $v) 
			      <tr>
				        <td>{{$v->link_id}}</td>
				        <td>{{$v->link_name}}</td>
                <td>{{$v->link_url}}</td>
                <td>{{$v->link_type=="1" ? "LOGO链接" : "文字链接"}}</td>
                <td>@if($v->link_logo)<img src="{{env('ADMINLOGO_URL')}}{{$v->link_logo}}" width="45px" height="45px">
                    @endif
                </td>
                <td>{{$v->link_man}}</td>
                <td>{{$v->link_desc}}</td>
                <td>{{$v->link_show=="1" ? "√" : "×"}}</td>
                <td>
                    <a href="{{url('/link/edit/'.$v->link_id)}}" class="btn btn-primary">编辑</a>
                    <a id="{{$v->link_id}}" class="btn btn-danger">删除</a>
                </td>
			      </tr>
			      @endforeach
            <tr><td colspan="9">{{$link->appends($all)->links()}}</td></tr>
        </tbody>
    </table>
    
</div>  	
<script>
    //ajax删除
    $(document).on("click",".btn-danger",function(){
        var id=$(this).attr("id");
        if(confirm("是否确认删除？")){
            $.get("/link/destroy/"+id,function(result){
                if(result.code=='00000'){
                   location.reload();
                }
            },'json');
        }
    });

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