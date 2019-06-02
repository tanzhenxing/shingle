<?php
namespace app\index\controller;

class Cos extends Base
{
    /**
     * 编辑腾讯云存储配置信息
     * @return mixed
     */
    public function edit()
    {
        // 获取腾讯云存储配置信息
        $cos = new \app\common\model\Cos();
        $cos_info = $cos->get(['code'=>'tencent']);
        if (empty($cos_info)) {
            $result = array('code'=>1,'message'=>'腾讯云存储配置信息不存在');
            return $result;
        }
        $this->assign('cos',$cos_info);
        return $this->fetch();
    }

    /**
     * 更新腾讯云存储配置信息
     * @return array
     */
    public function update()
    {
        // 接收post 数据
        $post_data = $this->request->post();
        // 获取腾讯云存储配置信息
        $cos = new \app\common\model\Cos();
        $cos_info = $cos->get(['code'=>'tencent']);
        if (empty($cos_info)) {
            $result = array('code'=>1,'message'=>'腾讯云存储配置信息不存在');
            return $result;
        }
        // 保存配置信息
        $save = $cos_info->allowField(true)->save($post_data);
        if ($save) {
            $result = array('code'=>0,'message'=>'保存成功');
        } else {
            $result = array('code'=>0,'message'=>'保存失败');
        }
        return $result;
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
