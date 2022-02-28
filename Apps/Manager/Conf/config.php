<?php
return array(
  'URL_MODEL'      => 3,
	//'配置项'=>'配置值'
		'TMPL_PARSE_STRING'  =>array(
				'__CSS__' => __ROOT__.'/Public/Manager/Css',
				'__IMG__' => __ROOT__.'/Public/Manager/Images',
				'__JS__'     => __ROOT__.'/Public/Manager/JScript/', // 增加新的JS类库路径替换规则
				'__UPLOAD__' => '/Uploads', // 增加新的上传路径替换规则
				'__PUBLIC__' => __ROOT__.'/Public/',
		)
);