@extends('layouts.shop')
@section('title', '1809 电商 ')
@section('content')
<!-- side nav right-->
<div class="side-nav-panel-right">
    <ul id="slide-out-right" class="side-nav side-nav-panel collapsible">

        @if($session_name==null)
            <li class="profil">
                <img src="img/profile.jpg" alt="">
                <h2>John Doe</h2>
            </li>
            <li><a href="/contact"><i class="fa fa-user"></i>About Us</a></li>
            {{--<li><a href="/contact"><i class="fa fa-envelope-o"></i>Contact Us</a></li>--}}
            <li><a href="/login"><i class="fa fa-sign-in"></i>Login</a></li>
            <li><a href="/register"><i class="fa fa-user-plus"></i>Register</a></li>
        @else
            <li class="profil">
                <img src="img/下载.jpg" alt="">
                <h2>欢迎<font color="red">{{$session_name}}</font>登录</h2>
            </li>
            <li><a href="/contact"><i class="fa fa-user"></i>About Us</a></li>
            <li><a href="/logout"><i class="fa fa-sign-out"></i>Logout</a></li>
        @endif
    </ul>
</div>
<!-- end side nav right-->

<!-- navbar bottom -->
<div class="navbar-bottom">
    <div class="row">
        <div class="col s2">
            <a href="/"><i class="fa fa-home"></i></a>
        </div>
        <div class="col s2">
            <a href="/wish"><i class="fa fa-heart"></i></a>
        </div>
        <div class="col s4">
            <div class="bar-center">
                <a href="/cartdet"><i class="fa fa-shopping-basket"></i></a>
                <span>{{$a}}</span>
            </div>
        </div>
        <div class="col s2">
            <a href="/contact"><i class="fa fa-envelope-o"></i></a>
        </div>
        <div class="col s2">
            <a href="#animatedModal2" id="nav-menu"><i class="fa fa-bars"></i></a>
        </div>
    </div>
</div>
<!-- end navbar bottom -->




<!-- register -->
<div class="pages section">
    <div class="container">
        <div class="pages-head">
            <h3>REGISTER</h3>
        </div>
        <div class="register">
            <div class="row">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="col s12">
                    <div class="input-field">
                        <input type="text" class="validate" placeholder="NAME" name="user_name" id="user_name" required>
                    </div>
                    <div class="input-field">
                        <input type="email" placeholder="EMAIL" class="validate" name="user_email" id="user_email" required>
                    </div>
                    <div class="input-field">
                        <input type="tel" placeholder="TEL" class="validate" name="user_tel" id="user_tel" required>
                    </div>
                    <div class="input-field">
                        <input type="text" placeholder="CODE" class="validate" name="tel_code" id="tel_code" required>
                        <div class="btn button-default" id="send_tel">CODE</div>
                    </div>
                    <div class="input-field">
                        <input type="password" placeholder="PASSWORD" class="validate" name="user_pwd" id="user_pwd" required>
                    </div>
                    <div class="btn button-default" id="butt">REGISTER</div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end register -->
@endsection



<!-- scripts -->
<script src="js/jquery.min.js"></script>


</body>
</html>
<script>
    $(function () {
        $('#send_tel').click(function () {
            var user_tel=$('#user_tel').val();
            var reg=/^1[3,4,5,7,8]\d{9}$/;
           if(user_tel==''){
               alert('手机号不为空哦');
               return false;
           }else if(!reg.test(user_tel)){
                alert('输入正确格式的手机号哦');
                return false;
           }
           $.ajax({
               url:'/telCode',
               dataType:'json',
               data:{user_tel:user_tel},
               type:'post',
               async:false,
               success:function (res) {
                   console.log(res);
                   if(res.code==2){
                       alert(res.msg);
                   }else{
                       alert('已发送请查收哦');
                   }
               }
           })
        });
        $('#butt').click(function () {
            var user_name=$('#user_name').val();
            var user_email=$('#user_email').val();
            var user_pwd=$('#user_pwd').val();
            var tel_code=$('#tel_code').val();
            var user_tel=$('#user_tel').val();
            var reg=/^1[3,4,5,7,8]\d{9}$/;
            if(user_name==''){
                alert('用户名不为空哦');
                return false;
            }
            if(user_email==''){
                alert('邮箱不为空哦');
                return false;
            }
            if(user_tel==''){
                alert('手机号不为空哦');
                return false;
            }else if(!reg.test(user_tel)){
                alert('输入正确格式的手机号哦');
                return false;
            }
            if(tel_code==''){
                alert('验证码不为空哦');
                return false;
            }
            if(user_pwd==''){
                alert('密码不为空哦');
                return false;
            }
            $.ajax({
                url:"/regdo",
                data:{user_name:user_name,user_email:user_email,user_pwd:user_pwd,user_tel:user_tel,tel_code:tel_code},
                dataType:'json',
                type:'post',
                async:false,
                success:function (res) {
                    console.log(res);
                    if(res.code==2){
                        alert(res.msg);
                    }else{
                        alert('注册成功');
                        location.href="/login";
                    }
                }
            });
            return false;
        })
    })
</script>