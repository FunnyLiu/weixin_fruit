<?php
header("Content-Type:text/html;chartset=utf-8");
require_once dirname(__FILE__) . '/common/GlobalFunctions.php';

/**
 * @description 判断是否是微信服务器
 * @return true为是，false为不是
 * @author 田雨晴
 * @date 2015/11/8 13:30
 */
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
  interface_log(ERROR, EC_OTHER, 'malicious:' . '$ip');
  exit(0);
}

/**
 * @description:            判断调用哪个公众号
 * @param $toUserName:      公众号id
 * @return                  公众号对象实体
 * @author：                田雨晴
 * @date:                   2015/11/8 13:44
 */
function getWeChatObj($toUserName) {
  if($toUserName == USERNAME_FRUIT) {
    require_once dirname(__FILE__) . '/class/WeChatCallBackFruit.php';
    return new WeChatCallBackFruit();
  }
  require_once dirname(__FILE__) . '/class/WeChatCallBack.php';
  return new WeChatCallBack();
}

/**
 * @description 输入消息错误记录日志
 * @author 田雨晴
 * @date 2015/11/8 14:00
 */
function exitErrorInput() {
  echo 'error input!';
  interface_log(INFO, EC_OK, "***** interface request end *****");
  interface_log(INFO, EC_OK, "*********************************");
  interface_log(INFO, EC_OK, "");
  exit(0);
}

//读取post数据
$postStr = file_get_contents("php://input");

interface_log(INFO, EC_OK, "");
interface_log(INFO, EC_OK, "************************************");
interface_log(INFO, EC_OK, "****** interface request start *****");
interface_log(INFO, EC_OK, 'request:' . $postStr);
interface_log(INFO, EC_OK, 'get:' . var_export($_GET, true));

//如果没有post数据
if(empty($postStr)) {
  interface_log(ERROR, EC_OK, "error input!");
  exitErrorInput();
}
//获取参数
$postObj = simplexml_load_string($postStr);
$toUserName = (string)trim($postObj->ToUserName);
if(!$toUserName) {
  interface_log(ERROR, EC_OK, "error input!");
  exitErrorInput();
}else {
  $wechatObj = getWeChatObj($toUserName);
}
$ret = $wechatObj->init($postObj);
if(!$ret) {
  interface_log(ERROR, EC_OK, "error input!");
  exitErrorInput();
}
$retStr = $wechatObj->process();
interface_log(INFO, EC_OK, "response:" . $retStr);
echo $retStr;
interface_log(INFO, EC_OK, "****** interface request end *****");
interface_log(INFO, EC_OK, "**********************************");
interface_log(INFO, EC_OK, "");

?>