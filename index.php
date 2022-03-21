<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
include_once "sqlInj.php";

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

//检测是否已安装CrmEb系统
if(file_exists("./install/") && !file_exists("./install/install.lock")){
    if($_SERVER['PHP_SELF'] != '/index.php'){
        header("Content-type: text/html; charset=utf-8");
        exit("请在域名根目录下安装,如:<br/> www.xxx.com/index.php 正确 <br/>  www.xxx.com/www/index.php 错误,域名后面不能圈套目录, 但项目没有根目录存放限制,可以放在任意目录,apache虚拟主机配置一下即可");
    }
    header('Location:/install/index.php');
    exit();
}

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);

// 定义应用目录
define('APP_PATH','./Apps/');

//生成模块
// define('BIND_MODULE','Manager');

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单