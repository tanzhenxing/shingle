<?php
namespace app\index\controller;

use app\common\controller\CosFile;
use app\common\controller\MessageFile;
use app\common\model\MessageRead;
use app\common\model\MessageReply;
use app\common\model\MessageReplyFile;
use Ramsey\Uuid\Uuid;

class Message extends Base
{
    /**
     * 消息列表
     * @param null $type
     * @return mixed
     * @throws
     */
    public function index($type = null)
    {
        // 获取消息分类
        if (empty($type)) {
            $list = \app\common\model\Message::where(['status'=>1])->order('update_time desc')->select();
        } else {
            $message_category = \app\common\model\MessageCategory::get(['unique_code'=>$type]);
            if (empty($message_category)) {
                $result = array('code'=>1,'message'=>'case category is null');
                return $result;
            }
            $list = \app\common\model\Message::where(['status'=>1,'category_id'=>$message_category['id']])->order('update_time desc')->select();
        }

        $unread_array = array();
        $unanswered_array = array();
        foreach ($list as &$item) {
            // 截取消息简介
            $description = preg_replace("/<.*?>/is","",$item['content']); // 过滤html标记
            $item['description'] = substr($description,0,200);
            // 获取消息接收人信息
            $to_user_id = $item['to_user_id'];
            $get_to_user = \app\common\model\User::get($to_user_id);
            if (empty($get_to_user)) {
                $result = array('code'=>1,'message'=>'to_user_id not exits');
                return json($result);
            }
            $item['to_user'] = $get_to_user;
            // 获取消息发送人信息
            $get_send_user = \app\common\model\User::get($item['user_id']);
            if (empty($get_send_user)) {
                $result = array('code'=>1,'message'=>'send_user_id not exits');
                return json($result);
            }
            $item['send_user'] = $get_send_user;
            // 判断当前登录的用户是否已读消息
            $message_read = MessageRead::get(['message_id'=>$item['id'],'user_id'=>$this->user_login['id']]);
            if (empty($message_read)) {
                $unread_array[] = $item;
                $item['read'] = 0;
            } else {
                $item['read'] = 1;
            }
            // 判断当前登录的用户是否已回复消息
            $message_reply = MessageReply::get(['message_id'=>$item['id'],'user_id'=>$this->user_login['id']]);
            if (empty($message_reply)) {
                $unanswered_array[] = $item;
                $item['reply'] = 0;
            } else {
                $item['reply'] = 1;
            }
        }

        $this->assign('list',$list);
        $this->assign('total', count($list));

        $this->assign('unread',$unread_array);
        $this->assign('unread_total',count($unread_array));

        $this->assign('unanswered',$unanswered_array);
        $this->assign('unanswered_total',count($unanswered_array));

        return $this->fetch();
    }

    /**
     * 消息管理列表
     * @param int $number
     * @return array|mixed
     * @throws
     */
    public function manage($number = 10)
    {
        // 获取所有的消息
        $list = \app\common\model\Message::where(['status'=>1])->paginate($number);
        foreach ($list as &$item) {
            // 获取消息接收人信息
            $get_to_user = \app\common\model\User::get($item['to_user_id']);
            if (empty($get_to_user)) {
                $result = array('code'=>1,'message'=>'to_user_id not exits');
                return $result;
            }
            $item['to_user'] = $get_to_user;
            // 获取消息发送人信息
            $get_send_user = \app\common\model\User::get($item['user_id']);
            if (empty($get_send_user)) {
                $result = array('code'=>1,'message'=>'send_user_id not exits');
                return $result;
            }
            $item['send_user'] = $get_send_user;
        }

        $this->assign('list',$list);
        $count = $list->total();
        $this->assign('count', $count);

        $page = $list->render();
        $this->assign('page', $page);

        return $this->fetch();
    }

