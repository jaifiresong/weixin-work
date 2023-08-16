<?php

namespace ReqTencent\Work\Contracts;

interface WorkInterface
{
    public function corpid();

    public function corpsecret();

    public function agentid();

    public function get($url);

    public function post($url, $params);

    public function get_access_token();
}