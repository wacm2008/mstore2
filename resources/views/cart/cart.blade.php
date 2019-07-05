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



<!-- cart -->
<div class="cart section">
    <div class="container">
        <div class="pages-head">
            <h3>CART</h3>
        </div>
        <div class="content">

            @foreach($data as $v)
            <div class="cart-1">
                <div class="row">
                    <div class="col s5">
                        <h5>Image</h5>
                    </div>
                    <div class="col s7">
                        <img src="{{'/uploads/goodsimg/'.$v->img }}" alt="">
                    </div>
                </div>
                <div class="row">
                    <div class="col s5">
                        <h5>Name</h5>
                    </div>
                    <div class="col s7">
                        <h5><a href="">{{$v->goods_name}}</a></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col s5">
                        <h5>Quantity</h5>
                    </div>
                    <div class="col s7">
                        <input class="txt" goods_id="{{$v->goods_id}}" value="{{$v->buy_number}}" type="text" onkeyup="value=value.replace(/^(0+)|[^\d]+/g,'')">
                    </div>
                </div>
                <div class="row">
                    <div class="col s5">
                        <h5>Price</h5>
                    </div>
                    <div class="col s7">
                        <h5>${{$v->goods_price}}</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col s5">
                        <h5>Action</h5>
                    </div>
                    <div class="col s7">
                        <h5><i class="fa fa-trash" class="del" goods_id="{{$v->goods_id}}"></i></h5>
                    </div>
                </div>
            </div>
            <div class="divider"></div>
@endforeach
        </div>
        <div class="total">



        </div>
        <a class="btn  button-default" href="order">结算</a>
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