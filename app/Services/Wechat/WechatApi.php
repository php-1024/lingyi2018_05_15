<?php
namespace App\Services\Wechat;
use App\Models\WechatOpenSetting;
use App\Services\Wechat\wxfiles\WXBizMsgCrypt;
/*
    微信开放平台操作相关接口
*/

class WechatApi{
    public function test(){
        //$info = \HttpCurl::doget('http://www.baidu.com');
        //dump($info);
        echo 1234;
    }

    /*
     *
     */
    public function get_component_access_token(){
        $token_info = WechatOpenSetting::getComponentAccessToken();
        if(!empty($token_info->param_value) && $token_info->expire_time - time() > 300){//过时前5分钟也需要重置了
            return $token_info->param_value;
        }
        $wxparam = config('app.wechat_open_setting');
        $ticket_info = WechatOpenSetting::getComponentVerifyTicket();
        if(empty($ticket_info->param_value)){
            exit('获取微信开放平台ComponentVerifyTicket失败');
        }else{
            $url = 'https://api.weixin.qq.com/cgi-bin/component/api_component_token';
            $data = array(
                'component_appid' => $wxparam['open_appid'],
                'component_appsecret' => $wxparam['open_appsecret'],
                'component_verify_ticket' => $ticket_info->param_value
            );
            $data = json_encode($data);
            $re = \HttpCurl::doPost($url, $data);
            $re = json_decode($re,true);
            if (!empty($re['component_access_token'])) {
                WechatOpenSetting::editComponentAccessToken($re['component_access_token'],time()+7000);
                return $re['component_access_token'];
            }else{
                exit('获取微信开放平台ComponentAccessToken失败');
            }
        }
    }
    /* 出于安全考虑，在第三方平台创建审核通过后，微信服务器 每隔10分钟会向第三方的消息接收地址推送一次component_verify_ticket，用于获取第三方平台接口调用凭据
     *  获取该参数
    */
    public function getVerify_Ticket($timeStamp,$nonce,$encrypt_type,$msg_sign,$encryptMsg){
        $wxparam = config('app.wechat_open_setting');
        $jm = new WXBizMsgCrypt($wxparam['open_token'],  $wxparam['open_key'], $wxparam['open_appid']);
        $xml_tree = new \DOMDocument();
        $xml_tree->loadXML($encryptMsg);
        $array_e = $xml_tree->getElementsByTagName('Encrypt');
        $encrypt = $array_e->item(0)->nodeValue;
        $format = "<xml><ToUserName><![CDATA[toUser]]></ToUserName><Encrypt><![CDATA[%s]]></Encrypt></xml>";
        $from_xml = sprintf($format, $encrypt);
        $msg = '';
        $errCode = $jm->decryptMsg($msg_sign, $timeStamp, $nonce, $from_xml, $msg);
        dump($errCode);
        if ($errCode == 0) {
            $xml = new \DOMDocument();
            $xml->loadXML($msg);
            $array_e = $xml->getElementsByTagName('ComponentVerifyTicket');
            $component_verify_ticket = $array_e->item(0)->nodeValue;
            WechatOpenSetting::editComponentVerifyTicket($component_verify_ticket,time()+550);
            return true;
        }else{
            return false;
        }
    }
}
?>