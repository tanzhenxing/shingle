<?php
/**
 * Created by PhpStorm.
 * User: tanzhenxing
 * Date: 2018/6/22
 * Time: 23:47
 */
namespace app\common\controller;

use app\common\model\Cos;
use think\Controller;
use Qcloud\Cos\Client;
use app\common\model\CosKey;
use app\common\model\CosRegion;

class QcloudCos extends Controller
{
    /**
     * 上传文件到云存储
     * @param $cos_id
     * @param $local_file
     * @param $server_file
     * @return array
     */
    public function upload($cos_id,$local_file,$server_file)
    {
        $config = $this->config($cos_id);
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
     * cos 配置信息
     * @param $id
     * @return array
     */
    public function config($id)
    {
        // cos 信息
        $cos = new Cos();
        $cos_data = $cos->get($id);
        if(empty($cos_data)){
            $result = array('code'=>1,'message'=>'cos id 不存在');
            return $result;
        }

        // cos key 信息
        $cos_key = new CosKey();
        $cos_key_data = $cos_key->get($cos_data['key_id']);
        if(empty($cos_key_data)){
            $result = array('code'=>1,'message'=>'cos key id 不存在');
            return $result;
        }

        // cos地域信息
        $cos_region = new CosRegion();
        $cos_region_data = $cos_region->get($cos_data['region_id']);
        if(empty($cos_region_data)){
            $result = array('code'=>1,'message'=>'cos region_id 不存在');
            return $result;
        }

        $bucket = $cos_data['bucket_name'].'-'.$cos_key_data['app_id']; //bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
        $cos_config = array('region' =>$cos_region_data['short_name'],
            'credentials'=> array(
                'appId' => $cos_key_data['app_id'],
                'secretId'    => $cos_key_data['secret_id'],
                'secretKey' => $cos_key_data['secret_key']
            ));
        $result = array('code'=>0,'bucket'=>$bucket,'config'=>$cos_config);
        return $result;
    }
}