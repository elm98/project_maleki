<?php
session_start();
require_once '../../../config.php';
require_once '../setting-new.php';
/*--- get action ---*/
$action=$filter->post('action');

switch($action)
{
    case 'showlist':
    case 'serchlist':
    header("Content-Type: application/json");
    echo json_encode(paging($action));
    break;
    
    case 'insert':
    echo insert();
    break;
    
    case 'update':
    echo update();
    break;
    
    case 'item-edit':
    echo item_edit();
    break;
    
    
    case 'add-menu-group':
    $message=add_menu_group();
    $array=paging();
    $array['message']=$message;
    header("Content-Type: application/json");
    echo json_encode($array);
    break;
    
    
    case 'delete':
    $message=delete();
    $array=paging();
    $array['message']=$message;
    header("Content-Type: application/json");
    echo json_encode($array);
    break;
}






/*******************************
           FUNCTION
*******************************/



/**** update ****/
function update()
{
    global $filter;
    $message="";
    $flag=true;
    $menuid=$filter->post('menuid',0);// دریافت ای دی دسته
    $output_json=stripcslashes($_POST['nestable-output']); // رشته جیسون حاوی ای دی و وابستگی ها
    $d=json_decode($output_json);//var_dump($d);
    
    $menu_ids=menu_update($d,$menuid); // بروزرسانی منو از گروه مشخص
    $menu_ids=rtrim($menu_ids,',');
    delete_items($menu_ids,$menuid); // حذف ایتمهایی که دستور حذف انها داده شده
    
    if($flag)$message=message::success('ویرایش منو با موفقیت انجام شد'.' <a href="">برای نمایش تغییرات کلیک کنید</a>');
    else $message::alert('بروز رسانی منو ناقص مانده ، لطفا مجددا تلاش نمایید');
    
    
    return $message;    
}


// پردازش متن خروجي جیسون براي  درج در ديتا بيس
// $menu : رشته جیسون حاوی تمام ایدی و وابستگی ها
// $menuid : ای دی دسته یا گروه این منو
// $parent : ای دی منوی والد
// $menu_ids : رشته ای که حاوی اختلاف ای دی منوهابرای حذف میباشد
function menu_update($menu,$menuid,$parent=0,$menu_ids="")
{
    global $flag;
    if(is_array($menu) && count($menu)>0)
    {
       foreach ($menu as $handle)
       {
           if(isset($handle->children))
           {
               $menu_ids.=$handle->id.',';
               if(existitem($handle->id,$menuid))
               {
                    if(!edititem($handle->id,$parent,$menuid))
                    {
                        //echo 'ویرایش آیتم شکست خورد';
                        $flag=false;
                    }
               }
               else
               {
                    if(!insertitem($handle->id,$parent,$menuid))
                    {
                        //echo 'افزودن آیتم جدید شکست خورد';
                        $flag=false;
                    }
               }
               $menu_ids=menu_update($handle->children,$menuid,$handle->id,$menu_ids); 
           }
           else if(isset($handle->id))
           {
               $menu_ids.=$handle->id.',';
               if(existitem($handle->id,$menuid))
               {
                    if(!edititem($handle->id,$parent,$menuid))
                    {
                        //echo 'ویرایش آیتم شکست خورد';
                        $flag=false;
                    }
               }
               else
               {
                    if(!insertitem($handle->id,$parent,$menuid))
                    {
                        //echo 'افزودن آیتم جدید شکست خورد';
                        $flag=false;
                    }
               }
           }
       }
    }
    return $menu_ids;
}


function existitem($id,$mid)
{
    $menu=new menu();
    $count=$menu->count("where id=$id AND mid=$mid");
    if($count > 0)return true;
    return false;
}

function edititem($id,$parent,$mid)
{
    $menu=new menu();
    $where="where id=$id AND mid=$mid";
    if($menu->update(array('parent'=>$parent),$where))return true;
    return false;
}

function insertitem($id,$parent,$mid)
{
    $menu=new menu();
    $insert=$menu->insert(array(
    'id'=>$id,
    'parent'=>$parent,
    'mid'=>$mid,
    'link'=>siteurl));
    if($insert)return true;
    else
    {
        echo 'no insert';
        return false;
    }
}

function delete_items($ids,$mid)
{
    $menu=new menu();
    $continu=empty($ids)?false:true;
    $return=true;
    if($continu)
    {
        $delete=$menu->delete("where (id NOT IN($ids)) AND mid=$mid");
        if(!$delete)
        {
            echo 'no deleted item';
            $return=false;
        }
    }
    return $return;
}



