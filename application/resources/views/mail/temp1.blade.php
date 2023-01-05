<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
    <meta content="width=device-width" name="viewport"/>
    <meta content="IE=edge" http-equiv="X-UA-Compatible"/>
    <title></title>
</head>
<body class="clean-body" style="margin: 0; -webkit-text-size-adjust: 100%; background-color: #fff;font-family: Tahoma">
<table width="100%" border="0" cellspacing="0" cellpadding="0" dir="rtl" style="direction:rtl;font-family:IRANSans,Vazir,tahoma!important;font-size:12px;line-height:23px">
    <tbody>
    <tr>
        <td align="center" valign="middle" style="background-color:#eeeeee"><br>
            {{--<p>
                <a href="{{url('/')}}" target="_blank" data-saferedirecturl="{{url('/')}}">
                    <img style="border:0 none" onerror="this.src='http://www.tahlildadeh.com/Files/Ads/Android%20Slider%20555%20x%20101.jpg'" src="{{url('/uploads/setting/'.\App\Models\Option::getval('logo-medium'))}}" width="156" height="58" alt="" class="CToWUd">
                </a>
            </p>--}}
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tbody>
                <tr>
                    <td height="23"
                            style="background:url({{url('/back/custom/img/email/temp1/header-bg.jpg')}}) no-repeat center bottom">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="middle"
                        style="background:url({{url('/back/custom/img/email/temp1/border-bg.jpg')}}) repeat-y center">
                        <table width="550" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                            <tr>
                                <td width="550" align="right" valign="top">
                                    <div style="padding: 20px;font-family: Tahoma">
                                        {!! $content !!}
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="55"
                        style="background:url({{url('/back/custom/img/email/temp1/footer-bg.jpg')}}) no-repeat center top">
                        &nbsp;
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" valign="middle" height="95" style="direction:rtl;font-family:IRANSans,Vazir,tahoma!important;font-size:12px;line-height:23px;background-color:#2e363f;color:#b1b7be"><a href="{{url('/')}}" style="color:#b1b7be;text-decoration:none;font-weight:bold" target="_blank" data-saferedirecturl="{{url('/')}}">www.<span style="color:#ff1b1a">{{str_replace(['http://','https://'],['',''],url('/'))}}</span></a><br>
            {{\App\Models\Option::getval('blog_title')}}<br>
            {{\App\Models\Option::getval('description')}}
        </td>
    </tr>
    <tr>
    </tr>
    </tbody>
</table>
</body>
</html>
