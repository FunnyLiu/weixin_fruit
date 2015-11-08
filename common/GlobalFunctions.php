<?php
/**
 * 全局函数
 */
require_once dirname(__FILE__) . '/GlobalDefine.php';
//获取来源ip
function getIp() {

}
/**
 * @description 获取AccessToken
 * @return AccessToken的值
 * @author 刘放
 * @date 2015/11/8 14:40
 */
function getAccessToken(){
	$mem = new Memcached();
	if(!$mem->addServer('127.0.0.1',11211)){
		return "连接memcached失败";
	}
	$access_token = $mem->get('access_token');
	//如果memcached中缓存时间过期或者没有accesstoken，则重新请求
	if(!$access_token){
		$token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".APPID."&secret=".APPSECRET;
		$output = curlGet($token_access_url);
		//接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
		$result = json_decode($output, true);
		$access_token = $result['access_token'];
		$mem->set('access_token',$access_token,7200);
	}
	return $access_token;	
}
/**
 * @description 模拟get请求
 * @param $url 需要请求的url
 * @return 返回json格式结果
 * @author 刘放
 * @date 2015/11/8 14:41
 */
function curlGet($url){
	//获取文件内容或获取网络请求的内容
	if(!curl_init()){
		return "";
	}
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
/**
 * @description 模拟post请求
 * @param $url 需要请求的url
 * @param $post 请求的post内容
 * @return 返回json格式结果
 * @author 刘放
 * @date 2015/11/8 14:41
 */
function curlPost($url,$post){
	if(!curl_init()){
		return "";
	}
	//获取文件内容或获取网络请求的内容
	$header[] = 'Content-type:text/xml';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	// post数据
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	// post的变量
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 

	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

/**
 * 默认打开所有的日志文件
 * ERROR、INFO、DEBUG日志级别对应的关闭标记文件分别为NO_ERROR、NO_INFO、NO_DEBUG
 */
function isLogLevelOff($logLevel) {
  //ROOT_PATH在GlobalDefine.php中定义为当前文件的上一级目录
  $switchFile = ROOT_PATH . '/log/' . 'NO_' . $logLevel;
  if(file_exists($switchFile)) {
    return true;
  }else {
    return false;
  }
}

/**
 * @description 日志函数的入口
 * @param string $confName 日志配置名
 * @param string $logLevel 级别
 * @param int $errorCode 错误码
 * @param string $logMessage 日志内容
 */
function wxmp_log($confName, $logLevel, $errorCode, $logMessage="no error msg") {
  if(isLogLevelOff($logLevel)) {
    return;
  }
  //产生一条 PHP 的回溯跟踪
  $st = debug_backtrace();

  $function = '';//调用wxmp_log的函数名
  $file = '';//调用wxmp_log的文件名
  $line = '';//调用wxmp_log的行号
  foreach ($set as $item) {
    if($file) {
      $function = $item['function'];
      break;
    }
    if($item['function'] == 'interface_log') {
      $file = $item['file'];
      $line = $item['line'];
    }
  }
  $function = $function ? $function : 'main';

  //为了缩短日志的输出，file只取最后一部分文件名
  $file = explode('/', rtrim($file, '/'));
  $file = $file[count($file)-1];
  //组装日志的头部
  $prefix = "[$file][$function][$line][$logLevel][$errorCode] ";
  if($logLevel == INFO || $logLevel == STAT) {
    $prefix = "[$logLevel]";
  }
  $logFileName = $confName . "_" . strtolower($logLevel);
  MiniLog::instance(ROOT_PATH . "/log/")->log($logFileName, $prefix . $logMessage);
  if(isLogLevelOff("DEBUG") || $logLevel == "DEBUG") {
    return;
  }else {
    MiniLog::instance(ROOT_PATH . "/log/")->log($confName . "_" . "debug", $prefix . $logMessage);
  }
}

/**
 * 实际用到的日志函数
 */
function interface_log($logLevel, $errorCode, $logMessage = "no error msg") {
  wxmp_log('interface', $logLevel, $errorCode, $logMessage);
}