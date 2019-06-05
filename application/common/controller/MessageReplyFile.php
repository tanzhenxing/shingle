<?php
namespace app\common\controller;

use think\Controller;

class MessageReplyFile extends Controller
{
    /**
     * 保存数据记录
     * @param $data
     * @return array
     */
    public static function save($data)
    {
        // 获取数据
        $query = array('message_id'=>$data['message_id'],'file_id'=>$data['file_id']);
        $obj = new \app\common\model\MessageReplyFile();
        $get_data = $obj->get($query);
        if (empty($get_data)) { // 新建记录
            $result = static::create($data);
        } else { // 更新记录
            unset($data['message_id'],$data['file_id']);
            $data['id'] = $get_data['id'];
            $result = static::update($data);
        }
        // 返回保存成功结果
        return $result;
    }

    /**
     * 创建数据记录
     * @param $data
     * @return array
     */
    public static function create($data)
    {
        // 验证数据
        if (isset($data['id'])) {
            $result = array('code'=>1,'message'=>'id 已经存在');
            return $result;
        }
        $validate = new \app\common\validate\MessageReplyFile();
        if (!$validate->check($data)) {
            $result = array('code'=>1,'message'=>$validate->getError());
            return $result;
        }
        // 保存数据
        $obj = new \app\common\model\MessageReplyFile();
        $save = $obj->allowField(true)->save($data);
        // 返回保存失败结果
        if (!$save) {
            $result = array('code'=>1,'message'=>'保存数据失败');
            return $result;
        }
        // 重新获取最新的数据
        $query = array('message_id'=>$data['message_id'],'file_id'=>$data['file_id']);
        $result_data = $obj->get($query);
        // 返回保存成功结果
        $result = array('code'=>0,'message'=>'保存数据成功','data'=>$result_data);
        return $result;
    }

    /**
     * 更新数据记录
     * @param $data
     * @return array
     */
    public static function update($data)
    {
        // 验证数据
        if (!isset($data['id']) or !is_int($data['id'])) {
            $result = array('code'=>1,'message'=>'id: '.$data['id'] .' 无效');
            return $result;
        }
        // 获取数据
        $obj = new \app\common\model\MessageReplyFile();
        $get_data = $obj->get($data['id']);
        if (empty($get_data)) { // 新建记录
            $result = array('code'=>1,'message'=>'id：'.$data['id'] .' 不存在');
            return $result;
        }
        // 保存数据
        $save = $obj->allowField(true)->save($data);
        // 返回保存失败结果
        if (!$save) {
            $result = array('code'=>1,'message'=>'保存数据失败','data'=>$data);
            return $result;
        }
        // 重新获取最新的数据
        $result_data = $obj->get($data['id']);
        // 返回保存成功结果
        $result = array('code'=>0,'message'=>'保存数据成功','data'=>$result_data);
        return $result;
    }

}