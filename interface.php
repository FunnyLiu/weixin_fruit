<?php
header("Content-Type:text/html;chartset=utf-8");
require_once dirname(__FILE__) . '/common/GlobalFunctions.php';
function checkSignature() {
  $signature = $_GET["signature"];
  $timestamp = $_GET["timestamp"];
  $nonce = $_GET["nonce"];
            
  $token = TOKEN;
  $tmpArr = array($token, $timestamp, $nonce);
  // use SORT_STRING rule
  sort($tmpArr, SORT_STRING);
  $tmpStr = implode($tmpArr);
  $tmpStr = sha1($tmpStr);
  
  if($tmpStr == $signature){
    return true;
  }else{
    return false;
  }
}

if(checkSignature()) {
  if($_GET["echostr"]) {
    echo $_GET["echostr"];
    exit(0);
  }
}else {
  //恶意请求：获取来源ip，并写日志...
  //$ip = getIp();
  //没写完interface_log(ERROR, EC_OTHER)
}

function getWeChatObj($toUserName) {
  if($toUserName == USERNAME_FRUIT) {
    require_once dirname(__FILE__) . '/class/WeChatCallBackFruit.php';
    return new WeChatCallBackFruit();
  }
  require_once dirname(__FILE__) . '/class/WeChatCallBack.php';
  return new WeChatCallBack();
}

function exitErrorInput() {
  echo 'error input!';
  //各种日志...
  exit(0);
}

//读取post数据
$postStr = file_get_contents("php://input");
#这里写postStr的日志...

//如果没有post数据
if(empty($postStr)) {
  #日志...
  exitErrorInput();
}
//获取参数
$postObj = simplexml_load_string($postStr);
$toUserName = (string)trim($postObj->ToUserName);
if(!$toUserName) {
  #日志...
}else {
  $wechatObj = getWeChatObj($toUserName);
}
$ret = $wechatObj->init($postObj);
if(!$ret) {
  #日志...
}
$retStr = $wechatObj->process();
#日志...
echo $retStr;
#日志...