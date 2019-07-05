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



<!-- cart -->
<div class="cart section">
    <div class="container">
        <div class="pages-head">
            <h3>CART</h3>
        </div>
        <div class="content">
           <h1>购物车太空了!</h1>
        </div>
        <div class="total">



        </div>
        <button class="btn button-default">结算</button>
    </div>
</div>
<!-- end cart -->
@endsection




<!-- scripts -->
<script src="js/jquery.min.js"></script>
<script>
    $(function(){
        $(".txt").change(function(){

            var data={};
            var id = $(this).attr('goods_id');


            var num=$(this).val();

            data.num=num;
            data.id=id;
            var url = "cartdet";
            $.ajax({
                type: "get",
                data: data,
                dataType: "json",
                url: url,
                success: function (data) {
                    alert(data.msg)
                }
            })
        })

    })
    $(function(){
        $(".fa-trash").click(function(){

            var data={};
            var id = $(this).attr('goods_id');

            data.id=id;
            var url = "delete";
            $.ajax({
                type: "post",
                data: data,
                dataType: "json",
                url: url,
                success: function (data) {
                    alert(data.msg);
                    location.reload();
                }
            })
        })

    })
</script>
</body>
</html>