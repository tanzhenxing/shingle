<?php

namespace app\common\validate;

use think\Validate;

class CosRegion extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'title'=>'require',
        'name'=>'require|alphaDash',
        'short_name'=>'require|alphaDash',
        'cdn_domain'=>'require|activeUrl',
        'xml_domain'=>'require|activeUrl',
        'json_domain'=>'require|activeUrl',
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
