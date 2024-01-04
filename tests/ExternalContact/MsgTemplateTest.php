<?php

namespace Test\ExternalContact;

use PHPUnit\Framework\TestCase;
use ReqTencent\Work\Qywx;
use Test\Feeds\TxlConfig;

class MsgTemplateTest extends TestCase
{
    // 获取客户
    public function test02()
    {
        $r = Qywx::external_contact_customer(new TxlConfig())->user_ids('jaifire');
        print_r($r);
        $r = Qywx::external_contact_customer(new TxlConfig())->tag_list();
        echo json_encode($r);

        //        $r = Qywx::external_contact_customer(new TxlConfig())->staff_list();
        //        print_r($r);
        //            [0] => ZhouChunMing
        //            [1] => zhuzhenyong
        //            [2] => nu11
        //            [3] => jaifire
        $this->assertIsString("");
    }

    // 群发文本消息
    public function test03()
    {
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

    // 群发图文消息
    public function test04()
    {
        $msg = [
            //'sender' => 'nu11',
            'external_userid' => [
                'wm3-DXEAAA_Xa1S_R1pm7HEq0ayEgauA',
                'wm3-DXEAAAJdSfwlZXz1kIFGVJjt6RFg',
                'wm3-DXEAAAVZ2QGWaoMxlgX2MLfO80cg', // 1
            ],
            'attachments' => [
                [
                    'msgtype' => 'link',
                    'link' => [
                        'title' => '标题',
                        'picurl' => 'https://www.songcj.com/html/wap/assets/images/tools/timestamp.jpg',
                        'desc' => '消息描述',
                        'url' => 'http://hyty.hy5188.com/?r=tg/contact_qywx',
                    ],
                ],
            ],
            'allow_select' => true,
        ];
        $r = Qywx::external_contact_msg_template(new TxlConfig())->add_msg_template($msg);
        print_r($r);
        $this->assertIsString("");
    }

    //群发结果
    public function test05()
    {
        //$r = Qywx::external_contact_msg_template(new TxlConfig())->groupmsg_list(strtotime('-7 day'), time());
        //print_r($r);
        $r = Qywx::external_contact_msg_template(new TxlConfig())->groupmsg_to_users('msg3-DXEAAA2rLPyFypCRasS0tv5zN9Qg');
        echo json_encode($r);

        $this->assertIsString("");
    }

}