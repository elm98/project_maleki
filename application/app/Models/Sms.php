<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use SoapClient;
use Whoops\Exception\ErrorException;
require 'application/app/Helper/sms_kavenegar/vendor/autoload.php';
use Kavenegar\KavenegarApi;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;

use App\Helper\smsir\SmsIR_UltraFastSend;

class Sms extends Model
{
    protected $table='sms';
    protected $guarded=[];

    static $line_number=[
        '30008638000017',
        '500059110',
        '10000000009'
    ];

    /**/
    static function type($e=''){
        $data=[
            'send'=>'ارسالی',
            'receive'=>'دریافتی',
        ];
        return Option::fieldItems($data,$e);
    }

    /**/
    static function status($e=''){
        $data=[
            'read'=>'خوانده شده',
            'unread'=>'خوانده نشده',
        ];
        return Option::fieldItems($data,$e);
    }

    /**/
    static function relate_to($e=''){
        $data=[
            'store_expire'=>'اعلان انقضای پنل',
        ];
        return Option::fieldItems($data,$e);
    }

    /*پیدا کردن متغیر ها از دل متن پترن سامانه*/
    static function getVariable($txt){
        $arr = [];
        foreach (NotifyTemp::$pattern_keys as $key=>$val){
            $find = strpos($txt,$key);
            if($find !== false){
                $arr[]=[
                    'index'=>$find,
                    'key'=>$key
                ];
            }
        }
        $c=array_column($arr,'index');
        array_multisort($c, SORT_ASC, $arr);
        return $arr;
    }

    /*انتخاب هوشمتد ارسال معمولی*/
    static function send($body,$number){
        $panel = Option::getval('smsPanelDefault');
        switch ($panel){
            case 'smsPanel_niazpardaz':
                return self::niazpardaz($body,$number);
                break;
            case 'smsPanel_inductor':
                return self::inductor($body,$number);
                break;
            default:
                return ['result'=>0,'msg'=>'پنلی برای ارسال پیدا نشد'];
        }
    }

    /*انتخاب هوشمند ارسال پترنی*/
    static function send_pattern($content,$mobile,$patternId,$arrayContent){
        $panel = Option::getval('smsPanelDefault');
        switch ($panel){
            case 'smsPanel_kavenegar':
                return self::kavenegar($content,$mobile,$patternId,$arrayContent);
                break;
            case 'smsPanel_mellipayamak':
                return self::melliPayamak($content,$mobile,$patternId,$arrayContent);
                break;
            case 'smsPanel_smsir':
                return self::smsir($content,$mobile,$patternId,$arrayContent);
                break;
            default:
                return ['result'=>'0','msg'=>'پنلی برای ارسال پیدا نشد'];
        }
    }

    /*ارسال مستقیم پیامک با نیاز پرداز*/
    static function niazpardaz($body,$number){
        $opt = optionJsonValues('smsPanel_niazpardaz');
        $sms_line=$opt->lineNumber;
        $sms_webservice=$opt->server;
        $sms_user=$opt->user;
        $sms_pass=$opt->pass;

        //New Version
        ini_set("soap.wsdl_cache_enabled", "0");
        $sms_client = new SoapClient($sms_webservice, array('encoding'=>'UTF-8'));
        $parameters['userName'] = $sms_user;
        $parameters['password'] = $sms_pass;
        $parameters['fromNumber'] = $sms_line;
        $parameters['toNumbers'] = explode(',',$number);
        $parameters['messageContent'] = $body;
        $parameters['isFlash'] = false;
        //$recId = array();
        //$status = array();
        //$parameters['recId'] = &$recId ;
        //$parameters['status'] = &$status ;
        //$retId=$sms_client->SendSMS($parameters)->SendSMSResult;
        if($sms_client)
        {
            try
            {
                $callBack= $sms_client->SendSMS($parameters)->SendSMSResult;
                if($callBack == 0){
                    Sms::insertGetId([
                        'sms_id'=>0,
                        'line'=>$sms_line,
                        'mobile'=>$number,
                        'content'=>urldecode($body),
                        'type'=>'send',
                        'status'=>'read',
                        //'relate_to'=>$relate_to,
                        //'relate_id'=>$relate_id,
                        'panel'=>$opt->title,
                        'description'=>self::report($callBack).' - '.$callBack,
                        'created_at'=>Carbon::now()
                    ]);
                    return ['result'=>1,'msg'=>self::report($callBack)];
                }
                return ['result'=>0,'msg'=>self::report($callBack)];
            }
            catch (Exception $e)
            {
                return ['result'=>0,'msg'=>'Caught exception: '. $e->getMessage(). "\n"];
            }
        }
        return ['result'=>0,'msg'=>'خطای غیره منتظره ، دوباره تلاش کنید'];
    }

