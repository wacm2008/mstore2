<?php

namespace App\Http\Controllers\weixin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\WxUser;
use Illuminate\Support\Facades\Session;
use App\model\User;
class weixincontroller extends Controller
{
    public function code(){

        $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('APPID').'&redirect_uri='.urlEncode('http://them.mneddx.com/getcode').'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        header('refresh:0;url='.$url);
    }
    public function getcode(){

        //   echo '<pre>';print_r($_GET);echo '</pre>';

        // echo '<pre>';print_r($_GET);echo '</pre>';

        $code = $_GET['code'];

        //获取 access_token
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WX_APP_ID').'&secret='.env('SECRET').'&code='.$code.'&grant_type=authorization_code';
        $response = json_decode(file_get_contents($url),true);

        //echo '<pre>';print_r($response);echo '</pre>';
        $access_token = $response['access_token'];
        $openid = $response['openid'];
        //获取用户信息
        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
        $user_info = json_decode(file_get_contents($url),true);
        $openid=$user_info['openid'];

        //查询用户表中是否存在
        $res= User::where(['user_name'=>$user_info['nickname']])->first();
        // echo $res;exit;
        if($res){
            $uid = $res->user_id;
            //查询微信用户表有无
            $user = WxUser::where('uid',$uid)->first();
            if(!$user){
                $info=[
                    'openid'=>$user_info['openid'],
                    'nickname'=>$user_info['nickname'],
                    'sex'=>$user_info['sex'],
                    'uid'=>$uid,
                    'city'=>$user_info['city'],
                    'province'=>$user_info['province'],
                    'country'=>$user_info['country'],
                    'head'=>$user_info['headimgurl']
                ];
                $id = WxUser::insertGetId($info);
                $font = "欢迎登录".$user_info['nickname'];
            }else{
                $font = "欢迎回来".$res['nickname'];
            }
        }else{
            //添加用户表
            $info=[
                'openid'=>$user_info['openid'],
                'user_name'=>$user_info['nickname'],
            ];
            $uid = User::insertGetid($info);
            //添加到微信用户表
            $info1=[
                'openid'=>$user_info['openid'],
                'nickname'=>$user_info['nickname'],
                'sex'=>$user_info['sex'],
                'uid'=>$uid,
                'city'=>$user_info['city'],
                'province'=>$user_info['province'],
                'country'=>$user_info['country'],
                'head'=>$user_info['headimgurl']
            ];
            WxUser::insert($info1);
            $font = "欢迎登录".$user_info['nickname'];
        }
        Session::put(['user_id'=>$uid,'user_name'=>$user_info['nickname']]);
        echo "<script>alert(".$font.");</script>";
        header('refresh:1;url=/');
    }
}
