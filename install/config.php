<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
	//数据库配置信息
	'DB_TYPE'   => 'mysql', // 数据库类型
	'DB_HOST'   => '#DB_HOST#', // 服务器地址
	'DB_NAME'   => '#DB_NAME#', // 数据库名
	'DB_USER'   => '#DB_USER#', // 用户名
	'DB_PWD'    => '#DB_PWD#', // 密码
	'DB_PORT'   => '#DB_PORT#', // 端口
	'DB_PREFIX' => '#DB_PREFIX#', // 数据库表前缀
	'DB_CHARSET'=> '#DB_CHARSET#', // 字符集
	'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增
	'SHOW_PAGE_TRACE' =>false,
	
	'MODULE_ALLOW_LIST' => array ('Home','Manager'),
	'DEFAULT_MODULE' => 'Home',
];
