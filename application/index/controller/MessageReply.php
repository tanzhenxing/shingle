<?php
namespace app\index\controller;

use app\common\controller\CosFile;
use app\common\controller\MessageReplyFile;

class MessageReply extends Base
{
    /**
     * 保存消息回复数据
     * @return array
     */
    public function save()
    {
        $post_data = $this->request->post();
        // 保存 message_reply 信息
        $reply_array = array('user_id'=>$post_data['user_id'],'message_id'=>$post_data['message_id'],'content'=>$post_data['content'],'uuid'=>$post_data['uuid'],'status'=>$post_data['status']);
        $message_reply_save = \app\common\controller\MessageReply::save($reply_array);
        if ($message_reply_save['code']) {
            $result = array('code'=>1,'message'=>'save message reply fail');
            return $result;
        }
        $message_reply_id = $message_reply_save['data']['id'];
        // 保存附件信息到数据库
        $cos_file_array = array();
        if (!empty($post_data['files'])) {
            foreach ($post_data['files'] as $item) {
                $str_len = strlen($item);
                $file_name_len = $str_len - 28;
                $file_name = substr($item,28,$file_name_len);
                $url_md5 = md5($item);
                $cos_file_data = array('user_id'=>$this->user_login['id'],'name'=>$file_name,'url'=>$item,'url_md5'=>$url_md5,'status'=>1);
                $save_cos_file = CosFile::save($cos_file_data);
                if ($save_cos_file['code']) {
                    return $save_cos_file;
                }
                $cos_file_array[] = $save_cos_file['data'];
            }
        }

        // 保存消息回复附件信息
        $message_file_array = array();
        foreach ($cos_file_array as $cos_file) {
            $message_file_data = array('reply_id'=>$message_reply_id,'file_id'=>$cos_file['id'],'sort'=>$cos_file['id'],'status'=>1);
            $message_file = MessageReplyFile::save($message_file_data);
            if ($message_file['code']) {
                return $message_file;
            }
            $message_file_array[] = $message_file_data;
        }
        // 返回结果
        $result = array('code'=>0,'message'=>'save message success','data'=>$reply_array);
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