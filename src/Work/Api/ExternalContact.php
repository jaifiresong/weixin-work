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

    /**
     * https://developer.work.weixin.qq.com/document/path/92228
     * 新增或更新，配置客户联系「联系我」方式
     * 注意:
     *      通过API添加的「联系我」不会在管理端进行展示，每个企业可通过API最多配置50万个「联系我」。
     *      用户需要妥善存储返回的config_id，config_id丢失可能导致用户无法编辑或删除「联系我」。
     *      临时会话模式不占用「联系我」数量，但每日最多添加10万个，并且仅支持单人。
     *      临时会话模式的二维码，添加好友完成后该二维码即刻失效。
     * @param array $optional
     * @param int $type //联系方式类型,1-单人, 2-多人
     * @param int $scene //1-在小程序中联系，2-通过二维码联系
     * @return mixed
     */
    public function get_contact_way($optional = [], $type = 2, $scene = 2)
    {
        $json = [
            'user' => $optional['user'] ?? null,//使用该联系方式的用户userID列表，在type为1时为必填，且只能有一个
            'party' => $optional['party'] ?? null,//使用该联系方式的部门id列表，只在type为2时有效
            'state' => $optional['state'] ?? null,//企业自定义的state参数，不超过30个字符
            'remark' => $optional['remark'] ?? null,//联系方式的备注信息，用于助记，不超过30个字符
            'style' => $optional['style'] ?? null,//在小程序中联系时使用的控件样式
            'skip_verify' => $optional['skip_verify'] ?? null,//外部客户添加时是否无需验证，默认为true
            'is_temp' => $optional['is_temp'] ?? null,//是否临时会话模式，true表示使用临时会话模式，默认为false
            'expires_in' => $optional['expires_in'] ?? null,//临时会话二维码有效期，以秒为单位。该参数仅在is_temp为true时有效，默认7天，最多为14天
            'chat_expires_in' => $optional['chat_expires_in'] ?? null,//临时会话有效期，以秒为单位。该参数仅在is_temp为true时有效，默认为添加好友后24小时，最多为14天
            'unionid' => $optional['unionid'] ?? null,//可进行临时会话的客户unionid，该参数仅在is_temp为true时有效，如不指定则不进行限制
            'is_exclusive' => $optional['is_exclusive'] ?? null,//是否开启同一外部企业客户只能添加同一个员工，默认为否，开启后，同一个企业的客户会优先添加到同一个跟进人
            'conclusions' => $optional['conclusions'] ?? null,//结束语，会话结束时自动发送给客户
        ];
        if (isset($optional['config_id'])) {
            $json['config_id'] = $optional['config_id'];
            $api = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/update_contact_way?access_token=' . $this->token;
        } else {
            $json ['type'] = $type;//必填，联系方式类型,1-单人, 2-多人
            $json ['scene'] = $scene;//必填，场景，1-在小程序中联系，2-通过二维码联系
            $api = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/add_contact_way?access_token=' . $this->token;
        }
        return $this->promise->post($api, json_encode($json));
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/92228#%E5%88%A0%E9%99%A4%E4%BC%81%E4%B8%9A%E5%B7%B2%E9%85%8D%E7%BD%AE%E7%9A%84%E3%80%8C%E8%81%94%E7%B3%BB%E6%88%91%E3%80%8D%E6%96%B9%E5%BC%8F
     * 删除已配置的联系方式
     * @param $config_id
     * @return mixed
     */
    public function del_contact_way($config_id)
    {
        $json = [
            'config_id' => $config_id,
        ];
        $api = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/del_contact_way?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/92228#%E8%8E%B7%E5%8F%96%E4%BC%81%E4%B8%9A%E5%B7%B2%E9%85%8D%E7%BD%AE%E7%9A%84%E3%80%8C%E8%81%94%E7%B3%BB%E6%88%91%E3%80%8D%E6%96%B9%E5%BC%8F
     * @param $config_id
     * @return mixed
     */
    public function info_contact_way($config_id)
    {
        $json = [
            'config_id' => $config_id,
        ];
        $api = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_contact_way?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/92228#%E8%8E%B7%E5%8F%96%E4%BC%81%E4%B8%9A%E5%B7%B2%E9%85%8D%E7%BD%AE%E7%9A%84%E3%80%8C%E8%81%94%E7%B3%BB%E6%88%91%E3%80%8D%E5%88%97%E8%A1%A8\
     * 注意，该接口仅可获取2021年7月10日以后创建的「联系我」
     * @param null $cursor
     * @param int $limit
     * @param null $start_time
     * @param null $end_time
     * @return mixed
     */
    public function list_contact_way($cursor = null, $limit = 1000, $start_time = null, $end_time = null)
    {
        $json = [
            'start_time' => $start_time, //默认为90天前
            'end_time' => $end_time, //默认为当前时间
            'cursor' => $cursor, //分页查询使用的游标，为上次请求返回的 next_cursor
            'limit' => $limit, //每次查询的分页大小，默认为100条，最多支持1000条
        ];
        $api = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/list_contact_way?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }
}