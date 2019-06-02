<?php
namespace app\index\controller;

use think\facade\Env;

class Upload extends Base
{
    /**
     * 上传文件到本地服务器
     * @return array
     */
    public static function file()
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        $path = Env::get('root_path') . 'public/upload';
        $info = $file->move($path);
        if($info){
            $file_path = '/upload/' . $info->getSaveName();
            $file_path = str_replace('\\','/',$file_path);
            $result = array('code'=>0,'message'=>'success','data'=>array('url'=>$file_path));
        } else {
            // 上传失败获取错误信息
            $result = array('code'=>1,'message'=>$file->getError());
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
