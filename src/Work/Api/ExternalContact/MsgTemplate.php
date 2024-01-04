<?php


namespace ReqTencent\Work\Api\ExternalContact;


use ReqTencent\Work\Api\Base;

/*
 * 消息推送
*/

class MsgTemplate extends Base
{
    /**
     * https://developer.work.weixin.qq.com/document/path/92135
     * 创建企业群发
     * @param array $optional
     * @param string $chat_type
     * @return mixed
     */
    public function add_msg_template($optional = [], $chat_type = 'single')
    {
        $json = [
            'chat_type' => $chat_type,//群发任务的类型，默认为 single，表示发送给客户，group 表示发送给客户群。对于客户群发，sender，external_userid，tag_filter不可同时为空，如果指定了external_userid,则tag_filter不生效
            'chat_id_list' => $optional['chat_id_list'] ?? null,//客户群id列表，仅在chat_type为group时有效，最多可一次指定2000个客户群。指定群id之后，收到任务的群主无须再选择客户群，仅对4.1.10及以上版本的企业微信终端生效
            'sender' => $optional['sender'] ?? null,//发送企业群发消息的成员userid，当类型为发送给客户群时必填，当只提供sender参数时，相当于选取了这个成员所有的客户。
            'allow_select' => $optional['allow_select'] ?? null,//是否允许成员在待发送客户列表中重新进行选择，默认为false
            'text' => $optional['text'] ?? null,//消息文本内容，最多4000个字节，text和attachments不能同时为空
            'attachments' => $optional['attachments'] ?? null,//附件，最多支持添加9个附件
        ];

        //客户的externaluserid列表，仅在chat_type为single时有效，最多可一次指定1万个客户
        //实验发现，当客户添加了多个企业成员时，会分别分配给不同的成员进行发送，还有可能分漏掉一部分客户，所以该参数建意不要用
        $json['external_userid'] = $optional['external_userid'] ?? null;

        //要进行群发的客户标签列表，同组标签之间按“或关系”进行筛选，不同组标签按“且关系”筛选，每组最多指定100个标签，支持规则组标签
        //一般不会配置客户标签，所以该参数可以不用
        $json['tag_filter'] = $optional['tag_filter'] ?? null;

        $api = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/add_msg_template?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/97610
     * 提醒成员群发，24小时内每个群发最多触发三次提醒
     * @param $msg_id
     * @return mixed
     */
    public function remind_send($msg_id)
    {
        $json = [
            'msgid' => $msg_id,
        ];
        $api = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/remind_groupmsg_send?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/97611
     * 停止企业群发
     * @param $msg_id
     * @return mixed
     */
    public function cancel_send($msg_id)
    {
        $json = [
            'msgid' => $msg_id,
        ];
        $api = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/cancel_groupmsg_send?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/93338#%E8%8E%B7%E5%8F%96%E7%BE%A4%E5%8F%91%E8%AE%B0%E5%BD%95%E5%88%97%E8%A1%A8
     * 获取企业与成员的群发记录
     * @param $start_time
     * @param $end_time
     * @param null $cursor
     * @param array $optional
     * @return mixed
     */
    public function groupmsg_list($start_time, $end_time, $cursor = null, $optional = [])
    {
        $json = [
            'start_time' => $start_time, //10位时间戳，群发任务记录的起止时间间隔不能超过1个月
            'end_time' => $end_time, //10位时间戳，群发任务记录的起止时间间隔不能超过1个月
            'cursor' => $cursor, //用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
            'chat_type' => $optional['chat_type'] ?? 'single', //群发任务的类型，single，表示发送给客户，group表示发送给客户群
            'creator' => $optional['creator'] ?? null, //群发任务创建人企业账号id
            'filter_type' => $optional['filter_type'] ?? null, //0：企业发表 1：个人发表 2：所有，默认为2
            'limit' => $optional['limit'] ?? null, //返回的最大记录数，整型，最大值100，默认值50，超过最大值时取默认值
        ];
        $api = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_groupmsg_list_v2?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/93338#%E8%8E%B7%E5%8F%96%E7%BE%A4%E5%8F%91%E6%88%90%E5%91%98%E5%8F%91%E9%80%81%E4%BB%BB%E5%8A%A1%E5%88%97%E8%A1%A8
     * 获取消息的发送对象列表
     * @param $msg_id
     * @param null $cursor
     * @param int $limit
     * @return mixed
     */
    public function groupmsg_to_users($msg_id, $cursor = null, $limit = 1000)
    {
        $json = [
            'msgid' => $msg_id,
            'cursor' => $cursor,//用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
            'limit' => $limit,//返回的最大记录数，整型，最大值1000，默认值500，超过最大值时取默认值
        ];
        $api = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_groupmsg_task?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/93338#%E8%8E%B7%E5%8F%96%E4%BC%81%E4%B8%9A%E7%BE%A4%E5%8F%91%E6%88%90%E5%91%98%E6%89%A7%E8%A1%8C%E7%BB%93%E6%9E%9C
     * 获取企业群发成员执行结果
     * @param $msg_id
     * @param $user_id
     * @param null $cursor
     * @param int $limit
     * @return mixed
     */
    public function groupmsg_send_result($msg_id, $user_id, $cursor = null, $limit = 1000)
    {
        $json = [
            'msgid' => $msg_id,
            'userid' => $user_id,//发送成员userid
            'cursor' => $cursor,//用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
            'limit' => $limit,//返回的最大记录数，整型，最大值1000，默认值500，超过最大值时取默认值
        ];
        $api = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_groupmsg_send_result?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/92137
     * 发送新客户欢迎语
     */
    /**
     * https://developer.work.weixin.qq.com/document/path/92366
     * 入群欢迎语素材管理
     */
}