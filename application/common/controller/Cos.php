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
        $cosClient = new Client($config['data']['config']);
        $upload = $cosClient->Upload($config['data']['bucket'], $server_file, $body = fopen($local_file, 'rb'));
        if(!isset($upload['Location'])){
            $result = array('code'=>1, 'message'=>'上传文件到cos 失败');
            return $result;
        }
        $file_url = str_replace('%2F','/',$upload['Location']);
        $data = array('url'=>$file_url,'path'=>'/'.$server_file);
        // 返回结果
        $result = array('code'=>0, 'message'=>'success', 'data'=>$data);
        return $result;
    }

    /**
     * 获取cos 配置信息
     * @return array
     */
    public static function config()
    {
        // 获取腾讯云存储信息
        $cos_info = static::info();
        if ($cos_info['code']) {
            return $cos_info;
        }
        // 组合配置信息
        $bucket = $cos_info['data']['cos']['bucket_name'].'-'.$cos_info['data']['cos']['app_id']; //bucket的命名规则为{name}-{appid}
        $cos_config = array(
            'region' =>$cos_info['data']['region']['name'],
            'schema' => 'https', //协议头部，默认为http
            'credentials'=> array(
                'appId' => $cos_info['data']['cos']['app_id'],
                'secretId'    => $cos_info['data']['cos']['secret_id'],
                'secretKey' => $cos_info['data']['cos']['secret_key']
            ));
        // 返回结果
        $result = array('code'=>0,'message'=>'success','data'=>array('bucket'=>$bucket,'config'=>$cos_config));
        return $result;
    }

    /**
     * 获取云存储信息
     * @return array
     */
    public static function info()
    {
        // 获取cos 配置信息
        $cos = \app\common\model\Cos::get(['code'=>'tencent']);
        if (empty($cos)) {
            $result = array('code'=>1,'message'=>'cos 配置信息不存在');
            return $result;
        }
        $cos['bucket'] = $cos['bucket_name'] . '-' . $cos['app_id'];
        // 获取cos 地域信息
        $cos_region = CosRegion::get($cos['region_id']);
        if (empty($cos_region)) {
            $result = array('code'=>1,'message'=>'cos 地域信息不存在');
            return $result;
        }
        $result = array('code'=>0,'message'=>'success','data'=>array('cos'=>$cos,'region'=>$cos_region));
        return $result;
    }

}