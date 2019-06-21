<?php
namespace app\common\controller;

use think\Controller;

class FileExtension extends Controller
{
    /**
     * 推送数据
     * @param $data
     * @return array
     */
    public static function push($data)
    {
        if (!isset($data['extension']) or empty($data['extension'])) {
            $result = array('code'=>1,'message'=>'unique_code不能为空');
            return $result;
        }
        $get_data = \app\common\model\FileExtension::get(['extension'=>$data['extension']]);
        if (empty($get_data)) {
            $result = static::create($data);
        } else {
            $data['id'] = $get_data['id'];
            $result = static::update($data);
        }
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
            $result = array('code'=>1,'message'=>'不能提交id');
            return $result;
        }
        if (!isset($data['extension']) or empty($data['extension'])) {
            $result = array('code'=>1,'message'=>'extension不能为空');
            return $result;
        }
        // 验证数据内容是否合法
        $validate = new \app\common\validate\FileExtension();
        if (!$validate->check($data)) {
            $result = array('code'=>1,'message'=>$validate->getError());
            return $result;
        }
        // 保存数据
        $obj = new \app\common\model\FileExtension();
        $save = $obj->allowField(true)->save($data);
        // 返回保存失败结果
        if (!$save) {
            $result = array('code'=>1,'message'=>'数据保存失败');
            return $result;
        }
        // 重新获取最新的数据
        $query = array('extension'=>$data['extension']);
        $result_data = $obj->get($query);
        // 返回保存成功结果
        $result = array('code'=>0,'message'=>'数据保存成功','data'=>$result_data);
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
        if (!isset($data['id']) or !is_numeric($data['id'])) {
            $result = array('code'=>1,'message'=>'id: '.$data['id'] .' 无效');
            return $result;
        }
        // 清除空数据
        foreach ($data as $key=>$value) {
            if ($value==='') {
                unset($data[$key]);
            }
        }
        // 验证数据格式
        $validate = new \app\common\validate\FileExtension();
        if (!$validate->check($data)) {
            $result = array('code'=>1,'message'=>$validate->getError());
            return $result;
        }
        // 获取数据
        $obj = new \app\common\model\FileExtension();
        $get_data = $obj->get($data['id']);
        if (empty($get_data)) {
            $result = array('code'=>1,'message'=>'id：'.$data['id'] .' 不存在');
            return $result;
        }
        // 保存数据
        $save_array = $data;
        unset($save_array['id']);
        $save = $get_data->allowField(true)->save($save_array);
        // 返回保存失败结果
        if (!$save) {
            $result = array('code'=>1,'message'=>'数据更新失败','data'=>$data);
            return $result;
        }
        // 重新获取最新的数据
        $result_data = $obj->get($data['id']);
        // 返回保存成功结果
        $result = array('code'=>0,'message'=>'数据更新成功','data'=>$result_data);
        return $result;
    }

    /**
     * 真删除
     * @param $id
     * @return array
     */
    public static function delete($id)
    {
        $get_data = \app\common\model\FileExtension::get($id);
        if (empty($get_data)) {
            $result = array('code'=>1,'message'=>'id:' . $id . '不存在');
            return $result;
        }
        $delete = $get_data->delete($id);
        if ($delete) {
            $result = array('code'=>0,'message'=>'删除成功');
        } else {
            $result = array('code'=>1,'message'=>'删除失败');
        }
        return $result;
    }

}