    /**
     * 读取消息
     * @param $id
     * @return array|mixed
     * @throws
     */
    public function read($id)
    {
        // 获取cos 配置信息
        $cos_info = \app\common\controller\Cos::info();
        if ($cos_info['code']) {
            return $cos_info;
        }
        $cos_json_url = 'https://' . $cos_info['data']['cos']['bucket'] . '.' . $cos_info['data']['region']['json_domain'];
        $this->assign('cos',$cos_info['data']);
        // 获取消息信息
        $message = \app\common\model\Message::get($id);
        if (empty($message)) {
            $result = array('code'=>1,'message'=>'message not exits');
            return $result;
        }
        $this->assign('message',$message);

        // 获取发送人信息
        $send_user = \app\common\model\User::get($message['user_id']);
        if (empty($send_user)) {
            $result = array('code'=>1,'message'=>'user_id not exits');
            return $result;
        }
        $this->assign('send_user',$send_user);
        // 获取接收人信息
        $to_user = \app\common\model\User::get($message['to_user_id']);
        if (empty($to_user)) {
            $result = array('code'=>1,'message'=>'to_user_id not exits');
            return $result;
        }
        $this->assign('to_user',$to_user);
        // 获取消息附件
        $files_array = array();
        $message_file = \app\common\model\MessageFile::where(['message_id'=>$message['id'],'status'=>1])->order('sort desc')->select();
        if (!empty($message_file)) {
            foreach ($message_file as $item) {
                $cos_file = \app\common\model\CosFile::get($item['file_id']);
                if (!empty($cos_file)) {
                    $files_array[] = array('url'=>$cos_json_url . $cos_file['url'],'name'=>$cos_file['name']);
                }
            }
        }
        $this->assign('files',$files_array);

        // 获取回复列表
        $message_reply = MessageReply::where(['message_id'=>$message['id']])->select();
        if (!empty($message_reply)) {
            foreach ($message_reply as &$reply) {
                $user_id = $reply['user_id'];
                $reply_user = \app\common\model\User::get($user_id);
                $reply['username'] = $reply_user['username'];
                $reply['avatar'] = $reply_user['avatar'];
                $reply['nickname'] = $reply_user['nickname'];
                // 获取回复附件
                $files_array = array();
                $message_file = MessageReplyFile::where(['reply_id'=>$reply['id'],'status'=>1])->order('sort desc')->select();
                if (!empty($message_file)) {
                    foreach ($message_file as $item) {
                        $file_id = $item['file_id'];
                        $cos_file = \app\common\model\CosFile::get($file_id);
                        if (!empty($cos_file)) {
                            $files_array[] = array('url'=>$cos_json_url . $cos_file['url'],'name'=>$cos_file['name']);
                        }
                    }
                }
                $reply['files'] = $files_array;
            }
        }
        $this->assign('reply',$message_reply);

        // 保存已读记录
        $get_message_read = MessageRead::get(['message_id'=>$id,'user_id'=>$this->user_login['id']]);
        if (empty($get_message_read)) {
            $read_data_array = array('message_id'=>$id,'user_id'=>$this->user_login['id'],'status'=>1);
            $message_read = \app\common\controller\MessageRead::save($read_data_array);
            if ($message_read['code']) {
                return $message_read;
            }
        }

        // 获取uuid
        $uuid4 = Uuid::uuid4();
        $uuid = $uuid4->getHex();
        $this->assign('uuid',$uuid);

        return $this->fetch();
    }

    /**
     * 新增消息
     * @return mixed
     * @throws
     */
    public function create()
    {
        // 获取消息分类
        $message_category = \app\common\model\MessageCategory::where(['status'=>1])->select();
        $this->assign('category',$message_category);

        // 获取用户信息
        $session_username = session('username');
        $user_list = \app\common\model\User::where(['status'=>1,'type'=>1])->select();
        $user_list_array = array();
        foreach ($user_list as $item) {
            if ($item['username'] != $session_username) { // 从记录中去掉当前登录的用户
                $user_list_array[] = $item;
            }
        }
        $this->assign('user_list',$user_list_array);

        // 获取cos 配置信息
        $cos_info = \app\common\controller\Cos::info();
        if ($cos_info['code']) {
            return $cos_info;
        }
        $this->assign('cos',$cos_info['data']);

        // 获取uuid
        $uuid4 = Uuid::uuid4();
        $uuid = $uuid4->getHex();
        $this->assign('uuid',$uuid);

        return $this->fetch();
    }

