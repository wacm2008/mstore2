<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreRegisterPost;
use App\Http\Requests\StoreLoginPost;
use App\Model\cartmodel;
use Mail;
use Illuminate\Support\Str;
class UserController extends Controller
{
    //注册首页
    public function register()
    {
        $session_name=Session::get('user_name');
        $data=cartmodel::where(['cart_status'=>1])->select()->paginate(6);
        $a=$data->count();
        return view('user/register',['session_name'=>$session_name,'a'=>$a]);
    }
    //注册执行
    public function regdo(Request $request)
    {
        $user_name=$request->input('user_name');
        $user_email=$request->input('user_email');
        $user_pwd=$request->input('user_pwd');
        $user_tel=$request->input('user_tel');
        $tel_code=$request->input('tel_code');
        $reg='/^1[3,4,5,7,8]\d{9}$/';
        $info=User::where(['user_name'=>$user_name])->first();
        if($user_name==''){
            echo json_encode(['msg'=>'用户名不为空哦','code'=>2]);die;
        }
        if($info){
            echo json_encode(['msg'=>'用户名不能重复哦','code'=>2]);die;
        }
        if($user_email==''){
            echo json_encode(['msg'=>'邮箱不为空哦','code'=>2]);die;
        }
        if($user_tel==''){
            echo json_encode(['msg'=>'手机号不为空哦','code'=>2]);die;
        }else if(!preg_match($reg,$user_tel)){
            echo json_encode(['msg'=>'输入正确格式的手机号哦','code'=>2]);die;
        }else if($user_tel==$info['user_tel']){
            echo json_encode(['msg'=>'手机号已被注册哦','code'=>2]);die;
        }
        if($tel_code==''){
            echo json_encode(['msg'=>'验证码不为空哦','code'=>2]);die;
        }else if(Session::get('rand')!=$tel_code){
            echo json_encode(['msg'=>'验证码不正确哦','code'=>2]);die;
        }else if(time()-Session::get('timeout')>300){
            echo json_encode(['msg'=>'验证码过期了哦','code'=>2]);die;
        }
        if($user_pwd==''){
            echo json_encode(['msg'=>'密码不为空哦','code'=>2]);die;
        }
        $p=password_hash($user_pwd,PASSWORD_DEFAULT);
        $data=[
            'user_name'=>$user_name,
            'user_email'=>$user_email,
            'user_pwd'=>$p,
            'user_tel'=>$user_tel,
            'create_time'=>time(),
        ];
        $res=User::insert($data);
        if($res){
            echo json_encode(['msg'=>'注册成功','code'=>1]);
        }else{
            echo json_encode(['msg'=>'注册失败哦','code'=>2]);die;
        }
    }
    //登录首页
    public function login()
    {
        $session_name=Session::get('user_name');
        $data=cartmodel::where(['cart_status'=>1])->select()->paginate(6);
        $a=$data->count();
        return view('user/login',['session_name'=>$session_name,'a'=>$a]);
    }
    //登录执行
    public function logindo(Request $request)
    {
        $user_name=$request->input('user_name');
        $user_pwd=$request->input('user_pwd');
        //DB::connection()->enableQueryLog();
        $userInfo=User::where(['user_name'=>$user_name])->orWhere(['user_tel'=>$user_name])->first();
        //var_dump(DB::getQueryLog());
        if($user_name==''){
            echo json_encode(['msg'=>'用户名或手机号不为空哦','code'=>2]);die;
        }
        if($user_pwd==''){
            echo json_encode(['msg'=>'密码不为空哦','code'=>2]);die;
        }
        if($userInfo){
            if(password_verify($user_pwd,$userInfo->user_pwd)){
                //设置session
                $user_id=$userInfo->user_id;
                Session::put(['user_id'=>$user_id,'user_name'=>$userInfo['user_name']]);
//                var_dump(Session::all());
//                echo Session::getId();
//                $request->session()->flush();
                echo json_encode(['msg'=>'登录成功','code'=>1]);
            }else{
                echo json_encode(['msg'=>'密码不对哦','code'=>2]);die;
            }
        }else{
            echo json_encode(['msg'=>'用户名或密码不对哦','code'=>2],JSON_UNESCAPED_UNICODE);die;
        }
    }
    //手机验证码
    public function telCode(Request $request)
    {
        $user_tel=$request->input('user_tel');
        $info=User::where(['user_tel'=>$user_tel])->first();
        if($user_tel==''){
            echo json_encode(['msg'=>'手机号不为空哦','code'=>2]);die;
        }
        if($info){
            echo json_encode(['msg'=>'手机号已注册哦','code'=>2]);die;
        }
        $rand=rand(100000,999999);
        $sendTel=$this->sendTel($user_tel,$rand);
        if($sendTel==00000){
            Session::put(['rand'=>$rand,'tel'=>$user_tel,'timeout'=>time()+300]);
            echo json_encode(['msg'=>'已发送请查收哦','code'=>1]);
        }else{
            echo json_encode(['msg'=>'发送失败','code'=>2]);die;
        }
    }
    //发送短信
    public function sendTel($user_tel,$rand){
        $host = "http://dingxin.market.alicloudapi.com";
        $path = "/dx/sendSms";
        $method = "POST";
        $appcode = "81f4c93dd39c45ada67a72f93e01a57e";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);

        $querys = "mobile=".$user_tel."&param=code%3A".$rand."&tpl_id=TP1711063";
        $bodys = "";
        $url = $host . $path . "?" . $querys;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);//CURLOPT_HEADER设置为True，可以获取响应的头信息
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        $curl=json_decode(curl_exec($curl),true);
        //print_r($curl);
        //Array ( [return_code] => 00000 [order_id] => ALY1558954887375032864 )
        return $curl['return_code'];
    }
    //退出
    public function logout(Request $request)
    {
        $request->session()->forget(['user_id','user_name']);
        $s=Session::get('user_name');
        $s1=Session::get('user_id');
        if(!$s&&!$s1){
            return redirect()->to("/");
        }
    }
}
