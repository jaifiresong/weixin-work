<?php


namespace ReqTencent\Work\Api;

/*
 * 客户联系
 * https://developer.work.weixin.qq.com/document/path/92109
*/

class ExternalContact extends Base
{
    /**
     * https://developer.work.weixin.qq.com/document/path/92113
     * 获取客户列表
     * @param $staff_id string 企业成员的userid
     * @return mixed
     */
    public function user_ids($staff_id)
    {
        $api = "https://qyapi.weixin.qq.com/cgi-bin/externalcontact/list?access_token={$this->token}&userid=$staff_id";
        return $this->promise->get($api);
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/92114
     * 获取客户详情
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
     * 企业/第三方可通过此接口获取(批量)指定成员添加的客户信息列表
     */
    public function customers_by_staffids(array $staffids, $cursor = '', $limit = 100)
    {
        $json = [
            "userid_list" => $staffids, //企业成员的userid列表，字符串类型，最多支持100个
            "cursor" => $cursor,
            "limit" => $limit, //最大值100，默认值50
        ];
        $api = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/batch/get_by_user?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/92228
     * 配置客户联系「联系我」方式
     * 注意:
     *      通过API添加的「联系我」不会在管理端进行展示，每个企业可通过API最多配置50万个「联系我」。
     *      用户需要妥善存储返回的config_id，config_id丢失可能导致用户无法编辑或删除「联系我」。
     *      临时会话模式不占用「联系我」数量，但每日最多添加10万个，并且仅支持单人。
     *      临时会话模式的二维码，添加好友完成后该二维码即刻失效。
     */
}