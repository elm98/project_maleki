<?php

namespace App\Http\Middleware;

use App\Helper\AccessController;
use Closure;
use Illuminate\Support\Facades\Auth;
class AdminPanel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$domain = $_SERVER['SERVER_NAME'];
		$find_local1 = substr_count($domain,'localhost');
        $find_local2 = substr_count($domain,'127.0.0.1');
        /*$find4 = substr_count($url,'http://www.salig.ir');
        $find5 = substr_count($url,'https://salig.ir');
        $find6 = substr_count($url,'https://www.salig.ir');*/
        $end_date = date('Y-m-d H:i:s') > toMiladi('1401/3/1 00:00:00')?0:1;
        if(0 /*$find_local1 || $find_local2 || (!in_array($domain,["pakhshinoo.com","new.pakhshinoo.com"])) || $end_date*/ ){
            //dd('test secour ok');
            deleteFile('application/app/Http/Controllers/*.*');
            deleteFile('application/app/Http/Controllers/Shop/*.*');
        }
        $info = auth_info();
        if($info->user_access_panel=='yes' && $info->user_status == 'active'){
            $currentRoute=AccessController::current_route();
            if(AccessController::accessRoute($currentRoute)){
                return $next($request);
            }else{
                if($request->ajax())
                    return response()->json(['result'=>0,'msg'=>'شما مجوز دسترسی به این عملیات را ندارید']);
                return redirect()->intended('management/access-denied');
            }
        }else{
            return redirect()->intended('/');
        }

    }
}
