<?php
require_once dirname(__FILE__) . '/common/MongoClass.php';

$mongo = MongoClass::init();
//查询名称为苹果的数据
$data = $mongo->find(array("name"=>"苹果"));
  	echo '<pre>';
  	print_r($data);//成功获取
  	echo '<pre>';
//insertFruit($db,$data);

/**
 * @description 批量插入fruit文档中
 * @param $db 选择的数据库名称
 * @param $post 需要插入的二维数组
 * @author 刘放
 * @date 2015/11/11 22:08
 */
function insertFruit($db,$post){
	for($i=0,$len=count($post);$i<$len;$i++){
		$db->fruit->insert($post[$i]);
	}
}