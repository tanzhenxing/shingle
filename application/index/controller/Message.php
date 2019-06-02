<?php
namespace app\index\controller;

class Message extends Base
{
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 新增消息
     * @return mixed
     */
    public function create()
    {
        return $this->fetch();
    }

    public function save()
    {
        $post_data = $this->request->post();
        dump($post_data);
    }

    public function edit($id)
    {

    }

    public function update()
    {

    }

    public function delete($id)
    {

    }

    public function search()
    {

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