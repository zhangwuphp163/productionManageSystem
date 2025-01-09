<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class OrderMonitor
{
    public static function orderUpdate($content,$type)
    {
        $setting = DB::table('admin_settings')->where('slug','monitors')->first();
        $mobiles = ['15814770779'];
        if(!empty($setting)){
            $value = json_decode($setting->value,true);
            switch ($type){
                case '跟单':
                    $mobiles = $value['跟单'];
                    break;
                case '运营':
                    $mobiles = $value['运营'];
                    break;
                case '设计':
                    $mobiles = $value['设计'];
                    break;
            }
        }
        $client = new Client();
        $client->request('POST', "https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=db8208da-f5d6-4c32-927f-5254a4dcb69a",[
            'verify' => false,
            'json' => [
                'msgtype' => 'text',
                'text' => [
                    "content" => $content,
                    "mentioned_mobile_list" => $mobiles
                ]
            ],
            'timeout' => 30,
            'read_timeout' => 30,
            'connect_timeout' => 5,
            'headers'=>[
                'Content-Type' => 'application/json'
            ],
        ]);

    }

}
