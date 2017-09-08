<?php
@session_start;
defined("DS") or define("DS",DIRECTORY_SEPARATOR);//斜杠
defined("ROOT_PATH") or define("ROOT_PATH",__DIR__.DS);//项目根目录
defined("APP_PATH") or define("APP_PATH",ROOT_PATH."Application".DS);//应用目录
defined("FRAME_PATH") or define("FRAME_PATH",ROOT_PATH."Framework".DS);//核心框架目录
defined("PUBLIC_PATH") or define("PUBLIC_PATH",ROOT_PATH."Public".DS);//公共目录
defined("UPLOADS_PATH") or define("UPLOADS_PATH",ROOT_PATH."Uploads".DS);//上传目录
defined("CONFIG_PATH") or define("CONFIG_PATH",APP_PATH."Config".DS);//配置目录
defined("CONTROLLER_PATH") or define("CONTROLLER_PATH",APP_PATH."Controller".DS);//控制器目录
defined("MODEL_PATH") or define("MODEL_PATH",APP_PATH."Model".DS);//模型目录
defined("VIEW_PATH") or define("VIEW_PATH",APP_PATH."View".DS);//模型目录

defined("TOOLS_PATH") or define("TOOLS_PATH",FRAME_PATH."Tools".DS);//工具类目录

//加载配置文件
$GLOBALS['config']=include CONFIG_PATH."application.config.php";

//接收方法
$a=isset($_GET['a'])?$_GET['a']:$GLOBALS['config']['app']['default_action'];
//接收控制器
$c=isset($_GET['c'])?$_GET['c']:$GLOBALS['config']['app']['default_controller'];
//接收平台
$p=isset($_GET['p'])?$_GET['p']:$GLOBALS['config']['app']['default_platform'];

defined("CURRENT_CONTROLLER_PATH") or define("CURRENT_CONTROLLER_PATH",CONTROLLER_PATH.$p.DS);//当前控制器目录

defined("CURRENT_VIEW_PATH") or define("CURRENT_VIEW_PATH",VIEW_PATH.$p.DS.$c.DS);//当前视图目录


//必需放在上面
spl_autoload_register("autoload");

//创建对象
$className=$c."Controller";
$controller=new $className();

//对象调用方法显示
$controller->$a();

//自动加载 $class是自动传过来的类的名称
function autoload($class)
{
    //声明一个数组用来装特殊的类文件的映射
    $classMapping = [
        "Model" => FRAME_PATH . "Model.class.php",
        "Db" => TOOLS_PATH . "Db.class.php",
        "Controller"=>FRAME_PATH."Controller.class.php"
    ];
    //判断特殊类文件数组里存不存该类文件的映射
    if (isset($classMapping[$class])) {
        //载入特殊类文件
        include $classMapping[$class];
    } elseif (substr($class, -10) === "Controller") {
        //加载控制器类文件
        include CURRENT_CONTROLLER_PATH . $class . ".class.php";
    } elseif (substr($class, -5) === "Model") {
        //加载模型类文件
        include MODEL_PATH . $class . ".class.php";
    }
}