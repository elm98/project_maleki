<?php

namespace App\Http\Middleware;

use App\Helper\AccessController;
use App\Models\ShopStore;
use Closure;
use Illuminate\Support\Facades\Auth;
class Seller
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
        $store_ids = session('store_ids');
        if(!isset($store_ids) || empty($store_ids) || count($store_ids)){
            $store_ids = ShopStore::where('user_id',\auth()->user()->id)
                ->pluck('id')
                ->toArray();
        }
        if(count($store_ids)){
            $request->request->add([
                'store_ids'=>$store_ids
            ]);
            session(['store_ids'=>$store_ids]);
            return $next($request);
        }
        else{
            if($request->json()){
                return response()->json(['result'=>0,'msg'=>'هیچ فروشگاهی برای شما یافت نشد']);
            }
            return redirect('/')->with(['error'=>'هیچ فروشگاهی برای شما یافت نشد']);
        }

    }
}
