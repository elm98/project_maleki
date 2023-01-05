<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'f_name',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*relation*/
    function userAddress(){
        return $this->hasMany('App\Models\UserAddress','user_id');
    }

    /*relation*/
    function userMeta(){
       $r=$this->hasOne('App\Models\UserMeta','user_id');
       return $r;
    }

    /*check meta*/
    function meta($key){
        $meta=$this->userMeta;
        if($meta){
            if($meta->$key){
                return $meta->$key;
            }
        }
        return '';
    }


    /**/
    static function status($e=''){
        $data=[
            'active'=>'فعال',
            'inactive'=>'غیر فعال',
            'pending'=>'تعلیق از فعالیت',
            'verify'=>'در حال اعتبار سنجی',
        ];
        return Option::fieldItems($data,$e);
    }

    /**/
    static function role($e=''){
        $data=[
            'administrator'=>'مدیر ارشد',
            'operator'=>'اپراتور',
            'personal'=>'پرسنل',
            'customer'=>'مشتری',
            'store_manager'=>'مدیر فروشگاه',
            'rs_agent'=>'نماینده / مشاور',
        ];
        return Option::fieldItems($data,$e);
    }

    /*تولید کد معرف*/
    static function present_code($id){
        $str = $id;
        $count=strlen((string)$id);
        $length= $count + 2;
        for ($i = 0; $i < $length - $count; $i++) {
            $rand = mt_rand(0, 9);
            $str .= $rand;
        }
        return $str;
    }


}
