<?php 

require '../vendor/autoload.php';

use Kavenegar\KavenegarApi;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;

try{
	$api = new KavenegarApi("5650635348616B576D424B317346486252316C2B704B5842456F64753665654573483867616D5737764E303D");
	$receptor = "09353501323";
	$token = "1";
	$token2 = "";
	$token3 = "";
	$template = "admin-card";
	$type = "sms";//sms | call
	$result = $api->VerifyLookup($receptor,$token,$token2,$token3,$template,$type);
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