<?php

define("TOKEN", "weixin");
define("APPID", "wx72331864a154cf69");
define("APPSECRET", "d71a0d4fc9bd2aaf22c3e78a59f2948c");
define("USERNAME_FRUIT", "gh_c85239648587");

define('HINT_NOT_IMPLEMENT', '未实现'); //默认错误提示
define('HINT_TPL', '<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Content><![CDATA[%s]]></Content>
<FuncFlag>0</FuncFlag>
</xml>'); //回复模板
?>