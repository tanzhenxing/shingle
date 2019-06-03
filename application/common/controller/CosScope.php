<?php
namespace app\common\controller;


class CosScope
{
    protected $action;
    protected $bucket;
    protected $region;
    protected $resourcePrefix;

    /**
     * @param $action
     * @param $bucket
     * @param $region
     * @param $resourcePrefix
     */
    public function initialize($action, $bucket, $region, $resourcePrefix)
    {
        $this->action = $action;
        $this->bucket = $bucket;
        $this->region = $region;
        $this->resourcePrefix = $resourcePrefix;
    }

    public function get_action()
    {
        return $this->action;
    }

    public function get_resource()
    {
        $index = strripos($this->bucket, '-');
        $bucketName = substr($this->bucket, 0, $index);
        $appid = substr($this->bucket, $index + 1);
        if(!(strpos($this->resourcePrefix, '/') === 0)){
            $this->resourcePrefix = '/' . $this->resourcePrefix;
        }
        return 'qcs::cos:' . $this->region . ':uid/' . $appid . ':prefix//' . $appid . '/' . $bucketName . $this->resourcePrefix;
    }

}