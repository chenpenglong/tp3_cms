<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理系统</title>
<link rel="stylesheet" type="text/css" href="/Public/Manager/Css/RightFrm.css" />
<script type="text/javascript" src="/Public/Manager/JScript//jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="/Public//Bianji/ueditor.config.js"></script>
<script type="text/javascript" src="/Public//Bianji/ueditor.all.min.js"></script>
<script type="text/javascript" src="/Public/Manager/JScript//Comm.js"></script>
<script type="text/javascript" src="/Public/Manager/JScript//webset/jscolor.js"></script>
<script type="text/javascript" src="/Public/Manager/JScript//webset/ThisJs.js"></script>
<script src="/Public//laydate/laydate.js"></script>
<style type="text/css">
	.laydate{
		width:80px;
		text-align:center;
	}
</style>
</head>
<body>
<table  border="0" cellpadding="0" cellspacing="1" class="headTable">
  <tr>
    <th width="100%">系统设置</th>
  </tr>
</table>
<form name="theForm" method="post" action="<?php echo U('webSet/editWebSet');?>">
<input type="hidden" name="id" value="<?php echo $theObj['id']; ?>" />
<table border="0" cellpadding="0" cellspacing="1" class="formTable">
  <tr>
    <th width="15%">网站名称：</th>
    <td width="35%"><input type="text" name="webName" value="<?php echo ($config["webName"]); ?>" style="width:95%" /></td>
    <th width="15%">网站LOGO：</th>
    <td width="35%">
    	<input type="text" name="webLogo" value="<?php echo ($config["webLogo"]); ?>" size="40" />
    	<input type="button" value=" 图片上传 " class="btn" onclick="showUploadDialog('image','theForm.webLogo','/Public/')" />
    </td>
  </tr>
  <tr>
  	<th width="15%">手机：</th>
  	<td width="35%"><input type="text" name="mobile" value="<?php echo ($config["mobile"]); ?>" style="width:95%" /></td>
    <th width="15%">座机：</th>
    <td width="35%"><input type="text" name="tel" value="<?php echo ($config["tel"]); ?>" style="width:95%" /></td>
  </tr>
  <tr>
    <th width="15%">二维码：</th>
    <td width="35%">
    	<input type="text" name="ewm" value="<?php echo ($config["ewm"]); ?>" size="40" />
    	<input type="button" value=" 图片上传 " class="btn" onclick="showUploadDialog('image','theForm.ewm','/Public/')" />
    </td>
    <th width="15%">地址：</th>
    <td width="35%"><input type="text" name="address" value="<?php echo ($config["address"]); ?>" size="40" /></td>
  </tr>
  <tr>
    <th valign="top">网站首页关键字：</th>
    <td><textarea name="webKeywords" rows="4" style="width:95%;"><?php echo ($config["webKeywords"]); ?></textarea></td>
    <th valign="top">网站首页描述：</th>
    <td><textarea name="webDescription" rows="4" style="width:95%;"><?php echo ($config["webDescription"]); ?></textarea></td>
  </tr>
</table>

<table  border="0" cellpadding="0" cellspacing="1" class="headTable">
  <tr>
    <th width="100%">其它设置</th>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="1" class="formTable">
  <tr>
    <th width="15%">是否启用漂浮：</th>
    <td width="35%">
    	<input type="radio" name="isShowPf" value="1" /> 开启
    	<input type="radio" name="isShowPf" value="0" /> 关闭
    	背景颜色：<input type="text" name="ShowPfColor" value="<?php echo ($config["ShowPfColor"]); ?>" size="5" class='color' />
    	<script type="text/javascript">
    	setDxk("isShowPf","<?php echo ($config["isShowPf"]); ?>");
    	</script>
    </td>
    <th width="15%">默认是否启用生成缩略图：</th>
    <td width="35%">
    	<input type="radio" name="isSetImg" value="1" /> 开启
    	<input type="radio" name="isSetImg" value="0" /> 关闭
    	<script type="text/javascript">
    	setDxk("isSetImg","<?php echo ($config["isSetImg"]); ?>");
    	</script>
    </td>
  </tr>
  <tr>
    <th>其它第三方代码：</th>
    <td colspan="3"><textarea name="otherCode" id="otherCode" rows="8" style="width:98%;"><?php echo ($config["otherCode"]); ?></textarea></td>
  </tr>
