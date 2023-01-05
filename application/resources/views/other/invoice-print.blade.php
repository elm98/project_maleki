<html dir="rtl" lang="fa">

<head>
    <title>پرینت فاکتور</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <script src="{{_slash('back/custom/js/')}}jquery-3.5.1.min.js"></script>
    <script src="{{_slash('front/custom/js/jQuery.print.min.js')}}"></script>
    <?php
    $width = '21cm'; //A4 = 210 * 297
    $height = '29.7cm';
    ?>
    <style>
        @font-face {
            font-family:'iranyekan';
            font-weight: 500;
            font-style: normal;
            src: url('{{_slash('back/custom')}}/fonts/iranyekan/iranyekan.eot');
            src: url('{{_slash('back/custom')}}/fonts/iranyekan/iranyekan.eot?#iefix') format("embedded-opentype"),
            url('{{_slash('back/custom')}}/fonts/iranyekan/iranyekan.woff') format("woff"),
            url('{{_slash('back/custom')}}/fonts/iranyekan/iranyekan.html') format("woff2"),
            url('{{_slash('back/custom')}}/fonts/iranyekan/iranyekan.html') format("truetype");
        }
        body,div,p,h1,h2,h3,h4,h5,h6,input,select,textarea,button,a,input,select,textarea
        {
            font-family:'iranyekan';
        }
        body{
            direction: rtl;
            background: #eee;
            -webkit-print-color-adjust: exact !important;
        }
        *{
            box-sizing: border-box;
        }
        .m0{
            margin: 0!important;
        }
        .p0{
            padding: 0!important;
        }
        .page-header,
        .page-footer{
            width: {{$width}};
            padding: 10px;
            margin: auto;
        }
        .font-small{
            font-size: 11px!important;
        }.font-medium{
            font-size: 13px!important;
        }.font-large{
            font-size: 18px!important;
        }.font-bold{
            font-weight: bold!important;
        }
        #main-print{
            width: {{$width}};
            margin: auto;
            min-height: 200px;
            padding: 15px;
            box-sizing: border-box;
            background: #fff;
        }
        .border-1{
            border:solid 5px;
            border-image: repeating-linear-gradient( 50deg,
            #060d11, #111111 3%,
            #fea741 1%, #fea741 8%,
            red , red 8%
            ) 10;
        }
        .border-2{
            border:solid 10px;
            border-image-source: url("https://www.w3schools.com/cssref/border.png");
            border-image-slice: 32%;
            border-image-width: 15px;
            border-image-outset: 2px;
            border-image-repeat: round;
            /*border-image: url('symmetric.png') 35% / 35px / 30px round;*/
        }
        .border-3{
            border:double 5px #000;
        }
        .btn{
            padding: 5px 15px;
            border-radius: 5px;
            background: #eee;
            color: #000;
            text-decoration: none;
            border-style: none;
            cursor: pointer;
        }
        .bg-success{
            background: #0aeac2!important;
        }
        .bg-info{
            background: #3076ff !important;
            color:#fff !important;
        }
        .bg-danger{
            background: #fe231e !important;
            color:#fff !important;
        }
        .bg-warning{
            background: #fea741 !important;
            color:#000 !important;
        }
        .text-center{
            text-align: center!important;
        }
        .text-right{
            text-align: right!important;
        }
        .text-left{
            text-align: left!important;
        }
        .col-1{
            width: 16.66%;
        }.col-2{
            width: 20%;
        }.col-3{
            width: 25%;
        }.col-4{
            width: 33.43%;
        }.col-5{
            width: 41.66%;
        }.col-6{
            width: 50%;
        }.col-7{
            width: 58.33%;
        }.col-8{
            width: 66.66%;
        }.col-9{
            width: 75%;
        }.col-10{
            width: 83.33%;
        }.col-11{
            width: 91.66%;
        }.col-12{
            width: 100%;
        }
        [class*="col-"]{
            float: right;
        }
        .row{
            width: 100%;
        }
        .row:after{
            clear: both;
            content: '';
            display: block;
         }
        .tbl-product{
            width: 100%;
            border-collapse: collapse;
        }
        .tbl-product tr th{
            background: #000;
            color:#fff;
            font-weight: normal;
            font-size: 13px;
            padding:5px 2px;
        }
        .tbl-product tbody td{
            border:solid 1px #000;
            padding: 3px;
            font-size: 13px;
        }
        .tbl-product caption{
            background-color: #b3b3b3;
            border-bottom: solid 1px #000;
            padding: 7px;
        }
        .tbl-product td p{
            margin: 0;
        }
        .tbl-result{
            width: 100%;
            border-collapse: collapse;
        }
        .tbl-result tr td{
            font-size: 13px;
            border: solid 1px #59b17e;
            text-align: center;
            padding: 5px 3px;
        }
        .bold{
            font-weight: bold !important;
        }
        .tbl-result tr td:first-child{
             background: #caebd8;
        }
        @media screen and (max-width:600px){
            [class*="col-"]{
                width: 100%;
            }
        }
        @media print {

        }
    </style>
</head>
<?php
$options = \App\Models\Option::multiValue(['logo','blog_title','mobile','tel','address','state','city','currency']);
//$id = unHashId($id);
$invoice = \App\Models\ShopInvoice::find($id);
$subList = \App\Models\ShopInvoiceSub::leftJoin('shop_products as product','product.id','shop_invoice_sub.product_id')
    ->where('shop_invoice_sub.invoice_id',$id)
    ->select('shop_invoice_sub.*'
        ,'product.id as product_id'
        ,'product.title as product_title'
        ,'product.img as product_img'
    )
    ->get();
$currency = $options['currency'];
?>
<body>
    <div class="page-header">
        <div style="text-align: center;padding: 10px">
            <a class ="btn" href="{{url('/profile/order-info/'.($id))}}"><h5 style="margin: 0 0 15px 0;padding: 0">برگشت به فاکتور</h5></a>
            <a class="btn" href="{{url('/invoice-print/'.($id))}}">نمایش کل فاکتور</a>
            <a class="btn" href="{{url('/invoice-print/'.($id).'?action=address')}}">نمایش فقط ادرس</a>&nbsp;&nbsp;
            <a class="btn" href="{{url('/invoice-print/'.($id).'?action=list')}}">نمایش فقط لیست محصولات</a>
        </div>
    </div>
    <div id="main-print" class="border-3">
        <?php $action = isset($_GET['action'])?$_GET['action']:'' ?>
        @if($action == 'address')
            @include('back-end.shop.invoice-print-address')
        @elseif($action == 'list')
            @include('back-end.shop.invoice-print-list')
        @else
            @include('other.invoice-print-address')
            @include('other.invoice-print-list')
        @endif


        {{--<div class="row" style="margin-top: 30px">
            <div class="col-12">
                <hr/>
            </div>
            <div class="col-6">
                <p>مهر و امضای فروشنده</p>
            </div>
            <div class="col-6">
                <p>مهر و امضای مشتری</p>
            </div>
        </div>--}}
    </div>
    <div class="page-footer">
        <button class="print btn bg-warning">چاپ فاکتور</button>
    </div>

</body>
<script src="{{_slash('/front/custom/js/helperFront.js')}}"></script>
<script src="{{_slash('/plugin/num2persian/dist/num2persian-min.js')}}"></script>
<script type='text/javascript'>
    $(function() {
        $('.print').on('click', function() {
            $.print("#main-print");
        });
    });
</script>

</html>
