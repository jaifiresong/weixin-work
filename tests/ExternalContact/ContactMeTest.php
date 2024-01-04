<?php


namespace Test\ExternalContact;


use ReqTencent\Work\Qywx;
use Test\Feeds\TxlConfig;

class ContactMeTest
{
    // 获取联系我二维码
    public function test01()
    {
        //$r = Qywx::externalcontact(new TxlConfig())->list_contact_way();
        $r = Qywx::external_contact_contact_me(new TxlConfig())->get_contact_way(['user' => ['ZhouChunMing']]);
        var_dump($r);
        $this->assertIsString("");
    }
}