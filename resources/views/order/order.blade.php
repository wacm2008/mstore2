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



<!-- shop single -->
<div class="pages section">
    <div class="container">
        @foreach($goodsinfo as $k=> $v)
        <div class="shop-single  shops" goods_id = "{{$v-> goods_id}}">
            <img src="{{'/uploads/goodsimg/'.$v->img }}" alt="">
            <h5>{{$v-> goods_name}}</h5>
            <div class="price">$20 <span>$28</span></div>
            <p>购买的数量 ({{$v-> buy_number}})</p>
        </div>
        @endforeach
        <div class="form-button">
            <a class="btn  btns  button-default">确认结算</a>
        </div>
    </div>
</div>
<!-- end shop single -->
@endsection




<!-- scripts -->
<script src="js/jquery.min.js"></script>

</body>
</html>
<script>
    $(function () {
        $('.btns').click(function () {
              var goods_id = "";
              $('.shops').each(function (index) {
                  goods_id +=  $(this).attr('goods_id')+',';
              })
                goods_id = goods_id.substr(0,goods_id.length-1);
               $.get({
                       url:'orderdo',
                       data:{goods_id:goods_id},
                       dataType:'json',
                       success:function (res) {
                            if(res.errno =='ok'){
                              location.href='orhtml?order_id='+res.oreder_id;
                            }
                       }
                 });
        })
    })
</script>