<?php
/**
 * Created by PhpStorm.
 * Email: wenmang2015@qq.com
 * Date: 2017/8/28
 * Time: 11:24
 * Company: 源码时代重庆校区
 */

//定义为抽象类，只能被继承
abstract class Model
{
//声明一个属性用来存储连接数据库的资源
    protected $db;
    //声明一个存储错误信息属性
    protected $error;
    public function __construct()
    {
        //1. 连接数据库
        //include_once TOOLS_PATH."Db.class.php";
//2. 静态调用
        $this->db = Db::createObject($GLOBALS['config']['db']);

    }

    //声明公开的方法获得错误信息
    public function getError()
    {
        return $this->error;

    }

}