     @extends("layouts.shop")
     @section("title",'收货地址')
     @section('content')
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>收货地址</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/static/index/images/head.jpg" />
     </div><!--head-top/-->
     <table class="shoucangtab">
      <tr>
       <td width="75%"><a href="{{url('/address/addressDo')}}" class="hui"><strong class="">+</strong> 新增收货地址</a></td>
       <td width="25%" align="center" style="background:#fff url(/static/index/imagesxian.jpg) left center no-repeat;"><a href="javascript:;" class="orange">删除信息</a></td>
      </tr>
     </table>
     
     @foreach ($addressInfo as $v)
     @php
                if($v["is_default"]==1){
                    $d = "border:1px solid red;";
                }else{
                    $d="";
                }
            
     @endphp
     <div class="dingdanlist" onClick="window.location.href='proinfo.html'" style="{{$d}}">
      <table>
       <tr>
        <td width="50%">
         <h3>{{$v->address_name}}&nbsp;{{$v->address_tel}}</h3>
         <time>{{$v->country}}{{$v->province}}{{$v->area}}{{$v->datail}}</time>
        </td>
        <td align="right"><a href="" class="hui"><span class="glyphicon glyphicon-check"></span> 修改信息</a></td>
       </tr>
      </table>
     </div><!--dingdanlist/-->
       @endforeach
     @include("index.public.footer");
     @endsection