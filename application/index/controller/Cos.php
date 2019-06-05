<?php
namespace app\index\controller;

use app\common\model\CosRegion;

class Cos extends Base
{
    /**
     * 编辑腾讯云存储配置信息
     * @return array|mixed
     * @throws
     */
    public function edit()
    {
        // 云存储地域信息列表
        $cos_region_list = CosRegion::where(['status'=>1])->select();
        if (empty($cos_region_list)) {
            $result = array('code'=>1,'message'=>'腾讯云存储地域信息不存在');
            return json($result);
        }
        $this->assign('region',$cos_region_list);
        // 获取腾讯云存储配置信息
        $cos_info = \app\common\controller\Cos::info();
        if ($cos_info['code']) {
            return json($cos_info);
        }
        $this->assign('cos',$cos_info['data']);

        return $this->fetch();
    }

    /**
     * 更新腾讯云存储配置信息
     * @return array
     */
    public function save()
    {
        // 接收post 数据
        $post_data = $this->request->post();
        // 保存数据
        $cos = \app\common\controller\Cos::save($post_data);
        return $cos;
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
