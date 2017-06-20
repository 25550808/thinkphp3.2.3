<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace Behavior;

/**
 * 记录请求参数，SQL日志
 */

use Think\Instance;

class WriteRequestLogBehavior
{
    static public $_instance = null;

    private function __construct()
    {
    }

    public function __clone()
    {
        exit('Objects are not allowed to create');
    }

    /**
     * 实例化对象
     *
     * @return mixed
     */
    static public function instance()
    {
        if (empty(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }


    /**
     * 记录请求
     */
    public function recordRequest()
    {
       
        if(PHP_SAPI === 'cli'){
            return;
        }

        G('api_time_end');

        $duartion = G('loadTime', 'api_time_end');
        try {
            $model = new Instance(C('LOG_DB'));

            $uid = 0;
            if(isset($_REQUEST['token'])){
                $uid = S($_REQUEST['token']);

                $uid = !empty($uid) && is_int($uid)? $uid : 0;
            }

            $data = [
                'uid'         => $uid,
                'domain'      => isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '',
                'reference'   => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
                'uri'         => isset($_SERVER['REQUEST_URI']) ? (strpos($_SERVER['REQUEST_URI'], '?') === false ? $_SERVER['REQUEST_URI'] : strstr($_SERVER['REQUEST_URI'], '?', true)) : '',
                'params'      => $_SERVER['REQUEST_METHOD'] == 'POST' ? json_encode($_POST, JSON_UNESCAPED_UNICODE) : json_encode($_GET, JSON_UNESCAPED_UNICODE),
                'param_extra' => empty($_FILES) ? '' : json_encode($_FILES, JSON_UNESCAPED_UNICODE),
                'ip'          => get_client_ip(),
                'type'        => isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST' ? 2 : 1,
                'duration'    => $duartion
            ];

            if (!empty($data['domain'])) {
                $model->table('request_log')->add($data);
            }else{
                throw new \Exception('SERVER变量解析异常');
            }
        } catch (\Exception $e) {
            $data = [
                'uid'         => 0,
                'domain'      => empty(getenv('SERVER_NAME')) ? $e->getFile() : getenv('SERVER_NAME'),
                'reference'   => empty(getenv('HTTP_REFERER')) ? $e->getCode() : getenv('HTTP_REFERER'),
                'uri'         => empty(getenv('REQUEST_URI')) ? $e->getLine() : getenv('REQUEST_URI'),
                'params'      => empty($_REQUEST) ? $e->getMessage() : json_encode($_REQUEST, JSON_UNESCAPED_UNICODE),
                'param_extra' => '',
                'ip'          => get_client_ip(),
                'type'        => 9,
                'duration'    => $duartion
            ];

            $model->table('request_log')->add($data);
        }
    }
}
