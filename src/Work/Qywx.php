<?php

namespace ReqTencent\Work;


use ReqTencent\Work\Api\Base;
use ReqTencent\Work\Api\Cyvi;
use ReqTencent\Work\Api\Kf;
use ReqTencent\Work\Api\Media;
use ReqTencent\Work\Contracts\WorkInterface;

class Qywx
{
    private static $instances;

    public static function base(WorkInterface $promise): Base
    {
        return new Base($promise);
    }

    public static function cyvi(WorkInterface $promise): Cyvi
    {
        return new Cyvi($promise);
    }

    public static function kf(WorkInterface $promise): Kf
    {
        return new Kf($promise);
    }

    public static function media(WorkInterface $promise): Media
    {
        return new Media($promise);
    }
}