<?php

namespace app\common\publicnum;

use think\facade\Cache;
use think\facade\Config;

class PubSdk {

    private $appId = 'wx58740203e2b4acde';
    private $appSecret = 'c196838f3a62725f7455b36df6f70468';
    private $ticket = '';

    // 获取access_token
    public function getAccessToken() {

        // 尝试从缓存中获取 component_access_token
        $componentAccessToken = Cache::get('component_access_token');
        
        if (!$componentAccessToken) {
            $url = 'https://api.weixin.qq.com/cgi-bin/component/api_component_token';
            $data = [
                'component_appid' => $this->appId,
                'component_appsecret' => $this->appSecret,
                'component_verify_ticket' => $this->ticket
            ];

            $options = [
                'http' => [
                    'header'  => "Content-type: application/json\r\n",
                    'method'  => 'POST',
                    'content' => json_encode($data),
                ],
            ];

            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            print_r($result);die;
            $response = json_decode($result, true);

            if (isset($response['component_access_token'])) {
                $componentAccessToken = $response['component_access_token'];
                Cache::set('component_access_token', $componentAccessToken, $response['expires_in'] - 200);
            } else {
                return null;
            }
        }
        
        return $componentAccessToken;
    }

    // 获取关注者列表
    // public function getFollowerList($accessToken, $nextOpenId = '') {
    //     $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token={$accessToken}&next_openid={$nextOpenId}";
    //     $response = file_get_contents($url);
    //     return json_decode($response, true);
    // }


    
    // $weChatAPI = new WeChatAPI($appId, $appSecret);

    // $accessToken = $weChatAPI->getAccessToken();
    // $followerList = $weChatAPI->getFollowerList($accessToken);

    // echo '<pre>';
    // print_r($followerList);
    // echo '</pre>';

}