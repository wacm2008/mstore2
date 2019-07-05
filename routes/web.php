<?php

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
//首页
Route::get('/', 'home\HomeController@index');
//注册
Route::get('/register', 'user\UserController@register');
Route::post('/regdo', 'user\UserController@regdo');
//登录
Route::get('/login', 'user\UserController@login');
Route::post('/logindo', 'user\UserController@logindo');
//手机验证码
Route::post('/telCode', 'user\UserController@telCode');
//退出
Route::get('/logout', 'user\UserController@logout');
//商品详情
Route::get('/detil', 'Goods\GoodsdetialController@detial');
//加入购物车
Route::post('/cart', 'Goods\GoodsdetialController@cart');
//购物车列表
Route::get('/cartdet', 'Cart\CartController@cartdet')->middleware('checkLogin');
//删除
Route::post('/delete', 'Cart\CartController@delete');


//收藏列表
Route::get('/wish', 'Collection\CollectionController@colle_list')->middleware('checkLogin');
//点击收藏
Route::get('/getConlle/{id}', 'Collection\CollectionController@getConlle');

//联系我们
Route::get('/contact', 'contact\ContactController@contact')->middleware('checkLogin');
//接受数据
Route::post('/sendmail', 'contact\ContactController@sendmail');
//商品列表
Route::get('/product', 'goodslist\GoodsListController@goodslist');
//商品浏览排名
Route::get('/goodsRanking', 'Goods\GoodsdetialController@ranking')->middleware('checkLogin');
//结算
Route::get('/order', 'order\OrderController@order')->middleware('checkLogin');


//确认结算
Route::get('/orderdo', 'order\OrderController@orderdo')->middleware('checkLogin');
//订单页面
Route::get('/orhtml', 'order\OrderController@orhtml')->middleware('checkLogin');
//支付宝支付
Route::get('/alipay', 'order\OrderController@alipay')->middleware('checkLogin');
//支付宝支付成功回调
Route::get('/succuess', 'order\OrderController@succuess');
//支付宝支付成功异步回调
Route::post('/alipayNotify', 'order\OrderController@alipayNotify');
Route::get('/succuess', 'order\OrderController@succuess');
//支付宝支付成功异步回调
Route::post('/alipayNotify', 'order\OrderController@alipayNotify');
//ajax轮询改变支付状态
Route::get('/paystatus', 'order\OrderController@paystatus');
//微信支付成功回调
Route::post('/wxnotify', 'order\OrderController@wxnotify');
//获取url
Route::get('code', 'weixin\weixincontroller@code');
//获取code
Route::get('getcode', 'weixin\weixincontroller@getcode');