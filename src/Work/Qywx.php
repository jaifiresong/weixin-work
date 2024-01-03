<?php

namespace ReqTencent\Work;


use ReqTencent\Work\Api\Base;
use ReqTencent\Work\Api\Cyvi;
use ReqTencent\Work\Api\ExternalContact\ContactMe;
use ReqTencent\Work\Api\ExternalContact\Customer;
use ReqTencent\Work\Api\ExternalContact\MsgTemplate;
use ReqTencent\Work\Api\Kf;
use ReqTencent\Work\Api\Media;
use ReqTencent\Work\Api\OAuth;
use ReqTencent\Work\Contracts\WorkInterface;

class Qywx
{
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

    public static function oauth(WorkInterface $promise): OAuth
    {
        return new OAuth($promise);
    }

    public static function external_contact_contact_me(WorkInterface $promise): ContactMe
    {
        return new ContactMe($promise);
    }

    public static function external_contact_customer(WorkInterface $promise): Customer
    {
        return new Customer($promise);
    }

    public static function external_contact_msg_template(WorkInterface $promise): MsgTemplate
    {
        return new MsgTemplate($promise);
    }
}