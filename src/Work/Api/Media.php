<?php


namespace ReqTencent\Work\Api;

/*
 * 素材管理
 * https://developer.work.weixin.qq.com/document/path/91054
*/

class Media extends Base
{
    /**
     * https://developer.work.weixin.qq.com/document/path/90253
     * 上传临时素材
     * @param $file_path
     * @param string $type 媒体文件类型，分别有图片（image）、语音（voice）、视频（video），普通文件（file）
     * @param string $mime_type
     * @param string $posted_filename
     * @return mixed
     */
    public function upload($file_path, $type = 'image', $mime_type = '', $posted_filename = '')
    {
        $payload = [
            'media' => curl_file_create($file_path, $mime_type, $posted_filename)
        ];
        $api = "https://qyapi.weixin.qq.com/cgi-bin/media/upload?access_token={$this->token}&type=$type";
        return $this->promise->post($api, $payload);
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/90256
     * 上传图片
     * @param $file_path
     * @param string $mime_type
     * @param string $posted_filename
     * @return mixed
     */
    public function upload_img($file_path, $mime_type = '', $posted_filename = '')
    {
        $payload = [
            'media' => curl_file_create($file_path, $mime_type, $posted_filename)
        ];
        $api = 'https://qyapi.weixin.qq.com/cgi-bin/media/uploadimg?access_token=' . $this->token;
        return $this->promise->post($api, $payload);
    }

    /**
     * https://developer.work.weixin.qq.com/document/path/90254
     * 获取临时素材
     * @param $media_id
     * @return mixed
     */
    public function get($media_id)
    {
        $api = "https://qyapi.weixin.qq.com/cgi-bin/media/get?access_token={$this->token}&media_id=$media_id";
        return $this->promise->get($api);
    }
}