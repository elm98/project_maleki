<!--
	Author: Amirreza Shayesteh Far
	Author URL: http://amirrezaa.ir
-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $options = \App\Models\Option::multiValue(['blog_title','mobile'])?>
    <title><?php echo e($options['blog_title']); ?></title>
    <script>
        //این خط را حذف کنید و اسکریپت خود را بدون تگ قرار دهید
    </script>
    <style>
        html, body, div, input, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, figcaption, figure, footer, header, hgroup, menu, nav, section, summary, time, mark, audio, video {
            margin: 0;
            padding: 0;
            border: 0;
            outline: 0;
            font-size: 100%;
            vertical-align: baseline;
        }
        @font-face {
            font-family: Vazir;
            src: url('<?php echo e(url('/back/custom/fonts/vazir/Vazir.eot')); ?>');
            src: url('<?php echo e(url('/back/custom/fonts/vazir/Vazir-1.eot')); ?>') format('embedded-opentype'),
            url('<?php echo e(url('/back/custom/fonts/vazir/Vazir.woff')); ?>') format('woff'),
            url('<?php echo e(url('/back/custom/fonts/vazir/Vazir.ttf')); ?>') format('truetype');
            font-weight: normal;
        }
        @font-face {
            font-family: Vazir;
            src: url('<?php echo e(url("/back/custom/fonts/vazir/Vazir-Bold.eot")); ?>');
            src: url('<?php echo e(url("/back/custom/fonts/vazir/Vazir-Bold-1.eot")); ?>') format('embedded-opentype'),
            url('<?php echo e(url("/back/custom/fonts/vazir/Vazir-Bold.woff")); ?>') format('woff'),
            url('<?php echo e(url("/back/custom/fonts/vazir/Vazir-Bold.ttf")); ?>') format('truetype');
            font-weight: bold;
        }
        @font-face {
            font-family: Vazir;
            src: url('<?php echo e(url("/back/custom/fonts/vazir/Vazir-Light.eot")); ?>');
            src: url('<?php echo e(url("/back/custom/fonts/vazir/Vazir-Light-1.eot")); ?>') format('embedded-opentype'),
            url('<?php echo e(url("/back/custom/fonts/vazir/Vazir-Light.woff")); ?>') format('woff'),
            url('<?php echo e(url("/back/custom/fonts/vazir/Vazir-Light.ttf")); ?>') format('truetype');
            font-weight: 300;
        }
        body {
            background-color: #2F3242;
        }
        svg {
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -250px;
            margin-left: -400px;
        }
        .message-box {
            height: 200px;
            width: 380px;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -100px;
            margin-left: 50px;
            color: #FFF;
            font-family: vazir;
            font-weight: 300;
        }
        .message-box h1 {
            direction:rtl;
            font-size: 50px;
            line-height: 46px;
            margin-bottom: 40px;
        }
        .buttons-con .action-link-wrap {
            margin-right: -10px;
            direction: rtl;
            margin-top: 40px;
        }
        .buttons-con .action-link-wrap a {
            background: #36b455;
            padding: 8px 25px;
            border-radius: 4px;
            color: #FFF;
            font-weight: bold;
            font-size: 14px;
            transition: all 0.3s linear;
            cursor: pointer;
            text-decoration: none;
            margin-right: 10px
        }
        .buttons-con .action-link-wrap a:hover {
            background: #5A5C6C;
            color: #fff;
        }

        #Polygon-1 , #Polygon-2 , #Polygon-3 , #Polygon-4 , #Polygon-4, #Polygon-5 {
            animation: float 1s infinite ease-in-out alternate;
        }
        #Polygon-2 {
            animation-delay: .2s;
        }
        #Polygon-3 {
            animation-delay: .4s;
        }
        #Polygon-4 {
            animation-delay: .6s;
        }
        #Polygon-5 {
            animation-delay: .8s;
        }

        @keyframes  float {
            100% {
                transform: translateY(20px);
            }
        }
        @media (max-width: 450px) {
            svg {
                position: absolute;
                top: 50%;
                left: 50%;
                margin-top: -250px;
                margin-left: -190px;
            }
            .message-box {
                top: 50%;
                left: 50%;
                margin-top: -100px;
                margin-left: -190px;
                text-align: center;
            }
        }
        .copyr {
            direction: rtl;
            font-size: 14px;
            color: #dcdcdc;
            position: relative;
            z-index: 3;
            font-family: vazir;
            margin-top: 50px;
        }
        .copyr a {
            text-decoration: none;
            color: #fff;
        }
    </style>
</head>
<body>

<svg width="380px" height="500px" viewbox="0 0 837 1045" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
        <path d="M353,9 L626.664028,170 L626.664028,487 L353,642 L79.3359724,487 L79.3359724,170 L353,9 Z" id="Polygon-1" stroke="#007FB2" stroke-width="6" sketch:type="MSShapeGroup"></path>
        <path d="M78.5,529 L147,569.186414 L147,648.311216 L78.5,687 L10,648.311216 L10,569.186414 L78.5,529 Z" id="Polygon-2" stroke="#EF4A5B" stroke-width="6" sketch:type="MSShapeGroup"></path>
        <path d="M773,186 L827,217.538705 L827,279.636651 L773,310 L719,279.636651 L719,217.538705 L773,186 Z" id="Polygon-3" stroke="#795D9C" stroke-width="6" sketch:type="MSShapeGroup"></path>
        <path d="M639,529 L773,607.846761 L773,763.091627 L639,839 L505,763.091627 L505,607.846761 L639,529 Z" id="Polygon-4" stroke="#F2773F" stroke-width="6" sketch:type="MSShapeGroup"></path>
        <path d="M281,801 L383,861.025276 L383,979.21169 L281,1037 L179,979.21169 L179,861.025276 L281,801 Z" id="Polygon-5" stroke="#36B455" stroke-width="6" sketch:type="MSShapeGroup"></path>
    </g>
</svg>
<div class="message-box">
    <h1>اوپس! 404</h1>
    <p style="direction: rtl; font-size: 18px;">صفحه مورد نظر شما یافت نشد، میتوانید با ما تماس بگیرید یا به صفحه دیگری بروید!</p>
    <div class="buttons-con">
        <div class="action-link-wrap">
            <a onclick="history.back(-1)" class="link-button link-back-button">بازگشت به قبل</a>
            <a href="<?php echo e(url('/')); ?>" class="link-button">رفتن به صفحه اصلی</a>
        </div>
    </div>
    
</div>
</body>
</html>
<!--
	Author: mohammad shoja
	Author URL: http://moderniz.ir
-->
<?php /**PATH C:\wamp64\www\mis_maleki\application\resources\views/front-end/404.blade.php ENDPATH**/ ?>