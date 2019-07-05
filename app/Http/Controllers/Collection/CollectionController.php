<?php

namespace App\Http\Controllers\Collection;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\goods;
use Illuminate\Support\Facades\Session;
use App\model\Praise;
use App\Model\cartmodel;
class CollectionController extends Controller
{
    //收藏列表
    public function colle_list()
    {
        $uid = Session::get('user_id');
        $session_name=Session('user_name');
        if($uid==''){
            echo "<script>alert('请先登录')</script>";
            header('refresh:1;url=/login');
            die;
        }
        $arr = Praise::where('admin_id',$uid)->get();
        if($arr){
            $info = [];
            foreach($arr as $k=>$v){
                $info[]=goods::where('goods_id',$v->essay_id)->first()->toArray();
            }

            $data=cartmodel::where(['cart_status'=>1])->select()->paginate(6);
            $a=$data->count();

//            print_r($info);
            return view('collection.collelist',['err'=>1,'msg'=>$info,'a'=>$a,'session_name'=>$session_name]);
        }else{
            $arr1 = [
                'err'=>2,
                'msg'=>'暂无收藏商品!'
            ];
            return view('collection.collelist',$arr1);
        }

    }
    //点击收藏
    public function getConlle($id)
    {
        $uid = session('user_id');
        if($uid==''){
            $arr = [
                'err'=>3,
                'msg'=>"请先登录！"
            ];
            echo json_encode($arr);die;
        }
        $res = Praise::where(['admin_id'=>$uid,'essay_id'=>$id])->first();
        if(!$res){
            $r = Praise::insert(['admin_id'=>$uid,'essay_id'=>$id]);
            if($r){
                $arr = [
                    'err'=>1,
                    'msg'=>"收藏成功，可在收藏列表查看！"
                ];
            }
        }else{
            $arr = [
                'err'=>2,
                'msg'=>"已经收藏过了，可在收藏列表查看！"
            ];
        }
        echo json_encode($arr);
    }
}
