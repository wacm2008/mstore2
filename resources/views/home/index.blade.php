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

<!-- slider -->
<div class="slider">

    <ul class="slides">
        <li>
            <img src="img/下载.jpg" alt="">
            <div class="caption slider-content  center-align">
                <h2>我们</h2>
                <h4>听组长的话</h4>
                <a href="" class="btn button-default">SHOP</a>
            </div>
        </li>
        <li>
            <img src="img/ash.jpg" alt=''>
            <div class="caption slider-content  center-align">
                <h2>你们 MSTORE</h2>
                <h4>Lorem 听组长的话 d.</h4>
                <a href="" class="btn button-default">SHOP NOW</a>
            </div>
        </li>
        <li>
            <img src="img/342.jpg" alt="">
            <div class="caption slider-content  center-align">
                <h2>你们 MSTORE</h2>
                <h4>Lorem 听组长的话 do.</h4>
                <a href="" class="btn button-default">SHOP NOW</a>
            </div>
        </li>
    </ul>

</div>
<!-- end slider -->

<!-- features -->
<div class="features section">
    <div class="container">
        <div class="row">
            <div class="col s6">
                <div class="content">
                    <div class="icon">
                        <i class="fa fa-car"></i>
                    </div>
                    <h6>Free Shipping</h6>
                    <p>Lorem ipsum dolor sit amet consectetur</p>
                </div>
            </div>
            <div class="col s6">
                <div class="content">
                    <div class="icon">
                        <i class="fa fa-dollar"></i>
                    </div>
                    <h6>Money Back</h6>
                    <p>Lorem ipsum dolor sit amet consectetur</p>
                </div>
            </div>
        </div>
        <div class="row margin-bottom-0">
            <div class="col s6">
                <div class="content">
                    <div class="icon">
                        <i class="fa fa-lock"></i>
                    </div>
                    <h6>Secure Payment</h6>
                    <p>Lorem ipsum dolor sit amet consectetur</p>
                </div>
            </div>
            <div class="col s6">
                <div class="content">
                    <div class="icon">
                        <i class="fa fa-support"></i>
                    </div>
                    <h6>24/7 Support</h6>
                    <p>Lorem ipsum dolor sit amet consectetur</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end features -->

<!-- quote -->
<div class="section quote">
    <div class="container">
        <h4>FASHION UP TO 50% OFF</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid ducimus illo hic iure eveniet</p>
    </div>
</div>
<!-- end quote -->

<!-- product -->
<div class="section product">
    <div class="container">
        <div class="section-head">
            <h4>新品</h4>
            <div class="divider-top"></div>
            <div class="divider-bottom"></div>
        </div>
        <div class="row">
            @foreach($new_shop as $key=>$val)
                <div class="col s6">
                    <div class="content">
                        <a href='detil?goods_id={{$val->goods_id}}'><img src="{{'/uploads/goodsimg/'.$val->goods_img  }}" alt="" height="280" width="280"></a>
                        <h6><a href='detil?goods_id={{$val->goods_id}}'>{{$val-> goods_name}}</a></h6>
                        <div class="price">
                            <b> ${{$val -> goods_price}}</b> <span>|${{$val -> goods_bzprice}}</span>&nbsp;&nbsp;&nbsp;&nbsp;<b>❤</b>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- end product -->

<!-- promo -->
<div class="promo section">
    <div class="container">
        <div class="content">
            <h4>PRODUCT BUNDLE</h4>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
            <button class="btn button-default">SHOP NOW</button>
        </div>
    </div>
</div>
<!-- end promo -->

<!-- product -->
<div class="section product">
    <div class="container">
        <div class="section-head">
            <h4>小编推荐</h4>
            <div class="divider-top"></div>
            <div class="divider-bottom"></div>
        </div>

        <div class="row">
            @foreach($shop as $k=>$v)
            <div class="col s6"  >
                <div class="content">
                    <a href='detil?goods_id={{$v ->goods_id}}'><img src="{{'/uploads/goodsimg/'.$v ->goods_img  }}" alt="" height="280"></a>
                    <h6> <a href='detil?goods_id={{$v->goods_id}}'>{{$v-> goods_name}}</a></h6>
                    <div class="price">
                        <b> ${{$v -> goods_price}}</b> <span>|${{$v -> goods_bzprice}}</span>&nbsp;&nbsp;&nbsp;&nbsp;<b>❤</b>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="pagination-product">
            {{ $shop->links() }}
        </div>
    </div>
</div>
<!-- end product -->
@endsection
<script src="js/jquery.min.js"></script>
<script>
    $(function(){
       $('#btu').click(function(){
          var id = $(this).attr('goods_id');
          console.log(id);
       })
    })
</script>
</body>
</html>
