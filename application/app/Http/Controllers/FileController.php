<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{

    private $prefix_url='';
    private $media_url ='uploads/media'; // تا ابتدای مسیر گالری
    private $full_url =''; // مسیر کامل از صفر تا گالری
    private $image=['jpg','JPG','jpeg','JPEG','png','PNG','gif','GIF','svg','SVG'];
    private $video=['AVI','MKV','MP4','WMV','Xvid','MOV','avi','mkv','mp4','wmv','xvid','mov'];
    private $audio=['WAV','MP3','AAC','OGG','WMA','wav','mp3','aac','ogg','wma'];

    function __construct()
    {
        $this->prefix_url = realpath(base_path() . '/..');
        $this->full_url = $this->prefix_url.'/'.$this->media_url;
    }

    /**/
    function access_directory($role,$folderName,$directory){
        $basePath = realpath(base_path() . '/..');
        $galleryPath='/uploads/gallery';
        $fullPath = $basePath . $galleryPath;
        $root="";
        if(!in_array($role,User::admin_roles())){
            if(is_dir($fullPath.'/'.$folderName)){
                $root='/'.$folderName;
            }
            else{
                return ['result'=>0,'msg'=>'دسترسی شما محدود شده , با پشتیبانی تماس بگیرید'];
            }
        }
        $currentPath=$galleryPath.$root.$directory;
        $fullPath = $basePath . $currentPath;
        return[
            'result'=>1,
            'galleryPath'=>$galleryPath,
            'currentPath'=>$currentPath,
            'fullPath'=>$fullPath,
            'basePath'=>$basePath,
            'directory'=>$directory,
            'root'=>$root,
        ];
    }

    /*لیست فایلها در یک دایرکتوری*/
    function file_list(Request $request){
        $directory=$this->clear_directory($request->input('directory','/'));
        $current=$this->media_url.'/'.$directory;
        $items=[];
        $filter_type=$request->input('filter','all');

        /*ایجاد لینک بازگشت به بالا*/
        $arr=[];
        $split=explode('/',$directory);
        for ($i=0;$i<count($split)-1;$i++){
            $arr[]=$split[$i];
        }
        $back = implode('/',$arr);
        //$back=empty($back)?'/':$back;
        if($directory !==''){
            $items[]=[
                'name'=>'بازگشت به عقب',
                'type'=>'back',
                'format'=>'back',
                'size'=>'',
                'url'=>$back,
                'path'=>$back,
                'icon'=>'img/back.png',
                'item_type'=>'back',
            ];
        }

        /*یافتن پوشه ها*/
        $folder_list=array_filter(glob($this->full_url.'/'.$directory.'/*'), 'is_dir');
        foreach ($folder_list as $item){
            $arr=explode('/',$item);
            $name=end($arr);
            $items[]=[
                'name'=>$name,
                'type'=>'folder',
                'item_type'=>'folder',
                'format'=>'folder',
                'size'=>'',
                'url'=>url('/').$current.'/'.$name,
                'path'=>$this->clear_directory($directory.'/'.$name),
                'icon'=>'img/folder_icon.png',
            ];
        }
        /*یافتن همه فایل ها*/
        $fileList=array_filter(glob($this->full_url.'/'.$directory.'/*'), 'is_file');
        usort($fileList, function($a,$b){ return filemtime($b) - filemtime($a);});/*مرتب سازی تاریخ*/
        //usort($fileList, create_function('$a,$b', 'return filemtime($a) - filemtime($b);'));
        foreach ($fileList as $item){
            $arr=explode('/',$item);
            $fileName=end($arr);
            $arrDot=explode('.',$fileName);
            $format=end($arrDot);
            $datetime=filemtime($item);
            $size=filesize($item);
            $kb=$size > 1024?$size / 1024:0;
            $mb=$kb > 1024?$kb / 1024:0;
            $gb=$mb > 1024?$mb / 1024:0;
            $sizeOf=number_format($size,1)." b";
            if($gb > 0)
                $sizeOf=number_format($gb,1)." Gb";
            elseif($mb > 0)
                $sizeOf=number_format($mb,1)." Mb";
            elseif ($kb > 0)
                $sizeOf=number_format($kb,1)." Kb";

            //Find Type
            if(in_array($format,$this->image)){
                $type='image';
                $icon='img/image_icon.png';
                $show_list = in_array($filter_type,['all','image'])?true:false;
            }elseif (in_array($format,$this->video)){
                $type='video';
                $icon='img/video_icon.png';
                $show_list = in_array($filter_type,['all','video'])?true:false;
            }elseif (in_array($format,$this->audio)){
                $type='audio';
                $icon='img/audio_icon.png';
                $show_list = in_array($filter_type,['all','audio'])?true:false;
            }else{
                $type='document';
                $icon='img/document_icon.png';
                $show_list = in_array($filter_type,['all','document'])?true:false;
            }

            $url=asset($current.'/'.$fileName);
            if($show_list){
                $items[]=[
                    'name'=>$fileName,
                    'type'=>'file',
                    'item_type'=>$type,
                    'format'=>$format,
                    'size'=>$sizeOf,
                    'dateFa'=>Helper::v(date('Y-m-d H:i:s',$datetime),'Y-m-d H:i:s'),
                    'dateEn'=>date('Y-m-d H:i:s',$datetime),
                    'url'=>$url,
                    'path'=>$this->clear_directory($directory.'/'.$fileName),
                    'icon'=>$type=='image'?$url:$icon,
                ];
            }
        }
        //$c=array_column($items,'dateEn');
        //array_multisort($c, SORT_ASC, $items);
        return ['result'=>1,'data'=>$items];
    }

    /*آپلود فایلها در یک دایرکتوری*/
    function file_uploader(Request $request ){
        $files=isset($_FILES['files'])?$_FILES['files']:[];
        $directory=$this->clear_directory($request->input('directory',''));
        $over_write=$request->input('over_write','no');
        $report=[];
        $complete=1;
        $list=scandir($this->full_url.'/'.$directory);
        if(count($files['name'])){
            for ($i=0;$i<count($files['name']);$i++){
                $mov_file=$directory.'/'.$files['name'][$i];
                $is_write = (!$over_write || $over_write == 'yes') && in_array($files['name'][$i],$list)?false:true;
                if($is_write){
                    $mov=move_uploaded_file($files['tmp_name'][$i],$this->full_url.'/'.$mov_file);
                    if(!$mov){
                        $complete=0;
                        $report[]=$files['error'][$i];
                    }
                }else{
                    $complete=0;
                    $report[]=$files['name'][$i];
                }
            }
        }
        if($complete){
            return ['result'=>1,'msg'=>'آپلود فایلها با موفقیت انجام شد','mm'=>$this->full_url.'/'.$mov_file];
        }
        else{
            return ['result'=>0,'msg'=>'در آپلود فابل / فایلها خطایی رخ داده','report'=>$report];
        }
    }

    /*حذف فایلها در یک دایرکتوری*/
    function files_delete(Request $request){
        $directory=$request->input('directory','/');
        $files=$request->input('files');
        foreach ($files as $item){
            if($find=glob($this->full_url.'/'.$directory.'/'.$item)){
                unlink($find[0]);
            }
        }
        return ['result'=>1,'msg'=>'درخواست با موفقیت انجام شد'];

    }

    /*ایجاد یک دایرکتوری جدید*/
    function new_directory(Request $request ){
        $validator = Validator::make($request->all(), [
            'new_folder'=>'required',
        ],[
            'new_folder.required'=>'نام پوشه جدید را وارد کنید .',
        ]);
        if ($validator->fails()) {
            return response()->json(['result'=>'0','msg'=>$validator->messages()->first()]);
        }

        $directory=$request->input('directory','/');
        $new_folder=$request->input('new_folder');

        /*یافتن پوشه ها*/
        $folderList=array_filter(glob($this->full_url.'/'.$directory.'/*'), 'is_dir');
        $folder_list=array_map(function ($a){
            $b=explode('/',$a);
            return end($b);
        },$folderList);

        if(count($folder_list) && in_array($new_folder,$folder_list)){
            return ['result'=>0,'msg'=>'پوشه هم نام در این مسیر وجود دارد'];
        }else{
            if(mkdir($this->full_url.'/'.$directory.'/'.$new_folder)) {
                return ['result'=>1,'msg'=>'پوشه جدید ایجاد شد','data'=>$folder_list];
            }else{
                return ['result'=>0,'msg'=>'خطایی در هنگام ایجاد پوشه رخ داده'];
            }
        }
    }

    /**/
    function clear_directory($directory){
        $len=strlen($directory);
        $firs_character=substr($directory,0,1);
        if($len > 0){
            if($firs_character=='/'){
                $directory=substr($directory,1,$len-1);
            }
        }else{
            $directory='';
        }
        return $directory;
    }
}
