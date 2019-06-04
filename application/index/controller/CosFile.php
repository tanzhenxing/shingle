<?php
namespace app\index\controller;

use think\Controller;

class CosFile extends Controller
{
    /**
     * 保存云存储文件信息
     * @param $data
     * @return array
     */
    public static function save($data)
    {
        // 验证数据
        $validate = new \app\common\validate\CosFile();
        if (!$validate) {
            $result = array('code'=>1,'message'=>$validate->getError());
            return $result;
        }
        // 保存数据
        $cos_file = new \app\common\model\CosFile();
        $save = $cos_file->allowField(true)->save($data);
        if (!$save) {
            $result = array('code'=>1,'message'=>'save cos file fail');
            return $result;
        }
        // 获取cos文件信息
        $cos_file_info = $cos_file->get(['url_md5'=>$data['url_md5']]);
        if (empty($cos_file_info)) {
            $result = array('code'=>1,'message'=>'not in database');
            return $result;
        }
        // 返回结果
        $result = array('code'=>0,'message'=>'save cos file success','data'=>$cos_file_info);
        return json($result);
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