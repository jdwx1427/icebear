<?php

namespace app\wechat\controller;

use think\facade\Db;
use think\facade\Log;
use think\facade\Request;

class WeChatMonitor
{
    public function click()
    {
        // 获取请求参数
        $wechat_unionid = Request::get('wechat_unionid');
        $campaign_id = Request::get('campaign_id');
        $ad_id = Request::get('ad_id');
        $addway = Request::get('addway');
        $advertiser_id = Request::get('advertiser_id');
        $dynamic_creative_id = Request::get('dynamic_creative_id');
        $act_type = Request::get('act_type');
        $act_time = Request::get('act_time');
        $trace_id = Request::get('trace_id');
        $adgroup_id = Request::get('adgroup_id');
        $click_time = Request::get('click_time');
        $qywx_corp_id = Request::get('qywx_corp_id');
        $add_channel = Request::get('add_channel');
        $callback = Request::get('callback');
        
        if(!$trace_id){
            return json(['ret'=>443,'msg'=>'trace_id不能为空']);
        }
        if(!$adgroup_id){
            return json(['ret'=>443,'msg'=>'adgroup_id不能为空']);
        }
        if(!$click_time){
            return json(['ret'=>443,'msg'=>'click_time不能为空']);
        }
        if(!$qywx_corp_id){
            return json(['ret'=>443,'msg'=>'qywx_corp_id不能为空']);
        }
        if(!$add_channel){
            return json(['ret'=>443,'msg'=>'add_channel不能为空']);
        }
        if(!$callback){
            return json(['ret'=>443,'msg'=>'callback不能为空']);
        }

        $params = [
            'wechat_unionid' => $wechat_unionid ?? '',
            'campaign_id' => $campaign_id ?? '',
            'ad_id' => $ad_id ?? '',
            'addway' => $addway ?? '',
            'advertiser_id' => $advertiser_id ?? '',
            'dynamic_creative_id' => $dynamic_creative_id ?? '',
            'act_type' => $act_type ?? '',
            'act_time' => $act_time ?? '',
            'trace_id' => $trace_id ?? '',
            'adgroup_id' => $adgroup_id ?? '',
            'click_time' => $click_time ?? '',
            'qywx_corp_id' => $qywx_corp_id ?? '',
            'add_channel' => $add_channel ?? '',
            'callback' => $callback ?? ''
        ];

        // 记录日志
        Log::info('Ad Click', $params);

        // 保存到数据库
        $res = Db::name('wechat')->insert($params);
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
