<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// //闭包路由
// Route::get('/index',function(){
//     echo "这是一个闭包路由";
// });
// //Route::view('/index','index',['name'=>'呆头呆脑']);
// Route::get('/index','IndexController@index');
// Route::post('/add','IndexController@add');
// //必选参数
// Route::get('/goods/{id}',function($id){
//     echo "$id";
// });
// Route::get('/goods/{id}','IndexController@goods')->where('id','\d+');
// //可选参数
// Route::get('/show/{id?}/{name?}',function($id=0,$name=0){
//     echo "$id<br>"."$name";
// });
// Route::get('/show/{id?}/{name?}','IndexController@show')->where(['id'=>'\w*','name'=>'\w*']);
// //混合参数
// Route::get('/good/{id}/{name?}',function($id,$name=0){
//     echo "$id<br>"."$name";
// });
// Route::get('/good/{id}/{name?}','IndexController@good')->where(['id'=>'\d+','name'=>'\w?']);//? 0-1   + 1-多   * 0-多

//后台路由
Route::domain('admin.1910.com')->group(function (){
    //品牌
    Route::prefix('/brand')->middleware("auth")->group(function () {
        Route::get("create","admin\BrandController@create");
        Route::post("store","admin\BrandController@store");
        //Route::get("index","admin\BrandController@index");
        //Route::match(["get","post"],"index","admin\BrandController@index");
        Route::any("index","admin\BrandController@index");
        Route::get("edit/{id}","admin\BrandController@edit");
        Route::post("update/{id}","admin\BrandController@update");
        Route::get("destroy/{id}","admin\BrandController@destroy");
    });
    //分类
    Route::prefix('/cate')->middleware("auth")->group(function () {
        Route::get("create","admin\CateController@create");
        Route::post("store","admin\CateController@store");
        Route::get("index","admin\CateController@index");
        Route::get("edit/{id}","admin\CateController@edit");
        Route::post("update/{id}","admin\CateController@update");
        Route::get("destroy/{id}","admin\CateController@destroy");
    });
    //商品
    Route::prefix('/goods')->middleware("auth")->group(function () {
        Route::get("create","admin\GoodsController@create");
        Route::post("store","admin\GoodsController@store");
        Route::any("index","admin\GoodsController@index");
        Route::get("edit/{id}","admin\GoodsController@edit");
        Route::post("update/{id}","admin\GoodsController@update");
        Route::get("destroy/{id}","admin\GoodsController@destroy");
    });
    //管理员
    Route::prefix('/admin')->middleware("auth")->group(function () {
        Route::get("create","admin\AdminController@create");
        Route::post("store","admin\AdminController@store");
        Route::get("index","admin\AdminController@index");
        Route::get("edit/{id}","admin\AdminController@edit");
        Route::post("update/{id}","admin\AdminController@update");
        Route::get("destroy/{id}","admin\AdminController@destroy");
    });
    //友情链接管理
    Route::prefix('/link')->middleware("auth")->group(function () {
        Route::get("create","admin\LinkController@create");
        Route::post("store","admin\LinkController@store");
        Route::any("index","admin\LinkController@index");
        Route::get("edit/{id}","admin\LinkController@edit");
        Route::post("update/{id}","admin\LinkController@update");
        Route::get("destroy/{id}","admin\LinkController@destroy");
    });
    //后台登录
    // Route::view("/login","admin.login");
    // Route::post("/login/loginDo","admin\LoginController@loginDo");
    //cookie
    Route::get("/setcookie","IndexController@setcookie");//设置cookie
    Route::get("/getcookie","IndexController@getcookie");//获取cookie

    Auth::routes();
    Route::get('/home', 'HomeController@index')->name('home');
});

//前台路由
Route::domain('www.1910.com')->group(function (){
    //前台  
    Route::prefix('/index')->group(function () {
        Route:: get('index','Index\IndexController@index')->name('shop.index');
        Route:: get('prolist','Index\IndexController@prolist');
        Route:: get('getProlist','Index\IndexController@getProlist');
        Route:: get('proinfo/{id}','Index\IndexController@proinfo')->name('shop.proinfo');
        Route:: get('addcar','Index\IndexController@addcar');
        Route:: get('carlist','Index\IndexController@carlist')->name('shop.cartlist');
        Route:: get('changeNumber','Index\IndexController@changeNumber');
        Route:: get('getTotal','Index\IndexController@getTotal');
        Route:: get('jiesuan/{goods_id}','Index\IndexController@jiesuan');
        Route:: get('getMoney/{id}','Index\IndexController@getMoney');
        Route:: get('pay','Index\IndexController@pay');
    });
    //购物车  
    Route::prefix('/address')->group(function () {
        Route:: get('jiesuan/{goods_id}','Index\AddressController@jiesuan');
        Route:: get('address','Index\AddressController@address');
        Route:: get('addressDo','Index\AddressController@addressDo');
        Route:: get('getAddress','Index\AddressController@getAddress');
        Route:: get('getCity','Index\AddressController@getCity');
        Route:: post('addressAdd','Index\AddressController@addressAdd');
        Route:: get('success','Index\AddressController@success');
        Route:: get('orderPay','Index\AddressController@orderPay');
    });
    //支付 
    Route::prefix('/order')->group(function () {
        Route:: get('orderSuccess/{id}','Index\OrderController@orderSuccess');
    });
    //登录
    Route::prefix('/login')->group(function () {
        Route:: get('login','Index\LoginController@login');
        Route:: get('reg','Index\LoginController@reg');
        Route:: post('regDo','Index\LoginController@regDo');
        Route:: post('loginDo','Index\LoginController@loginDo');
        Route:: get('quit','Index\LoginController@quit');
    });
    //手机号发送验证码
    Route:: post('/sendSms','Index\LoginController@sendSms');
    //邮箱验证码
    Route:: get('/sendEmail','Index\LoginController@sendEmail');
    Route:: get('/test','Index\LoginController@test');
});    