<?php

namespace App\Http\Controllers\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\detial;
use App\Model\cartmodel;
use App\model\goods;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redis;
class GoodsdetialController extends Controller
{
    public function detial(Request $request){
        $session_name=Session::get('user_name');
        $data=cartmodel::where(['cart_status'=>1])->select()->paginate(6);
        $count=0;
        foreach ($data as $k => $v){
            $price=$v->buy_number*$v->goods_price;
            $count=$count+=$price;
        }
        $a=$data->count();

        $id=$request->input('goods_id');

       $data= detial::where(['goods_id'=>$id])->first();
      // var_dump($data);exit;
        //有序集合 浏览排名
       $redis_key='ss:goods_view';
       Redis::zIncrBy($redis_key,1,$id);
        return view('goods.detil',['data'=>$data,'session_name'=>$session_name,'a'=>$a]);
    }
    //商品浏览排名
    public function ranking()
    {
        $page=$_GET['p']??1;
        $start=($page-1)*3;
        $pagesize=2;
        $end=$start+$pagesize;
        $redis_key='ss:goods_view';
        //倒序
        $list2=Redis::zRevRange($redis_key,$start,$end,true);
        //print_r($list2);
        $llave=array_keys($list2);
        //print_r($llave);
        $parto=array_chunk($llave,3);
        //print_r($parto);
        $borra=array_shift($parto);
        //print_r($borra);
        $browse=[];
        foreach ($borra as $k=>$v){
            $browse[]=goods::where(['goods_id'=>$v])->first();
        }
        return view('ranking/ranking',['browse'=>$browse]);
    }
    public function cart(Request $request){
        $id=$request->input('id');
        $img=detial::where(['goods_id'=>$id])->first();
        $sel=cartmodel::where(['goods_id'=>$id])->first();
        if($sel){
            $buy_number=$sel->buy_number+1;
           $num=cartmodel::where(['goods_id'=>$id])->update(['buy_number'=>$buy_number]);
            if($num==1){
                $response=[
                    'status'=>0,
                    'msg'=>'加入购物车成功'
                ];
            }else{
                $response=[
                    'status'=>0,
                    'msg'=>'加入购物车成功'
                ];
            }
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
            $user_id=Session::get('user_id');
//            var_dump($user_id);die;
           $buy_number=1;
            $create_time=time();
            $data=[
                'user_id'=>$user_id,
                'goods_id'=>$id,
                'buy_number'=>$buy_number,
                'create_time'=>$create_time,
                'img'=>$img['goods_img'],
                'goods_name'=>$img['goods_name'],
                'goods_price'=>$img['goods_price']
            ];
            $res=cartmodel::insert($data);
            if($res==true){
                $response=[
                    'status'=>0,
                    'msg'=>'加入购物车成功'
                ];
            }else{
                $response=[
                    'status'=>0,
                    'msg'=>'加入购物车成功'
                ];
            }
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }

    }
}
