<?php
namespace app\index\controller;

class Message extends Base
{
    public function index()
    {
        return $this->fetch();
    }

    public function create()
    {

    }

    public function save()
    {

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