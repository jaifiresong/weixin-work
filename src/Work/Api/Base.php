<?php

namespace ReqTencent\Work\Api;


use ReqTencent\Work\Contracts\WorkInterface;

class Base
{
    protected $token;
    protected $promise;

    public function __construct(WorkInterface $promise)
    {
        $this->token = $promise->get_access_token();
        $this->promise = $promise;
    }
}