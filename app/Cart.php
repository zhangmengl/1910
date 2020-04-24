<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //表名
    protected $table = 'cart';
    //主键
    protected $primaryKey = 'cart_id';
    //时间戳
    public $timestamps = false;
    //黑名单  用create添加的时候加黑名单
    protected $guarded = [];
}
