<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>微商城 @yield('title')</title>
    <link rel="shortcut icon" href="/static/index/images/favicon.ico" />
    
    <!-- Bootstrap -->
    <link href="/static/index/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/index/css/style.css" rel="stylesheet">
    <link href="/static/index/css/response.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond./static/index/js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="/static/index/js/jquery.min.js"></script>
  </head>
  <body>
    <div class="maincont">

    @yield('content')

    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/static/index/js/bootstrap.min.js"></script>
    <script src="/static/index/js/style.js"></script>
    @php $name=Route::currentRouteName();@endphp
    @if($name=='shop.index'||$name=='shop.proinfo')
    <!--焦点轮换-->
    <script src="/static/index/js/jquery.excoloSlider.js"></script>
    <script>
		$(function () {
		 $("#sliderA").excoloSlider();
		});
	</script>
  @endif
  @if($name=='shop.proinfo'||$name=='shop.cartlist')
  <!-- jq加减 -->
  <script src="/static/index/js/jquery.spinner.js"></script>
  <script>
    $('.spinnerExample').spinner({});
    @if($name=='shop.cartlist')
    @foreach($checkedbuynumber as $k=>$v)
        $("#buy_"+{{$k}}).val({{$v}});
    @endforeach
    @endif
	</script>
  @endif
  </body>
</html>