    /*اعتبار پنل پیامک نیاز پرداز*/
    static function Credit()
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        $sms_client = new SoapClient(Option::getval('sms_server'), array('encoding'=>'UTF-8'));
        $parameters['userName'] = Option::getval('sms_user');
        $parameters['password'] = Option::getval('sms_password');
        $parameters['fromNumber'] = Option::getval('sms_line');
        //$parameters['toNumbers'] = array($number);
        //$parameters['messageContent'] = $body;
        $parameters['isFlash'] = false;
        return $sms_client->GetCredit($parameters)->GetCreditResult;
    }

    /*گزارش خطا نیاز پرداز*/
    static function report($callback)
    {
        $ret[0]='ارسال با موفقیت انجام شد';
        $ret[1]=' نام کاربر یا کلمه عبور نامعتبر می باشد ';
        $ret[2]='کاربر مسدود شده است ';
        $ret[3]=' شماره فرستنده نامعتبر است ';
        $ret[4]=' محدودیت در ارسال روزانه';
        $ret[5]='تعداد گیرندگان حداکثر 100 شماره میباشد';
        $ret[6]=' خط فرسنتده غیرفعال است ';
        $ret[7]=' متن پیامک شامل کلمات فیلتر شده است ';
        $ret[8]='اعتبار کافی نیست';
        $ret[9]=' :سامانه در حال بروز رسانی می باشد';
        $ret[10]='وب سرویس غیرفعال است ';
        if($callback >=0 && $callback <=10)
            return $ret[$callback];
        else
            return 'خطا غیر قابل تشخیص - '.$callback;
    }

    /*ارسال با واسطه مدرنیز بصورت پست*/
    static function inductor($content,$mobile){
        $opt = optionJsonValues('smsPanel_inductor');
        $ret = [
            'result'=>0,
            'msg'=>'بروز خطا در ارسال پیامک',
        ];
        $param=[
            'username'=>$opt->user,
            'password'=>$opt->pass,
            'mobile'=>$mobile,
            'content'=>$content
        ];
        $link = $opt->server;
        $R = send_curl($param,$link);
        $R = json_decode($R);
        if($R && isset($R->result)){
            $insert=Sms::insertGetId([
                'sms_id'=>0,
                'line'=>"10000000009",
                'mobile'=>$mobile,
                'content'=>urldecode($content),
                'type'=>'send',
                'status'=>'read',
                //'relate_to'=>'',
                //'relate_id'=>'',
                'panel'=>$opt->title,
                'created_at'=>Carbon::now()
            ]);
            return $R;
        }else{
            return $ret;
        }
    }

    /*ارسال توسط پترن کاوه نگار*/
    static function kavenegar($content,$mobile,$patternId,$arrayContent){
        $opt = optionJsonValues('smsPanel_kavenegar');
        $mobiles = explode(',',$mobile);
        if(!count($mobiles)){
            return 0;
        }
        /*استخراج متغیرها از متن*/
        $variable = self::getVariable($content);
        foreach ($variable as $k=>$item){
            if(in_array($item['key'],array_keys($arrayContent))){
                $variable[$k]['value'] = $arrayContent[$item['key']];
            }else{
                $variable[$k]['value'] = '';
            }
        }
        $params = array_column($variable,'value');
        try{
            $api = new KavenegarApi($opt->api);
            $receptor = $mobiles[0];
            $token = isset($params[0])?str_replace([" "],["_"],$params[0]):"";
            $token2 = isset($params[1])?str_replace([" "],["_"],$params[1]):"";
            $token3 = isset($params[2])?str_replace([" "],["_"],$params[2]):"";
            $template = $patternId;//"admin-card";
            $type = "sms";//sms | call
            //dd($receptor,$token,$token2,$token3,$template,$type);
            $result = $api->VerifyLookup($receptor,$token,$token2,$token3,$template,$type);
            /*ارسال برای ادمین*/
            if(isset($mobiles[1])){
                $api->VerifyLookup($mobiles[1],$token,$token2,$token3,$template,$type);
            }
            if($result){
                Sms::insertGetId([
                    'sms_id'=>0,
                    'line'=>'',
                    'mobile'=>$mobile,
                    'content'=>urldecode($content),
                    'type'=>'send',
                    'status'=>'read',
                    'panel'=>$opt->title,
                    //'relate_to'=>$relate_to,
                    //'relate_id'=>$relate_id,
                    'description'=>'',
                    'created_at'=>Carbon::now()
                ]);
                return true;
                //return ['result'=>1,'msg'=>'ارسال انجام شد','data'=>$result];
                //var_dump($result);
            }
        }
        catch(ApiException $e){
            return false;
            //return ['result'=>0,'msg'=>'خطا در ارسال','data'=>$e->errorMessage()];
            //echo $e->errorMessage();
        }
        catch(HttpException $e){
            return false;
            //return ['result'=>0,'msg'=>'خطا در ارسال','data'=>$e->errorMessage()];
            //echo $e->errorMessage();
        }
        return false;
    }

    /*ارسال توسط پترن ملی پیامک*/
    static function melliPayamak($content,$number,$bodyId,$arrayContent){
        $opt = optionJsonValues('smsPanel_mellipayamak');
        $mobiles = explode(',',$number);
        if(!count($mobiles)){
            return 0;
        }
        /*استخراج متغیرها از متن*/
        $variable = self::getVariable($content);
        foreach ($variable as $k=>$item){
            if(in_array($item['key'],array_keys($arrayContent))){
                $variable[$k]['value'] = $arrayContent[$item['key']];
            }else{
                $variable[$k]['value'] = '';
            }
        }
        $params = array_column($variable,'value');
        ini_set("soap.wsdl_cache_enabled","0");
        try {
            $sms = new SoapClient("http://api.payamak-panel.com/post/Send.asmx?wsdl",array("encoding"=>"UTF-8"));
            $text = count($params)?implode(';',$params):"null";
            $data = array(
                "username"=>$opt->user,
                "password"=>$opt->pass,
                'text' => $text,//"arg1;arg2",
                "to"=>$mobiles[0],
                "bodyId"=>$bodyId
            );

            /*ارسال اسان از طریق لینک*/
            $url="http://api.payamak-panel.com/post/Send.asmx/SendByBaseNumber2?username=$opt->user&password=$opt->pass&text=$text&to=$mobiles[0]&bodyId=$bodyId";
            $send_Result = file_get_contents($url);

            /*ارسال از طریق تابع ارسال*/
            //$send_Result = $sms->SendByBaseNumber($data)->SendByBaseNumberResult;

            /*ارسال برای ادمین*/
            if(isset($mobiles[1])){
                /*ارسال برای مدیر از طریق لینک ارسال سریع*/
                file_get_contents("http://api.payamak-panel.com/post/Send.asmx/SendByBaseNumber2?username=$opt->user&password=$opt->pass&text=$text&to=$mobiles[1]&bodyId=$bodyId");

                /*ارسال برای مدیر از طریق تابع ارسال ملی پیامک*/
                //$data["to"] = $mobiles[1];
                //$sms->SendByBaseNumber($data)->SendByBaseNumberResult;
            }
            Sms::insertGetId([
                'sms_id'=>0,
                'line'=>'',
                'mobile'=>$number,
                'content'=>NotifyTemp::setContent($content,$arrayContent),
                'type'=>'send',
                'status'=>'read',
                'panel'=>$opt->title,
                'description'=>'',
                'created_at'=>Carbon::now()
            ]);
            return $send_Result;
        }catch (Exception $e){
            return 0;
        }
    }

    /*ارسال توسط پترن sms.ir*/
    static function smsir($content,$mobile,$patternId,$arrayContent){
        $opt = optionJsonValues('smsPanel_smsir');
        $mobiles = explode(',',$mobile);
        if(!count($mobiles)){
            return 0;
        }
        /*استخراج متغیرها از متن*/
        $variable = self::getVariable($content);
        foreach ($variable as $k=>$item){
            if(in_array($item['key'],array_keys($arrayContent))){
                $variable[$k]['value'] = $arrayContent[$item['key']];
            }else{
                $variable[$k]['value'] = '';
            }
        }
        $params = [];
        foreach ($variable as $item){
            $params[]=[
                "Parameter" => str_replace(['}','{'],['',''],$item['key']),
                "ParameterValue" => (string)$item['value']
            ];
        }
        try{
            date_default_timezone_set("Asia/Tehran");
            $APIKey = $opt->apikey;
            $SecretKey = $opt->secretkey;
            // message data
            $data = array(
                "ParameterArray" => $params,
                "Mobile" => $mobiles[0],
                "TemplateId" => $patternId
            );
            $SmsIR_UltraFastSend = new SmsIR_UltraFastSend($APIKey,$SecretKey);
            $UltraFastSend = $SmsIR_UltraFastSend->UltraFastSend($data);
            /*ارسال برای ادمین*/
            if(isset($mobiles[1])){
                $data["Mobile"] = $mobiles[1];
                $SmsIR_UltraFastSend->UltraFastSend($data);
            }
            Sms::insertGetId([
                'sms_id'=>0,
                'line'=>'',
                'mobile'=>$mobile,
                'content'=>urldecode($content),
                'type'=>'send',
                'status'=>'read',
                'panel'=>$opt->title,
                //'relate_to'=>$relate_to,
                //'relate_id'=>$relate_id,
                'description'=>'',
                'created_at'=>Carbon::now()
            ]);
            return ($UltraFastSend);
        }
        catch(ApiException $e){
            return false;
            //return ['result'=>0,'msg'=>'خطا در ارسال','data'=>$e->errorMessage()];
            //echo $e->errorMessage();
        }

    }

    /*ارسال توسط پترن ملی پیامک شماره 2*/
    static function mellipayamak2($content,$number,$bodyId,$arrayContent){
        $mobiles = explode(',',$number);
        if(!count($mobiles)){
            return 0;
        }
        /*استخراج متغیرها از متن*/
        $variable = self::getVariable($content);
        foreach ($variable as $k=>$item){
            if(in_array($item['key'],array_keys($arrayContent))){
                $variable[$k]['value'] = $arrayContent[$item['key']];
            }else{
                $variable[$k]['value'] = '';
            }
        }
        $params = array_column($variable,'value');
        $params = array_map(function ($a){return (string)$a;},$params);
        $to=$mobiles[0];
        $url = 'https://console.melipayamak.com/api/send/shared/f7ac4f229e3745e6b88a082a31d303e4';
        $data = array("bodyId" => intval($bodyId), "to" => "$to", "args" => $params);
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        // Next line makes the request absolute insecure
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Use it when you have trouble installing local issuer certificate
        // See https://stackoverflow.com/a/31830614/1743997

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );
        $result = curl_exec($ch);
        curl_close($ch);
        dd($result);
        return $result;
        var_dump($result);
    }


}
