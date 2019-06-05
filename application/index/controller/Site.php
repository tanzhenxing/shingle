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
    public function save()
    {
        $post_data = $this->request->post();
        $site_update = \app\common\controller\Site::save($post_data);
        return $site_update;
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
