<?php
return [
	    // 数据库配置
    'DB_TYPE'   => 'mysql',         // 数据库类型
    'DB_HOST'   => 'localhost',   // 服务器地址
    'DB_NAME'   => 'main',    // 数据库名
    'DB_USER'   => 'root',          // 用户名
    'DB_PWD'    => '',          // 密码
    'DB_PORT'   => '3306',          // 端口
    'DB_PREFIX' => 'zdy',        // 数据库表前缀
    'DB_DEBUG'  => true,            // 开启调试


    //LOG数据库
    'LOG_DB'    => [
        'DB_TYPE'   => 'mysql',         // 数据库类型
        'DB_HOST'   => 'localhost',   // 服务器地址
        'DB_NAME'   => 'log',    // 数据库名
        'DB_USER'   => 'root',          // 用户名
        'DB_PWD'    => '',          // 密码
        'DB_PORT'   => '3306',          // 端口
        'DB_PREFIX' => 'zdy',        // 数据库表前缀
        'DB_DEBUG'  => true,            // 开启调试
    ],
];