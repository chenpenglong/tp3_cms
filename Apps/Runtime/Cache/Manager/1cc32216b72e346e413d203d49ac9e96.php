<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="/Public/Manager/Css/Login.css" />
<script type="text/javascript" src="/Public/Manager/JScript//jquery-1.4.4.min.js"></script>
<!--[if IE 6]>
<script type="text/javascript" src="DD_belatedPNG_0.0.8a-min.js"></script>
<script>
	DD_belatedPNG.fix('#loginBody');
</script>
<![endif]-->
<script type="text/javascript">
	//验证字符串是否只含数字，字母，汉字和下划线 是则返回True 否则返回False
	function isHf(str){
		var reg = /[^A-Za-z0-9\u4e00-\u9fa5_]/g;
		if (reg.test(str)) {
			return (false);
		}
		else {
			return (true);
		}
	}
	//登录验证
	function ckLogin(theFrom)
	{
		if(theFrom.user.value=="")
		{
			alert("用户名不能为空,请输入用户名！");
			theFrom.user.focus();
			return false;
		}
		else
		{
			if(!isHf(theFrom.user.value))
			{
				alert("用户名只能含有数字，字母和下划线 ,请重新输入用户名！");
				theFrom.user.focus();
				return false;
			}
		}
		if(theFrom.pass.value=="")
		{
			alert("密码不能为空，请输入密码！");
			theFrom.pass.focus();
			return false;
		}
		else
		{
			if(!isHf(theFrom.pass.value))
			{
				alert("密码只能含有数字，字母和下划线 ,请重新输入密码！");
				theFrom.pass.focus();
				return false;
			}
		}
		
		if(theFrom.ckCode.value=="")
		{
			alert("验证码不能为空，请输入验证码！");
			theFrom.ckCode.focus();
			return false;
		}
		else
		{
			if(theFrom.ckCode.value.length!=4)
			{
				alert("验证码错误，请重新输入验证码！");
				theFrom.ckCode.focus();
				return false;
			}
		}
	}
	$(function(){
		$("#thebg").css({"height":$(window).height()+"px"});
	});
</script>
<title>后台管理系统</title>
</head>
<body>
	<div id="thebg" style="height: 947px;"><img src="/Public/Manager/Images/loginbg.jpg"><img src="/Public/Manager/Images/loginbg2.jpg" height="1000"></div>
	<form action="<?php echo U('Index/login');?>" method="post" onsubmit="return ckLogin(this);" >
	<input type="hidden" name="action" value="login" />
	<div id="loginBody">
		<label class="lb_user">用户账户：</label>
		<label class="lb_pass">用户密码：</label>
		<label class="lb_ckcode">验证字符：</label>
		
		<input id="loginBtn" type="submit" value="登 录" hidefocus="true" />
		<input type="text" name="user" value="" class="txt User" />
		<input type="password" name="pass" value="" class="txt Pass" />
		<input type="text" name="ckCode" value="" class="txt CkCode" />
		<img class="ImgCkCode" src="<?php echo u('index/getVerify');?>" width="100" height="22" alt="看不清楚请点击这里" />
	</div>
	</form>
	<script>
		$(function(){
			$('.ImgCkCode').click(function(){
				var _src = "<?php echo U('index/getVerify/rad/radstr');?>";
				_src = _src.replace("radstr",Math.random());
				$(this).attr("src",_src);
			})
		})
	</script>
</body>
</html>