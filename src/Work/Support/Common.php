<?php

namespace ReqTencent\Work\Support;

use ReqTencent\Work\Contracts\WorkInterface;

class Common
{
    /**
     * 验证是否微信发送消息
     * @param $signature
     * @param $timestamp
     * @param $nonce
     * @param $token
     * @return bool
     */
    public static function checkMsgSignature($signature, $timestamp, $nonce, $token): bool
    {
        $arr = array($token, $timestamp, $nonce);
        sort($arr, SORT_STRING);
        if (sha1(implode($arr)) === $signature) {
            return true;
        }
        return false;
    }

    /**
     * 获取 token
     * 公众号和小程序是一样的
     * @param WorkInterface $promise
     * @return mixed
     */
    public static function getAccessToken(WorkInterface $promise)
    {
        $corpid = $promise->corpid();
        $corpsecret = $promise->corpsecret(); // 不同的应用有不同的secret，获取的token是不能共用的
        return $promise->get("https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$corpid&corpsecret=$corpsecret");
    }

    /**
     * 接收微信服务器推送的信息
     */
    public static function receiveMsg()
    {
        $input = file_get_contents('php://input');
        return simplexml_load_string($input, 'SimpleXMLElement', LIBXML_NOCDATA);
    }
}