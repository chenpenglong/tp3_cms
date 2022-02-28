<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="keywords" content="<?php echo ($config["webKeywords"]); ?>" />
<meta name="description" content="<?php echo ($config["webDescription"]); ?>" />
<title><?php echo ($config["webName"]); ?></title>
<link rel="stylesheet" type="text/css" href="/Public/Home/Css/Style.css" />
<link rel="stylesheet" type="text/css" href="/Public/Home/Css/swiper.min.css" />
<script type="text/javascript" src="/Public/Home/JScript//jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/Public/Home/JScript//swiper.min.js"></script>
<script type="text/javascript" src="/Public/Home/JScript//wow.js"></script>
<script type="text/javascript" src="/Public/Home/JScript//Comm.js"></script>

<script type="text/javascript" src="/Public/layer/layer.js"></script>
<link rel="stylesheet" type="text/css" href="/Public/Home/Css/bootstrap.css" />


</head>
<body class="Body-Extend">

	<div id="top">top</div>

	
	<div id="footer"></div>


<!--第三方插件-->
<?php echo ($config["otherCode"]); ?>
<!--右侧漂浮-->
<?php if($config["isShowPf"] > 0): ?><script type="text/javascript" src="/Public/Home/JScript//jquery.easing.1.1.js"></script>
<script type="text/javascript" src="/Public/Home/JScript//jquery-float.js"></script>

<div id="rightPiaoFu" style="background-color:#<?php echo ($config["ShowPfColor"]); ?>;">
	<div class="content">
	<div class='close'>×</div>
	<?php if($piaoFuDataList != null): ?><ul>
		<?php if(is_array($piaoFuDataList)): $i = 0; $__LIST__ = $piaoFuDataList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo["type"] == 0): ?><li class="sort" style="background-color:#<?php echo ($config["ShowPfColor"]); ?>;"><?php echo ($vo["title"]); ?></li><?php endif; ?>
			<?php if($vo["type"] == 1): ?><li class="qq">
					<a href="tencent://message/?uin=<?php echo ($vo["code"]); ?>&Site=点击这里给我发消息&Menu=yes" target="blank">
					<img border="0" src="http://wpa.qq.com/pa?p=1:<?php echo ($vo["code"]); ?>:4" alt="点击这里给我发消息" align="absmiddle" /> <?php echo ($vo["title"]); ?>
					</a>
				</li><?php endif; ?>
			
			<?php if($vo["type"] == 2): ?><li class="email"><?php echo ($vo["code:"]); ?></li><?php endif; ?>
			
			<?php if($vo["type"] == 3): ?><li class="msn">
					<a href="msnim:chat?contact=<?php echo ($vo["code"]); ?>" target="blank">
					<img border="0" src="Tpl/Images/msn.jpg" alt="点击这里给我发消息" align="absmiddle" /> <?php echo ($vo["title"]); ?>
					</a>
				</li><?php endif; ?>
			
			<?php if($vo["type"] == 4): ?><li class="skype">
					<a href="skype:<?php echo ($vo["code"]); ?>?call" target="blank">
					<img border="0" src="Tpl/Images/skype.png" alt="点击这里给我发消息" align="absmiddle" /> <?php echo ($vo["title"]); ?>
					</a>
				</li><?php endif; ?>
			
			<?php if($vo["type"] == 5): ?><li class="tel"><?php echo ($vo["code"]); ?></li><?php endif; ?>
			
			<?php if($vo["type"] == 6): ?><li class="img"><img src="/<?php echo ($vo["code"]); ?>" /></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
		</ul><?php endif; ?>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$("#rightPiaoFu").floatQQ();
		$("#rightPiaoFu .close").click(function(){
			$("#rightPiaoFu").hide();
		});
	});
</script><?php endif; ?>
<script>
	if (!(/msie [6|7|8|9]/i.test(navigator.userAgent))){
		new WOW().init();
	};
</script> 
	

</body>
</html>