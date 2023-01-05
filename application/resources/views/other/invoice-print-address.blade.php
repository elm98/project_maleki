<div class="row border-1" style="padding: 0px 10px 10px">
    <div class="col m12 s12">
        <p class="text-center"><img width="150px" src="{{_slash('/uploads/setting/'.$options['logo'])}}"></p>
    </div>
    <div class="col-6" style="border-left: solid 1px #ddd">
        <table style="width: 100%">
            <tbody>
            <tr>
                <td>
                    <div style="padding-top: 50px">
                        <p class="font-bold">گیرنده : {{$invoice->receiver_nickname}}</p>
                        <p class="font-medium">{{locateName($invoice->state)}} - {{locateName($invoice->city)}} - {{$invoice->address}}</p>
                        <p class="font-bold">تلفن :</p>
                        <p class="font-medium">{{$invoice->mobile}} - {{$invoice->tel}}</p>
                        <p class="font-medium">کد پستی :{{!empty($invoice->zip_code)?$invoice->zip_code:'وارد نشده'}}</p>
                        <p class="font-medium">تاریخ سفارش : {{alphaDateTime($invoice->created_at)}}</p>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-6" style="padding: 0px 7px">
        <p class="font-bold">فرستنده : {{$options['blog_title']}}</p>
        <p class="font-medium">{{$options['address']}}</p>
        <p class="font-bold">تلفن های تماس :</p>
        <p class="font-medium">{{$options['mobile']}} - {{$options['tel']}}</p>
        <p class="font-medium" dir="ltr">{{url('/')}}</p>
        <p class="font-medium" dir="ltr">{{\App\Models\Option::getval('invoice_prefix')}}{{$invoice->id}}</p>
    </div>
</div>
