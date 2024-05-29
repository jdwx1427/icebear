<?php

namespace app\publicnum\controller;

use think\facade\Db;
use think\facade\Log;
use think\facade\Request;

class pubMonitor
{
    public function click()
    {
        // 获取请求参数
        $trace_id = Request::get('trace_id');
        $wechat_openid = Request::get('wechat_openid');
        $adgroup_id = Request::get('adgroup_id');
        $act_time = Request::get('act_time');
        $campaign_id = Request::get('campaign_id');
        $ad_id = Request::get('ad_id');
        $wechat_account_id = Request::get('wechat_account_id');
        $position_id = Request::get('position_id');
        $advertiser_id = Request::get('advertiser_id');
        $device_os_type = Request::get('device_os_type');
        $shared_ad = Request::get('shared_ad');
        $dynamic_creative_id = Request::get('dynamic_creative_id');
        $callback = Request::get('callback');
        
        if(!$trace_id){
            return json(['ret'=>443,'msg'=>'trace_id不能为空']);
        }
        if(!$adgroup_id){
            return json(['ret'=>443,'msg'=>'adgroup_id不能为空']);
        }
        if(!$act_time){
            return json(['ret'=>443,'msg'=>'act_time不能为空']);
        }
        if(!$callback){
            return json(['ret'=>443,'msg'=>'callback不能为空']);
        }

        $params = [
            'trace_id' => $trace_id ?? '',
            'wechat_openid' => $wechat_openid ?? '',
            'adgroup_id' => $adgroup_id ?? '',
            'act_time' => $act_time ?? '',
            'campaign_id' => $campaign_id ?? '',
            'ad_id' => $ad_id ?? '',
            'wechat_account_id' => $wechat_account_id ?? '',
            'position_id' => $position_id ?? '',
            'advertiser_id' => $advertiser_id ?? '',
            'device_os_type' => $device_os_type ?? '',
            'shared_ad' => $shared_ad ?? '',
            'dynamic_creative_id' => $dynamic_creative_id ?? '',
            'callback' => $callback ?? ''
        ];

        // 记录日志
        Log::info('pubMonitor ----- Ad Click', $params);

        // 保存到数据库
        $res = Db::name('publicnum')->insert($params);
        if(!$res){
            return json(['ret' => 0,'msg'=>$res]);
        }

        // 返回响应
        return json(['ret' => 0,'msg'=>'success']);
    }



    // protected function sendAttributionData($data)
    // {
    //     // 回传归因数据到广告平台
    //     $url = 'https://api.ad-platform.com/attribution'; // 替换为实际的广告平台回传 URL
    //     $postData = json_encode($data);

    //     $ch = curl_init($url);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    //     $response = curl_exec($ch);
    //     $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //     curl_close($ch);

    //     // 记录回传结果
    //     Log::info('Attribution Response', ['response' => $response, 'http_code' => $httpCode]);
    // }
}
