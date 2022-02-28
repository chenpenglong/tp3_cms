//验证类别表单
function ckTheSortForm(theForm){
	if (theForm.sortName.value == "") {
		alert("请输入类别名称");
		theForm.sortName.focus();
		return false;
	}
}
//验证信息表单
function ckTheNewsForm(theForm){
	if (theForm.title.value == "") {
		alert("请输入标题名称");
		theForm.title.focus();
		return false;
	}
}
/*
function GetXhEditor( Bianji="", theId="content_noreplace", editorBase="/", widht = "100%") {
	
	var str = "<script type=\"text/javascript\">";
	str += 'window.UEDITOR_HOME_URL="' +editorBase+ 'Bianji/";';
	str += "</script>";
	str += "<script type=\"text/javascript\" src=\""+Bianji+"ueditor.config.js\"></script>";
	str += "<script type=\"text/javascript\" src=\""+Bianji+"/ueditor.all.min.js\"></script>";
	str += "<script type=\"text/javascript\">";
	str += "UE.getEditor('" +theId+ "',{initialFrameHeight:500});";
	str += "</script>";
	return str;
}
*/