<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/29
 * Time: 18:19
 */

abstract class Controller
{
//用来存储传递过来的数据
protected $data=[];

    /**
     * 显示视图
     * @param $template 视图文件
     */
    protected function display($template){

    //  从数组中将变量导入到当前的符号表  就是把数组中键名当成变量名,数组中的键值对应变量的名值
        extract($this->data);
        //var_dump($this->data);

        //引用视图文件
        include CURRENT_VIEW_PATH.$template.".html";
        exit;
    }

    /**
     * 传递数据到视图
     * @param $key 视图中接收的变量
     * @param string $value 控制器中传递的值
     */
    protected function assign($key,$value=""){

        //如果参数时数组（必须为关联数组）,则合并
        if (is_array($key)){
            //数组合并
            $this->data=array_merge($this->data,$key);
        }else{
            //给data赋值
            $this->data[$key]=$value;
        }

    }

    protected function redirect($url,$msg="",$time=0){
        if($time){
            echo "<h1>".$msg."</h1>";
        }
        //跳转
        header("Refresh:".$time.";".$url);
        exit;

    }


}