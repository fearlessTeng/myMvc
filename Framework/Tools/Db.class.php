<?php
/**
 * Created by PhpStorm.
 * Email: wenmang2015@qq.com
 * Date: 2017/8/22
 * Time: 9:11
 * Company: 源码时代重庆校区
 */
/**
 * 1.根据业务需要确定类名(大驼峰):Db
 * 2.根据外部特征设置属性
 *      属性:主机名,用户名,密码,数据库,端口,字符集
 *
 * 3.根据内部功能声明方法
 *
 *
 *
 *
 * 三私一公:
 * 1.私有化构造方法(不能new出对象);
 * 2.设置一个公有静态方法用来创建对象
 * 3.设置一个私有静态属性用来存储第2步创建的对象
 * 4.私有克隆魔术方法
 */
//声明一个Db类
class Db{

    //声明属性
    private $host="127.0.0.1";
    private $user="root";
    private $password;
    private $database="test";
    private $port=3306;
    private $charset="utf8";

    //3.创建一个静态的私有的属性用来存储第2步创建对象
    private static $obj=null;
    //声明一个$conn存MYSQL连接资源
    private $conn;
   //构造函数初始化属性

    //1.私有化构造方法
    private function __construct($config)
    {
        foreach ($config as $k=>$v){
            $this->$k=$v;
        }
        //先连接数据库
        $this->dbConnect();
        //设置字符集
        $this->setCharset();
    }

    //2.设置一个公开的静态方法用来创建一个对象
    public static function createObject($config=[]){

       //如果$obj为空
       if (null===self::$obj){
           //创建对象
           self::$obj=new self($config);
       }
       //返回对象
       return self::$obj;

    }

    //连接数据库
    private function dbConnect()
    {
      $this->conn=  mysqli_connect($this->host,$this->user,$this->password,$this->database,$this->port);
      //判断是否出错
        if (false===$this->conn){

            exit("连接数据库出错:".mysqli_connect_error());
        }
    }
    //设置字符集
    private function setCharset(){
       $result=mysqli_query($this->conn,"set names ".$this->charset);
       if(false===$result){
           exit("设置符集出错:".mysqli_error($this->conn));
       }
    }

    //执行SQL语句
    public function query($sql){

       $result=mysqli_query($this->conn,$sql);
       if (false===$result){
           exit("执行SQL语句:".$sql."出错:".mysqli_error($this->conn));
       }
       return $result;
    }

    //声明一个方法返回所有结果
    public function fetchAll($sql){
        //1.得到结果集
        $result=$this->query($sql);
       return mysqli_fetch_all($result,MYSQLI_ASSOC);
    }

    //声明一个方法取出一条数据
    public function fetchRow($sql){
        //1.执行SQL语句=调用query方法
        // $result= mysqli_query($this->conn,$sql);
        $result=$this->query($sql);
        //2.整理结果集
       $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
        //返回结果集
        return $row;

    }

    //声明一个方法返回第一行第一列第一条数据
    public function fetchColumn($sql){
        $result=$this->query($sql);
        //2.整理结果集
        $row=mysqli_fetch_array($result,MYSQLI_NUM);

        if (null===$row){
            return "没有数据";
        }
        //返回结果集
        return $row[0];


    }

    //4.私有化克隆魔术方法
    private function __clone()
    {

    }

    //析构方法
    public function __destruct()
    {
        mysqli_close($this->conn);
    }

}
