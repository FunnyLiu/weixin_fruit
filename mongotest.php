<?php
$mongo = new Mongo();
//$alldb = $mongo->listDBs();//获取所有数据库名称
$db = $mongo->fruitdb;
//$result = $db->fruit->count();//获取数量
//echoName($db);//输出name
	$arrayList =array(
		array("name"=>"lflf","age"=>4),
		array("name"=>"tyqtyq","age"=>5),
		);

	insertFruit($db,$arrayList);
//$db->fruit->insert(array("name"=>"lflf","age"=>1));
/**
 * @description 批量输出fruit文档中的name属性
 * @param $db 选择的数据库名称
 * @author 刘放
 * @date 2015/11/11 21:36
 */
function echoName($db){
	$result = $db->fruit->find();
	foreach ($result as $item) {
		echo $item["name"].'<br>';
	}
}
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