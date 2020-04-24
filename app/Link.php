<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class link extends Model
{
    //表名
    protected $table = 'link';
    //主键
    protected $primaryKey = 'link_id';
    //时间戳
    public $timestamps = false;
    //黑名单  用create添加的时候加黑名单
    protected $guarded = [];
}
