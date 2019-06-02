<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    /**
     * 默认首页
     */
    public function index()
    {
        $this->redirect('/index/login/index');
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
