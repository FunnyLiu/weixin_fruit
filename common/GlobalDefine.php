<?php

define("TOKEN", "weixin");
define("APPID", "wx72331864a154cf69");
define("APPSECRET", "d71a0d4fc9bd2aaf22c3e78a59f2948c");
//水果公众号的toUserName
define("USERNAME_FRUIT", "gh_c85239648587");
//默认错误提示
define('HINT_NOT_IMPLEMENT', '未实现'); 
define('HINT_TPL', "<xml>
<ToUserName>%s</ToUserName>
<FromUserName>%s</FromUserName>
<CreateTime>%s</CreateTime>
<MsgType>%s</MsgType>
<Content>%s</Content>
<FuncFlag>0</FuncFlag>
</xml>");
//定义日志级别
define("DEBUG", "DEBUG");
define("INFO", "INFO");
define("ERROR", "ERROR");
//根目录
define("ROOT_PATH", __FILE__ . "/..")
?>