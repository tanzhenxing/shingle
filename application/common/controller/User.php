<?php
namespace app\common\controller;

use app\common\validate\UserLogin;
use think\Controller;

class User extends Controller
{
    /**
     * 用户登录验证
     * @param $data
     * @return array
     */
    public static function loginValidate($data)
    {
        // 验证登录信息
        $validate = new UserLogin();
        if (!$validate) {
            $result = array('code'=>1,'message'=>$validate->getError());
            return $result;
        }
        // 检查用户名是否存在
        $get_user = \app\common\model\User::get(['username'=>$data['username']]);
        if(empty($get_user)) {
            $result = array('code'=>1,'message'=>'username not exist.');
            return $result;
        }
        // 检测密码是否正确
        // $password = password_hash($data['password'],PASSWORD_BCRYPT); // 密码加密方式
        if (!password_verify($data['password'],$get_user['password'])) {
            $result = array('code'=>1,'message'=>'password is error.');
            return $result;
        }
        // 保存用户登录session 记录
        session('username',$get_user['username']);
        // 返回结果
        $result = array('code'=>0,'message'=>'user login success','data'=>$get_user);
        return $result;
    }

    /**
     * 当前用户是否已登录检测
     * @return array
     */
    public static function loginCheck()
    {
        // 检查用户session是否存在
        $session_username = session('username');
        if(empty($session_username)) {
            $result = array('code'=>1,'message'=>'this user session is null,not login.');
            return $result;
        }
        // 检查用户是否登录
        $get_user = \app\common\model\User::get(['username'=>$session_username]);
        if(empty($get_user)) {
            $result = array('code'=>1,'message'=>'username is error.');
            return $result;
        }
        // 返回结果
        $result = array('code'=>0,'message'=>'user login check success','data'=>array('user_login'=>$get_user));
        return $result;
    }

    /**
     * 保存数据记录
     * @param $data
     * @return array
     */
    public static function save($data)
    {
        // 获取数据
        $query = array('username'=>$data['username']);
        $obj = new \app\common\model\User();
        $get_data = $obj->get($query);
        if (empty($get_data)) { // 新建记录
            $result = static::create($data);
        } else { // 更新记录
            unset($data['username']);
            $data['id'] = $get_data['id'];
            $result = static::update($data);
        }
        // 返回保存成功结果
        return $result;
    }

    /**
     * 创建数据记录
     * @param $data
     * @return array
     */
    public static function create($data)
    {
        // 验证数据
        if (isset($data['id'])) {
            $result = array('code'=>1,'message'=>'id 已经存在');
            return $result;
        }
        $validate = new \app\common\validate\User();
        if (!$validate->check($data)) {
            $result = array('code'=>1,'message'=>$validate->getError());
            return $result;
        }
        // 保存数据
        $obj = new \app\common\model\User();
        $save = $obj->allowField(true)->save($data);
        // 返回保存失败结果
        if (!$save) {
            $result = array('code'=>1,'message'=>'保存数据失败');
            return $result;
        }
        // 重新获取最新的数据
        $query = array('username'=>$data['username']);
        $result_data = $obj->get($query);
        // 返回保存成功结果
        $result = array('code'=>0,'message'=>'保存数据成功','data'=>$result_data);
        return $result;
    }

    /**
     * 更新数据记录
     * @param $data
     * @return array
     */
    public static function update($data)
    {
        // 验证数据
        if (!isset($data['id']) or !is_int($data['id'])) {
            $result = array('code'=>1,'message'=>'id: '.$data['id'] .' 无效');
            return $result;
        }
        // 获取数据
        $obj = new \app\common\model\User();
        $get_data = $obj->get($data['id']);
        if (empty($get_data)) { // 新建记录
            $result = array('code'=>1,'message'=>'id：'.$data['id'] .' 不存在');
            return $result;
        }
        // 保存数据
        $save = $obj->allowField(true)->save($data);
        // 返回保存失败结果
        if (!$save) {
            $result = array('code'=>1,'message'=>'保存数据失败','data'=>$data);
            return $result;
        }
        // 重新获取最新的数据
        $result_data = $obj->get($data['id']);
        // 返回保存成功结果
        $result = array('code'=>0,'message'=>'保存数据成功','data'=>$result_data);
        return $result;
    }

}
