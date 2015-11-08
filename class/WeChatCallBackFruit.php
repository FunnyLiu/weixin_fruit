<?php
/**
 * fruit server implemention
 */
require_once dirname(__FILE__) . '/WeChatCallBack.php';
class WeChatCallBackFruit extends WeChatCallBack {
  
  public function process() {
    if($this->_msgType != 'text') {
      return $this->makeHint("只支持文本消息！");
    }
    //测试获取从memcached获取accesstoken成功
    $result = getAccessToken();
    $mem = new Memcached();
    $mem->addServer('127.0.0.1',11211);
    $a = $mem->get('access_token');
    switch((string)trim($this->_postObject->Content)){
      case "2":
        $contentStr = $result;
        break;
      case "1":
        $contentStr = $a;
        break;
      default:
        $contentStr = "请输入1或者2";        
    }
    return $this->makeHint($contentStr);
  }
}