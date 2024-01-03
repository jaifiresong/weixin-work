<?php


namespace ReqTencent\Work\Api\ExternalContact;


use ReqTencent\Work\Api\Base;

/*
 * 客户管理
*/

class Customer extends Base
{
    /**
     * https://developer.work.weixin.qq.com/document/path/92571
     * 获取配置了客户联系功能的成员列表
    */

    /**
     * https://developer.work.weixin.qq.com/document/path/92113
     * 获取客户列表
     * @param $staff_id string 企业成员的userid
     * @return mixed
     */
    public function user_ids(string $staff_id)
    {
        $api = "https://qyapi.weixin.qq.com/cgi-bin/externalcontact/list?access_token={$this->token}&userid=$staff_id";
        return $this->promise->get($api);
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/92114
     * 获取客户详情
     * @param $external_userid
     * @param null $cursor
     * @return mixed
     */
    public function user_detail($external_userid, $cursor = null)
    {
        $query = http_build_query([
            'access_token' => $this->token,
            'external_userid' => $external_userid,  //外部联系人的userid，注意不是企业成员的账号
            'cursor' => $cursor,  //上次请求返回的next_cursor
        ]);
        $api = "https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get?$query";
        return $this->promise->get($api);
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/92994
     * 批量获取客户详情
     * @param array $staffids
     * @param string $cursor
     * @param int $limit
     * @return mixed
     */
    public function customers_by_staffids(array $staffids, $cursor = '', $limit = 100)
    {
        $json = [
            'userid_list' => $staffids, //企业成员的userid列表，字符串类型，最多支持100个
            'cursor' => $cursor,
            'limit' => $limit, //最大值100，默认值50
        ];
        $api = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/batch/get_by_user?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }
}