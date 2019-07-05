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




<!-- contact us -->
<div class="pages section">
    <div class="container">
        <div class="pages-head">
            <h3>联系我们</h3>
        </div>
        <div class="contact-us">
            <div class="row">
                <div class="col s12">
                    <form action="send-mail.php" class="contact-form" id="contact-form" method="post">
                        <div class="form-group" id="name-field">
                            <input type="text" class="validate" id="form-name" name="form-name" placeholder="NAME" required>
                        </div>
                        <div class="form-group" id="email-field">
                            <input type="email" class="validate" id="form-email" name="form-email" placeholder="EMAIL" required>
                        </div>
                        <div class="form-group" id="subject-field">
                            <input type="text" class="validate" id="form-subject" name="form-subject" placeholder="SUBJECT" required>
                        </div>
                        <div class="form-group" id="message-field">
                            <textarea name="form-message" id="form-message" cols="30" rows="10" class="materialize-textarea" placeholder="YOUR MESSAGE" required></textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn button-default" type="submit" id="submit" name="submit">SEND MESSAGE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end contact us -->
@endsection






</body>
</html>