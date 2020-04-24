<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    //表名
    protected $table = 'orderaddress';
    //主键
    protected $primaryKey = 'id';
    //时间戳
    public $timestamps = false;
    //白名单  用create添加的时候加白名单
    protected $fillable = ['country','province','area','address_name','address_tel','order_id','user_id'];
}
