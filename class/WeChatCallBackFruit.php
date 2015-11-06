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
    switch((string)trim($this->_postObject->Content)){
      case "2":
        $contentStr = "田雨晴喜欢刘放";
        break;
      case "1":
        $contentStr = "刘放喜欢田雨晴";
        break;
      default:
        $contentStr = "请输入1或者2";        
    }
    return $this->makeHint($contentStr);
  }
}