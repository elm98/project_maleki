<div class="row">
    <div class="col-12" style="padding-top: 15px">
        <table class="tbl-product">
            <caption class="font-medium bold">مشخصات و لیست محصول</caption>
            <thead>
            <tr>
                <th>شناسه</th>
                <th>تصویر</th>
                <th>محصول</th>
                <th>قیمت به {{$currency}}</th>
                <th>تعداد</th>
                <th> تخفیف</th>
                <th>مبلغ کل</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sum_count=0;
            $sum_discount=0;
            $sum_price=0;
            ?>
            @foreach($subList as $item)
                <?php
                $finance = \App\Models\ShopInvoiceSub::finance($item,$invoice->tax_percent);
                $discount = $item->real_price - $item->customer_price;
                $sum_count+=$item->count;
                $price =$item->customer_price * $item->count;
                $sum_discount+=$discount;
                $sum_price+=$price;
                ?>
                <tr>
                    <td>{{$item->product_id}}</td>
                    <td><img src="{{_slash($item->product_img)}}" width="50px"></td>
                    <td style="word-break: break-all;max-width: 35%;width: 100%">{{$item->product_title}}</td>
                    <td>
                        <p> {{number_format($item->real_price)}} </p>
                        <p>{{--مشتری: {{number_format($item->customer_price)}} --}}</p>
                    </td>
                    <td class="text-center">{{$item->count}}</td>
                    <td class="text-center">{{number_format($discount)}} </td>
                    <td class="text-center">{{number_format($price)}}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4"></td>
                <td style="background: #caebd8" class="text-center bold">{{number_format($sum_count)}}</td>
                <td style="background: #caebd8" class="text-center bold">{{number_format($sum_discount)}}</td>
                <td style="background: #caebd8" class="text-center bold">{{number_format($sum_price)}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="row" style="padding-top: 30px">
            <div class="col-12" style="border-right: solid 2px #0aeac2;padding-right: 15px;padding-left: 15px;margin: 20px 0">
                <p class="m0"><span class="font-bold">یادداشت مشتری :</span><span class="font-medium"> {{$invoice->description}}</span></p>
            </div>
            <div class="col-12" style="border-right: solid 2px #0aeac2;padding-right: 15px;padding-left: 15px">
                <p class="m0"><span class="font-bold">یادداشت فروشنده :</span><textarea rows="3" style="width: 100%;border:0px;padding: 3px">{{$invoice->seller_description}}</textarea></p>
            </div>
        </div>
    </div>
    <div class="col-6">
        <?php $finance = \App\Models\ShopInvoice::finance($invoice)?>
        <table class="tbl-result" style="margin-top: 30px">
            <tr>
                <td>مبلغ کل مشتری :</td>
                <td>{{number_format($finance['customer_price'])}} {{$currency}}</td>
            </tr>
            <tr>
                <td>مبلغ تخفیف :</td>
                <td>{{number_format($finance['all_discount_price'])}} {{$currency}}</td>
            </tr>
            <tr>
                <td>مبلغ مالیات :</td>
                <td>{{number_format($finance['tax_price'])}} {{$currency}}</td>
            </tr>
            <tr>
                <td>مبلغ حمل و نقل:</td>
                <td>{{number_format($finance['shipping_price'])}} {{$currency}}</td>
            </tr>
            <tr>
                <td>کوپن تخفیف:</td>
                <td>{{($invoice->coupon_cart_percent) * 100}}% | {{number_format($finance['coupon_cart_price'])}} {{$currency}}</td>
            </tr>
            <tr>
                <td>مبلغ قابل پرداخت نهایی:</td>
                <td>{{number_format($finance['paid_price'])}} {{$currency}}</td>
            </tr>
            <tfoot>
            <tr>
                <td colspan="2" id="persianPrice"></td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#persianPrice").html(helper().persianNumber(parseInt({{$finance['paid_price']}})) + ' {{$currency}}');
    })
</script>
