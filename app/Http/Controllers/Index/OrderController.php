<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //下单成功
    public function orderSuccess($id){
        echo "123";
        return view("index.success");
    }
}
