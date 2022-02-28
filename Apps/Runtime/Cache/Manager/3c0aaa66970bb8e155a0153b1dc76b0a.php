<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>左侧</title>
<link rel="stylesheet" type="text/css" href="/Public/Manager/Css/Frame.css" />
<script type="text/javascript" src="/Public/Manager/JScript//jquery-1.4.4.min.js"></script>
</head>
<base target="FrmMain">
<body class="LeftBody">
<div id="Left-Sizer">
	<div id="leftZw">&nbsp;</div>
	<div class="Bengin"><em>网站建设</em></div>	
	<div class="OneRecord open">
		<h5>基本信息</h5>
		<ul>
			<li><a href="../../index.php" target="_blank">打开首页</a></li>
			<li><a href="<?php echo U('Manager/Public/RightFrm');?>">欢迎界面</a></li>
			<li><a href="<?php echo U('admin/adminList');?>">管理员账户</a></li>
			<li><a href="<?php echo U('index/loginOut');?>" target="_top">安全退出</a></li>
		</ul>
	</div>
	
	<?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="OneRecord">
			<h5><?php echo ($vo["name"]); ?></h5>
			<ul>
				<?php if(is_array($vo["list"])): $key = 0; $__LIST__ = $vo["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$it): $mod = ($key % 2 );++$key;?><li><a href="<?php echo ($it); ?>"><?php echo ($key); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div><?php endforeach; endif; else: echo "" ;endif; ?>
	
	<script type="text/javascript">
	$(function(){
		$(".OneRecord h5").click(function(){
			$(this).next('ul').slideToggle('slow');
			$(this).parent().siblings().find('ul').slideUp('slow');
		});
		if($(document.body).outerHeight(true)<$(document).height()){
			$("#leftZw").css({"top":"100%"});
		}
	});
	</script>
</div>
</body>
</html>