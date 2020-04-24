<?php

/**
 * 公用的方法  返回json数据，进行信息的提示
 * @param $status 状态
 * @param string $message 提示信息
 * @param array $data 返回数据
 */
    //无限极分类
    function getCateInfo($cateInfo,$pid=0,$level=0){
        if(!$cateInfo){
            return;
        }
        static $cate=[];
        foreach($cateInfo as $k=>$v){
            if($v->pid==$pid){
                $v->level=$level;
                $cate[]=$v;
                getCateInfo($cateInfo,$v->cate_id,$level+1);
            }
        }
        return $cate;
    }
    //文件上传  --后台
    function upload($filename){
        //接收文件
        $file=request()->$filename;
        //判断文件在上传过程中是否出错
        if($file->isValid()){
            //接收并上传文件
            $path = $file->store('adminLogo');
            return $path;
        }
        exit("未获取到上传文件或上传过程出错");
    }    
    //多文件上传  后台
    function MoreUpload($filename){
        //接收文件
        $file=request()->$filename;
        //循环接收的文件
        foreach($file as $k=>$v){
            //判断文件在上传过程中是否出错
            if($v->isValid()){
                //接收并上传文件
                $path[$k] = $v->store('adminLogo');
            }else{
                $path[$k] = "未获取到上传文件或上传过程出错";
            }
        }
        return $path;
    }
    //错误提示
    function showMsg($code,$msg){
        $data=[
            'code'=>$code,
            'msg'=>$msg
        ];
        echo json_encode($data);die;
    }

