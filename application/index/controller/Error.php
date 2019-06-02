<?php
/**
 * Created by PhpStorm.
 * User: tanzhenxing
 * Date: 2018/7/20
 * Time: 15:53
 */
namespace app\index\controller;

use think\Controller;

class Error extends Controller
{
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
