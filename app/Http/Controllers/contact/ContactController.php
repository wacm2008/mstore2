<?php

namespace App\Http\Controllers\contact;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Model\cartmodel;
class ContactController extends Controller
{
    public function contact()
    {
        $session_name=Session::get('user_name');

        $data=cartmodel::where(['cart_status'=>1])->select()->paginate(6);
        $a=$data->count();
        return view('contact.contact',['session_name'=>$session_name,'a'=>$a]);
    }
    //执行
    public  function  sendmail()
    {
        var_dump($_POST);
    }
}
