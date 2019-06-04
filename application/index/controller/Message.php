<?php
namespace app\index\controller;

use app\common\model\CosRegion;
use app\common\model\MessageRead;
use app\common\model\MessageReply;

class Message extends Base
{
    /**
     * 消息列表
     * @param $number
     * @return array|mixed
     * @throws
     */
    public function index()
    {
        // 获取所有的消息
        $list = \app\common\model\Message::where(['status'=>1])->order('update_time desc')->select();
        $unread_array = array();
        $unanswered_array = array();
        foreach ($list as &$item) {
            // 获取 接收人信息
            $to_user_id = $item['to_user_id'];
            $to_user_info = \app\common\model\User::get($to_user_id);
            if (empty($to_user_info)) {
                $result = array('code'=>1,'message'=>'to_user_id not exits');
                return $result;
            }
            $item['to_user_username'] = $to_user_info['username'];
            $item['to_user_nickname'] = $to_user_info['nickname'];
            $item['to_user_avatar'] = $to_user_info['avatar'];
            $get_user = \app\common\model\User::get($item['user_id']);
            $item['user'] = $get_user;
            $description = preg_replace("/<.*?>/is","",$item['content']); // 过滤html标记
            $item['description'] = substr($description,0,200);
            // 判断消息是否已读
            $login_user = $this->login_user;
            $message_read = MessageRead::get(['message_id'=>$item['id'],'user_id'=>$login_user['id']]);
            if (empty($message_read)) {
                $unread_array[] = $item;
                $item['read'] = 0;
            } else {
                $item['read'] = 1;
            }
            // 判断消息是否已回复
            $message_reply = MessageReply::get(['message_id'=>$item['id']]);
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
        // 获取当前用户信息
        $session_username = session('username');
        $user = \app\common\model\User::get(['username'=>$session_username]);
        if (empty($user)) {
            $result = array('code'=>1,'message'=>'user not exits');
            return $result;
        }
        // 获取当前用户的消息
        $list = \app\common\model\Message::where(['status'=>1])->paginate($number);
        // 获取 接收人信息
        foreach ($list as &$item) {
            $to_user_id = $item['to_user_id'];
            $to_user_info = \app\common\model\User::get($to_user_id);
            if (empty($user)) {
                $result = array('code'=>1,'message'=>'to_user_id not exits');
                return $result;
            }
            $item['to_user_username'] = $to_user_info['username'];
            $item['to_user_nickname'] = $to_user_info['nickname'];
            $item['to_user_avatar'] = $to_user_info['avatar'];
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
        $cos = \app\common\model\Cos::get(['code'=>'tencent']);
        if (empty($cos)) {
            $result = array('code'=>1,'message'=>'cos 配置信息不存在');
            return $result;
        }
        $app_id = $cos['app_id'];
        $bucket_name = $cos['bucket_name'];
        $bucket = $bucket_name . '-' . $app_id;
        $cos['bucket'] = $bucket;
        $region_id = $cos['region_id'];
        // 获取cos 地域信息
        $cos_region = CosRegion::get($region_id);
        if (empty($cos_region)) {
            $result = array('code'=>1,'message'=>'cos 地域信息不存在');
            return $result;
        }
        // $xml_domain = $cos_region['xml_domain'];
        $json_domain = $cos_region['json_domain'];

        $cos['region_name'] = $cos_region['name'];
        $this->assign('cos',$cos);

        $message = \app\common\model\Message::get($id);
        if (empty($message)) {
            $result = array('code'=>1,'message'=>'message not exits');
            return $result;
        }
        $this->assign('message',$message);

        // 当前登录的用户
        $session_username = session('username');
        $user = \app\common\model\User::get(['username'=>$session_username]);
        if (empty($user)) {
            $result = array('code'=>1,'message'=>'user_id not exits');
            return $result;
        }
        $this->assign('user',$user);

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
                    $files_array[] = array('url'=>'https://' . $bucket . '.' . $json_domain . $cos_file['url'],'name'=>$cos_file['name']);
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
                            $files_array[] = array('url'=>'https://' . $bucket . '.' . $json_domain . $cos_file['url'],'name'=>$cos_file['name']);
                        }
                    }
                }
                $reply['files'] = $files_array;
            }
        }
        $this->assign('reply',$message_reply);

        // 保存已读记录
        $message_read = new MessageRead();
        $message_read_info = $message_read->get(['message_id'=>$id]);
        if (empty($message_read_info)) {
            $read_data_array = array('message_id'=>$id,'user_id'=>$this->login_user['id'],'status'=>1);
            $message_read_save = $message_read->allowField(true)->save($read_data_array);
            if (!$message_read_save) {
                $result = array('code'=>1,'message'=>'save message read fail');
                return $result;
            }
        }

        return $this->fetch();
    }

    /**
     * 新增消息
     * @return mixed
     * @throws
     */
    public function create()
    {
        // 获取用户信息
        $session_username = session('username');
        $user = \app\common\model\User::where(['status'=>1,'type'=>1])->select();
        $user_array = array();
        foreach ($user as $item) {
            if ($item['username'] != $session_username) { // 从记录中去掉当前用户
                $user_array[] = $item;
            }
        }
        $this->assign('user',$user_array);

        // 获取cos 配置信息
        $cos_info = \app\common\controller\Cos::info();
        if ($cos_info['code']) {
            return $cos_info;
        }
        $this->assign('cos',$cos_info['data']);

        return $this->fetch();
    }

    /**
     * 保存消息
     * @return array
     */
    public function save()
    {
        // 接收post数据
        $post_data = $this->request->post();
        // 验证数据
        $validate = new \app\index\validate\Message();
        if (!$validate->check($post_data)) {
            $result = array('code'=>1,'message'=>$validate->getError());
            return $result;
        }
        // 获取当前用户id
        $user_id = $this->user_login['id'];

        // 保存消息到数据
        $message_array = array('user_id'=>$user_id,'to_user_id'=>$post_data['to_user_id'],'title'=>$post_data['title'],'content'=>$post_data['content'],'status'=>1);
        $message = new \app\common\model\Message();
        $save = $message->allowField(true)->save($message_array);
        if (!$save) {
            $result = array('code'=>1,'message'=>'save message fail');
            return $result;
        }
        $message_id = $message->id;

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
                    $files_array[] = array('url'=>'https://' . $cos_info['data']['cos']['bucket'] . '.' . $cos_info['data']['region']['json_domain'] . $cos_file['url'],'name'=>$cos_file['name']);
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
                            $files_array[] = array('url'=>'https://' . $cos_info['data']['cos']['bucket'] . '.' . $cos_info['data']['region']['json_domain'] . $cos_file['url'],'name'=>$cos_file['name']);
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
        $this->assign('cos',$cos_info['data']);

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
                    $files_array[] = array('url'=>'https://' . $cos_info['data']['cos']['bucket'] . '.' . $cos_info['data']['region']['json_domain'] . $cos_file['url'],'name'=>$cos_file['name']);
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
                            $files_array[] = array('url'=>'https://' . $cos_info['data']['cos']['bucket'] . '.' . $cos_info['data']['region']['json_domain'] . $cos_file['url'],'name'=>$cos_file['name']);
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
     * 保存更新信息
     * @return array
     */
    public function update()
    {
        $post_data = $this->request->post();
        // 验证post数据

        // 保存 message_reply 信息
        $reply_array = array('user_id'=>$post_data['user_id'],'message_id'=>$post_data['message_id'],'content'=>$post_data['content'],'status'=>1);
        $message_reply = new MessageReply();
        $reply_save = $message_reply->allowField(true)->save($reply_array);
        if (!$reply_save) {
            $result = array('code'=>1,'message'=>'save message reply fail');
            return $result;
        }
        $message_reply_id = $message_reply->id;

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
     * 消息 软删除
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        $message = \app\common\model\Message::get($id);
        $save = $message->save(['status'=>0]);
        if ($save) {
            $result = array('code'=>0,'message'=>'delete message success');
        } else {
            $result = array('code'=>1,'message'=>'delete message fail');
        }
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
        $message = \app\common\model\Message::where('title','like',$keywords.'%')->select();
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