<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use App\Mail\SendCode;
use Illuminate\Support\Facades\Mail;
use App\Reg;

class LoginController extends Controller
{
    //登录
    public function login(){
        return view("index.login");
    }
    //执行登录
    public function loginDo(){
        $reg=request()->except("_token");
        $reg_name=Reg::where("reg_name",$reg["reg_name"])->first();
        //dd(decrypt($admin_name->admin_pwd));
        if(decrypt($reg_name->reg_pwd)!=$reg["reg_pwd"]){
              return redirect("/login")->with("msg","用户名或密码有误");
        }
        session(["reg_name"=>$reg_name]);
        if($reg['refer']){
            return redirect($reg["refer"]);
        }
        return redirect("/index/index");
    }
    //退出
    public function quit(){
        session(["reg_name"=>null]);
        return redirect("/index/index");
    }
    //注册
    public function reg(){
        return view("index.reg");
    }
    //手机号/邮箱注册
    public function regDo(){
        $sessionInfo=session("sessionInfo");
        $post=request()->all();
        //验证手机号/邮箱号
        if($post["reg_name"]==""){
            return redirect("/login/reg")->with("msg","手机号或邮箱号必填");exit;
        }else{
            $where=[
                ["reg_name","=",$post["reg_name"]]
            ];
            //查询条数
            $count=Reg::where($where)->count();
            //如果查询到的条数大于0，代表已被注册
            if($count>0){
                return redirect("/login/reg")->with("msg","手机号或邮箱号已被注册");exit;
            }else if($sessionInfo["send_name"]!=$post["reg_name"]){
                return redirect("/login/reg")->with("msg","发送验证的号与注册的号不一致");exit;
            }
        }
        //短信验证码
        if($post["reg_code"]==""){
            return redirect("/login/reg")->with("duan","验证码必填");exit;
        }else if($sessionInfo["send_code"]!=$post["reg_code"]){
            return redirect("/login/reg")->with("duan","验证码错误");exit;
        }else if(time()-$sessionInfo['send_time']>300){
            return redirect("/login/reg")->with("duan","验证码已失效");exit;
        }
        //密码
        $pwd='/^[0-9a-z]{6,18}$/i';
        if($post["reg_pwd"]==""){
            return redirect("/login/reg")->with("mi","密码必填");exit;
        }else if(!preg_match($pwd,$post["reg_pwd"])){
            return redirect("/login/reg")->with("mi","密码错误");exit;
        }
        //确认密码
        if($post["pwd"]!=$post["reg_pwd"]){
            return redirect("/login/reg")->with("qmi","确认密码必须与密码一致");exit;
        }
        // dd($post);
        $post=request()->except("_token","pwd");
        $post["reg_pwd"]=encrypt($post["reg_pwd"]);
        $res=Reg::insert($post);
        if($res){
            return redirect("/login/login")->with("zhu","注册成功，请登录");
        }else{
            return redirect("/login/reg")->with("zhu","注册失败，请重新注册");
        }
    }
    //手机号
    public function sendSms(Request $request){
        $mobile=request()->mobile;
        //php验证手机号
        $reg='/^1[356789]\d{9}$/';
        //dd(preg_match($reg,$mobile));
        if(!preg_match($reg,$mobile)){
            echo json_encode(['code'=>'00001','msg'=>'手机号格式有误']);exit;
        }
        //随机验证码
        $code=rand(100000,999999);
        //发送的手机号
        $res=$this->sendByMobile($mobile,$code);
        if($res['Message']=='OK'){
            // session(['code'=>$code]);
            $sessionInfo = ["send_name"=>$mobile,"send_code"=>$code,"send_time"=>time()];
            session(["sessionInfo"=>$sessionInfo]);
            request()->session()->save();
            echo json_encode(['code'=>'00000','msg'=>'发送成功']);exit;
        }
    }
    //邮箱
    public function sendEmail(Request $request){
        $email=request()->email;
        //php验证邮箱
        $reg='/^([a-zA-Z]|[0-9])(\w|\-)+@[a-zA-Z0-9]+\.([a-zA-Z]{2,4})$/';
        //dd(preg_match($reg,$email));
        if(!preg_match($reg,$email)){
            echo json_encode(['code'=>'00001','msg'=>'邮箱格式有误']);exit;
        }
        //随机验证码
        $code=rand(100000,999999);
        //发送的手机号
        $this->sendByEmail($email,$code);
        // session(['code'=>$code]);
        $sessionInfo = ["send_name"=>$email,"send_code"=>$code,"send_time"=>time()];
        session(["sessionInfo"=>$sessionInfo]);
        request()->session()->save();
        echo json_encode(['code'=>'00000','msg'=>'发送成功']);exit;
    }
    

    //测试
    public function test(){
        dd(session("code"));
    }

    //发送的手机号
    public function sendByMobile($mobile,$code){
        // Download：https://github.com/aliyun/openapi-sdk-php
        // Usage：https://github.com/aliyun/openapi-sdk-php/blob/master/README.md
        // 用户登录名称 zhang@1863081387909137.onaliyun.com
        // AccessKey ID LTAI4G649XGuFaUr3FDJ2ejQ
        // AccessKeySecret MlGvbB7hINkUMnu9NKfuCGWDq5vrvJ
        AlibabaCloud::accessKeyClient('LTAI4G649XGuFaUr3FDJ2ejQ', 'MlGvbB7hINkUMnu9NKfuCGWDq5vrvJ')
                                ->regionId('cn-hangzhou')
                                ->asDefaultClient();

        try {
            $result = AlibabaCloud::rpc()
                                ->product('Dysmsapi')
                                // ->scheme('https') // https | http
                                ->version('2017-05-25')
                                ->action('SendSms')
                                ->method('POST')
                                ->host('dysmsapi.aliyuncs.com')
                                ->options([
                                                'query' => [
                                                'RegionId' => "cn-hangzhou",
                                                'PhoneNumbers' => $mobile,
                                                'SignName' => "扶摇直上",
                                                'TemplateCode' => "SMS_183241780",
                                                'TemplateParam' => "{code:$code}",
                                                ],
                                            ])
                                ->request();
            return($result->toArray());
        } catch (ClientException $e) {
            return $e->getErrorMessage() . PHP_EOL;
        } catch (ServerException $e) {
            return $e->getErrorMessage() . PHP_EOL;
        }

    }
    //发送邮箱
    public function sendByEmail($email,$code){
        Mail::to($email)->send(new SendCode($code));
    }


}
