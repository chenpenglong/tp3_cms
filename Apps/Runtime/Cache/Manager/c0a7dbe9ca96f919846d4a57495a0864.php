<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理系统</title>
<link rel="stylesheet" type="text/css" href="/Public/Manager/Css/RightFrm.css" />
<!--[if lt IE 9]>
<script type="text/javascript" src="/Public/Manager/JScript//jquery-1.4.4.min.js"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type="text/javascript" src="/Public/Manager/JScript//jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="/Public/Manager/JScript//comm.js"></script>
<!--<![endif]-->
</head>
<body>
<table  border="0" cellpadding="0" cellspacing="1" class="headTable">
  <tr>
    <th width="80%">类别设置</th>
  </tr>
</table>
<table  border="0" cellpadding="0" cellspacing="1" class="listTable">
  <tr>

    <th width="50%">类别名</th>
    <th width="20%">排序</th>
    <th width="30%">操作</th>
  </tr> 
  
  <tr>
    <td width="50%"></td>
    <td width="20%"></td>
    <td width="30%" class="center"><a href="<?php echo U('sortAdd?id='.$id);?>">【新增】</a></td>
  </tr> 
  
  <?php echo ($list); ?>
  
</table>
<iframe name="hideframe" width="0" height="0"></iframe>
<script type="text/javascript">$(function(){setTableColor();});</script>
<script language="javascript">
	
  	
</script>


</body>
</html>