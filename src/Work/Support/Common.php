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
     * https://developer.work.weixin.qq.com/document/10013#%E5%BC%80%E5%8F%91%E6%AD%A5%E9%AA%A4
     * https://developer.work.weixin.qq.com/document/path/91039
     * 获取 token，每个应用的access_token是彼此独立的，所以每个应用的access_token应该分开来获取，至少保留512字节的存储空间。
     * @param WorkInterface $promise
     * @return mixed
     */
    public static function getAccessToken(WorkInterface $promise)
    {
        //每个企业都拥有唯一的corpid，获取此信息可在管理后台“我的企业”－“企业信息”下查看“企业ID”（需要有管理员权限）
        $corpid = $promise->corpid();

        // 不同的应用有不同的secret，获取的token是不能共用的
        // 自建应用secret。在“应用管理”->“应用”->“自建”，点进某个应用，即可看到。
        // 基础应用secret：
        //     某些基础应用，支持通过API进行操作，如“微信客服”。在“应用与小程序”->“应用”->“微信客服”，点开“API”小按钮，即可看到。
        //     某些应用没有自己的secret，需要授权给其它应用进行调用，如“审批”。在“应用与小程序”->“应用”->“审批”，点开“API”小按钮，即可看到。
        // 客户联系secret。客户联系没有自己的secret，需要授权给其它应用进行调用。在“客户与上下游”->“客户联系”栏，点开“API”小按钮，即可看到。
        // 通讯录管理secret。在“安全与管理”-“管理工具”-“通讯录同步”里面查看（需开启“API接口同步”）；
        $corpsecret = $promise->corpsecret();

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