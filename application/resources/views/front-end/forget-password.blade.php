<html>
<head>
    <title>فراموشی رمز عبور</title>
</head>
<body>
<div id="loading" style="display: none"><span>منتظر بمانید</span></div>
<div style="text-align: center;color: #fff;padding-top: 35px">
    <a href="{{url('/')}}" style="color: #fff;text-decoration: none">
        <span>{{\App\Models\Option::getval('blog_title')}}</span> (بازیابی رمز عبور)
    </a>
</div>
<div class="container">
    <div class="box"></div>
    <div class="container-forms">
        <div class="container-info">
            <div class="info-item">
                <div class="table">
                    <div class="table-cell">
                        <p>
                            ارسال درخواست رمز عبور
                        </p>
                        <div class="btn" id="btn1">
                            ارسال درخواست
                        </div>
                    </div>
                </div>
            </div>
            <div class="info-item">
                <div class="table">
                    <div class="table-cell">
                        <p>
                            تنظیم مجدد رمز عبور
                        </p>
                        <div class="btn" id="btn2" style="visibility: hidden">
                            ریست پسورد
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-form">
            <div class="form-item log-in">
                <div class="table">
                    <div class="table-cell">
                        <p style="text-align:center">ایمیل خود را وارد کنید</p>
                        <input type="email" name="email" id="email" placeholder="ایمیل خود را وارد کنید"  autocomplete="off"/>
                        <div class="btn" onclick="send_request()">
                            ارسال
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-item sign-up">
                <div class="table">
                    <div class="table-cell">
                        <p style="text-align:center">رمز جدید خود را تنظیم کنید</p>
                        <input name="Password" id="password" placeholder="رمز عبور جدید" type="Password"/>
                        <input name="Password_confirmation" id="password_confirmation" placeholder="تکرار رمز عبور " type="Password"/>
                        <div class="btn" onclick="reset_password()">
                            ارسال
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<style>
    /*@charset "UTF-8";*/

    #loading{
        width: 100%;
        height: 100vh;
        background: rgb(111, 111, 111, 0.9);
        text-align: center;
        padding-top: 75px;
        color: #fff;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 999;
    }
    @font-face {
        font-family:'iranyekan';
        font-weight: 500;
        font-style: normal;
        src: url('{{url('back/custom/fonts')}}/iranyekan/iranyekan.eot');
        src: url('{{url('back/custom/fonts')}}/iranyekan/iranyekan.eot?#iefix') format("embedded-opentype"),
        url('{{url('back/custom/fonts')}}/iranyekan/iranyekan.woff') format("woff"),
        url('{{url('back/custom/fonts')}}/iranyekan/iranyekan.html') format("woff2"),
        url('{{url('back/custom/fonts')}}/iranyekan/iranyekan.html') format("truetype");
    }
    body {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        font-family: 'iranyekan',tahoma, "Roboto", sans-serif;
        background-color: #5356ad;
        overflow: hidden;
    }
    input {
        font-family: 'iranyekan',tahoma;
    }

    .table {
        display: table;
        width: 100%;
        height: 100%;
    }

    .table-cell {
        display: table-cell;
        vertical-align: middle;
        -moz-transition: all 0.5s;
        -o-transition: all 0.5s;
        -webkit-transition: all 0.5s;
        transition: all 0.5s;
    }

    .container {
        position: relative;
        width: 600px;
        margin: 30px auto 0;
        height: 320px;
        background-color: #999ede;
        top: 40%;
        margin-top: -160px;
        -moz-transition: all 0.5s;
        -o-transition: all 0.5s;
        -webkit-transition: all 0.5s;
        transition: all 0.5s;
    }

    .container .box {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .container .box:before, .container .box:after {
        content: " ";
        position: absolute;
        left: 152px;
        top: 50px;
        background-color: #9297e0;
        transform: rotateX(52deg) rotateY(15deg) rotateZ(-38deg);
        width: 300px;
        height: 285px;
        -moz-transition: all 0.5s;
        -o-transition: all 0.5s;
        -webkit-transition: all 0.5s;
        transition: all 0.5s;
    }

    .container .box:after {
        background-color: #a5aae4;
        top: -10px;
        left: 80px;
        width: 320px;
        height: 180px;
    }

    .container .container-forms {
        position: relative;
    }

    .container .btn {
        cursor: pointer;
        text-align: center;
        margin: 0 auto;
        width: 120px;
        color: #fff;
        background-color: #ff73b3;
        opacity: 1;
        -moz-transition: all 0.5s;
        -o-transition: all 0.5s;
        -webkit-transition: all 0.5s;
        transition: all 0.5s;
    }

    .container .btn:hover {
        opacity: 0.7;
    }

    .container .btn, .container input {
        padding: 10px 15px;
    }

    .container input {
        margin: 0 auto 15px;
        display: block;
        width: 220px;
        -moz-transition: all 0.3s;
        -o-transition: all 0.3s;
        -webkit-transition: all 0.3s;
        transition: all 0.3s;
    }

    .container .container-forms .container-info {
        text-align: left;
        font-size: 0;
    }

    .container .container-forms .container-info .info-item {
        text-align: center;
        font-size: 16px;
        width: 300px;
        height: 320px;
        display: inline-block;
        vertical-align: top;
        color: #fff;
        opacity: 1;
        -moz-transition: all 0.3s;
        -o-transition: all 0.3s;
        -webkit-transition: all 0.3s;
        transition: all 0.3s;
    }

    .container .container-forms .container-info .info-item p {
        font-size: 20px;
        margin: 20px;
    }

    .container .container-forms .container-info .info-item .btn {
        background-color: transparent;
        border: 1px solid #fff;
    }

    .container .container-forms .container-info .info-item .table-cell {
        padding-right: 35px;
    }

    .container .container-forms .container-info .info-item:nth-child(2) .table-cell {
        padding-left: 35px;
        padding-right: 0;
    }

    .container .container-form {
        overflow: hidden;
        position: absolute;
        left: 30px;
        top: -30px;
        width: 305px;
        height: 380px;
        background-color: #fff;
        box-shadow: 0 0 15px 0 rgba(0, 0, 0, 0.2);
        -moz-transition: all 0.5s;
        -o-transition: all 0.5s;
        -webkit-transition: all 0.5s;
        transition: all 0.5s;
    }

    .container .container-form:before {
        content: "✔";
        position: absolute;
        left: 160px;
        top: -50px;
        color: #5356ad;
        font-size: 130px;
        opacity: 0;
        -moz-transition: all 0.5s;
        -o-transition: all 0.5s;
        -webkit-transition: all 0.5s;
        transition: all 0.5s;
    }

    .container .container-form .btn {
        position: relative;
        box-shadow: 0 0 10px 1px #ff73b3;
        margin-top: 30px;
    }

    .container .form-item {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        opacity: 1;
        -moz-transition: all 0.5s;
        -o-transition: all 0.5s;
        -webkit-transition: all 0.5s;
        transition: all 0.5s;
    }

    .container .form-item.sign-up {
        position: absolute;
        left: -100%;
        opacity: 0;
    }

    .container.log-in .box:before {
        position: absolute;
        left: 180px;
        top: 62px;
        height: 265px;
    }

    .container.log-in .box:after {
        top: 22px;
        left: 192px;
        width: 324px;
        height: 220px;
    }

    .container.log-in .container-form {
        left: 265px;
    }

    .container.log-in .container-form .form-item.sign-up {
        left: 0;
        opacity: 1;
    }

    .container.log-in .container-form .form-item.log-in {
        left: -100%;
        opacity: 0;
    }

    .container.active {
        width: 260px;
        height: 140px;
        margin-top: -70px;
    }

    .container.active .container-form {
        left: 30px;
        width: 200px;
        height: 200px;
    }

    .container.active .container-form:before {
        content: "✔";
        position: absolute;
        left: 51px;
        top: 5px;
        color: #5356ad;
        font-size: 130px;
        opacity: 1;
    }

    .container.active input, .container.active .btn, .container.active .info-item {
        display: none;
        opacity: 0;
        padding: 0px;
        margin: 0 auto;
        height: 0;
    }

    .container.active .form-item {
        height: 100%;
    }

    .container.active .container-forms .container-info .info-item {
        height: 0%;
        opacity: 0;
    }
    .rabbit {
        width: 50px;
        height: 50px;
        position: absolute;
        bottom: 20px;
        right: 20px;
        z-index: 3;
        fill: #fff;
    }
</style>

<script src="{{_slash('back')}}/custom/js/jquery-3.5.1.min.js"></script>
<script>
    let $token = '{{isset($user) && !empty($recovery_token) && $user->recovery_pass_token == $recovery_token ?$recovery_token:''}}';
    console.log($token);
    $(document).ready(function () {
        if($token.length){
            $("#btn2").click();
        }else{
            $("#btn2").css('visibility','hidden');
        }
    })
</script>
<script>
    function send_request() {
        $("#loading").show();
        $.post('{{url('/forget-password-request')}}',{
            email:$("#email").val(),
            _token:'{{csrf_token()}}'
        }).done(function (r) {
            if(r.result){
                alert(r.msg);
                window.location.href='{{url('/')}}';
            }else{
                alert(r.msg);
            }
            $("#loading").hide();
        }).fail(function (e) {
            //console.log(e.responseJSON.message);
            $("#loading").hide();
            alert('خطایی در شبکه یا سرور رخ داده دوباره تلاش کنید');
        })
    }
    function reset_password() {
        $.post('{{url('/set-new-password')}}',{
            password:$("#password").val(),
            password_confirmation:$("#password_confirmation").val(),
            recovery_token:$token,
            _token:'{{csrf_token()}}'
        }).done(function (r) {
            if(r.result){
                alert(r.msg);
                window.location.href='{{url('/login')}}'
            }else{
                alert(r.msg);
            }
        }).fail(function (e) {
            alert('خطایی در شبکه یا سرور رخ داده دوباره تلاش کنید');
        })
    }
</script>
<script>
    $(".info-item .btn").click(function () {
        $(".container").toggleClass("log-in");
    });
    $(".container-form .btn-").click(function () {
        $(".container").addClass("active");
    });

</script>
