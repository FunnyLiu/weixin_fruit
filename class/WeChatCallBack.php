<?php
/**
 * wechat basic callback
 */

require_once dirname(__FILE__) . '/../common/GlobalDefine.php';
require_once dirname(__FILE__) . '/../common/GlobalFunctions.php';

class WeChatCallBack {
  protected $_postObject;
  protected $_fromUserName;
  protected $_toUserName;
  protected $_createTime;
  protected $_msgType;
  protected $_msgId;
  protected $_time;

  public function getToUserName() {
    return $this->_toUserName;
  }

  //组装提示信息，HINT_TPL在GlobalDefine.php中定义
  protected function makeHint($hint) {
    $resultStr = sprintf(HINT_TPL, $this->_fromUserName, $this->_toUserName, $this->_time, 'text', $hint);
    return $resultStr;
  }

  public function init($postObj) {
    //获取参数
    $this->_postObject = $postObj;
    if($this->_postObject == false) {
      return false;
    }
    $this->_fromUserName = (string)trim($this->_postObject->FromUserName);
    $this->_toUserName = (string)trim($this->_postObject->ToUserName);
    $this->_msgType = (string)trim($this->_postObject->MsgType);
    $this->_createTime = (string)trim($this->_postObject->CreateTime);
    $this->_msgId = (int)trim($this->_postObject->MsgId);
    $this->_time = time();
    if (!($this->_fromUserName && $this->_toUserName && $this->_msgType)) {
      return false;
    }
    return true;
  }

  public function process() {
    //HINT_NOT_IMPLEMENT在GlobalDefine.php中定义的一个提示信息
    return $this->makeHint(HINT_NOT_IMPLEMENT);
  }
}