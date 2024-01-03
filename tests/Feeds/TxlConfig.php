<?php

namespace Test\Feeds;

use LiteView\Curl\Lite;
use ReqTencent\Work\Contracts\WorkInterface;
use ReqTencent\Work\Support\Common;

class TxlConfig implements WorkInterface
{

    public function corpid()
    {
        return '';
    }

    public function corpsecret()
    {
        return '';
    }

    public function agentid()
    {
        // TODO: Implement agentid() method.
    }

    public function get($url)
    {
        $rsp = Lite::request()->get($url);
        return json_decode($rsp, true);
    }

    public function post($url, $params)
    {
        $rsp = Lite::request()->post($url, $params);
        return json_decode($rsp, true);
    }

    public function get_access_token()
    {
//        $r = Common::getAccessToken(new self());
//        var_dump($r);
//        return '1';
    }
}