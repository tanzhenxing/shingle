<?php
namespace app\index\controller;


class FileExtension extends Base
{
    /**
     * 列表页
     * @param int $number
     * @return mixed
     * @throws
     */
    public function index($number = 20)
    {
        $list = \app\common\model\FileExtension::where('status','>=',0)->paginate($number);
        $this->assign('list',$list);
        $count = $list->total();
        $this->assign('count', $count);
        $page = $list->render();
        $this->assign('page', $page);
        return $this->fetch();
    }

    /**
     * 新增
     * @return mixed
     * @throws
     */
    public function create()
    {
        return $this->fetch();
    }

    /**
     * 保存数据
     * @return array
     */
    public function save()
    {
        // 接收post 数据
        $post_data = $this->request->post();
        $result = \app\common\controller\FileExtension::create($post_data);
        return $result;
    }

    /**
     * 编辑
     * @param $id
     * @return mixed
     * @throws
     */
    public function edit($id)
    {
        // 获取数据
        $get_data = \app\common\model\FileExtension::get($id);
        if (empty($get_data)) {
            $result = array('code'=>1,'message'=>"ID: $id 无数据");
            return json($result);
        }
        $this->assign('data',$get_data);
        return $this->fetch();
    }

    /**
     * 更新数据
     * @return array
     */
    public function update()
    {
        $post_data = $this->request->post();
        $result = \app\common\controller\FileExtension::update($post_data);
        return $result;
    }

    /**
     * 软删除
     * @return array
     */
    public function sortDelete()
    {
        $post_data = $this->request->post();
        $result = \app\common\controller\FileExtension::update(['id'=>$post_data['id'],'status'=>$post_data['status']]);
        return $result;
    }

    /**
     * 真删除
     * @return array
     */
    public function delete()
    {
        $id = $this->request->post('id');
        $result = \app\common\controller\FileExtension::delete($id);
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
