<?php

namespace App\Listeners;

use App\Events\PostCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Redis;

class NotifyPostCreated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PostCreated  $event
     * @return void
     */
    public function handle()
    {
        $data=[
            'event'=>'newUser',
            'data'=>[
                'username'=>'mohammadShoja'
            ]
        ];
        Redis::publish('test-channel',json_encode($data));
        echo 'listener Run : ';
    }
}
