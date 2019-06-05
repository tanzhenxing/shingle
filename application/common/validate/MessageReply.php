<?php

namespace app\common\validate;

use think\Validate;

class MessageReply extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'user_id'=>'require|integer',
        'message_id'=>'require|integer',
        'content'=>'require',
        'uuid'=>'require|alphaNum|length:32',
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
