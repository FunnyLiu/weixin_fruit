<?php
/**
  * wechat php test
  */
include_once('wechatCallbackapiText.class.php');
//define your token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
$wechatObj->responseMsg();
?>