<?php
namespace app\index\controller;

class CosFile extends Base
{
    /**
     * 保存云存储文件信息
     * @param $data
     * @return array
     */
    public static function save($data)
    {
        $cos_file = new \app\common\model\CosFile();
        $save = $cos_file->allowField(true)->save($data);
        if ($save) {
            $cos_file_info = $cos_file->get(['url_md5'=>$data['url_md5']]);
            if (empty($cos_file_info)) {
                $result = array('code'=>1,'message'=>'not in database');
                return $result;
            }
            $result = array('code'=>0,'message'=>'save cos file success','data'=>$cos_file_info);
        } else {
            $result = array('code'=>1,'message'=>'save message fail');
        }
        return $result;
    }

}