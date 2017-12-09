<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use EasyWeChat\Factory;

class WeChatController extends Controller
{
    //
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志


        $options = [
            'app_id'    => 'wxa5236a25a9fad71e',
            'secret'    => '63392096d54ca2802911f417f0ba53e7',
            'token'     => 'jiahe',
            'log' => [
                'level' => 'debug',
                'file'  => '/tmp/easywechat.log',
            ],
            // ...
        ];

        $app = Factory::officialAccount($options);

        $server = $app->server;
        $user = $app->user;

        $server->push(function($message) use ($user) {
            $fromUser = $user->get($message['FromUserName']);

            return "{$fromUser->nickname} 您好！欢迎关注 佳和超市!";
        });


        return $app->server->serve();
    }
}
