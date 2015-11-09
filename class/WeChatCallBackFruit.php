<?php
/**
 * fruit server implemention
 */
require_once dirname(__FILE__) . '/WeChatCallBack.php';
class WeChatCallBackFruit extends WeChatCallBack {
  
  public function process() {
    switch ($this->_msgType) {
      case "text":
        $result = $this->receiveText();
        break;
      case "voice":
        $result = $this->receiveVoice();
        break;
      default:
        $result = $this->makeHint("只支持文本和语音消息！");
    }
      return $result;
  } 
  /**
   * @description 接受文本信息作出的响应
   * @return 返回文本值
   * @author 刘放
   * @date 2015/11/9 19:49
   */    
  public function receiveText(){
  //测试获取从memcached获取accesstoken成功
      $result = getAccessToken();
      switch((string)trim($this->_postObject->Content)){
        case "2":
          $contentStr = $result;
          break;
        case "1":
          $contentStr = "123";
          break;
        default:
          $contentStr = "请输入1或者2";        
      }
      return $this->makeHint($contentStr);
  } 
  /**
   * @description 接受语音信息作出的响应
   * @return 返回文本值
   * @author 刘放
   * @date 2015/11/9 19:59
   */  
  public function receiveVoice(){
      switch((string)trim($this->_postObject->Recognition)){
        case "苹果！":
          $contentStr = "我是苹果";
          break;
        case "草莓！":
          $contentStr = "我是草莓";
          break;
        default:
          $contentStr = "请说苹果或者草莓";
      }
      return $this->makeHint($contentStr);
  }
}