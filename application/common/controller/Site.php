<?php
namespace app\common\controller;

use think\Controller;

class Site extends Controller
{
    /**
     * 获取网站信息
     * @param $code
     * @return array
     */
    public static function info($code)
    {
        // 获取网站信息
        $site_info = \app\common\model\Site::get(['code'=>$code]);
        if (empty($site_info)) {
            $result = array('code'=>1,'message'=>'site info is null');
            return $result;
        }
        // 返回结果
        $result = array('code'=>0,'message'=>'success','data'=>$site_info);
        return $result;
    }

}
