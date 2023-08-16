<?php

class KfMsgOrEventService
{
    public $event;

    public function __construct($event)
    {
        $this->event = $event;
    }

    public function handle()
    {
        $token = (string)$this->event->Token ?? null;
        if ($token) {
            //查询消息
            $rk_cursor = 'testhy:qywx:wxkf:cursor';
            while (true) {
                $cursor = RedisCli::select()->get($rk_cursor);
                $raw_msg = WxKfAide::sync_msg($token, $cursor);
                $msg = json_decode($raw_msg, true);
                if ($msg['errcode']) {
                    Log::error('同步消息出错：' . $msg['errmsg'] . "@$token@" . gettype($token), 'wxkf');
                    break;
                }
                RedisCli::select()->set($rk_cursor, $msg['next_cursor']);
                Log::info("处理消息：" . count($msg['msg_list']), 'wxkf');
                foreach ($msg['msg_list'] as $one) {
                    Log::info('消息详情：' . json_encode($one), 'wxkf');
                    //处理业务逻辑
                    if (!empty($one['event']['welcome_code']) && $one['send_time'] > time() - 18) {
                    }
                    (new ContactService())->welcome($one);
                }
                if (!$msg['has_more']) {
                    break;
                }
            }
        }
    }
}