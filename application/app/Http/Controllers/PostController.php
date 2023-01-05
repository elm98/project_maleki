<?php

namespace App\Http\Controllers;

use App\Helper\AccessController;
use App\Helper\Helper;
use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PostController extends Controller
{
    /**/
    function post_list(){
        return view('back-end.post_list');
    }

    /**/
    function post_list_dt(Request $request){
        $status=$request->input('status','all');
        $role=$request->input('role','all');
        $date1=Helper::toMiladi($request->input('date1'),'00:01:01');
        $date2=Helper::toMiladi($request->input('date2'),'23:59:59');
        $data=Post::whereNotNull('id')
            ->where(function ($q) use($status){
                return in_array($status,[null,'','all','0'])
                    ? 1
                    : $q->where('post.status',$status);
            })
            ->where(function ($q) use($date1,$date2){
                $date2=!empty($date2)?$date2:Carbon::now()->endOfDay()->toDateTimeString();
                return in_array($date1,[null,'','all','0'])
                    ? 1
                    : $q->whereBetween('post.created_at',[$date1,$date2]);
            })
            ->whereIn('post.type',['post','page'])
            ->select('post.*');
        $dt=Datatables::of($data);

        /*****************field*******************/
        $dt->addColumn('checked', '<label><input type="checkbox" name="foo[]" value="{{$id}}" class="dt-row-checkbox"><span></span></label>{{$id}}');
        $dt->editColumn('title',function ($data){
            return '<a href="'.url('/management/post-edit/'.hashId($data->id)).'">'.imageTitle('uploads/media/'.$data->img,$data->title).'</span>'.
                '<br/> <span title="'.$data->unique_title.'">'.excerpt($data->unique_title,25).'</span>';
        });
        $dt->editColumn('status',function ($data){
            return Helper::status_color($data->status,Post::status($data->status));
        });
        $dt->editColumn('type',function ($data){
            return Post::type($data->type);
        });
        $dt->editColumn('created_at',function ($data){
            return '<span class="font-small" title="'.Helper::alphaDate($data->created_at).'">'.Helper::alphaDateTime($data->created_at).'</span>';
        });
        $dt->addColumn('action', function ($data) {
            $html='<a href="'.url('/management/post-edit/'.Helper::hash($data->id)).'" title="ویرایش" class="mr-5"><i class="material-icons circle dt-icon">edit</i></a>';
            $html.='<a href="javascript:;" title="حذف" class="mr-5" onclick="helper().one_row_delete(this,'.$data->id.',\'post-delete\')"><i class="material-icons red-text circle dt-icon" >delete</i></a>';
            $html.='<a href="'.url('/management/post-copy/'.hashId($data->id)).'" title="کپی" class="mr-5" ><i class="material-icons teal-text circle dt-icon " >collections_bookmark</i></a>';
            return  $html;
        });
        return $dt->escapeColumns(null)->make(true);
    }

    /**/
    function post_add(){
        $post=new \classEmpty();
        $post->id=0;
        $post->created_at=date('Y-m-d H:i:s');
        $post->updated_at=date('Y-m-d H:i:s');
        $post->status='active';
        return view('back-end.post_edit',compact('post'));
    }

    /**/
    function post_edit($id){
        $id=Helper::unHash($id);
        $post=Post::find($id);
        if($post)
            return view('back-end.post_edit',compact('post'));
        else
            return back()->with(['error'=>'مطلبی یافت نشد']);
    }

    /**/
    function post_update(Request $request){
        $this->validate($request,[
            'id'=>'required',
            'title'=>'required|unique:post,title,'.Helper::unHash($request->input('id')),
            'status'=>'required',
        ],[
            'list.required'=>'حد اقل یک تصویر انتخاب کنید',
            'status.required'=>'وضعیت را انتخاب نمایید',
        ]);
        $id=unHashId($request->input('id'));

        $array=[
            'title'=>$request->input('title'),
            'content'=>$request->input('content',''),
            'status'=>$request->input('status'),
            'lang'=>'fa',
            'access_type'=>'public',
            'type'=>$request->input('type','post'),
            'edit_by'=>auth_info()->user_id,
        ];
        if($id==0){
            $array['created_at']=Carbon::now();
            $array['created_by']=auth_info()->user_id;
            $id=DB::table('post')->insertGetId($array);
        }else{
            $array['updated_at']=Carbon::now();
            Post::where('id',$id)->update($array);
        }



        if($id){
            $file=isset($_FILES['file'])?$_FILES['file']:null;
            if($file && $file['tmp_name']){
                deleteFile("uploads/post/".$id.'_*.*');
                $upOne = realpath(base_path() . '/..');
                $folder = $upOne . '/uploads/post';
                $postfix=explode('.',$file['name']);
                //$fileName=$id.'_'.time().'.'.end($postfix);
                $fileName=$id.'_'.$file['name'];
                $folder.='/'.$fileName;
                if(move_uploaded_file($file['tmp_name'],$folder)){
                    Post::find($id)->update(['file'=>$folder]);
                }
            }

        }




        return ['result'=>1,'msg'=>'ذخیره محتوا با موفقیت انجام شد','param'=>['id'=>Helper::hash($id)]];
    }


    /**/
    function post_delete(Request $request){
        $foo=$request->input('foo');
        if(Post::whereIn('id',$foo)->delete()){
            foreach ($foo as $id){
                deleteFile("uploads/post/$id".'_gallery_*.*');
            }
            return ['result'=>1,'msg'=>'درخواست حذف با موفقیت انجام شد'];
        }
        return ['result'=>0,'msg'=>'خطای غیر منتظره دوباره تلاش کنید'];
    }

    /**/
    function copy($id){
        $id=unHashId($id);
        $post=Post::find($id);
        if($post){
            $post->title = $post->title .' (copy)';
            $post->unique_title = '';
            $post->id = 0;
            return view('back-end.post_edit',compact('post'));
        }
        else
            return back()->with(['error'=>'مطلبی یافت نشد']);
    }


    /*************************
     CATEGORY POST
    *************************/

    /*دسته بندی درختی*/
    function portfolio_cat(Request $request){
        $type='portfolio';
        $group_id=0;
        $C=new Category();
        $data=json_encode($C->item_read(0,$type,$group_id));
        return view('back-end.portfolio_cat',compact('data','type','group_id'));
    }

    /*دسته بندی درختی*/
    function post_cat(Request $request){
        $type='post';
        $group_id=0;
        $C=new Category();
        $data=json_encode($C->item_read(0,$type,$group_id));
        return view('back-end.post_cat_list',compact('data','type','group_id'));
    }

    /*نمایش جزییات دسته از منو*/
    function post_cat_detail(Request $request){
        $id=$request->input('id');
        $data=Category::find($id);
        if($data)
            return ['result'=>1,'data'=>$data];
        else
            return ['result'=>0,'msg'=>'آیتمی شناسایی نشد'];
    }

    /*بروز رسانی جزییات دسته از منو*/
    function post_cat_detail_update(Request $request){
        $this->validate($request,[
            'id'=>'required',
            'title'=>'required'
        ]);
        $item=Category::find($request->input('id'));
        $item->img=$request->input('img','');
        $item->title=$request->input('title');
        $item->value=$request->input('value');
        if($item->save())
            return ['result'=>1,'msg'=>'درخواست انجام شد'];
        else
            return ['result'=>0,'msg'=>'خطای غیر منتظره ، دوباره امتحان کنید'];
    }

    /*خذف شاخه همراه با زیر شاخه ها*/
    function post_cat_item_delete(Request $request){
        $this->validate($request,[
            'id'=>'required|exists:categories,id',
        ]);
        $id=$request->input('id');
        $ids=Category::where('parent_id',$id)
            ->pluck('id')
            ->toArray();
        $ids[]=$id;
        if(Category::whereIn('id',$ids)->delete()){
            return ['result'=>1,'msg'=>'عملیات حذف با موفقیت انجام شد'];
        }
        return ['result'=>0,'msg'=>'خطای غیر منتظره ، دوباه تلاش کنید'];
    }

    /**/
    function add_fast_category(Request $request){
        $this->validate($request,[
            'title'=>'required',
            'type'=>'required',
            'group_id'=>'required',
        ]);
        $title=$request->input('title');
        $type=$request->input('type');
        $group_id=$request->input('group_id');
        $find=Category::where('title',$title)
            ->where('type',$type)
            ->where('group_id',$group_id)
            ->count();
        $sort=Category::where('type',$type)
            ->where('group_id',$group_id)
            ->orderby('sort','desc')
            ->limit(1)
            ->get();
        if($find)
            return ['result'=>0,'msg'=>'این عنوان تکراری است'];
        $id=Category::insertGetId([
            'title'=>$title,
            'type'=>$type,
            'group_id'=>$group_id,
            'parent_id'=>0,
            'sort'=>$sort?$sort->first()->sort + 1:1,
        ]);
        if($id)
            return ['result'=>1,'data'=>['id'=>$id]];
        return ['result'=>0,'msg'=>'خطای غیر منتظره رخ داده'];

    }


}
