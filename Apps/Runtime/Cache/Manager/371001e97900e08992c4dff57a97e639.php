<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>顶部</title>
<link rel="stylesheet" type="text/css" href="/Public/Manager/Css/Frame.css" />
</head>
<body>
	<div id="Top-Sizer">
		<div class="extend">
			<div class="Dispaly_1"></div>
			<div class="Dispaly_2">【当前用户：<?php echo $theObj['nickname'];?>&nbsp;<span id="showTime"></span>】</div>
		</div>
	</div>
	<iframe src="../../../Null.php" width="0" height="0"></iframe>
	<script type="text/javascript">
	//获取今天的时间
	function getTheDay(){
		today = new Date();
		var day = "";
		var date1 = "";
		switch (today.getDay()) {
			case 0:
				day = "星期日";
				break;
			case 1:
				day = "星期一";
				break;
			case 2:
				day = "星期二";
				break;
			case 3:
				day = "星期三";
				break;
			case 4:
				day = "星期四";
				break;
			case 5:
				day = "星期五";
				break;
			case 6:
				day = "星期六";
				break;
			default:
				break;
		}
		
		if (today.getYear() >= 2000) {
			date1 = (today.getYear()) + "年" + (today.getMonth() + 1) + "月" + today.getDate() + "日 ";
		}
		else {
			date1 = (1900 + today.getYear()) + "年" + (today.getMonth() + 1) + "月" + today.getDate() + "日 ";
		}
		var time = "";
		time += (today.getHours() < 10 ? "0" + today.getHours() : today.getHours());
		time += ":" + (today.getMinutes() < 10 ? "0" + today.getMinutes() : today.getMinutes());
		time += ":" + (today.getSeconds() < 10 ? "0" + today.getSeconds() : today.getSeconds());
		document.getElementById("showTime").innerHTML = date1 + day + "&nbsp;" + time;
		setTimeout("getTheDay()", 1000);
	}
	getTheDay();
	</script>
</body>
</html>