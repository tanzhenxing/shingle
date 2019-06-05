<?php
namespace app\index\controller;


class CosKey extends Base
{
    /**
     * 计算临时密钥
     */
    public function info()
    {
        // 获取cos 配置信息
        $cos_info = \app\common\controller\Cos::info();
        if ($cos_info['code']) {
            return json($cos_info);
        }
        // 计算临时秘钥
        $get_cos_key = new \app\common\controller\CosKey();
        // 配置参数
        $config = array(
            'url' => 'https://sts.tencentcloudapi.com/',
            'domain' => 'sts.tencentcloudapi.com',
            'proxy' => '',
            'secretId' => $cos_info['data']['cos']['secret_id'], // 固定密钥
            'secretKey' => $cos_info['data']['cos']['secret_key'], // 固定密钥
            'bucket' => $cos_info['data']['cos']['bucket'], // 换成你的 bucket
            'region' => $cos_info['data']['region']['name'], // 换成 bucket 所在园区
            'durationSeconds' => 1800, // 密钥有效期
            'allowPrefix' => '*', // 这里改成允许的路径前缀，可以根据自己网站的用户登录态判断允许上传的目录，例子：* 或者 a/* 或者 a.jpg
            // 密钥的权限列表。简单上传和分片需要以下的权限，其他权限列表请看 https://cloud.tencent.com/document/product/436/31923
            'allowActions' => array (
                // 所有 action 请看文档 https://cloud.tencent.com/document/product/436/31923
                // 简单上传
                'name/cos:PutObject',
                'name/cos:PostObject',
                // 分片上传
                'name/cos:InitiateMultipartUpload',
                'name/cos:ListMultipartUploads',
                'name/cos:ListParts',
                'name/cos:UploadPart',
                'name/cos:CompleteMultipartUpload'
            )
        );

        // 获取临时密钥，计算签名
        $tempKeys = $get_cos_key->getTempKeys($config);

        // 返回数据给前端
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: http://127.0.0.1'); // 这里修改允许跨域访问的网站
        header('Access-Control-Allow-Headers: origin,accept,content-type');
        return json($tempKeys);
    }

    /**
     * 空操作
     * @return array
     */
    public function _empty()
    {
        $request_url = $this->request->domain() . $this->request->url();
        $result = array('code'=>1, 'message'=>'访问的网址:[ ' . $request_url .' ] 不存在');
        return json($result);
    }
}
