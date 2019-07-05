<?php

namespace App\Http\Controllers\order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\cartmodel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\order\WXBizDataCryptController;
class OrderController extends Controller
{
    //全局变量   微信支付
    public $values = [];
    public  $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder'; //统一下单接口
    public  $notify_url = 'http://them.mneddx.com/wxnotify'; //支付成功回调


    public function order()
    {
        $session_name=Session::get('user_name');

        $data=cartmodel::where(['cart_status'=>1])->select()->paginate(6);
        $count=0;
        foreach ($data as $k => $v){
            $price= $v-> buy_number * $v ->goods_price;
            $count= $count += $price;
        }
        $a=$data->count();
        $goodsinfo = DB::table('shop_cart')->where(['user_id'=>Session::get('user_id')])->get();
       return view('order.order',['goodsinfo'=>$goodsinfo,'session_name'=>$session_name,'a'=>$a]);
    }
    //确认结算
    public function orderdo()
    {
       if(empty($_GET['goods_id']))
       {
           $response = [
               'errno '=> 'no',
               'msg '=> '商品不存在'
           ];
           die(json_encode($response,JSON_UNESCAPED_UNICODE));
       }
        $goods_id = explode(',',$_GET['goods_id']);
        $shopInfo = cartmodel::where(['user_id'=>Session::get('user_id')])->get();
        $countprice = 0;
        foreach ($shopInfo as $k=>$v)
        {
            $countprice = $countprice + $v-> goods_price * $v-> buy_number;
        }
        //存入订单表
        $orderInfo['order_amount'] = $countprice;
        $orderInfo['order_no'] = $this-> str();
        $orderInfo['pay_type'] = 1; //1 支付宝
        $orderInfo['user_id'] =Session::get('user_id');
        $orderInfo['create_time']= time();
        $res1 = DB::table('shop_order')->insert($orderInfo);
        if(!$res1){
            $response = [
                'errno'=> 'no',
                'msg' => '订单生成失败'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        $order_id = DB::getPdo()->lastInsertId($res1);
//        var_dump($order_id);die;
        $res2 = DB::table('shop_cart')->whereIn('goods_id',$goods_id)->where(['user_id'=>Session::get('user_id')])->get();
        $goodsInfo = json_decode($res2,true);
        foreach ($goodsInfo as $k=> $v)
        {
            $goodsInfo[$k]['order_id'] =$order_id;
            $goodsInfo[$k]['user_id'] = Session::get('user_id');
            $goodsInfo[$k]['create_time'] =time();
            $goodsInfo[$k]['update_time'] =time();
            $goodsInfo[$k]['goods_img'] = $v['img'];
            unset($goodsInfo[$k]['cart_id']);
            unset($goodsInfo[$k]['buy_number']);
            unset($goodsInfo[$k]['save_status']);
            unset($goodsInfo[$k]['cart_status']);
            unset($goodsInfo[$k]['cart_id']);
            unset($goodsInfo[$k]['img']);
        }
        $shop_dateil = DB::table('shop_detail')->insert($goodsInfo);
        if(!$shop_dateil){
            $response = [
                'errno'=> 'no',
                'msg' => '订单详情生成失败'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        //清空购物车
        $res3 = DB::table('shop_cart')->where(['user_id'=>Session::get('user_id')])->delete();
        if(!$res3){
            $response = [
                'errno'=> 'no',
                'msg' => '清空购物车失败'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        $response = [
            'errno'=> 'ok',
            'oreder_id'=> $order_id
        ];
        die(json_encode($response,JSON_UNESCAPED_UNICODE));
    }
    //订单号
    public function str()
    {
        $str = substr(sha1(time() . Str::random(10).'PIKAI_'."_"), 5, 15);
        return $str;
    }
    //订单页面
    public  function orhtml()
    {
        $session_name=Session::get('user_name');
        $data=cartmodel::where(['cart_status'=>1])->select()->paginate(6);
        $count=0;
        foreach ($data as $k => $v){
            $price=$v->buy_number*$v->goods_price;
            $count=$count+=$price;
        }
        $a=$data->count();
        if(empty($_GET['order_id'])){
            $response = [
                'errno'=> 'no',
                'msg'=> '空'
            ];
        }
        $order_no = DB::table('shop_order')->where(['order_id'=> $_GET['order_id']])->first();
        $order_nos = $order_no-> order_no;
        return view('order.orhtml',['order_nos'=> $order_nos,'session_name'=>$session_name,'a'=>$a]);
    }
    //支付
    public function alipay()
    {
        if(empty($_GET)){
            $response = [
                'errno'=> 'no',
                'msg'=> '订单不存在'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        $res = DB::table('shop_order')->where(['order_no'=>$_GET['oid']])->first();
        if(!$res){
            $response = [
                'errno'=> 'no',
                'msg'=> '订单不存在'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        if($_GET['paytype'] =='1'){
            //支付宝支付
             $this-> getalipay($_GET['oid']);

        }else if($_GET['paytype'] =='2'){
             $data = $this-> getWexinpay($_GET['oid']);
             return view('weixin.test',$data);
        }
    }
    //支付宝支付
    public function getalipay($oid)
    {
//        echo "<pre>";print_r($_SERVER);echo "<pre>";die;
        $str2 = json_encode($_SERVER['HTTP_USER_AGENT']);
        $str = 'Windows';
       if(strpos($str2,$str) != false){
          //扫码支付
            $method = 'alipay.trade.page.pay';
            $prouct_code = 'FAST_INSTANT_TRADE_PAY';
            $url = 'https://openapi.alipaydev.com/gateway.do';
       }else{
           //h5支付
            $method = 'alipay.trade.wap.pay';
            $prouct_code = 'QUICK_WAP_WAY';
            $url = 'https://openapi.alipaydev.com/gateway.do';
       }
        $res = DB::table('shop_order')->where(['order_no'=>$_GET['oid']])->first();
        //业务参数
        $bizcont = [
            'subject' => '月七',//交易标题/订单标题/订单关键
            'out_trade_no'=>$oid, //订单号
            'total_amount'      => $res->order_amount / 100, //支付金额
            'product_code'      => $prouct_code //固定值
        ];

        //公共参数
        $data = [
            'app_id'   => '2016092700608889',
            'method'   => $method,
            'format'   => 'JSON',
            'charset'   => 'utf-8',
            'sign_type'   => 'RSA2',
            'timestamp'   => date('Y-m-d H:i:s'),
            'version'   => '1.0',
            'notify_url'   => 'http://them.mneddx.com/alipayNotify',       //异步通知地址
            'return_url'   => 'http://vm.them.com/succuess',      // 同步通知地址
            'biz_content'   => json_encode($bizcont),
        ];
        //拼接参数
        ksort($data);//根据键以升序对关联数组进行排序
        $i = "";
        foreach ($data as $k=>$v)
        {
            $i.=$k.'='.$v.'&';
        }
        $trim  = rtrim($i,'&');
//        var_dump($trim);die;
        //生成签名 最后拼接为url 格式
        $rsaPrivateKeyFilePath = openssl_get_privatekey('file://'.storage_path('app/keys/private.pem')); //密钥
//           var_dump($rsaPrivateKeyFilePath);
//            $a = openssl_error_string();
//            var_dump($a);die;
        //生成签名
        openssl_sign($trim,$sign,$rsaPrivateKeyFilePath,OPENSSL_ALGO_SHA256);
        $sign = base64_encode($sign);
        $data['sign']=$sign;
        //拼接url
        $a='?';
        foreach($data as $key=>$val){
            $a.=$key.'='.urlencode($val).'&'; //urlencode 将字符串以url形式编码
        }
        $trim2 = rtrim($a,'&');
//        var_dump($trim2);die;
        $url2 = $url.$trim2;
        header('refresh:2;url='.$url2);

    }
    //支付成功回调
    public function  succuess()
    {
        echo '支付成功：三秒后跳至首页';
        header('refresh:2;url=http://them.mneddx.com/');
    }
    //异步回调
    public function  alipayNotify()
    {
        $p = json_encode($_POST);
        $data=json_decode($p,true);
        $log_str = "\n>>>>>> " .date('Y-m-d H:i:s') . ' '.$p . " \n";
        is_dir('logs') or mkdir('logs', 0777, true);
        file_put_contents('logs/alipay_notify',$log_str,FILE_APPEND);
        echo 'success';
        //TODO 验签 更新订单状态
        $pay_time = strtotime($data['gmt_payment']);
        DB::table('shop_order')->where(['order_no'=>$data['out_trade_no']])->update(['pay_time'=> $pay_time,'pay_status'=>2]);

    }

    //微信支付
    public function  getWexinpay($oid)
    {
        $info = DB::table('shop_order')->where(['order_no'=>$oid])->first();
        if(empty($info)){
            header('Refresh:3;url=orderlist');
            echo "订单不存在，3秒将跳转至订单页";
        }
        //组合参数
        $total_fee = 1; //用户要支付的金额  1分
        //必填参数
        $order_info =[
            'appid' => 'wxd5af665b240b75d4', //公众帐号id
            'mch_id' => '1500086022', //商户id
            'nonce_str'=> Str::random(16), //随机的字符串
            'sign_type' => 'MD5', //签名类型
            'body' => '测试微信支付-'.mt_rand(1111,9999).Str::random(6), //商品简单描述，
            'out_trade_no' => $oid, //订单
            'total_fee' => $total_fee,//订单总金额
            'spbill_create_ip' => $_SERVER['REMOTE_ADDR'], //客户端ip
            'notify_url' => $this-> notify_url, //通知回调地址
            'trade_type' => 'NATIVE' // 交易类型
        ];
         $this-> values = $order_info;
        //生成签名
        $this ->Setsign();
        $xml = $this-> Toxml(); //将数组转化为xml格式
        //发送请求
        $res =$this ->postXmlCurl($xml,$this->url,$useCert = false, $second = 30 );

        $data =  simplexml_load_string($res);
        echo 'return_code: '.$data->return_code;echo '<br>';
        echo 'return_msg: '.$data->return_msg;echo '<br>';
        echo 'appid: '.$data->appid;echo '<br>';
        echo 'mch_id: '.$data->mch_id;echo '<br>';
        echo 'nonce_str: '.$data->nonce_str;echo '<br>';
        echo 'sign: '.$data->sign;echo '<br>';
        echo 'result_code: '.$data->result_code;echo '<br>';
        echo 'prepay_id: '.$data->prepay_id;echo '<br>';
        echo 'trade_type: '.$data->trade_type;echo '<br>';
        echo 'code_url: '.$data->code_url;echo '<br>';
        $data = [
            'code_url'  => $data->code_url,
            'oid' => $oid
        ];
        return $data;
    }
    public function  Setsign()
    {
        $sign = $this ->MakeSign();
        $this ->values['sign'] = $sign;
        return $sign;
    }
    //签名
    public function MakeSign()
    {
        //签名步骤一：按字典序排序参数
        ksort($this-> values);
        $string = $this -> ToUrlParams();
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=".'7c4a8d09ca3762af61e59520943AB26Q';
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }
    public  function  ToUrlParams()
    {
        $buff = "";
        foreach($this-> values as $k=>$v)
        {
            //把组成参数拼接上
            if($k != 'sign' && $v != "" && !is_array($v)){
                $buff .= $k. "=" . $v . "&";
            }
        }
        $buff = trim($buff,'&');
        return $buff;
    }
    //xml
    protected function Toxml()
    {
        if(!is_array($this->values) || count($this->values) <= 0)
        {
            die("数组数据异常！");
        }
        $xml = "<xml>";
        foreach ($this-> values as $key=>$val)
        {
            // var_dump($val);echo "<hr>";
            //检测变量是否是数字 字符串
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }
    //curl
    private  function postXmlCurl($xml, $url, $useCert = false, $second = 30)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            die("curl出错，错误码:$error");
        }
    }

    //支付成功改变订单状态
    public function paystatus()
    {
        $oid = $_GET['oid'];
        $info = DB::table('shop_order')->where(['order_no'=>$oid])->first();
        $response = [];
        if($info){
            if($info->pay_time>0){      //已支付
                $response = [
                    'status'    => 0,       // 0 已支付
                    'msg'       => 'ok'
                ];
            }
            //echo '<pre>';print_r($info->toArray());echo '</pre>';
        }else{
            die("订单不存在");
        }
        die(json_encode($response));
        // echo $o_id;
    }

    //微信支付成功回调
    public function wxnotify()
    {
        $data = file_get_contents('php://input');
        //记录日志
        $log_str = date('Y-m-d H:i:s') . "\n" . $data . "\n<<<<<<<";
        is_dir('logs') or mkdir('logs', 0777, true);
        file_put_contents('logs/wx_pay_notice.log',$log_str,FILE_APPEND);
        $xml = simplexml_load_string($data);

//        $pay_time = strtotime($xml->time_end);
        //支付成功
        DB::table('shop_order')->where(['order_no'=>$xml->out_trade_no])->update(['pay_amount'=>$xml->cash_fee,'pay_time'=>time()]);
        $response = '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
        echo $response;
    }
}


