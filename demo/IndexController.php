<?php

class IndexController
{
    public function wxkf()
    {
        $token = config('qywx.wxkf.token');
        $aes = new QyWxCrypt(config('qywx.wxkf.AESKey'));
        if (!empty($_GET['echostr'])) {
            //配置回调URL时会有echostr
            if (!QyWx::check($token, $_GET['echostr'])) {
                return 'echostr error';
            }
            $str = $aes->decrypt($_GET['echostr']);
            return strval($str);
        }
        $postStr = file_get_contents('php://input');
        if (empty($postStr)) {
            return 'postStr empty';
        }
        //处理消息
        $msg = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        if (!QyWx::check($token, $msg->Encrypt)) {
            return 'msg_signature error';
        }
        $xml = $aes->decrypt($msg->Encrypt);
        $plain = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        try {
            Log::info('收到消息：' . json_encode($plain), 'wxkf');
            (new KfMsgOrEventService($plain))->handle();
            Log::info('处理完成：' . json_encode($plain), 'wxkf');
        } catch (\Throwable $e) {
            $str = $e->getMessage() . PHP_EOL
                . $e->getFile() . '(' . $e->getLine() . ')' . PHP_EOL
                . $e->getTraceAsString();
            Log::error($str, 'wxkf_error');
        }
    }
}