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



<!-- product -->
<div class="section product product-list">
    <div class="container">
        <div class="pages-head">
            <h3>PRODUCT LIST</h3>
        </div>
        <div class="input-field">
            <select id="sel">
                <option   value="1">New shop</option>
                <option  value="2">Host shop</option>
                <option   value="3">Best shop</option>
            </select>
        </div>
        <div class="row  ssss">
            @foreach($goodsinfo as $k=> $v)
            <div class="col s6">
                <div class="content">
                    <a href="detil?goods_id={{$v->goods_id}}"><img src="{{'/uploads/goodsimg/'.$v->goods_img }}" alt=""></a>
                    <h6><a href="">{{$v -> goods_name}}</a></h6>
                    <div class="price">
                        ${{$v-> goods_price}} <span>${{$v-> goods_bzprice}}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="pagination-product">
            <ul>
                {{ $goodsinfo->links() }}
            </ul>
        </div>
    </div>
</div>
<!-- end product -->
@endsection



<!-- scripts -->
<script src="js/jquery.min.js"></script>


</body>
</html>
<script>
    $(function () {
            //内容更新事件
            $('#sel').change(function(){
                var val = $(this).prop('value');

                $.get({
                    url:'product',
                    data:{val:val},
                    success:function (res) {
                        $('.ssss').html(res);
                    }
                });
            });
    })
</script>