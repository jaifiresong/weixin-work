<?php


namespace ReqTencent\Work\Api;

/*
 * 微信客服
 * https://developer.work.weixin.qq.com/document/path/94638
*/

class Kf extends Base
{
    /**
     * https://developer.work.weixin.qq.com/document/path/94662
     * 添加客服帐号
     * @param $name
     * @param $media_id
     * @return mixed
     */
    public function kf_account_add($name, $media_id)
    {
        $json = [
            'name' => $name,
            'media_id' => $media_id,
        ];
        $api = 'https://qyapi.weixin.qq.com/cgi-bin/kf/account/add?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/94663
     * 删除客服帐号
     * @param $open_kfid
     * @return mixed
     */
    public function kf_account_del($open_kfid)
    {
        $json = [
            'open_kfid' => $open_kfid,
        ];
        $api = 'https://qyapi.weixin.qq.com/cgi-bin/kf/account/del?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/94664
     * 修改客服帐号
     * @param $open_kfid
     * @param $name
     * @param $media_id
     * @return mixed
     */
    public function kf_account_update($open_kfid, $name, $media_id)
    {
        $json = [
            'open_kfid' => $open_kfid,
            'name' => $name,
            'media_id' => $media_id,
        ];
        $api = 'https://qyapi.weixin.qq.com/cgi-bin/kf/account/update?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/94661
     * 获取客服帐号列表
     * @param int $offset
     * @param int $limit
     * @return mixed
     */
    public function kf_account_list($offset = 0, $limit = 100)
    {
        $json = [
            'offset' => $offset,
            'limit' => $limit,
        ];
        $api = 'https://qyapi.weixin.qq.com/cgi-bin/kf/account/list?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/94665
     * 获取客服帐号链接
     * @param $open_kfid
     * @param null $scene
     * @return mixed
     */
    public function add_contact_way($open_kfid, $scene = null)
    {
        $json = [
            'open_kfid' => $open_kfid,
            'scene' => $scene,
        ];
        $api = 'https://qyapi.weixin.qq.com/cgi-bin/kf/add_contact_way?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/94670
     * 读取最近3天内具体的消息内容和事件。不支持读取通过发送消息接口发送的消息
     * @param $token
     * @param null $cursor
     * @param int $limit
     * @return mixed
     */
    public function sync_msg($token, $cursor = null, $limit = 1000)
    {
        $json = [
            "token" => $token, //回调事件返回的token字段，10分钟内有效；可不填，如果不填接口有严格的频率限制。
            "limit" => $limit,//默认值和最大值都为1000。可能会出现返回条数少于limit的情况，需使用has_more字段判断是否继续请求。
        ];
        if ($cursor) {
            $payload["cursor"] = $cursor; //上一次调用时返回的next_cursor，第一次拉取可以不填。若不填，从3天内最早的消息开始返回。
        }
        $api = 'https://qyapi.weixin.qq.com/cgi-bin/kf/sync_msg?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/95122
     * 发送欢迎语等事件响应消息
     * 当特定的事件回调消息包含code字段，开发者可以此code为凭证，调用该接口给用户发送相应事件场景下的消息，如客服欢迎语、客服提示语和会话结束语等。
     * 满足通过API下发欢迎语（条件为：用户在过去48小时里未收过欢迎语，且未向客服发过消息），
     * @param $code
     * @param $content
     * @return mixed
     */
    public function send_msg_on_event($code, $content)
    {
        $json = [
            "code" => $code,
            "msgtype" => "text",
            "text" => [
                "content" => $content
            ]
        ];
        $api = 'https://qyapi.weixin.qq.com/cgi-bin/kf/send_msg_on_event?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/94677
     * 发送消息，当微信客户处于“新接入待处理”或“由智能助手接待”状态下，可调用该接口给用户发送消息，
     * 注意仅当微信客户在主动发送消息给客服后的48小时内，企业可发送消息给客户，最多可发送5条消息；若用户继续发送消息，企业可再次下发消息。
     * @param $content
     * @param $touser
     * @param $open_kfid
     * @return mixed
     */
    public function send_msg($content, $touser, $open_kfid)
    {
        $json = [
            "touser" => $touser,
            "open_kfid" => $open_kfid,
            "msgtype" => "text",
            "text" => [
                "content" => $content
            ]
        ];
        $api = 'https://qyapi.weixin.qq.com/cgi-bin/kf/send_msg?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/95159
     * 获取客户基础信息
     * @param array $ids
     * @return mixed
     */
    public function users_info(array $ids)
    {
        $json = [
            'external_userid_list' => $ids
        ];
        $api = 'https://qyapi.weixin.qq.com/cgi-bin/kf/customer/batchget?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }
}