    /**
     * 保存数据
     * @return array
     * @throws
     */
    public function save()
    {
        // 接收post数据
        $post_data = $this->request->post();
        // 获取当前用户id
        $user_id = $this->user_login['id'];

        // 保存消息数据
        $message_array = array('category_id'=>$post_data['category_id'],'user_id'=>$user_id,'to_user_id'=>$post_data['to_user_id'],'title'=>$post_data['title'],'content'=>$post_data['content'],'uuid'=>$post_data['uuid'],'status'=>1);
        $message_save = \app\common\controller\Message::save($message_array);
        if ($message_save['code']) {
            $result = array('code'=>1,'message'=>'save message fail');
            return $result;
        }
        $message_id = $message_save['data']['id'];

        // 保存附件信息到数据库
        $cos_file_array = array();
        if (!empty($post_data['files'])) {
            foreach ($post_data['files'] as $item) {
                $str_len = strlen($item);
                $file_name_len = $str_len - 28;
                $file_name = substr($item,28,$file_name_len);
                $url_md5 = md5($item);
                $cos_file_data = array('user_id'=>$user_id,'name'=>$file_name,'url'=>$item,'url_md5'=>$url_md5,'status'=>1);
                $save_cos_file = CosFile::save($cos_file_data);
                if ($save_cos_file['code']) {
                    return $save_cos_file;
                }
                $cos_file_array[] = $save_cos_file['data'];
            }
        }
        // 保存消息附件信息
        $message_file_array = array();
        foreach ($cos_file_array as $cos_file) {
            $message_file_data = array('message_id'=>$message_id,'file_id'=>$cos_file['id'],'sort'=>$cos_file['id'],'status'=>1);
             $message_file = MessageFile::save($message_file_data);
             if ($message_file['code']) {
                return $message_file;
             }
            $message_file_array[] = $message_file_data;
        }
        // 返回结果
        $result = array('code'=>0,'message'=>'save message success','data'=>$message_array);
        return $result;
    }

    /**
     * 回复消息
     * @param $id
     * @return array|mixed
     * @throws
     */
    public function reply($id)
    {
        // 获取cos 配置信息
        $cos_info = \app\common\controller\Cos::info();
        if ($cos_info['code']) {
            return $cos_info;
        }
        $cos_json_url = 'https://' . $cos_info['data']['cos']['bucket'] . '.' . $cos_info['data']['region']['json_domain'];
        $this->assign('cos',$cos_info['data']);
        // 获取消息信息
        $message = \app\common\model\Message::get($id);
        if (empty($message)) {
            $result = array('code'=>1,'message'=>'message not exits');
            return $result;
        }
        $this->assign('message',$message);

        // 发送人信息
        $send_user = \app\common\model\User::get($message['user_id']);
        if (empty($send_user)) {
            $result = array('code'=>1,'message'=>'user_id not exits');
            return $result;
        }
        $this->assign('send_user',$send_user);

        // 获取接收人信息
        $to_user = \app\common\model\User::get($message['to_user_id']);
        if (empty($to_user)) {
            $result = array('code'=>1,'message'=>'to_user_id not exits');
            return $result;
        }
        $this->assign('to_user',$to_user);
        // 获取消息附件
        $files_array = array();
        $message_file = \app\common\model\MessageFile::where(['message_id'=>$message['id'],'status'=>1])->order('sort desc')->select();
        if (!empty($message_file)) {
            foreach ($message_file as $item) {
                $file_id = $item['file_id'];
                $cos_file = \app\common\model\CosFile::get($file_id);
                if (!empty($cos_file)) {
                    $files_array[] = array('url'=>$cos_json_url . $cos_file['url'],'name'=>$cos_file['name']);
                }
            }
        }
        $this->assign('files',$files_array);

        // 获取回复列表
        $message_reply = MessageReply::where(['message_id'=>$message['id']])->select();
        if (!empty($message_reply)) {
            foreach ($message_reply as &$reply) {
                $user_id = $reply['user_id'];
                $reply_user = \app\common\model\User::get($user_id);
                $reply['username'] = $reply_user['username'];
                $reply['avatar'] = $reply_user['avatar'];
                $reply['nickname'] = $reply_user['nickname'];
                // 获取回复附件
                $files_array = array();
                $message_file = \app\common\model\MessageReplyFile::where(['reply_id'=>$reply['id'],'status'=>1])->order('sort desc')->select();
                if (!empty($message_file)) {
                    foreach ($message_file as $item) {
                        $file_id = $item['file_id'];
                        $cos_file = \app\common\model\CosFile::get($file_id);
                        if (!empty($cos_file)) {
                            $files_array[] = array('url'=>$cos_json_url . $cos_file['url'],'name'=>$cos_file['name']);
                        }
                    }
                }
                $reply['files'] = $files_array;
            }
        }
        $this->assign('reply',$message_reply);

        return $this->fetch();
    }

