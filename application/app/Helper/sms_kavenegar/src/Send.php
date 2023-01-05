<?php 

require '../vendor/autoload.php';

use Kavenegar\KavenegarApi;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;

try{
	$api = new KavenegarApi("5650635348616B576D424B317346486252316C2B704B5842456F64753665654573483867616D5737764E303D");
	$sender = "1000596446";
	$message = "ورود جدیدی به حساب شما با آی‌پی 188.213.159.135 ثبت شد. viraexchange.net";
	$receptor = array("09353501323","09115119590");
	$result = $api->Send($sender,$receptor,$message);
	if($result){
	    var_dump($result);
	}
}
catch(ApiException $e){
	echo $e->errorMessage();
}
catch(HttpException $e){
	echo $e->errorMessage();
}
