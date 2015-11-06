<?php
 
define("APPID", "wx72331864a154cf69");
define("APPSECRET", "d71a0d4fc9bd2aaf22c3e78a59f2948c");
 
$token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . APPID . "&secret=" . APPSECRET;
 //获取文件内容或获取网络请求的内容
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $token_access_url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);

//echo $output;
$result = json_decode($output, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
$access_token = $result['access_token'];
echo $access_token;
 
?>