    /**
     * 编辑消息
     * @param $id
     * @return array|mixed
     * @throws
     */
    public function edit($id)
    {
        // 获取cos 配置信息
        $cos_info = \app\common\controller\Cos::info();
        if ($cos_info['code']) {
            return $cos_info;
        }
        $cos_json_url = 'https://' . $cos_info['data']['cos']['bucket'] . '.' . $cos_info['data']['region']['json_domain'];
        $this->assign('cos',$cos_info['data']);

        // 获取消息信息
        $message = \app\common\model\Message::get($id);
        if (empty($message)) {
            $result = array('code'=>1,'message'=>'message not exits');
            return $result;
        }
        $this->assign('message',$message);

        // 发送人信息
        $send_user = \app\common\model\User::get($message['user_id']);
        if (empty($send_user)) {
            $result = array('code'=>1,'message'=>'user_id not exits');
            return $result;
        }
        $this->assign('send_user',$send_user);

        // 获取接收人信息
        $to_user = \app\common\model\User::get($message['to_user_id']);
        if (empty($to_user)) {
            $result = array('code'=>1,'message'=>'to_user_id not exits');
            return $result;
        }
        $this->assign('to_user',$to_user);
        // 获取消息附件
        $files_array = array();
        $message_file = \app\common\model\MessageFile::where(['message_id'=>$message['id'],'status'=>1])->order('sort desc')->select();
        if (!empty($message_file)) {
            foreach ($message_file as $item) {
                $file_id = $item['file_id'];
                $cos_file = \app\common\model\CosFile::get($file_id);
                if (!empty($cos_file)) {
                    $files_array[] = array('url'=>$cos_json_url . $cos_file['url'],'name'=>$cos_file['name']);
                }
            }
        }
        $this->assign('files',$files_array);

        // 获取回复列表
        $message_reply = MessageReply::where(['message_id'=>$message['id']])->select();
        if (!empty($message_reply)) {
            foreach ($message_reply as &$reply) {
                $user_id = $reply['user_id'];
                $reply_user = \app\common\model\User::get($user_id);
                $reply['username'] = $reply_user['username'];
                $reply['avatar'] = $reply_user['avatar'];
                $reply['nickname'] = $reply_user['nickname'];
                // 获取回复附件
                $files_array = array();
                $message_file = \app\common\model\MessageReplyFile::where(['reply_id'=>$reply['id'],'status'=>1])->order('sort desc')->select();
                if (!empty($message_file)) {
                    foreach ($message_file as $item) {
                        $file_id = $item['file_id'];
                        $cos_file = \app\common\model\CosFile::get($file_id);
                        if (!empty($cos_file)) {
                            $files_array[] = array('url'=>$cos_json_url . $cos_file['url'],'name'=>$cos_file['name']);
                        }
                    }
                }
                $reply['files'] = $files_array;
            }
        }
        $this->assign('reply',$message_reply);

        return $this->fetch();
    }

    /**
     * 消息 软删除
     * @param $id
     * @return array
     */
    public function softDelete($id)
    {
        $data = \app\common\model\Message::get($id);
        $update_array = array('id'=>$id,'status'=>0,'uuid'=>$data['uuid']);
        $result = \app\common\controller\Message::save($update_array);
        return $result;
    }

    /**
     * 搜索消息
     * @param null $keywords
     * @return mixed
     * @throws
     */
    public function search($keywords = null)
    {
        $this->assign('keywords',$keywords);
        // 获取消息列表
        $message = \app\common\model\Message::where('title','like','%' . $keywords .'%')->select();
        foreach ($message as &$item) {
            $get_user = \app\common\model\User::get($item['user_id']);
            $item['user'] = $get_user;
            $description = preg_replace("/<.*?>/is","",$item['content']); // 过滤html标记
            $item['description'] = substr($description,0,160);
            // 判断消息是否已读
            $message_read = MessageRead::get(['message_id'=>$item,'user_id'=>$this->user_login['id']]);
            if (empty($message_read)) {
                $item['read'] = 0;
            } else {
                $item['read'] = 1;
            }
        }
        $this->assign('message',$message);
        $total = count($message);
        $this->assign('total',$total);
        return $this->fetch();
    }

    /**
     * 消息附件上传
     * @return mixed
     */
    public function file()
    {
        // 获取cos 配置信息
        $cos_info = \app\common\controller\Cos::info();
        if ($cos_info['code']) {
            return $cos_info;
        }
        $this->assign('cos',$cos_info['data']);
        return $this->fetch();
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