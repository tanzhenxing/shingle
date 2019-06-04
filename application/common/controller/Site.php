<?php
namespace app\common\controller;

use think\Controller;

class Site extends Controller
{
    protected static $site_code = 'woniu_es';

    /**
     * 获取网站信息
     * @param $code
     * @return array
     */
    public static function info()
    {
        // 获取网站信息
        $site_info = \app\common\model\Site::get(['code'=>static::$site_code]);
        if (empty($site_info)) {
            $result = array('code'=>1,'message'=>'site info is null');
            return $result;
        }
        // 返回结果
        $result = array('code'=>0,'message'=>'success','data'=>$site_info);
        return $result;
    }

    /**
     * 更新网站信息
     * @param $data
     * @return array
     */
    public static function update($data)
    {
        if (empty($data)) {
            $result = array('code'=>1,'message'=>'post data is null');
            return $result;
        }
        // 获取网站信息
        $site = new \app\common\model\Site();
        $site_info = $site->get(['code'=>static::$site_code]);
        $site_save = $site_info->allowField(true)->save($data);
        if (!$site_save) {
            $result = array('code'=>1,'message'=>'update site info fail');
            return $result;
        }
        $site_info = $site->get(['code'=>static::$site_code]);
        // 返回结果
        $result = array('code'=>0,'message'=>'update site info success','data'=>$site_info);
        return $result;
    }

}
