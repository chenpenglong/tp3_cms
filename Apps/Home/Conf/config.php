<?php
return array(
	//'配置项'=>'配置值'
	'URL_MODEL'      => 3,
	'DEFAULT_MODULE' => 'Home',

	// 'URL_PATHINFO_DEPR'     =>  '-',
  // 'TMPL_EXCEPTION_FILE'   =>  './404.html',// 异常页面的模板文件
  // 'ERROR_PAGE'            =>  './404.html', // 错误定向页面

	'TMPL_PARSE_STRING'  =>array(
			'__CSS__' => __ROOT__.'/Public/Home/Css',
			'__IMG__' => __ROOT__.'/Public/Home/Images',
			'__JS__'     => __ROOT__.'/Public/Home/JScript/', // 增加新的JS类库路径替换规则
			'__UPLOAD__' => '/Uploads', // 增加新的上传路径替换规则
	)
);