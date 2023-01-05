<?php

namespace App\Helper;

use App\Models\Option;
use App\Models\PermissionList;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;
class AccessController
{
    static $prefix='management';
    static $except=['/','management','dashboard','access-denied'];

    static function info(){
        return auth_info();
    }

    /**/
    static function get_menu(){
        $name = 'dashboard_menu_'.self::info()->user_menu.'.json';
        if(file_exists("data/$name")){
            return $json=json_decode(file_get_contents("data/$name"));
        }else{
            return view('back-end.access_denied');
        }
        //return $json=json_decode(file_get_contents("data/menu.json"));
    }

    /**/
    static function get_permission_array(){
        $find=PermissionList::find(self::info()->user_permission_id);
        $arr=[];
        if($find)
        {
            $arr=!empty($find->items)?json_decode($find->items):[];
            array_push($arr,'dashboard');
        }
        return $arr;
    }

    /**/
    static function current_route(){
        return Route::getCurrentRoute()->uri;
    }

    /**/
    static function match($route){
        return self::$prefix.'/'.$route==self::current_route()?true:false;
    }

    /*چک کردن هم روشن کردن منو انتخابی هم مجوز والد منو برای نمایش*/
    static function is_active($parent_route,$child,$permission_array){
        $active=false;
        $is_permission=false;
        $current=self::current_route();
        foreach ($child as $item){
            if(self::$prefix.'/'.$item->route == $current){
                $active=true;
            }
            if(in_array($item->route,$permission_array) && (isset($item->title) && !empty($item->title))){
                $is_permission=true;
            }
        }
        if(self::$prefix.'/'.$parent_route == $current){
            $active=true;
        }
        if(in_array($parent_route,$permission_array)){
            $is_permission=true;
        }
        $is_permission=self::info()->user_role=='administrator'?true:$is_permission;
        return ['is_active'=>$active,'is_permission'=>$is_permission];
    }

    /* بررسی وجود دسترسی یا عدم وجود به روت */
    public static function accessRoute($path){
        $auth=self::info();
        $role=Role::where('role',$auth->user_role)->get();
        if($role->count()){
            if($role->first()->access_panel=='yes'){
                if(self::info()->user_role=='administrator'){
                    return true;
                }else{
                    $arr=self::get_permission_array();
                    $path=str_replace(self::$prefix.'/','',$path);
                    $arr=array_merge($arr,self::$except);
                    return in_array($path,$arr)?true:false;
                }
            }
        }
        return false;
    }

    /**/
    static function create_menu(){
        $arr=self::get_menu();
        $html='';
        $permission_array=self::get_permission_array();
        foreach ($arr as $row){
            $parentHidden=isset($row->hidden)?true:false;
            $is_child=isset($row->child)&&!empty($row->child)?true:false;
            $is_collapse=$is_child?'collapsible-header':'';
            $link='';
            $link=isset($row->href) && !empty($row->href)?str_replace('SITE_URL',url('/'),$row->href):$link;
            $link=isset($row->route) && !empty($row->route)?url(self::$prefix.'/'.$row->route):$link;
            $link=!empty($link)?$link:'Javascript:void(0)';
            $badge=isset($row->badge) && !empty($row->badge)?'<span class="badge badge pill red float-right mr-10">'.$row->badge.'</span>':'';
            $child=$is_child?$row->child:[];
            $activate=self::is_active($row->route,$child,$permission_array);
            $active=$activate['is_active']?'active':'';
            $is_permission=$activate['is_permission'];
            if(!$parentHidden && $is_permission){
                $active_parent_color=!$is_child && $active?'active':'';
                $html.='<li class="'.$active.' bold">';
                $html.='<a class="'.$is_collapse.' '.$active_parent_color.' waves-effect waves-cyan " href="'.$link.'">
                    <i class="material-icons">'.$row->icon.'</i>
                    <span class="menu-title" data-i18n="Dashboard">'.$row->title.'</span>
                    '.$badge.'
                </a>';
                if($is_child){
                    $html.='<div class="collapsible-body">';
                    $html.='<ul class="collapsible collapsible-sub" data-collapsible="accordion">';
                    foreach ($row->child as $items){
                        $hidden=isset($items->hidden)?true:false;
                        $is_permission_child=in_array($items->route,$permission_array) || self::info()->user_role=='administrator'?true:false;
                        if(!$hidden && $is_permission_child){
                            $active=self::$prefix.'/'.$items->route == self::current_route()?'active':'';
                            $target = isset($items->target) && !empty($items->target)?'target="'.$items->target.'"':'';
                            $link='';
                            $link=isset($items->href) && !empty($items->href)?str_replace('{SITE_URL}',url('/'),$items->href):$link;
                            $link=isset($items->route) && !empty($items->route)?url(self::$prefix.'/'.$items->route):$link;
                            $html.='<li><a class="'.$active.' iransans" href="'.$link.'" '.$target.' ><i class="material-icons">fiber_manual_record</i><span data-i18n="Modern">'.$items->title.'</span></a></li>';
                        }
                    }
                    $html.='</ul></div>';
                }
                $html.='</li>';
            }
        }
        return $html;
    }

    static function search_menu($term){
        $arr=self::get_menu();
        $html='';
        $permission_array=self::get_permission_array();
        foreach ($arr as $row){
            $is_child=isset($row->child)&&!empty($row->child)?true:false;
            if($is_child){
                foreach ($row->child as $items){
                    $hidden=isset($items->hidden)?true:false;
                    $is_permission_child=in_array($items->route,$permission_array) || self::info()->user_role=='administrator'?true:false;
                    if(!$hidden && $is_permission_child && substr_count($items->title,$term)){
                        $link='';
                        $link=isset($items->href) && !empty($items->href)?$items->href:$link;
                        $link=isset($items->route) && !empty($items->route)?url(self::$prefix.'/'.$items->route):$link;
                        $html.='<li class="w-100"><a  href="'.$link.'">'.$items->title.'</a></li>';
                    }
                }
            }else{
                if(substr_count($row->title,$term)){
                    $link=isset($row->href) && !empty($row->href)?$row->href:'';
                    $link=isset($row->route) && !empty($row->route)?url(self::$prefix.'/'.$row->route):$link;
                    $html.='<li class="w-100"><a  href="'.$link.'">'.$row->title.'</a></li>';
                }
            }
        }
        return $html;
    }
}
