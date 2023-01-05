<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Permission;
use App\Models\PermissionItem;
use App\Models\PermissionList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
{
    /*نمایش صفحه html*/
    function permission_source(){
        return view('back-end.permission_source');
    }

    /*لود صفحه*/
    function permission_route(){
        $routes=Route::getRoutes();
        $data=[];
        $list=[];
        $use_list=[];
        /*پیدا کردن همه روتها*/
        foreach ($routes as $item){
            $find=strpos($item->uri,'management/');
            if(is_numeric($find)){
                $list[]=str_replace('management/','',$item->uri) ;
            }
        }
        /*پیدا کردن و تمیز کردن از روتهای قبلا استفاده شده*/
        $data['group_list']=Permission::select('id','group_title','status')->get();
        $all=Permission::all();
        foreach ($all as $permission){
            $items=PermissionItem::where('permission_id',$permission->id)->get();
            foreach ($items as $row){
                foreach (explode(',',$row->routes)  as $route){
                    $use_list[]=$route;
                }
            }
        }
        $data['list']=array_diff($list,$use_list);
        return ['result'=>1,'data'=>$data];
    }

    /*انتخاب یک گروه مجوز*/
    function select_permission_group($id){
        $item=Permission::find($id);
        //return $item->items;
        $group_select['group_title']=$item->status?$item->group_title . '(فعال)':$item->group_title . '(غیر فعال)';
        $group_select['group_status']=$item->status;
        $q=PermissionItem::where('permission_id',$item->id)->select('id','title','routes')->get();
        $items = collect($q)->map(function ($a){
            $arr['title']=$a['title'];
            $arr['routes']=explode(',',$a['routes']) ;
            $arr['id']=$a['id'] ;
            $arr['status']=$a['status'] ;
            return $arr;
        });
        $group_select['items']=$q->count()?$items:[];
        return ['result'=>1,'data'=>$group_select];
    }

    /*افزودن گروه مجوز*/
    function permission_new_group(Request $request){
        $validator = Validator::make($request->all(), [
            'group_title'=>'required|unique:permission,group_title',
        ],[
            'group_title.required'=>'نام گروه مجوز را وارد کنید',
            'group_title.unique'=>'لطفا از نام تکراری استفاده نکنید',
        ]);
        if ($validator->fails()) {
            return response()->json(['result'=>0,'msg'=>$validator->messages()->first()]);
        }

        $insert=Permission::insertGetId([
            'group_title'=>$request->input('group_title'),
            //'items'=>json_encode([['title'=>'مسیر تازه','routes'=>[]]])
        ]);
        if($insert){
            return ['result'=>1,'id'=>$insert];
        }
        return ['result'=>0,'msg'=>'خطای غیر منتظره رخ داده'];

    }

    /*افزودن مسیر در گروه*/
    function permission_new_subGroup(Request $request){
        $validator = Validator::make($request->all(), [
            'title'=>'required',
            'group_id'=>'required|exists:permission,id'
        ],[
            'title.required'=>'عنوان را انتخاب کنید',
            'group_id.required'=>'هیچ گروه مجوزی انتخاب نشده',
            'group_id.exists'=>'گروه مجوز انتخاب شده معتبر نیست'
        ]);
        if ($validator->fails()) {
            return response()->json(['result'=>0,'msg'=>$validator->messages()->first()]);
        }
        $title=$request->input('title');
        $permission_id=$request->input('group_id');
        $items=PermissionItem::where('permission_id',$permission_id)->get();
        $unique=[];
        foreach ($items as $row){
            $unique[]=$row->title;
        }
        if(in_array($title,$unique)){
            return ['result'=>0,'msg'=>'این مجوز برای این گروه قبلا انتخاب شده'];
        }

        $newItems=[
            'permission_id'=>$permission_id,
            'title'=>$title,
            'routes'=>'',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ];
        //$permission->items = $items;
        if($newId=PermissionItem::insertGetId($newItems)){
            return ['result'=>1,'data'=>['new_id'=>$newId]];
        }
        return ['result'=>0,'msg'=>'خطای غیر منتظره رخ داده'];
    }

    /**/
    function permission_insert_route(Request $request){
        $validator = Validator::make($request->all(), [
            'subGroup_title'=>'required',
            'group_id'=>'required|exists:permission,id',
            'routes'=>'required|array',
            'item_id'=>'required',
        ],[
            'subGroup_title.required'=>'عنوان را انتخاب کنید',
            'group_id.required'=>'هیچ گروه مجوزی انتخاب نشده',
            'group_id.exists'=>'گروه مجوز انتخاب شده معتبر نیست'
        ]);
        if ($validator->fails()) {
            return response()->json(['result'=>0,'msg'=>$validator->messages()->first()]);
        }
        $routes=$request->input('routes');
        $item=PermissionItem::find($request->input('item_id'));
        if($item){
            $old_routes=explode(',',$item->routes);
            $new_routes = array_merge($old_routes,$routes);
            $new_routes = array_unique($new_routes);
            $new_routes = array_filter(array_map('trim',array_filter($new_routes)));
            $item->routes = implode(',',$new_routes);
            if($item->save()){
                return ['result'=>1,'msg'=>'درج مسیر های جدید انجام شد'];
            }
        }
        return ['result'=>0,'msg'=>'خطای غیر منتظره رخ داده'];
    }

    /**/
    function permission_delete_route(Request $request){
        $validator = Validator::make($request->all(), [
            'subGroup_title'=>'required',
            'group_id'=>'required|exists:permission,id',
            'route'=>'required',
            'item_id'=>'required',
        ],[
            'subGroup_title.required'=>'عنوان را انتخاب کنید',
            'group_id.required'=>'هیچ گروه مجوزی انتخاب نشده',
            'group_id.exists'=>'گروه مجوز انتخاب شده معتبر نیست'
        ]);
        if ($validator->fails()) {
            return response()->json(['result'=>0,'msg'=>$validator->messages()->first()]);
        }
        $route=$request->input('route');
        $item=PermissionItem::find($request->input('item_id'));
        if($item){
            $new_routes=[];
            foreach (explode(',',$item->routes) as $r){
                if($r != $route){
                    $new_routes[]=$r;
                }
            }
            $item->routes = trim(implode(',',$new_routes));
            if($item->save()){
                return ['result'=>1,'msg'=>'حذف مسیر انجام شد'];
            }
        }
        return ['result'=>0,'msg'=>'خطای غیر منتظره رخ داده'];
    }

    /**/
    function permission_delete_subGroup(Request $request){
        $validator = Validator::make($request->all(), [
            'subGroup_title'=>'required',
            'group_id'=>'required|exists:permission,id',
            'item_id'=>'required',
        ],[
            'subGroup_title.required'=>'عنوان را انتخاب کنید',
            'group_id.required'=>'هیچ گروه مجوزی انتخاب نشده',
            'group_id.exists'=>'گروه مجوز انتخاب شده معتبر نیست'
        ]);
        if ($validator->fails()) {
            return response()->json(['result'=>0,'msg'=>$validator->messages()->first()]);
        }
        if(PermissionItem::where('id',$request->input('item_id'))->delete()){
            return ['result'=>1,'msg'=>'حذف زیر گروه انجام شد'];
        }
        return ['result'=>0,'msg'=>'خطای غیر منتظره رخ داده'];
    }

    /**/
    function permission_delete_group(Request $request){
        $validator = Validator::make($request->all(), [
            'group_id'=>'required|exists:permission,id',
        ],[
            'group_id.required'=>'هیچ گروه مجوزی انتخاب نشده',
            'group_id.exists'=>'گروه مجوز انتخاب شده معتبر نیست'
        ]);
        if ($validator->fails()) {
            return response()->json(['result'=>0,'msg'=>$validator->messages()->first()]);
        }
        $permission_id=$request->input('group_id');
        if(Permission::where('id',$permission_id)->delete()){
            PermissionItem::where('permission_id',$permission_id)->delete();
            return ['result'=>1,'msg'=>'حذف گروه انجام شد'];
        }
        return ['result'=>0,'msg'=>'خطای غیر منتظره رخ داده'];
    }

    /**/
    function permission_status_group(Request $request){
        $validator = Validator::make($request->all(), [
            'group_id'=>'required|exists:permission,id',
        ],[
            'group_id.required'=>'هیچ گروه مجوزی انتخاب نشده',
            'group_id.exists'=>'گروه مجوز انتخاب شده معتبر نیست'
        ]);
        if ($validator->fails()) {
            return response()->json(['result'=>0,'msg'=>$validator->messages()->first()]);
        }
        $permission_id=$request->input('group_id');
        $p = Permission::find($permission_id);
        $p->status = !$p->status;
        if($p->save()){
            return ['result'=>1,'status'=>$p->status,'msg'=>'وضعیت گروه مجوز تغییر کرد'];
        }
        return ['result'=>0,'msg'=>'خطای غیر منتظره رخ داده'];
    }

    /**/
    function permission_list(){
        return view('back-end.permission_list');
    }

    /*لیست مجوزهای ساخته شده*/
    function permission_list_dt(Request $request){

        $data=PermissionList::select('permission_list.*');
        $dt=Datatables::of($data);

        /*****************field*******************/
        $dt->addColumn('checked', '<label><input type="checkbox" name="foo[]" value="{{$id}}" class="dt-row-checkbox"><span></span></label>');
        $dt->editColumn('username',function ($data){
            return '<div class="chip black-text "><img src="'.Helper::getAvatar($data->avatar).'"> '.$data->username.'<span></span></div>';
        });
        $dt->editColumn('created_at',function ($data){
            return '<span class="font-small" title="'.Helper::alphaDate($data->created_at).'">'.Helper::alphaDate2($data->created_at).'</span>';
        });
        $dt->addColumn('action', function ($data) {
            $html='<a href="'.url('/management/permission-edit/'.Helper::hash($data->id)).'" title="ویرایش" class="mr-5"><i class="material-icons circle dt-icon">edit</i></a>';
            $html.='<a href="javascript:;" title="حذف" class="mr-5" onclick="helper().one_row_delete(this,'.$data->id.',\'permission-delete\')"><i class="material-icons red-text circle dt-icon" >delete</i></a>';
            return  $html;
        });
        return $dt->escapeColumns(null)->make(true);
    }

    /**/
    function permission_add(){
        $listDt=Permission::where('status',1)->orderby('id','asc')->get();
        $list=[];
        foreach ($listDt as $row){
            $list[]=[
                'id'=>$row->id,
                'title'=>$row->group_title,
                'items'=>PermissionItem::where('permission_id',$row->id)->get()
            ];
        }
        $data=(object)[
            'id'=>0,
            'title'=>'',
            'items'=>"[]",
            'array_items'=>[],
        ];
        return view('back-end.permission_edit',compact('list','data'));
    }

    /**/
    function permission_edit($id){
        $listDt=Permission::where('status',1)->orderby('id','asc')->get();
        $list=[];
        foreach ($listDt as $row){
            $list[]=[
                'id'=>$row->id,
                'title'=>$row->group_title,
                'items'=>PermissionItem::where('permission_id',$row->id)->get()
            ];
        }
        $data=PermissionList::find(Helper::unHash($id));
        if($data){
            $arr=json_decode($data->items);
            $data->array_items=empty($arr)?[]:$arr;
            return view('back-end.permission_edit',compact('list','data'));
        }
        return redirect()->back()->with(['error'=>'فهرست مجوزها شناسایی نشد']);
    }

    /**/
    function permission_update(Request $request){
        $validate=Validator::make($request->all(),[
            'title'=>'required',
            'foo'=>'required|array'
        ],[
            'title.required'=>'عنوان را وارد کنید',
            'foo.required'=>'شما هیچ گزینه ای را تیک نزدید'
        ]);

        if ($validate->fails()){
            return response()->json(['result'=>0,'msg'=>$validate->messages()->first()]);
        }
        $id=Helper::unHash($request->input('id'));
        $title=$request->input('title');
        $string=implode('|',$request->input('foo'));
        $items=explode('|',$string);
        $data=[
            'title'=>$request->input('title'),
            'items'=>json_encode($items),
            'updated_at'=>Carbon::now()
        ];
        if($id > 0){
            $find=PermissionList::where('title',$title)
                ->whereNotIn('id',[$id])
                ->count();
            if($find){
                return ['result'=>0,'msg'=>'عنوان تکراری است'];
            }
            PermissionList::find($id)->update($data);
        }else{
            $find=PermissionList::where('title',$title)
                ->count();
            if($find){
                return ['result'=>0,'msg'=>'عنوان تکراری است'];
            }
            PermissionList::insert($data);
        }
        return ['result'=>1,'msg'=>'درخواست با موفقیت انجام شد'];
    }

    /**/
    function permission_delete(Request $request){
        $foo=$request->input('foo',[]);
        if(PermissionList::whereIn('id',$foo)->delete()){
            return ['result'=>1,'msg'=>'درخواست با موفقیت انجام شد'];
        }else{
            return ['result'=>0,'msg'=>'خطایی رخ داده ، دوباره تلاش کنید'];
        }
    }
}
