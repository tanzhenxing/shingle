<?php
namespace app\index\controller;

class Site extends Base
{
    /**
     * 编辑网站信息
     * @return mixed
     */
    public function edit()
    {
        return $this->fetch();
    }

    /**
     * 更新网站信息
     * @return array
     */
    public function update()
    {
        $post_data = $this->request->post();
        if (empty($post_data['thumb'])) {
            unset($post_data['thumb']);
        }
        if (empty($post_data['logo'])) {
            unset($post_data['logo']);
        }
        if (empty($post_data['icon'])) {
            unset($post_data['icon']);
        }
        $site = new \app\common\model\Site();
        $site_info = $site->get(['code'=>$this->site_code]);
        $site_save = $site_info->allowField(true)->save($post_data);
        if ($site_save) {
            $result = array('code'=>0,'message'=>'update site info success');
        } else {
            $result = array('code'=>1,'message'=>'update site info fail');
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
