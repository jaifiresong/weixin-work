<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use ReqTencent\Work\Qywx;
use Test\Feeds\TxlConfig;

class ExternalContactTest extends TestCase
{
    public function test01()
    {
        //$r = Qywx::externalcontact(new TxlConfig())->list_contact_way();
        $r = Qywx::external_contact_contact_me(new TxlConfig())->get_contact_way(['user' => ['ZhouChunMing']]);
        var_dump($r);
        $this->assertIsString("");
    }

    public function test02()
    {
        //$r = Qywx::externalcontact(new TxlConfig())->list_contact_way();
        $r = Qywx::cyvi(new TxlConfig())->departments();
        var_dump($r);
        $this->assertIsString("");
    }
}