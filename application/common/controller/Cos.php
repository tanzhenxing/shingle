<?php
/**
 * Created by PhpStorm.
 * User: tanzhenxing
 * Date: 2018/6/22
 * Time: 23:47
 */
namespace app\common\controller;

use Qcloud\Cos\Client;
use app\common\model\CosRegion;
use think\Controller;

class Cos extends Controller
{
    protected static $cos_code = 'tencent';

    /**
     * 上传文件到云存储
     * @param $local_file
     * @param $server_file
     * @return array
     */
    public static function upload($local_file,$server_file)
    {
        // 获取腾讯云存储信息
        $cos_info = static::info();
        if ($cos_info['code']) {
            return $cos_info;
        }
        // 组合配置信息
        $cos_config = array(
            'region' =>$cos_info['data']['region']['name'],
            'schema' => 'https', //协议头部，默认为http
            'credentials'=> array(
                'appId' => $cos_info['data']['cos']['app_id'],
                'secretId'    => $cos_info['data']['cos']['secret_id'],
                'secretKey' => $cos_info['data']['cos']['secret_key']
            ));
        // 上传文件到腾讯云存储
        $cosClient = new Client($cos_config);
        $upload = $cosClient->Upload($cos_info['data']['cos']['bucket'], $server_file, $body = fopen($local_file, 'rb'));
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
     * 获取云存储信息
     * @return array
     */
    public static function info()
    {
        // 获取cos 配置信息
        $cos = \app\common\model\Cos::get(['code'=>static::$cos_code]);
        if (empty($cos)) {
            $result = array('code'=>1,'message'=>'cos 配置信息不存在');
            return $result;
        }
        $cos['bucket'] = $cos['bucket_name'] . '-' . $cos['app_id']; // 云存储桶名称
        // 获取cos 地域信息
        $cos_region = CosRegion::get($cos['region_id']);
        if (empty($cos_region)) {
            $result = array('code'=>1,'message'=>'cos 地域信息不存在');
            return $result;
        }
        $result = array('code'=>0,'message'=>'success','data'=>array('cos'=>$cos,'region'=>$cos_region));
        return $result;
    }

    /**
     * 保存数据记录
     * @param $data
     * @return array
     */
    public static function save($data)
    {
        // 获取数据
        $query = array('code'=>$data['code']);
        $obj = new \app\common\model\Cos();
        $get_data = $obj->get($query);
        if (empty($get_data)) { // 新建记录
            $result = static::create($data);
        } else { // 更新记录
            unset($data['code']);
            $data['id'] = $get_data['id'];
            $result = static::update($data);
        }
        // 返回保存成功结果
        return $result;
    }

    /**
     * 创建数据记录
     * @param $data
     * @return array
     */
    public static function create($data)
    {
        // 验证数据
        if (isset($data['id'])) {
            $result = array('code'=>1,'message'=>'id 已经存在');
            return $result;
        }
        $validate = new \app\common\validate\Cos();
        if (!$validate->check($data)) {
            $result = array('code'=>1,'message'=>$validate->getError());
            return $result;
        }
        // 保存数据
        $obj = new \app\common\model\Cos();
        $save = $obj->allowField(true)->save($data);
        // 返回保存失败结果
        if (!$save) {
            $result = array('code'=>1,'message'=>'保存数据失败');
            return $result;
        }
        // 重新获取最新的数据
        $query = array('code'=>$data['code']);
        $result_data = $obj->get($query);
        // 返回保存成功结果
        $result = array('code'=>0,'message'=>'保存数据成功','data'=>$result_data);
        return $result;
    }

    /**
     * 更新数据记录
     * @param $data
     * @return array
     */
    public static function update($data)
    {
        // 验证数据
        if (!isset($data['id']) or !is_int($data['id'])) {
            $result = array('code'=>1,'message'=>'id: '.$data['id'] .' 无效');
            return $result;
        }
        // 获取数据
        $obj = new \app\common\model\Cos();
        $get_data = $obj->get($data['id']);
        if (empty($get_data)) { // 新建记录
            $result = array('code'=>1,'message'=>'id：'.$data['id'] .' 不存在');
            return $result;
        }
        // 保存数据
        $save = $obj->allowField(true)->save($data);
        // 返回保存失败结果
        if (!$save) {
            $result = array('code'=>1,'message'=>'保存数据失败','data'=>$data);
            return $result;
        }
        // 重新获取最新的数据
        $result_data = $obj->get($data['id']);
        // 返回保存成功结果
        $result = array('code'=>0,'message'=>'保存数据成功','data'=>$result_data);
        return $result;
    }

}