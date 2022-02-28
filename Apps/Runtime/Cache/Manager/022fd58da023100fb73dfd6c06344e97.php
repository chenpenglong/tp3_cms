<?php if (!defined('THINK_PATH')) exit();?><html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>后台管理系统</title>
<link rel="stylesheet" type="text/css" href="/Public/Manager/Css/RightFrm.css">
<script type="text/javascript" src="/Public/Manager/JScript//jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="/Public/Manager/JScript//Comm.js"></script>
</head>
<body>
<table border="0" cellpadding="0" cellspacing="1" class="headTable">
  <tbody><tr>
    <th width="100%">预约管理</th>
  </tr>
</tbody></table>
<table border="0" cellpadding="0" cellspacing="1" class="listTable">
  <tbody><tr>
    <th width="3%">&nbsp;</th>
    <th width="17%">客户姓名</th>
    <th width="20%">手机号码</th>
    <th width="20%">穿着需求</th>
    <th width="20%">留言时间</th>
    <th width="20%">操作</th>
  </tr>
  
  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
		<td class="center"><input type="checkbox" name="theId" value="<?php echo ($vo["id"]); ?>"></td>
		<td class="center"><?php echo ($vo["nickname"]); ?></td>
		<td class="center"><?php echo ($vo["tel"]); ?></td>
		<td class="center"><?php echo ($vo["subject"]); ?></td>
		<td class="center"><?php echo ($vo["addTime"]); ?></td>
		<td class="center">
			<a href="<?php echo U('guestBook/ready?id='.$vo['id']);?>">【查看】</a>
			<?php if(($vo["isSh"]) == "1"): ?><a href="javascript:isSh('<?php echo ($vo["id"]); ?>','<?php echo U("guestBook/isSh");?>');" style="color:#FF0000;">【已审】</a>
			<?php else: ?>
				<a href="javascript:isSh('<?php echo ($vo["id"]); ?>','<?php echo U("guestBook/isSh");?>');">【审核】</a><?php endif; ?>
		</td>
	  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
  
  <tr>
  	<td colspan="5" class="pageInfo">
	</td>
  </tr>
</tbody></table>
<div class="pages"><?php echo ($page); ?></div>
<table border="0" cellpadding="0" cellspacing="1" class="cmdTable">
  <tbody><tr>
    <th>
	<span onclick="selectAll('theId');">全选</span>&nbsp;&nbsp;&nbsp;&nbsp;
	<span onclick="unSelectAll('theId');">全不选</span>&nbsp;&nbsp;&nbsp;&nbsp;
	<span onclick="antiSelectAll('theId');">反选</span>&nbsp;&nbsp;&nbsp;&nbsp;
	<span onclick="handleSelect('theId','<?php echo U("guestBook/delete");?>')">删除</span>
	</th>
  </tr>
</tbody></table>
<iframe name="hideframe" width="0" height="0"></iframe>

<div id="rightZw" style="top: 100%;">&nbsp;</div></body></html>