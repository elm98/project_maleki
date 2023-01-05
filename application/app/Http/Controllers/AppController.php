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
use Yajra\DataTables\DataTables;

class AppController extends Controller
{
    /*جستجوی در بین منوهای اصلی*/
    function search_menu(Request $request){
        $term=$request->input('term','');
        $list=AccessController::search_menu($term);
        $list=empty($list)?'<li class="w-100"><a href="javascript::void(0)">هیچ منویی برای شما پیدا نشد</a></li>':$list;
        return ['result'=>1,'data'=>$list];
    }

    /*جستجوی مطالب*/
    function find_post(Request $request){
        $term=$request->input('q','');
        $data=[];
        $list=Post::where('title','LIKE','%'.$term.'%')
            ->select('id','title','img')
            ->get(100);
        foreach ($list as $item){
            $data['items'][]=[
                'id'=>$item->id,
                'img'=>Helper::getApiImg($item->img),
                'text'=>$item->title,
                //'text2'=>$item->title,
                //'text3'=>$item->title,
            ];
        }
        $count=$list->count();
        $data['total_count']=$count;
        $data['incomplete_results']=$count?true:false;
        $data['items']=$count?$data['items']:[];
        return $data;
    }

    /*جستجوی دسته ها*/
    function find_cat(Request $request){
        $term=$request->input('q','');
        $data=[];
        $list=Category::leftJoin('categories as parent','parent.id','categories.parent_id')
            ->where('categories.title','LIKE','%'.$term.'%')
            ->select('categories.id'
                ,'categories.title'
                ,'categories.img'
                ,'parent.title as parent_title'
            )
            ->get(100);
        foreach ($list as $item){
            $data['items'][]=[
                'id'=>$item->id,
                'img'=>Helper::getApiImg($item->img),
                'text'=>$item->title,
                'text2'=>'والد : '.$item->parent_title,
            ];
        }
        $count=$list->count();
        $data['total_count']=$count;
        $data['incomplete_results']=$count?true:false;
        $data['items']=$count?$data['items']:[];
        return $data;
    }

    /*جستجوی دیدگاه*/
    function find_comment(Request $request){
        $term=$request->input('q','');
        $data=[];
        $list=Comment::where('content','LIKE','%'.$term.'%')
            ->select('id','content','parent_id')
            ->get(100);
        foreach ($list as $item){
            $is_replay=$item->parent_id > 0 ?'<span class="font-very-small blue-text">درجواب یک دیدگاه :</span>':'';
            $data['items'][]=[
                'id'=>$item->id,
                'img'=>Helper::getApiAvatar(''),
                'text'=>$is_replay.Helper::excerpt($item->content,25).'...',
            ];
        }
        $count=$list->count();
        $data['total_count']=$count;
        $data['incomplete_results']=$count?true:false;
        $data['items']=$count?$data['items']:[];
        return $data;
    }

    /*جستجوی کاربر*/
    function find_user(Request $request){
        $term=$request->input('q','');
        $data=[];
        $list=User::where('nickname','LIKE','%'.$term.'%')
            ->orWhere('username','LIKE','%'.$term.'%')
            ->orWhere('mobile','LIKE',$term.'%')
            ->select('id','nickname','mobile','username')
            ->get(100);
        foreach ($list as $item){
            $is_replay=$item->parent_id > 0 ?'<span class="font-very-small blue-text">درجواب یک دیدگاه :</span>':'';
            $data['items'][]=[
                'id'=>Helper::hash($item->id),
                'img'=>Helper::getApiAvatar(''),
                'text'=>$item->nickname .' - '. $item->mobile,
                'text2'=>$item->username,
            ];
        }
        $count=$list->count();
        $data['total_count']=$count;
        $data['incomplete_results']=$count?true:false;
        $data['items']=$count?$data['items']:[];
        return $data;
    }

    /*یافتن دسته ها و زیر دسته ها جیسون*/
    function get_cat(Request $request){
        $this->validate($request,[
            'type'=>'required',
        ],[
            'type.required'=>'نوع دسته بندی را مشخص کنید',
        ]);
        $type=$request->input('type');
        $parent_id=$request->input('parent_id',0);
        return ['result'=>1,'data'=>Category::get_cat($type,$parent_id)];
    }