</table>
<!--<table  border="0" cellpadding="0" cellspacing="1" class="headTable">
  <tr>
    <th width="100%">水印设置</th>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="1" class="formTable">
  <tr>
    <th width="15%">图片水印使用状态：</th>
    <td width="35%">
    	<input type="radio" name="isWaterMark" value="1" /> 开启
    	<input type="radio" name="isWaterMark" value="0" /> 关闭
    	<script type="text/javascript">
    	setDxk("isWaterMark","<?php echo ($config["isWaterMark"]); ?>");
    	</script>
    </td>
    <th width="15%">图片水印启用条件：</th>
    <td width="35%">
    	宽:
        <input type="text" name="waterMarkWidth" size="4" title='图形的宽度只有达到此最小宽度要求时才会生成水印，数字型' value='<?php echo ($config["waterMarkWidth"]); ?>' />
        px
        &nbsp;
       	 高:
        <input type="text" name="waterMarkHeight" size="4" title='图形的高度只有达到此最小高度要求时才会生成水印，数字型' value='<?php echo ($config["waterMarkHeight"]); ?>' />
        px
    </td>
  </tr>
  <tr>
    <th valign="top">图片水印位置：</th>
    <td>
    	<select name='waterMarkPosition' id ='waterMarkPosition'>
    		<option value="1">左上</option>
    		<option value="2">左中</option>
    		<option value="3">左下</option>
    		<option value="4">中上</option>
    		<option value="5">中中</option>
    		<option value="6">中下</option>
    		<option value="7">右上</option>
    		<option value="8">右中</option>
    		<option value="9" selected>右下</option>
    	</select>
    	<script type="text/javascript">
    	document.getElementById("waterMarkPosition").value="<?php echo ($config["waterMarkPosition"]); ?>";
    	</script>
    </td>
    <th valign="top">图片水印边距：</th>
    <td>
    	宽:
        <input type="text" name="waterMarkMarginW" size='4' title='居左时作用为左边距，居右时作用为右边距，数字型' value='<?php echo ($config["waterMarkMarginW"]); ?>' />
        px
        &nbsp;
       	 高:
        <input type="text" name="waterMarkMarginH" size='4' title='居上时作用为上边距，居下时作用为下边柜，数字型' value='<?php echo ($config["waterMarkMarginH"]); ?>' />
        px
    </td>
  </tr>
  <tr>
    <th valign="top">图片水印图片路径：</th>
    <td colspan="3">
    	<input type="text" name="waterMarkPath" value="<?php echo ($config["waterMarkPath"]); ?>" size="40" />
    	<input type="button" value=" 图片上传 " class="btn" onclick="showWaterMarkDialog('/Public/')" />
    </td>
  </tr>
</table>-->
<table  border="0" cellpadding="0" cellspacing="1" class="headTable">
  <tr>
    <th width="100%">编辑器设置</th>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="1" class="formTable">
  <tr>
    <th width="15%">编辑器路径：</th>
    <td width="35%"><input type="text" name="editorBase" value="<?php echo ($config["editorBase"]); ?>" size="30" /> <span style="color:#ff0000;">* 根目录直接使用 “/”</span></td>
    <th width="15%">允许上传的文件最大大小：</th>
    <td width="35%"><input type="text" name="editorMaxSize" value="<?php echo ($config["editorMaxSize"]); ?>" size="5" /> (单位 M) 超过<?php echo get_cfg_var("upload_max_filesize"); ?>无效</td>
  </tr>
  <tr>
    <th>允许上传的图片后缀：</th>
    <td><input type="text" name="editorImgExt" value="<?php echo ($config["editorImgExt"]); ?>" size="40" /> 为空表示关闭</td>
    <th>允许上传的附件后缀：</th>
    <td><input type="text" name="editorLinkExt" value="<?php echo ($config["editorLinkExt"]); ?>" size="40" /> 为空表示关闭</td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="1" class="headTable">
  <tr>
    <th width="100%">网站底部信息：</th>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="1" class="formTable" style="margin-top:-1px;">
  <tr>
    <td colspan="2"><textarea name="webCopyright" id="webCopyright"><?php echo ($config["webCopyright"]); ?></textarea></td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="1" class="formTable" style="margin-top:-1px;">
  <tr>
    <th width="15%">&nbsp;</th>
    <td width="85%"><input type="submit" value=" 立 即 提 交 " class="btn" /></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
</form>
<script type="text/javascript">
	$(function(){
		var toobarsStr="";
		toobarsStr+="['source', ";
		toobarsStr+="'|', 'undo', 'redo', '|','bold', 'italic', 'underline', ";
		toobarsStr+="'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat'";
		toobarsStr+=", 'formatmatch', 'autotypeset','|','justifyleft', 'justifycenter', ";
		toobarsStr+="'justifyright', 'justifyjustify','forecolor','link', 'unlink']";
		UE.getEditor('webCopyright',{toolbars:[eval(toobarsStr)],initialFrameHeight:150,initialFrameWidth:'99%'});
		setTableColor("no");
	});

	//同时绑定多个
	lay('.laydate').each(function(){
	  laydate.render({
	    elem: this
	    ,trigger: 'click'
		,theme: '#393D49'
	  });
	}); 
</script>
</body>
</html>