<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>后台管理系统</title>
	</head>
	<frameset rows="80,*" bordercolor="#73A2D6" framespacing="0" frameBorder="no">
		<frame name="FrmTop" scrolling="no" noresize src="<?php echo U('TopFrm');?>"  />
		<frameset cols="200,*" bordercolor="#004F7A">
			<frame name="FrmMenu" noresize src="<?php echo U('MenuFrm');?>"  scrolling="auto" />
			<frame name="FrmMain" noresize src="<?php echo U('RightFrm');?>"  scrolling="atuo" />
		</frameset>
		<noframes>
			<body>
				<p>此网页使用了框架，但您的浏览器不支持框架。</p>
			</body>
		</noframes>
	</frameset>
</html>