<?php

namespace app\common\validate;

use think\Validate;

class MessageReplyFile extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'reply_id'=>'require|integer',
        'file_id'=>'require|integer',
        'sort'=>'require|integer',
        'status'=>'require|in:0,1'
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];
}
