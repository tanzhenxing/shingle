<?php
namespace app\index\controller;

class User extends Base
{
    public function index()
    {
        // 获取当前用户信息
        $session_username =  session('username');
        $user = \app\common\model\User::get(['username'=>$session_username]);
        $this->assign('user',$user);

        return $this->fetch();
    }

    /**
     * 管理员列表
     * @param int $number
     * @return mixed
     * @throws
     */
    public function admin($number = 10)
    {
        $list = \app\common\model\User::where(['type'=>0])->paginate($number);
        $this->assign('list',$list);
        $count = $list->total();
        $this->assign('count', $count);

        $page = $list->render();
        $this->assign('page', $page);
        return $this->fetch();
    }

    /**
     * 新增管理员
     * @return mixed
     */
    public function createAdmin()
    {
        return $this->fetch();
    }

    /**
     * 会员列表
     * @param int $number
     * @return mixed
     * @throws
     */
    public function member($number = 10)
    {
        $list = \app\common\model\User::where(['type'=>1])->paginate($number);
        $this->assign('list',$list);
        $count = $list->total();
        $this->assign('count', $count);

        $page = $list->render();
        $this->assign('page', $page);
        return $this->fetch();
    }

    /**
     * 新增会员
     * @return mixed
     */
    public function createMember()
    {
        return $this->fetch();
    }

    /**
     * 新增用户
     * @return mixed
     */
    public function create()
    {
        return $this->fetch();
    }

    /**
     * 保存用户信息
     * @return array
     */
    public function save()
    {
        $post_data = $this->request->post();
        $user = new \app\common\model\User();
        $get_user = $user->get(['username'=>$post_data['username']]);
        if (!empty($get_user)) {
            $result = array('code'=>1,'message'=>'username 已经存在');
            return $result;
        }
        // 保存用户信息
        $save = $user->allowField(true)->save($post_data);
        if ($save) {
            $result = array('code'=>0,'message'=>'创建会员成功');
        } else {
            $result = array('code'=>1,'message'=>'创建会员失败');
        }
        return $result;
    }

    /**
     * 设置当前用户资料
     * @return mixed
     */
    public function set()
    {
        $session_username = session('username');
        $user = \app\common\model\User::get(['username'=>$session_username]);
        $this->assign('user',$user);

        return $this->fetch();
    }

    /**
     * 编辑用户信息
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $user = \app\common\model\User::get($id);
        $this->assign('user',$user);

        return $this->fetch();
    }

    /**
     * 更新用户信息
     * @return array
     */
    public function update()
    {
        $post_data = $this->request->post();
        // 密码为空，则不修改
        if (empty($post_data['password'])) {
            unset($post_data['password']);
        } else {
            $post_data['password'] = password_hash($post_data['password'],PASSWORD_BCRYPT);
        }
        // 头像为空，则不修改
        if (empty($post_data['avatar'])) {
            unset($post_data['avatar']);
        }
        $user = \app\common\model\User::get($post_data['id']);

        if (empty($user)) {
            $result = array('code'=>1,'message'=>'user not exist');
            return $result;
        }
        // 保存用户信息到数据库
        unset($post_data['id']);
        $update_user = $user->allowField(true)->save($post_data);
        if ($update_user) {
            $result = array('code'=>0,'message'=>'update success');
        } else {
            $result = array('code'=>1,'message'=>'update fail');
        }
        return $result;
    }

    /**
     * 删除用户
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        $user = \app\common\model\User::get($id);
        if (empty($user)) {
            $result = array('code'=>1,'message'=>'user not exist');
            return $result;
        }
        $delete_user = $user->delete($id);
        if ($delete_user) {
            $result = array('code'=>0,'message'=>'delete the user success');
        } else {
            $result = array('code'=>1,'message'=>'delete the user fail');
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
