<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use ReqTencent\Work\Qywx;
use Test\Feeds\TxlConfig;

class MediaTest extends TestCase
{

    public function test01()
    {
//        $r = Qywx::media(new TxlConfig())->upload('./Feeds/1.png');
//        print_r($r);
//        $r = Qywx::media(new TxlConfig())->upload('./Feeds/2.mp4', 'video');
//        print_r($r);
        $r = Qywx::media(new TxlConfig())->upload('./Feeds/3.mp4', 'video');
        print_r($r);
        $this->assertIsString("");
    }
}