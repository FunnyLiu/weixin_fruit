<?php
header("Content-Type:text/html;chartset=utf-8");
$token = 'weixin';
$timestamp = time();
$nonce = '1364226029';
$tmpArr = array($token, $timestamp, $nonce);
// use SORT_STRING rule
sort($tmpArr, SORT_STRING);
$tmpStr = implode($tmpArr);
$tmpStr = sha1($tmpStr);
 
$token_access_url = "http://127.0.0.1:81/test2/WeiXin_Fruit/weixing_fruit/interface.php?signature=" . $tmpStr . "&timestamp=" . $timestamp . "&nonce=" . $nonce . '&echostr=';

$post_data = '<xml>
<ToUserName><![CDATA[gh_c85239648587]]></ToUserName>
<FromUserName><![CDATA[owIdsgsavsdgsagdavsad]]></FromUserName>
<CreateTime>1364458805</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[3]]></Content>
<MsgId>3924832095732890324</MsgId>
</xml>';

//获取文件内容或获取网络请求的内容
$header[] = 'Content-type:text/xml';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $token_access_url);
// post数据
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
// post的变量
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); 

$output = curl_exec($ch);
curl_close($ch);

print_r($output);
//print_r(simplexml_load_string($output));

?>