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