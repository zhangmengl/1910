<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderGoods extends Model
{
    //表名
    protected $table = 'ordergoods';
    //主键
    protected $primaryKey = 'id';
    //时间戳
    public $timestamps = false;
    //白名单  用create添加的时候加白名单
    protected $fillable = ['goods_id','goods_name','goods_img','goods_price','buy_number','order_id','user_id'];
}
