<?php
/**
 * Created by PhpStorm.
 * User: tanzhenxing
 * Date: 2018/6/22
 * Time: 23:47
 */
namespace app\common\controller;

use think\Controller;
use Qcloud\Cos\Client;
use app\common\model\CosRegion;

class Cos extends Controller
{
    /**
     * 上传文件到云存储
     * @param $local_file
     * @param $server_file
     * @return array
     */
    public static function upload($local_file,$server_file)
    {
        // 获取配置信息
        $config = static::config();
        if($config['code']){
            return $config;
        }
        // 上传文件到腾讯云存储
        $cosClient = new Client($config['config']);
        $upload = $cosClient->Upload($config['bucket'], $server_file, $body = fopen($local_file, 'rb'));
        if(!isset($upload['Location'])){
            $result = array('code'=>1, 'message'=>'上传文件到cos 失败');
            return $result;
        }
        $file_url = str_replace('%2F','/',$upload['Location']);
        $data = array('url'=>$file_url,'path'=>'/'.$server_file);

        $result = array('code'=>0, 'message'=>'success', 'data'=>$data);

        return $result;
    }

    /**
     * 获取cos 配置信息
     * @return array
     */
    public static function config()
    {
        // cos 信息
        $cos = \app\common\model\Cos::get(['code'=>'tencent']);
        if(empty($cos)){
            $result = array('code'=>1,'message'=>'cos 配置信息不存在');
            return $result;
        }
        // cos地域信息
        $cos_region = CosRegion::get($cos['region_id']);
        if(empty($cos_region)){
            $result = array('code'=>1,'message'=>'cos region 不存在');
            return $result;
        }
        // 返回配置信息
        $bucket = $cos['bucket_name'].'-'.$cos['app_id']; //bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
        $cos_config = array(
            'region' =>$cos_region['name'],
            'schema' => 'https', //协议头部，默认为http
            'credentials'=> array(
                'appId' => $cos['app_id'],
                'secretId'    => $cos['secret_id'],
                'secretKey' => $cos['secret_key']
            ));
        $result = array('code'=>0,'bucket'=>$bucket,'config'=>$cos_config);
        return $result;
    }

}