<?php

namespace App\Http\Controllers\goodslist;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\goods;
use Illuminate\Support\Facades\Session;
use App\Model\cartmodel;
class GoodsListController extends Controller
{
    public function goodslist()
    {
        $session_name=Session::get('user_name');
        $data=cartmodel::where(['cart_status'=>1])->select()->paginate(6);
        $count=0;
        foreach ($data as $k => $v){
            $price=$v->buy_number*$v->goods_price;
            $count=$count+=$price;
        }
        $a=$data->count();

        if(empty($_GET['val'])){
            $goodsinfo = goods::where(['goods_new'=>1])->paginate(6);
        }else if($_GET['val'] =='1'){
            $goodsinfo = goods::where(['goods_new'=>1])->paginate(6);
            return view('goodslist.div',['goodsinfo'=>$goodsinfo]);
        }else if($_GET['val'] =='2'){
            $goodsinfo = goods::where(['goods_hot'=>1])->paginate(6);
            return view('goodslist.div',['goodsinfo'=>$goodsinfo]);
        }else if($_GET['val'] =='3'){
            $goodsinfo = goods::where(['goods_best'=>1])->paginate(6);
            return view('goodslist.div',['goodsinfo'=>$goodsinfo]);
        }
        return view('goodslist.goodslist',['goodsinfo'=>$goodsinfo,'session_name'=>$session_name,'a'=>$a]);
    }
}
