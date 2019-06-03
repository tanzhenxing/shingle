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
        $post_data = $this->request->post();
        // $password = password_hash($post_data['password'],PASSWORD_BCRYPT); // 密码加密方式
        // 检查用户名是否存在
        $user_info = \app\common\model\User::get(['username'=>$post_data['username']]);
        if(empty($user_info)) {
            $result = array('code'=>1,'message'=>'username or password is error.');
            return $result;
        }
        // 检测密码是否正确
        if (!password_verify($post_data['password'],$user_info['password'])) {
            $result = array('code'=>1,'message'=>'password is error.');
            return $result;
        }
        // 保存用户session 记录
        session('username',$user_info['username']);
        // 返回结果
        $result = array('code'=>0,'message'=>'login success');
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