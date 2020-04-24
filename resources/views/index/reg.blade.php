     @extends("layouts.shop")
     @section("title",'注册')
     @section('content')
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>会员注册</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/static/index/images/head.jpg" />
     </div><!--head-top/-->
     <form action="{{url('/login/regDo')}}" method="post" class="reg-login">
     @csrf
      <h3>已经有账号了？点此<a class="orange" href="{{url('/login/login')}}">登陆</a></h3>
      <h3><b style="color:red">{{session("zhu")}}</b></h3>
      <div class="lrBox">
       <div class="lrList"><input type="text" name="reg_name" placeholder="输入手机号码或者邮箱号" /></div><b style="color:red">{{session("msg")}}</b>
       <div class="lrList2"><input type="text" name="reg_code" placeholder="输入短信验证码" />
        <button type="button">获取验证码</button></div><b style="color:red">{{session("duan")}}</b>
       <div class="lrList"><input type="text" name="reg_pwd" placeholder="输入密码（6-18位数字或字母）"/></div><b style="color:red">{{session("mi")}}</b>
       <div class="lrList"><input type="text"  name="pwd" placeholder="确认密码" /></div><b style="color:red">{{session("qmi")}}</b>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="submit" value="立即注册" />
      </div>
     </form><!--reg-login/-->
     <script>
          //点击获取验证码 
          $(document).on("click","button",function(){
               var name=$("input[name='reg_name']").val();
               var reg=/^1[356789]\d{9}$/;
               if(name==""){
                    alert("手机号或邮箱不为空");
                    return;
               }
               
               //定时器
               //获取纯文本的值
               $("button").text("60s");
               _t=setInterval(timeLess,1000);
               
               //手机号
               if(reg.test(name)){
                    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                    $.post('/sendSms',{mobile:name},function(result){
                         alert(result.msg);
                    },'json');
                    return;
               }

               //邮箱           
               var emailreg = /^([a-zA-Z]|[0-9])(\w|\-)+@[a-zA-Z0-9]+\.([a-zA-Z]{2,4})$/;
               //alert(emailreg.test(name));
               if(emailreg.test(name)){
                    $.get('/sendEmail',{email:name},function(result){
                         alert(result.msg);
                    },'json');
               } 

               //定时器
               function timeLess(){
                    //获取秒数的值
                    var second=$("button").text();
                    second=parseInt(second);
                    if(second<=0){
                         //获取纯文本的值
                         $("button").text("获取");
                         //清除定时器
                         clearInterval(_t);
                         //按钮生效
                         $("button").css("pointer-events","auto");
                    }else{
                         //秒数减一
                         second=second-1;
                         //把减后的秒数放回去
                         $("button").text(second+"s");
                         //按钮失效
                         $("button").css("pointer-events","none");
                    }
               }

          });

     </script>
     @include("index.public.footer");
     @endsection
    