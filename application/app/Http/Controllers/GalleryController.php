<?php

namespace App\Http\Controllers;

use App\Helper\AccessController;
use App\Helper\Helper;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\ShopProduct;
use App\Models\ShopStore;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class GalleryController extends Controller
{
    /*دریافت همه تصاویر*/
    function galleryList(Request $request){
        $validator = Validator::make($request->all(), [
            'id'=>'required',
            'path'=>'required',
        ],[
            'id.required'=>'شناسه ای ارسال نشد',
            'path.required'=>'مسیر فایلها پیدا نشد',
        ]);
        if ($validator->fails()) {
            return ['result'=>0,'msg'=>$validator->messages()->first()];
        }
        $id=$request->input('id');
        $path=$request->input('path');
        $list=glob(basePath()."/uploads/$path/$id*.*");
        $data=[];
        foreach ($list as $item){
            $n=explode('/',$item);
            $name = end($n);
            $data[]=[
                'id'=>$name,
                'name'=>$name,
                'size'=>sizeControl(filesize($item))['title'],
                'previewUrl'=> url("/uploads/$path/$name"),
                //'downloadUrl'=> url('/uploads/amlak/'.$name),
                //'customParam'=> '123'
            ];
        }
        return ['result'=>1,'list'=>$data];
    }

    /*اپلود فایلها*/
    function galleryUpload(Request $request){
        $validator = Validator::make($request->all(), [
            'id'=>'required',
            'path'=>'required',
            'files'=>'required|array',
        ],[
            'id.required'=>'شناسه ای ارسال نشد',
            'path.required'=>'مسیر فایلها پیدا نشد',
            'files.required'=>'حد اقل یک تصویر برای اپلود انتخاب کنید',
        ]);
        if ($validator->fails()) {
            return ['result'=>0,'msg'=>$validator->messages()->first()];
        }
        $id=$request->input('id');
        $path=$request->input('path');
        $files=isset($_FILES['files'])?$_FILES['files']:[];
        $directory=basePath()."/uploads/$path";
        $report=[];
        $complete=1;
        if(isset($files['name']) && count($files['name'])){
            for ($i=0;$i<count($files['name']);$i++){
                $mov_file=$directory.'/'.$id.myRandom(7).'.'.getSuffix($files['name'][$i]);
                $mov=move_uploaded_file($files['tmp_name'][$i],$mov_file);
                if(!$mov){
                    $complete=0;
                    $report[] = $files['name'][$i];
                }
            }
        }else{
            return ['result'=>0,'msg'=>'حد اقل یک تصویر برای اپلود انتخاب کنید'];
        }
        if($complete){
            return ['result'=>1,'msg'=>'آپلود فایلها با موفقیت انجام شد'];
        }
        else{
            return ['result'=>0,'msg'=>'در آپلود فایل خطایی رخ داده','report'=>$report];
        }
    }

    /*حذف تصویر*/
    function galleryDelete(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'path'=>'required',
        ],[
            'name.required'=>'نام فایل ارسال نشد',
            'path.required'=>'مسیر فایلها پیدا نشد',
        ]);
        if ($validator->fails()) {
            return ['result'=>0,'msg'=>$validator->messages()->first()];
        }
        $name=$request->input('name');
        $path=$request->input('path');
        $list=glob(basePath()."/uploads/$path/$name");
        foreach ($list as $item){
            unlink($item);
        }
        return ['result'=>1,'msg'=>'تصویر حذف شد'];
    }

}
