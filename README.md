# weixing_fruit
微信公众号开发项目

---
##**开发人员**
刘放 田雨晴

---
##**日期**
2015/11/02 

---
##**说明**
define("APPID", "wx72331864a154cf69");
define("APPSECRET", "d71a0d4fc9bd2aaf22c3e78a59f2948c");
**公众号原始id**：gh_c85239648587

class目录存放：框架基础类和各个公众号的业务逻辑实现
common目录存放：公用函数、日志和数据库封装
log目录存放：日志文件

class/WeChatCallBack.php            :框架基类
class/WeChatCallBack.Fruit.php      :水果公众号
interface.php                       :接入脚本
simulate_request.php                :模拟微信发消息