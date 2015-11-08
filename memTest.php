<?php
$mem = new Memcached();
if(!$mem->addServer('127.0.0.1',11211))
{
	die('连接失败！');
}
$mem->set('name','lf');
var_dump($mem->get('name'));