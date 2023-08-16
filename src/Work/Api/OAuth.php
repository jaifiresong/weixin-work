<?php


namespace ReqTencent\Work\Api;


class OAuth extends Base
{
    /**
     * https://developer.work.weixin.qq.com/document/path/91022
     * 组装授权登录地址
     */
    public function oauth2Authorize($redirect_uri, $scope = 2)
    {
        $_ = [1 => 'snsapi_base', 2 => 'snsapi_privateinfo'];
        $query = http_build_query([
            'appid' => $this->promise->corpid(),
            'redirect_uri' => $redirect_uri, //请使用urlencode对链接进行处理,注意不能urlencode
            'response_type' => 'code',
            'scope' => $_[$scope],
            'state' => 'STATE',//重定向后会带上state参数
            'agentid' => $this->promise->agentid(),//snsapi_privateinfo时必填否则报错
        ]);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?$query#wechat_redirect";
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/91023
     * 获取访问用户身份
     */
    public function userInfo($code)
    {
        $api = "https://qyapi.weixin.qq.com/cgi-bin/auth/getuserinfo?access_token={$this->token}&code=$code";
        return $this->promise->get($api);
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/95833
     * 获取访问用户敏感信息
     */
    public function userInfoDetail($user_ticket)
    {
        $json = [
            'user_ticket' => $user_ticket,
        ];
        $api = 'https://qyapi.weixin.qq.com/cgi-bin/auth/getuserdetail?access_token=' . $this->token;
        return $this->promise->post($api, json_encode($json));
    }
}