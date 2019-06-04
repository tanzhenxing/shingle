<?php
namespace app\index\controller;

use think\Controller;

class Login extends Controller
{
    /**
     * 登录页
     * @return mixed
     */
    public function index()
    {
        // 获取网站信息
        $site = \app\common\controller\Site::info();
        if ($site['code']) {
            return $site;
        }
        $this->assign('site',$site['data']);

        return $this->fetch();
    }

    /**
     * 登录检查
     * @return array
     */
    public function check()
    {
        // 接收post数据
        $post_data = $this->request->post();
        // 用户登录验证
        $user_login_validate = \app\common\controller\User::loginValidate($post_data);
        if ($user_login_validate['code']) {
            return $user_login_validate;
        }
        // 返回结果
        $result = array('code'=>0,'message'=>'login success');
        return json($result);
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