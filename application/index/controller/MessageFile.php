<?php
namespace app\index\controller;

class MessageFile extends Base
{
    public static function save($data)
    {
        $message_file = new \app\common\model\MessageFile();
        $save = $message_file->allowField(true)->save($data);
        if ($save) {
            $message_file_info = $message_file->get(['message_id'=>$data['message_id'],'file_id'=>$data['file_id']]);
            if (empty($message_file_info)) {
                $result = array('code'=>1,'message'=>'not in database');
                return $result;
            }
            $result = array('code'=>0,'message'=>'save success','data'=>$message_file_info);
        } else {
            $result = array('code'=>1,'message'=>'save fail');
        }
        return $result;
    }
}