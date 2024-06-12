<?php

namespace app\publicnum\controller;

use app\common\lib\pubticket\WXBizMsgCrypt;
use app\common\publicnum\PubSdk;
use think\facade\Cache;
use think\facade\Config;
use think\facade\Log;
use think\facade\Request;

class PubUsers
{
    public function getTicket()
    {

        $a = 10;
        $b = 20;
        $c = $a + $b;
        echo $c;


        die;

        
        // $token = Config::get('publicnumconfig.token');
        // $aes_key = Config::get('publicnumconfig.aes_key');
        // $app_id = Config::get('publicnumconfig.app_id');

        $msgSignature = Request::get('msg_signature');
        $timestamp = Request::get('timestamp');
        $nonce = Request::get('nonce');
        $postData = Request::getContent(); // 获取原始POST数据

        $crypt = new WXBizMsgCrypt('icEbeaR2018OKakhnF', 'RVRJJ5QwTzsMBFbuFlH3VIVhUH12tJChVEHdgqFONCS', 'wx58740203e2b4acde');
        $msg = '';
        $errCode = $crypt->decryptMsg($msgSignature, $timestamp, $nonce, $postData, $msg);
        print_r($errCode);die;

        if ($errCode == 0) {
            $xml = simplexml_load_string($msg, 'SimpleXMLElement', LIBXML_NOCDATA);
            $json = json_encode($xml);
            $array = json_decode($json, true);

            // 判断消息类型
            if ($array['InfoType'] == 'component_verify_ticket') {
                // 获取 component_verify_ticket
                $componentVerifyTicket = $array['ComponentVerifyTicket'];

                // 缓存 component_verify_ticket
                Cache::set('component_verify_ticket', $componentVerifyTicket, 540); // 9分钟缓存
            }

            // 返回成功响应
            return 'success';
        } else {
            // 解密失败
            return 'error';
        }
    }


    /**
     * 将xml转为array
     */
    private function _xmlToArr($xml)
    {
        $res = @simplexml_load_string($xml, NULL, LIBXML_NOCDATA);
        $res = json_decode(json_encode($res), true);
        return $res;
    }


    public function getUsers()
    {
        $pubAccesstoken = new PubSdk();
        print_r($pubAccesstoken->getAccessToken());
    }
}
