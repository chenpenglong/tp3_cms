<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理系统</title>
<link rel="stylesheet" type="text/css" href="/Public/Manager/Css/RightFrm.css" />
<script type="text/javascript" src="/Public/Manager/JScript//jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="/Public/Manager/JScript//Comm.js"></script>
</head>
<body>
<table  border="0" cellpadding="0" cellspacing="1" class="headTable">
  <tr>
    <th width="80%">浮动列表</th>
    <th width="20%" class="links"><a href="<?php echo U('float/add');?>">【新增】</a></th>
  </tr>
</table>
<table  border="0" cellpadding="0" cellspacing="1" class="listTable">
  <tr>
    <th width="3%">&nbsp;</th>
    <th width="15%">类别</th>
    <th width="27%">标题</th>
    <th width="25%">代码</th>
    <th width="10%">排序</th>
    <th width="20%">操作</th>
  </tr>
  
  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
	    <td class="center"><input type="checkbox" name="theId" value="<?php echo ($vo["id"]); ?>"></td>
	    <td class="center"><?php echo ($vo["type"]); ?></td>
	    <td class="center"><?php echo ($vo["title"]); ?></td>
	    <td class="center"><?php echo ($vo["code"]); ?></td>
	    <td class="center">
			<input class="sortInput" value="<?php echo ($vo["serialNum"]); ?>" onblur="serialNumDesc(this,'<?php echo ($vo["id"]); ?>','<?php echo U('float/serialNumDesc');?>');">			
	    </td>
	    <td class="center"><a href="<?php echo U('float/edit?id='.$vo['id']);?>">【修改】</a></td>
	  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
  
</table>
<table  border=0 cellpadding=0 cellspacing=1  class="cmdTable">
  <tr>
    <th>
	<span onClick="selectAll('theId');">全选</span>&nbsp;&nbsp;&nbsp;&nbsp;
	<span onClick="unSelectAll('theId');">全不选</span>&nbsp;&nbsp;&nbsp;&nbsp;
	<span onClick="antiSelectAll('theId');">反选</span>&nbsp;&nbsp;&nbsp;&nbsp;
	<span onClick="handleSelect('theId','<?php echo U('float/delete');?>');">删除</span>
	</th>
  </tr>
</table>
<iframe name="hideframe" width="0" height="0"></iframe>
<script type="text/javascript">$(function(){setTableColor();});</script>
</body>
</html>