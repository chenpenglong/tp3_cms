<?php
session_start ();
$configObj = $_SESSION['config'];
$type=$_GET['type'];
$thehz="";
switch ($type) {
	case "image":
		$thehz=$configObj['editorImgExt'];
		break;
	case "file":
		$thehz=$configObj['editorLinkExt'];
		break;
	default:
		die("允许的类型为：image,flash,media,file");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>课程</title>
<script type="text/javascript" src="jquery-1.4.4.min.js"></script>
<style type="text/css">
body
{background-color:#D4D0C7;font-size:12px;font-family:宋体; color:#333; margin:0px;padding:0px;}
#rootDiv {width:348px; height:auto; overflow:hidden; padding:8px;}
#thebg
fieldset {border:2px groove #F0F0F0;padding:8px;padding-top:0px;}
th {font-weight:normal;text-align:right; line-height:30px;}
.btn {margin-top:10px;height:23px;}
#jingdu
{width:223px;height:40px;overflow:hidden;position:absolute;left:75px;top:45px;
 border:1px solid #666; background-color:#0066CC; color:#fff; line-height:40px; display:none; }
#thebg
{width:348px; height:200px; overflow:hidden; padding:8px; position:absolute;left:0px; top:0px; background:#000; display:none;
filter:alpha(opacity=10);
-moz-opacity:0.1;
-khtml-opacity: 0.1;
opacity: 0.1;}
</style>
<script type="text/javascript">
function closeDialog(){
	$(parent.document.getElementById("showUploadDialogBg")).remove();
	$(parent.document.getElementById("showUploadDialog")).remove();
}
function SaveFile(){
	var filedata=document.getElementById("filedata").value;
	if(filedata.length==0){
		alert("请先选择您要上传的文件");
		return;
	}
	var temp=filedata.split(".");
	var evt="|<?php echo $thehz; ?>|";
	if(evt.indexOf("|"+temp[temp.length-1].toLowerCase()+"|")==-1){
		alert("允许上传的类型为：<?php echo $thehz; ?>");
		return;
	}
	document.getElementById("thebg").style.display="block";
	document.getElementById("jingdu").style.display="block";
	document.getElementById("UptheForm").submit();
}
function UpFileOk(thejson){
	if(thejson.err!=""){
		document.getElementById("thebg").style.display="none";
		document.getElementById("jingdu").style.display="none";
		alert(thejson.err);
	}else{
		parent.<?php echo $_GET['link']; ?>.value=thejson.msg.url;
		closeDialog();
	}
}
</script>
</head>
<body>
	<form id="UptheForm" method="post" action="upload.php?type=<?php echo $type; ?>&action=swaraj" enctype='multipart/form-data' target="hideframe" style="margin:0px;padding:0px;">
	<input type="hidden" name="theinput" value="<?php echo $_GET['link']; ?>" />
	<div id="rootDiv">
	<fieldset>
  		<legend>选项</legend>
  		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <th width="20%">文件选择：</td>
		    <td width="80%"><input type="file" name="filedata" id="filedata" /></td>
		  </tr>
		  <?php if ($type=="image"){ ?>
		  <tr>
		  	<th>缩略图：</td>
		    <td>
				<input type="radio" name="isslt" value="1"<?php if (intval($configObj['isSetImg'])===1){ echo ' checked="checked"';} ?> id="isslt_1" /><label for="isslt_1">开启</label>
				<input type="radio" name="isslt" value="0"<?php if (intval($configObj['isSetImg'])===0){ echo ' checked="checked"';} ?> id="isslt_0" /><label for="isslt_0">关闭</label>
				<span style='color:#ff0000;'>* 带动画的GIF图片请关闭</span>
			</td>
		  </tr>
		  <?php } ?>
		</table>
	</fieldset>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<div style="width:190px;height:auto;overflow:hidden;">类型：<?php echo $thehz; ?></div>
			</td>
			<td>
			<div style="text-align:right;">
				<input type="button" value="&nbsp;&nbsp;保存&nbsp;&nbsp;" class="btn" onClick="SaveFile()" />
		  		<input type="button" value="&nbsp;&nbsp;取消&nbsp;&nbsp;" class="btn" onClick="closeDialog()" />&nbsp;
		  	</div>
			</td>
		</tr>
	</table>
	<div id="thebg">&nbsp;</div>
  	<div id="jingdu">
    	<MARQUEE ALIGN="middle" BEHAVIOR="alternate" SCROLLAMOUNT="5">文件正在传输中</MARQUEE>
  	</div>
	</div>
	</form>
	<iframe name="hideframe" width="0" height="0"></iframe>
</body>
</html>