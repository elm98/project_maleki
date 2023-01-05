<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    /**/
    public function basic_email(){
        $options=Option::multiValue(['blog_title']);
        $data = ['name'=>$options['blog_title']];
        Mail::send(['text'=>'mail.test'], $data, function($message) {
            $message->to('mohammadshoja65@gmail.com', 'Tutorials Point')->subject
            ('سلام دارم ارسال ایمیل لاراول رو تست میکنم');
            $message->from('xyz@gmail.com','محمد شجاع');
        });
        return "ایمیل متنی ارسال شد ، اینباکس خودتون رو بررسی کنید";
    }

    /**/
    public function html_email(){
        $data = [
            'name'=>"محمد شجاع",
            'email_hash_code'=>'salam',
        ];
        Mail::send(
            'mail.test',
            $data,
            function($message) {
                $message
                    ->to('mohammadshoja65@gmail.com', 'Tutorials Point')
                    ->subject('Laravel HTML Testing Mail')
                    ->from('xyz@gmail.com','Virat Gandhi');
            });
        return "HTML Email Sent. Check your inbox.";
    }

    /**/
    public function attachment_email(){
        $param['to']='mohammadshoja65@gmail.com';
        $data = array('name'=>"Virat Gandhi");
        Mail::send('mail.test', $data, function($message) use($param) {
            $message->to($param['to'], 'Tutorials Point')->subject
            ('Laravel Testing Mail with Attachment');
            $message->attach('C:\test\image.png');
            $message->attach('C:\test\test.txt');
            $message->from('xyz@gmail.com','Virat Gandhi');
        });
        return "Email Sent with attachment to ".$param['to'].". Check your inbox.";
    }

    /*ارسال قالب ایمیل*/
    public function send($content,$param){
        //$options=Option::multiValue(['blog_title']);
        $param['from_email'] = isset($param['from_email']) && !empty($param['from_email'])?$param['from_email']:'empty@empty.com';
        $data=['content'=>$content];
        $toList = explode(',',$param['to']);
        foreach ($toList as $to){
            Mail::send(
                'mail.temp1',
                $data,
                function($message)use ($param,$content,$to) {
                    $message
                        ->to($to, $param['to_name'])
                        ->subject($param['subject'])
                        ->from($param['from_email'],$param['from'])
                        //->cc('email@example.com', 'Mr. Example')
                        //->bcc('email@example.com', 'Mr. Example')
                        //->replyTo('email@example.com', 'Mr. Example')
                        //->attach('path/to/attachment.txt')
                        //->embed('path/to/attachment.jpg')
                    ;
                });
        }

        return 1;
    }
}
