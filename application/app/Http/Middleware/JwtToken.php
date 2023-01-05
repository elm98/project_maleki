<?php

/*
 * This file is part of jwt-auth.
 *
 * (c) Sean Tymon <tymon148@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Middleware;
use Closure;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;

class JwtToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //$secret_key=config('jwt.secret');
        $token=$request->input('token');
        if(!empty($token)){
            try {
                if ($token = JWTAuth::parseToken()) {
                    $payload = JWTAuth::getPayload($token);
                    $info=$payload->get("sub");
                    if($request->method() == 'post' ){
                        $request->request->add(['user_id'=>intval($info)]);
                    }else{
                        $request->query->add(['user_id'=>intval($info)]);
                    }
                    //return response()->json($request);
                    //return response()->json($payload);
                }else{
                    return response()->json(['result' =>0,'msg'=>'Token is Not Complete','token_error'=>1]);
                }
            } catch (Exception $e) {
                if ($e instanceof TokenInvalidException){
                    return response()->json(['result' =>0,'msg'=>'توکن نامعتبر - Token Not Valid','token_error'=>'Not Valid']);
                }else if ($e instanceof TokenExpiredException){
                    return response()->json(['result' =>0,'msg' => 'توکن منقضی شده - Token Expire','token_error'=>'expire']);
                }else{
                    return response()->json(['result' =>0, 'msg' => 'موجودیتی پیدا نشد - Token Unknown','token_error'=>'expire','token'=>$token]);
                }
            }
            return $next($request);
        }
        return response()->json(['result' =>0, 'msg' => 'هیچ توکنی ارسال نشد']);
    }
}
