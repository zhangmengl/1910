<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    //表名
    protected $table = 'goods';
    //主键
    protected $primaryKey = 'goods_id';
    //时间戳
    public $timestamps = false;
    //黑名单  用create添加的时候加黑名单
    protected $guarded = [];


    //获取首页幻灯片数据
    public static function getIndexSlide(){
        return self::select("goods_id","goods_img")->where("is_slide",1)->take(5)->get();
    }
}