/*** بروز رسانی مشخصات یک ایتم منو ***/
function item_edit()
{
    global $filter;
    $menu=new menu();
    
    $idkey=$filter->post('idkey',0);
    $title=$filter->post('title');
    $link=$filter->post('link');
    $img=$filter->post('img');
    
    $continu=true;
    $message="هیچ عملیاتی انجام نشد";
    
    if($idkey==0)
    {
        $continu=false;
        $message='منو برای ویرایش شناسایی نشد';
    }
    
    if($continu)
    {
        $update=$menu->update(array(
        'title'=>$title,
        'link'=>$link,
        'img'=>$img),"where idkey=$idkey");
        if($update)$message=message::success('بروز رسانی آیتم منو انجام شد');
        else $message=message::alert('متاسفانه خطایی رخ داده ، دوباره تلاش کنید');
    }
    return $message;
}





/**** ایجاد دسته منوی جدید ****/
function add_menu_group()
{
    $menulist=new menulist();
    global $filter;
    $message=message::alert('هیچ عملیاتی صورت نگرفته');
    $title=$filter->post('title');
    $name=$filter->post('name');
    $continu=true;
    if(empty($title) || empty($name))
    {
        $continu=false;
        $message=message::alert('عنوان و یا نام منو نباید خالی باشد');
    }
    
    if($menulist->similar('name',$name))
    {
        $continu=false;
        $message=message::alert('منویی با این نام قبلا ثبت شده');
    }
    
    if($continu)
    {
        $insert=$menulist->insert(array(
        'title'=>$title,
        'name'=>$name));
        
        if($insert)$message=message::success('منوی جدید ایجاد شد');
        else $message=message::alert('در ثبت منو خطایی رخ داده لطفا دوباره تلاش کنید');
    }
    return $message;
}







/**** Delete ****/
function delete()
{
    $menulist=new menulist();
    $menu=new menu();
    global $filter;
    $message=message::alert('هیچ عملیاتی صورت نگرفته');
    $foo=$filter->post_array('foo');
    $listid=implode(',',$foo);
    
    if($menu->delete("where mid in ($listid)"))
    {
        if($menulist->delete("where id in($listid)")) 
        {
            $message=message::success('موارد انتخابی حذف شد');
        }
    }
    
    return $message;
}


/**** صفحه یندی ****/
function paging($action='showlist')
{
    global $pagination;
    global $option;
    global $filter;
    $menulist = new menulist();
    
    
    /*--- varible ---*/
    $pagenumber=$filter->post('pagenumber',1);
    if($action=='serchlist')
    {
        $serchitem_title=$filter->post('serchitem_title');
        $_SESSION['post']['serchitem_title']=!empty($serchitem_title)?"title like '%$serchitem_title%'":1;
    }
    /*--- ایجاد شرط جستجو ---*/
    $s1=isset($_SESSION['post']['serchitem_title'])?$_SESSION['post']['serchitem_title']:1;
    $where="where $s1 "; // شرط جستجو
    
    $allitem=$menulist->count($where); // شمارش تمام محتوا با در نظر گرفتن شرط جستجو
    $pagination->perpage=$option->perpage;
    $pagination->perbtn=$option->perbtn;
    $start=$pagination->limit($pagenumber);
    $where.=" LIMIT :start , :limit";
    $bind[':start']=$start;$bind[':limit']=$option->perpage;
    
    $fetch=$menulist->select($where,$bind); // دریافت محتوا بر اساس محدوده مشخص شده بررای نمایش
    /*--- تولید محتوا ---*/
    $content='';
    foreach($fetch as $row)
    {
        $content.='
        <tr>
            <td><input type="checkbox" class="child" value="'.$row['id'].'" name="foo[]" /></td>
            <td>'.$row['id'].'</td>
            <td>'.$row['title'].'</td>
            <td>'.$row['name'].'</td>
            <td><a href="?p=menu-edit&menuid='.$row['id'].'">نمایش</a></td>
        </tr>';
    }
    $return['content']=$content;
    
    /*-- ایجاد دکمه ها --*/
    $btn=$pagination->btn($allitem,$pagenumber);
    $return['btn']=$pagination->echobtn($btn['start'],$btn['end'],$allitem,$pagenumber);
    $return['bind']='start='.$start;
    return $return;
}

?>