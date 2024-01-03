<?php


namespace ReqTencent\Work\Api;

/*
 * 通讯录管理
 * https://developer.work.weixin.qq.com/document/path/90193
*/

class Cyvi extends Base
{
    /**
     * https://developer.work.weixin.qq.com/document/path/90196
     * 读取成员
     * @param $userid
     * @return mixed
     */
    public function member_info($userid)
    {
        $api = "https://qyapi.weixin.qq.com/cgi-bin/user/get?access_token={$this->token}&userid=$userid";
        return $this->promise->get($api);
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/90200
     * 获取部门成员
     * @param $department_id
     * @return mixed
     */
    public function simple_members($department_id)
    {
        $api = "https://qyapi.weixin.qq.com/cgi-bin/user/simplelist?access_token={$this->token}&department_id=$department_id";
        return $this->promise->get($api);
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/90201
     * 获取部门成员详情
     * @param $department_id
     * @return mixed
     */
    public function members($department_id)
    {
        $api = "https://qyapi.weixin.qq.com/cgi-bin/user/list?access_token={$this->token}&department_id=$department_id";
        return $this->promise->get($api);
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/90208
     * 获取部门列表
     * @param null $id 部门id。获取指定部门及其下的子部门（以及子部门的子部门等等，递归）。 如果不填，默认获取全量组织架构
     * @return mixed
     */
    public function departments($id = null)
    {
        $api = "https://qyapi.weixin.qq.com/cgi-bin/department/list?access_token={$this->token}";
        if (!is_null($id)) {
            $api .= "&id=$id";
        }
        return $this->promise->get($api);
    }
}