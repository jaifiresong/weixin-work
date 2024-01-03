<?php

namespace Test\Feeds;

use LiteView\Curl\Lite;
use ReqTencent\Work\Contracts\WorkInterface;

class TxlConfig implements WorkInterface
{

    public function corpid()
    {
        return 'ww2b1e450e10a598fb';
    }

    public function corpsecret()
    {
        // TODO: Implement corpsecret() method.
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
        return '';
    }
}