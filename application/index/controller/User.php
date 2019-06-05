<?php
namespace app\index\controller;

class User extends Base
{
    /**
     * 用户首页
     * @return mixed
     */
    public function index()
    {
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
        // 接收post数据
        $post_data = $this->request->post();
        // 保存数据
        $result = \app\common\controller\User::save($post_data);
        return $result;
    }

    /**
     * 设置当前用户资料
     * @return mixed
     */
    public function set()
    {
        return $this->fetch();
    }

    /**
     * 编辑用户信息
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $data = \app\common\model\User::get($id);
        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * 删除用户
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        $result = \app\common\controller\User::delete($id);
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
