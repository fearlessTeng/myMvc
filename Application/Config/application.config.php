<?php
/*private $host="127.0.0.1";
private $user="root";
private $password;
private $database="test";
private $port=3306;
private $charset="utf8";*/
return [
    "db" => [
        //主机名
        'host' => '127.0.0.1',
        //用户名
        'user' => 'root',
        //密码
        'password' => 'root',
        //库名
        'database' => 'myshop',
        //端口
        'port' => 3306,
        //字符集
        'charset' => 'utf8'
    ],
    "app" =>[
        //默认平台
        'default_platform'=>'Admin',
        //默认控制器
        'default_controller'=>'Admin',
        //默认的方法
        'default_action'=>'index'
    ]
];