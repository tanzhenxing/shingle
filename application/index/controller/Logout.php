<?php
namespace app\index\controller;


class Logout extends Base
{
    /**
     * 注销登录
     */
    public function index()
    {
        // 注销session
        session('username',null);
        // 返回首页
        $this->redirect('/');
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