    /*یافتن دسته ها و زیر دسته ها صورت html*/
    function get_cat_html(Request $request){
        $this->validate($request,[
            'type'=>'required',
        ],[
            'type.required'=>'نوع دسته بندی را مشخص کنید',
        ]);
        $type=$request->input('type');
        $parent_id=$request->input('parent_id',0);
        return ['result'=>1,'data'=>Category::get_cat_html($type,$parent_id)];
    }

    /*جستجوی نمایند گان املاک*/
    function find_rs_agent(Request $request){
        $term=$request->input('q','');
        $data=[];
        $list=User::whereIn('role',['rs_agent','administrator'])
            ->where(function($q) use($term){
                return $q->where('nickname','LIKE','%'.$term.'%')
                    ->orWhere('username','LIKE','%'.$term.'%')
                    ->orWhere('mobile','LIKE',$term.'%');
            })
            ->select('id','nickname','mobile','username')
            ->get(100);
        foreach ($list as $item){
            $is_replay=$item->parent_id > 0 ?'<span class="font-very-small blue-text">درجواب یک دیدگاه :</span>':'';
            $data['items'][]=[
                'id'=>Helper::hash($item->id),
                'img'=>Helper::getApiAvatar(''),
                'text'=>$item->nickname .' - '. $item->mobile,
                'text2'=>$item->username,
            ];
        }
        $count=$list->count();
        $data['total_count']=$count;
        $data['incomplete_results']=$count?true:false;
        $data['items']=$count?$data['items']:[];
        return $data;
    }

    /*جستجوی محصولات*/
    function find_product(Request $request){

        $term=$request->input('q','');
        $term=empty($term)?'-1':$term;
        $data=[];
        $list=ShopProduct::leftJoin('categories as cat',function ($q){
                return $q->orWhereRaw("FIND_IN_SET(ms011_cat.id,ms011_shop_products.cats)");
            })
            ->where('shop_products.title','LIKE','%'.$term.'%')
            ->groupby('shop_products.id')
            ->select(
                'shop_products.id'
                ,'shop_products.title'
                ,'shop_products.img'
            )
            ->selectRaw("GROUP_CONCAT(ms011_cat.title separator '|') as cat_titles")
            ->orderby('shop_products.created_at','desc')
            ->get(100);
        foreach ($list as $item){
            $data['items'][]=[
                'id'=>Helper::hash($item->id),
                'rawId'=>$item->id,
                'img'=>url($item->img),
                'link'=>getLink('product',$item),
                'text'=>$item->title ,
                'text2'=>excerpt($item->cat_titles,40),
                'text3'=>$item->cat_titles,
            ];
        }
        $count=$list->count();
        $data['total_count']=$count;
        $data['incomplete_results']=$count?true:false;
        $data['items']=$count?$data['items']:[];
        return $data;
    }

    /*جستجوی محصولات*/
    function find_store(Request $request){
        $term=$request->input('q','');
        $data=[];
        $list=ShopStore::leftJoin('categories as cat','cat.id','shop_store.cat_id')
            ->where('shop_store.title','LIKE','%'.$term.'%')
            ->select(
                'shop_store.id'
                ,'shop_store.title'
                ,'cat.title as cat_title'
                ,'shop_store.img'
            )
            ->get(100);
        foreach ($list as $item){
            $data['items'][]=[
                'id'=>Helper::hash($item->id),
                'img'=>url('uploads/shop/'.$item->img),
                'text'=>$item->title ,
                'text2'=>'دسته فروشگاه : '.$item->cat_title,
            ];
        }
        $count=$list->count();
        $data['total_count']=$count;
        $data['incomplete_results']=$count?true:false;
        $data['items']=$count?$data['items']:[];
        return $data;
    }

