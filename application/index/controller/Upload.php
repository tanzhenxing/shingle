<?php
namespace app\index\controller;

use app\common\model\FileExtension;
use think\facade\Env;

class Upload extends Base
{
    /**
     * 文件上传功能测试页
     * @return mixed
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 上传文件到本地服务器
     * @return array
     */
    public function file()
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 获取原文件名后缀
        $file_name = $file->getInfo('name');
        $file_path_info = pathinfo($file_name);
        $file_extension = $file_path_info['extension'];
        // 检查文件类型是否允许上传
        $file_extension_check = static::check($file_extension);
        if ($file_extension_check['code']) {
            return $file_extension_check;
        }
        $path = Env::get('root_path') . 'public/upload';
        $info = $file->move($path);
        if($info){
            $file_path = '/upload/' . $info->getSaveName();
            $file_path = str_replace('\\','/',$file_path);
            $result = array('code'=>0,'message'=>'success','data'=>array('url'=>$file_path,'src'=>$file_path));
        } else {
            // 上传失败获取错误信息
            $result = array('code'=>1,'message'=>$file->getError());
        }
        return $result;
    }

    /**
     * 上传文件到云存储
     * @return array|string
     */
    public function cos()
    {
        // 获取文件信息
        $file = $this->request->file('file');
        $file_info = $file->getInfo(); // 属性： 临时文件路径 tmp_name ，原文件名 name，错误 error，文件类型 type，文件大小 size
        $file_path = $file->getInfo('tmp_name'); // 本地文件路径
        if($file_info['error']){
            $result = array('status'=>0,'message'=>'获取上传文件信息失败！');
            return $result;
        }
        if($file_info['size'] == 0){
            $result = array('status'=>0,'message'=>'上传文件失败！文件大小为空');
            return $result;
        }
        // 获取原文件名后缀
        $file_name = $file->getInfo('name');
        $file_path_info = pathinfo($file_name);
        $file_extension = $file_path_info['extension'];
        // 检查文件类型是否允许上传
        $file_extension_check = static::check($file_extension);
        if ($file_extension_check['code']) {
            return $file_extension_check;
        }
        // 组合存放到云存储的文件路径
        $server_file_name = time() . rand(10000,99999) . '.' . $file_extension;
        $server_file_path = 'files/' . date('Y',time()) . '/' . date('m',time()) . '/'. date('d',time()) . '/' . $server_file_name;

        // 上传文件到腾讯云存储
        $cos_upload = \app\common\controller\Cos::Upload($file_path,$server_file_path);
        $file_url = $cos_upload['data']['url'];
        if (empty($file_url)) {
            $result = array('code'=>1,'message'=>'获取cos云存储上的文件网址失败');
        } else {
            $result = array('code'=>0 ,'message'=>'文件上传成功！', 'data'=>array('url'=>$file_url));
        }
        return $result;
    }

    /**
     * 检查文件类型是否允许上传
     * @param $extension
     * @return array
     */
    public function check($extension)
    {
        $file_extension = FileExtension::get(['status'=>1,'extension'=>$extension]);
        if (empty($file_extension)) {
            $result = array('code'=>1,'message'=>'文件类型：.' . $extension . ' 不允许上传');
        } else {
            $result = array('code'=>0,'message'=>'文件类型：.' . $extension . ' 允许上传');
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
