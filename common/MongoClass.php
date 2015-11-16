<?php
/**
 * mongo数据库操作类
 */
class MongoClass {
  public static $mongo;
  private $db;	
  function __construct(){
    $this->mongo = new Mongo();
    //初始化连接fruitdb数据库
    $this->db = $this->mongo->fruitdb;
  }

/**
 * @description 单例模式初始化连接数据库
 * @return mongo数据库实例
 * @author 刘放
 * @date 2015/11/16 15:00
 */
  public static function init(){
    if(!(self::$mongo instanceof self)){
      self::$mongo = new self();
    }
    return self::$mongo;
  }
 /**
   * @description 输出指定json文件夹中内容
   * @param url 文件所在路径
   * @author 刘放
   * @date 2015/11/16 15:12
   */ 
  public function echoData($url='./db.json'){
  	$json_string = file_get_contents($url);
  	$data = json_decode($json_string,true);
  	echo '<pre>';
  	print_r($data);
  	echo '<pre>';
    return $data;
  }
/**
 * @description 输出所有数据库名称和大小
 * @author 刘放
 * @date 2015/11/16 15:13
 */
  public function listAllDBs(){
  	$data = $this->mongo->listDBs();
  	print_r($data);
  }
/**
 * @description 输出指定集合名称的某属性合集
 * @param collection 集合名称
 * @param attr 属性名称
 * @author 刘放
 * @date 2015/11/16 15:35
 */
  public function echoCollection($collection = 'fruit',$attr = 'name'){
    $result = $this->db->selectCollection($collection)->find();
    foreach ($result as $item) {
      echo $item[$attr].'<br>';
    }
  }
/**
 * @description 输出指定条件的查询结果
 * @param condition 查询条件
 * @param collection 指定集合
 * @return 返回查询后结果数组
 * @author 刘放
 * @date 2015/11/16 17:13
 */
  public function find($condition = '',$collection = 'fruit'){
    $result = $this->db->selectCollection($collection)->find($condition);
    $data = iterator_to_array($result);
    return $data;
  }



}