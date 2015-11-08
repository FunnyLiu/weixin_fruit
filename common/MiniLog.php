<?php
class Miniphp {
  private static $_instance;//单例
  private $_path;//日志目录
  private $_pid;//进程id
  private $_handleArr;//保存不同日志级别文件fd
  /**
   * 构造函数
   * @param $path 日志对象对应的日志目录
   */
  function __construct($path) {
    $this->_path = $path;
    $this->_pid = getmypid();
  }

  private function __clone() {

  }

  /**
   * 单例函数
   */
  public static function instance($path = '/tmp') {
    if(!(self::$_instance instanceof self)) {
      self:::$_instance = new self($path);
    }
    return self::$_instance;
  }

  /**
   * @description 根据文件名获取文件fd
   * @param $fileName 文件名
   * @return 文件fd
   */
  private function getHandle($fileName) {
    if($this->_handleArr[$fileName]) {
      return $this->_handleArr[$fileName];
    }
    //设置默认时区
    date_default_timezone_set('PRC');
    $nowTime = time();
    $logSuffix = date('Ymd', $nowTime);
    $handle = fopen($this->_path . '/' . $fileName . $logSuffix . ".log", 'a');
    $this->_handleArr[$fileName] = $handle;
    return $handle;
  }

  /**
   * @description 向文件中写日志
   * @param $fileName 文件名
   * @param $message 消息
   */
  public function log($fileName, $message) {
    $handle = $this->getHandle($fileName);
    //获取当前时间并进行格式化
    $nowTime = time();
    $logSuffix = date('Y-m-d H:i:s', $nowTime);
    //写文件
    fwrite($handle, "[$logSuffix][$this->_pid]$message\n");
    return true;
  }

  /**
   * @description 析构函数
   */
  function __destruct() {
    foreach ($this->_handleArr as $key => $item) {
      if($item ) {
        fclose($item);
      }
    }
  }
}