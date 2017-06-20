1.在index.php 中增加  define('APP_STATUS','qa');   加载不同配置文件
    Application/Common/Conf/qa.php	//测试环境
    Application/Common/Conf/release.php	//正式环境

2. 基于thinkphp3.2.3，在框架中记录所有请求日志
    入口
    ThinkPHP/Library/Think/Think.class.php   第265行

