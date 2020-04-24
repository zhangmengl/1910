@extends('layouts.shop')
@section('title', '添加收货地址')
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
     @if(session('msg'))
          <div class="alert alert-danger">{{session("msg")}}</div>
     @endif
     <form action="{{url('/address/addressAdd')}}" method="post" class="reg-login">
     @csrf
      <div class="lrBox">
       <div class="lrList"><input type="text" name="address_name" placeholder="收货人" /></div>
       <div class="lrList"><input type="text" name="address_datail" placeholder="详细地址" /></div>
       <div class="lrList">
        <select class="area" name="country">
         <option value="">省份/直辖市</option>
         @foreach($areaInfo as $v)
         <option value="{{$v->id}}">{{$v->name}}</option>
         @endforeach
        </select>
       </div>
       <div class="lrList">
        <select class="area" name="province">
         <option>区县</option>
        </select>
       </div>
       <div class="lrList">
        <select class="area" name="area">
         <option>详细地址</option>
        </select>
       </div>
       <div class="lrList"><input type="text" name="address_tel" placeholder="手机" /></div>
       <div class="lrList2"><input type="text" name="is_default" placeholder="设为默认地址" /> <button>设为默认</button></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="submit" value="保存" />
      </div>
     </form><!--reg-login/-->
     
     @include('index.public.footer');
     <script>
      $(function(){
        $(document).on("change",".area",function(){
          // alert("123");
          var _this = $(this);
          var id = _this.val();
          // alert(id);
          $.get(
            "/address/getCity",
            {id:id},
            function(res){
              // alert(res);
              var _option = "<option value=''>请选择...</option>";
                        //for循环
                        for (var i in res) {
                            //将循环的值 展示option中 再赋值给空字符
                            _option += "<option value='" + res[i]['id'] + "'>" + res[i]['name'] + "</option>";
                        }
                        //将他赋给下一个兄弟
                        _this.parent().next("div").children().html(_option);
            },"json"
          );
        })
      })
     </script>
     @endsection

