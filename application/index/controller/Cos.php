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
        // 云存储地域信息
        $cos_region_list = CosRegion::where(['status'=>1])->select();
        if (empty($cos_region_list)) {
            $result = array('code'=>1,'message'=>'腾讯云存储地域信息不存在');
            return $result;
        }
        $this->assign('region',$cos_region_list);
        // 获取腾讯云存储配置信息
        $cos = new \app\common\model\Cos();
        $cos_info = $cos->get(['code'=>'tencent']);
        if (empty($cos_info)) {
            $result = array('code'=>1,'message'=>'腾讯云存储配置信息不存在');
            return $result;
        }
        $this->assign('cos',$cos_info);

        // 获取当前云存储所在地域
        $my_region = CosRegion::get($cos_info['region_id']);
        if (empty($my_region)) {
            $result = array('code'=>1,'message'=>'腾讯云存储没有关联地域');
            return $result;
        }
        $this->assign('my_region',$my_region);

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
     * 获取云存储信息
     * @return array
     */
    public static function get()
    {
        // 获取cos 配置信息
        $cos = \app\common\model\Cos::get(['code'=>'tencent']);
        if (empty($cos)) {
            $result = array('code'=>1,'message'=>'cos 配置信息不存在');
            return $result;
        }
        $app_id = $cos['app_id'];
        $bucket_name = $cos['bucket_name'];
        $bucket = $bucket_name . '-' . $app_id;
        $cos['bucket'] = $bucket;
        $region_id = $cos['region_id'];
        // 获取cos 地域信息
        $cos_region = CosRegion::get($region_id);
        if (empty($cos_region)) {
            $result = array('code'=>1,'message'=>'cos 地域信息不存在');
            return $result;
        }
        $result = array('code'=>0,'message'=>'success','data'=>array('cos'=>$cos,'region'=>$cos_region));
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