    /*بک آپ گرفتن از دیتا بیس*/
    function export_database($tables=false, $backup_name=false)
    {
        $host = env('DB_HOST');
		$user = env('DB_USERNAME');
		$pass = env('DB_PASSWORD');
		$name = env('DB_DATABASE');
        set_time_limit(3000);
        $mysqli = new \mysqli($host,$user,$pass,$name);
        $mysqli->select_db($name); $mysqli->query("SET NAMES 'utf8'");
        $queryTables = $mysqli->query('SHOW TABLES');
        while($row = $queryTables->fetch_row())
        { $target_tables[] = $row[0]; }
        if($tables !== false)
        { $target_tables = array_intersect( $target_tables, $tables); }
        $content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `".$name."`\r\n--\r\n\r\n\r\n";
        foreach($target_tables as $table){
            if (empty($table)){ continue; }
            $result	= $mysqli->query('SELECT * FROM `'.$table.'`');
            $fields_amount=$result->field_count;
            $rows_num=$mysqli->affected_rows;
            $res = $mysqli->query('SHOW CREATE TABLE '.$table);
            $TableMLine=$res->fetch_row();
            $content .= "\n\n".$TableMLine[1].";\n\n";
            $TableMLine[1]=str_ireplace('CREATE TABLE `','CREATE TABLE IF NOT EXISTS `',$TableMLine[1]);
            for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) {
                while($row = $result->fetch_row())	{ //when started (and every after 100 command cycle):
                    if ($st_counter%100 == 0 || $st_counter == 0 ){
                        $content .= "\nINSERT INTO ".$table." VALUES";
                    }
                    $content .= "\n(";
                    for($j=0; $j<$fields_amount; $j++){
                        $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) );
                        if (isset($row[$j])){
                            $content .= '"'.$row[$j].'"' ;
                        }else{$content .= '""';}
                        if ($j<($fields_amount-1)){$content.= ',';}
                    }
                    $content .=")";
                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) {
                        $content .= ";";
                    } else {$content .= ",";}
                    $st_counter=$st_counter+1;
                }
            } $content .="\n\n\n";
        }
        $content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
        $backup_name = $backup_name ? $backup_name : $name.'___('.vv(time(),'Y-m-d').'_'.date('H-i-s').').sql';
        //save file----------------------
        $path = basePath().'/data/database-backup';
        $file_list=glob($path.'/'.$name.'___*.*');
        if(count($file_list) > 25){
            sort($file_list);
            unlink($file_list[0]);
        }
        $handle = fopen($path.'/'.$backup_name,'w+');
        if(fwrite($handle,$content))
        {
            fclose($handle);
            $absolute_path=explode(DIRECTORY_SEPARATOR,$path);
            $msg= 'پشتیبان گیری با موفقیت انجام شد ';
            return ['result'=>1,'msg'=>$msg];
        }
        return ['result'=>0,'msg'=>'عملیات شکست خورد مجددا تلاش نمایید'];

        //----------ارسال مستقیم و بلافاصله فایل برای دانلود بعد از ایجاد----------
        /*ob_get_clean();
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header('Content-Length: '. (function_exists('mb_strlen') ? mb_strlen($content, '8bit'): strlen($content)) );
        header("Content-disposition: attachment; filename=\"".$backup_name."\"");
        echo $content;
        exit;*/
    }

    /*ایمپورت کردن دیتابیس*/
    function import_database(Request $request){
        $sql_file_OR_content  = basePath().'/data/database-backup/'.$request->input('filename','');
        if(file_exists($sql_file_OR_content)){
            $host = env('DB_HOST');
            $user = env('DB_USERNAME');
            $pass = env('DB_PASSWORD');
            $dbname = env('DB_DATABASE');
            set_time_limit(3000);
            $SQL_CONTENT = (strlen($sql_file_OR_content) > 300 ?  $sql_file_OR_content : file_get_contents($sql_file_OR_content) );
            $allLines = explode("\n",$SQL_CONTENT);
            $mysqli = new \mysqli($host, $user, $pass, $dbname);
            if (mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();}
            $zzzzzz = $mysqli->query('SET foreign_key_checks = 0');
            preg_match_all("/\nCREATE TABLE(.*?)\`(.*?)\`/si", "\n". $SQL_CONTENT, $target_tables);
            foreach ($target_tables[2] as $table){
                $mysqli->query('DROP TABLE IF EXISTS '.$table);
            }
            $zzzzzz = $mysqli->query('SET foreign_key_checks = 1');
            $mysqli->query("SET NAMES 'utf8'");
            $templine = '';	// Temporary variable, used to store current query
            foreach ($allLines as $line){
                // Loop through each line
                if (substr($line, 0, 2) != '--' && $line != '') {
                    $templine .= $line; 	// (if it is not a comment..) Add this line to the current segment
                    if (substr(trim($line), -1, 1) == ';') {
                        // If it has a semicolon at the end, it's the end of the query
                        if(!$mysqli->query($templine)){
                            print('Error performing query \'<strong>' . $templine . '\': ' . $mysqli->error . '<br /><br />');
                        }
                        $templine = ''; // set variable to empty, to start picking up the lines after ";"
                    }
                }
            }
            return ['result'=>1,'msg'=>'درون ریزی فایل بک آپ انجام شد'];
        }else{
            return ['result'=>0,'msg'=>'فایل بک آپ پیدا نشد'];
        }
    }




}
