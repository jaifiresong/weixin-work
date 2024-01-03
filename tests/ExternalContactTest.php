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
        $r = Qywx::external_contact_customer(new TxlConfig())->user_ids('jaifire');
        print_r($r);
        $r = Qywx::external_contact_customer(new TxlConfig())->tag_list();
        echo json_encode($r);
        $this->assertIsString("");
    }

    public function test03()
    {
//        $r = Qywx::external_contact_customer(new TxlConfig())->staff_list();
//        print_r($r);
        //            [0] => ZhouChunMing
        //            [1] => zhuzhenyong
        //            [2] => nu11
        //            [3] => jaifire
        $msg = [
            //'sender' => 'nu11',
            'external_userid' => [
                'wm3-DXEAAA_Xa1S_R1pm7HEq0ayEgauA',
                'wm3-DXEAAAJdSfwlZXz1kIFGVJjt6RFg',
                'wm3-DXEAAAVZ2QGWaoMxlgX2MLfO80cg', // 1
            ],
            'text' => ['content' => 'hello8'],
            'allow_select' => true,
        ];
        $r = Qywx::external_contact_msg_template(new TxlConfig())->add_msg_template($msg);
        print_r($r);
        $this->assertIsString("");
    }


}