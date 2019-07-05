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
                <a href="/cartdet" ><i class="fa fa-shopping-basket"></i></a>
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
<!-- menu -->
<!-- end menu -->
<!-- shop single -->
<div class="pages section">
    <div class="container">
        <div class="shop-single">
            <img src="{{'/uploads/goodsimg/'.$data['goods_img'] }}" alt="">
            <h5>{{$data['goods_name']}}</h5>
            <div class="price">${{$data['goods_price']}} <span>${{$data['goods_bzprice']}}</span></div>
            <button type="button" class="btn button-default" id="btu" goods_id="{{$data->goods_id}}">加入购物车</button>
            <button type="button" class="btn button-default" id="shc" goods_id="{{$data->goods_id}}">点击加入收藏</button>
        </div>
    </div>

</div>
<!-- end shop single -->
@endsection

<!-- scripts -->
<script src="js/jquery.min.js"></script>
    <script>
        $(function(){
            $('#btu').click(function(){
                var data={};
                var id = $(this).attr('goods_id');
                data.id=id;
                var url = "cart";
                $.ajax({
                    type: "post",
                    data: data,
                    dataType: "json",
                    url: url,
                    success: function (data) {
                      alert(data.msg)
                    }
                })
            })
            //收藏
            $('#shc').click(function(){
                var id = $(this).attr('goods_id');
                $.ajax({
                    url:"/getConlle/"+id,
                    dataType:'json',
                    method:'get',
                    success:function(res){
                        alert(res.msg);
                        if(res.err==3){
                            location.href="/login";
                        }
                    }
                })
            })
        })
    </script>
</body>
</html>