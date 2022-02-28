//翻页的跳转1
function goToTheUrl(TheSelect){
	location.href = TheSelect.value;
}

//限制内容图片大小
function resize(o,w) {
	if (o.width>w) {
	o.style.width=w+'px';
	o.style.height='auto';
	}
}

//加入收藏(调用addfavorite();)
function addfavorite(){
	try {
		window.external.addFavorite(window.location.href, document.title);
	}
	catch (e) {
		try {
			window.sidebar.addPanel(document.title, window.location.href, "");
		}
		catch (e) {
			alert('请使用按键 Ctrl+d，收藏网址')
		}
	}
}

//设为首页(调用setHome(this,window.location);)
function setHome(obj, vrl){
	try {
		obj.style.behavior = 'url(#default#homepage)';
		obj.setHomePage(vrl);
	}
	catch (e) {

		try {
			netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
			var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
			prefs.setCharPref('browser.startup.homepage', vrl);
		}
		catch (e) {
			alert("此操作被浏览器拒绝！\n请手动设为首页。");
		}
	}
}

//显示动画
function showFlash(flashWIDTH, flashHEIGHT, flashURL){
	if (flashURL.indexOf("?") != -1) {
		flashURL += '&rad=' + Math.random();
	}
	else {
		flashURL += '?rad=' + Math.random();
	}
	document.writeln('<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" WIDTH=' + flashWIDTH + ' HEIGHT=' + flashHEIGHT + '>');
	document.writeln('<PARAM NAME=movie VALUE="' + flashURL + '">');
	document.writeln('<PARAM NAME=wmode VALUE=transparent>');
	document.writeln('<PARAM NAME=loop VALUE=true>');
	document.writeln('<PARAM NAME=quality VALUE=high>');
	document.writeln('<EMBED src="' + flashURL + '" loop=true wmode=transparent quality=high swLiveConnect=FALSE WIDTH=' + flashWIDTH + ' HEIGHT=' + flashHEIGHT + ' TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></EMBED>');
	document.writeln('</OBJECT>');
}

//搜索
function SearchList(txtId, defaultvalue){
	var thetxt = document.getElementById(txtId);
	if (thetxt.value == "" || thetxt.value == defaultvalue) {
		alert(defaultvalue);
		thetxt.focus();
		return;
	}
	location.href = "News_Search.php?tag=Search&thetxt=" + encodeURIComponent(thetxt.value);
}

function ckMemberReg(theForm){
	var emailReg=/^[a-zA-Z0-9_-]+@([a-zA-Z0-9]+\.)+(com|cn|net|org)$/;
	if ( theForm.email.value<=0 ){
		alert("邮箱不能为空");
		theForm.email.focus();
		return false;
	}
	if ( !emailReg.test( theForm.email.value ) ){
		alert("邮箱格式不正确");
		theForm.email.focus();
		return false;
	}

	if (theForm.password.value.length < 4 || theForm.password.value.length > 20) {
		alert("密码长度在4位-20位之间");
		theForm.password.focus();
		return false;
	}
	if (theForm.password.value != theForm.password2.value) {
		alert("两次输入密码不一致");
		theForm.password2.focus();
		return false;
	}
	if ( theForm.username.value<=0 ){
		alert("姓名不能为空");
		theForm.username.focus();
		return false;
	}

	
	if ( theForm.work.value<=0 ){
		alert("工作单位不能为空");
		theForm.work.focus();
		return false;
	}
	if ( theForm.code.value<=0 ){
		alert("请输入验证码");
		theForm.code.focus();
		return false;
	}
}

function ckEditPassword( theForm ){
	if ( theForm.oldPassword.value<=0 ){
		alert("请输入旧密码");
		theForm.oldPassword.focus();
		return false;
	}
	if (theForm.newPassword.value.length < 4 || theForm.newPassword.value.length > 20) {
		alert("密码长度在4位-20位之间");
		theForm.newPassword.focus();
		return false;
	}
	if (theForm.newPassword.value != theForm.checkNewPassword.value) {
		alert("两次输入密码不一致");
		theForm.checkNewPassword.focus();
		return false;
	}
}

function ckEditData( theForm ){
	var myreg = /^(((13[0-9]{1})|(14[0-9]{1})|(17[0]{1})|(15[0-3]{1})|(15[5-9]{1})|(18[0-9]{1}))+\d{8})$/;
	var tel = theForm.tel.value;
	if ( theForm.tel.value<=0 ){
		alert("手机号码不能为空");
		theForm.tel.focus();
		return false;
	}
	if ( !myreg.test( tel ) ){
		alert("手机号码格式不正确");
		theForm.tel.focus();
		return false;
	}
	if ( theForm.username.value<=0 ){
		alert("姓名不能为空");
		theForm.username.focus();
		return false;
	}

	var emailReg=/^[a-zA-Z0-9_-]+@([a-zA-Z0-9]+\.)+(com|cn|net|org)$/;
	if ( theForm.email.value<=0 ){
		alert("邮箱不能为空");
		theForm.email.focus();
		return false;
	}
	if ( !emailReg.test( theForm.email.value ) ){
		alert("邮箱格式不正确");
		theForm.email.focus();
		return false;
	}
	if ( theForm.work.value<=0 ){
		alert("工作单位不能为空");
		theForm.work.focus();
		return false;
	}
}

function ckUpZy( theForm ){

	if ( theForm.title.value<=0 ){
		alert("稿件标题不能为空");
		theForm.title.focus();
		return false;
	}

	if ( theForm.file.value<=0 ){
		alert("请上传文件");
		theForm.file.focus();
		return false;
	}
}

function ckUpZw( theForm ){

	if ( theForm.title.value<=0 ){
		alert("稿件标题不能为空");
		theForm.title.focus();
		return false;
	}

	if ( theForm.file.value<=0 ){
		alert("请上传文件");
		theForm.file.focus();
		return false;
	}
}


function ckZwShenhe( theForm ){
	var statusZhuanjia = $('.ps_text .onfocus').attr('rel');//专家是否录用
	theForm.statusZhuanjia.value = statusZhuanjia;
	
//	if ( theForm.dianping.value<=0 && statusZhuanjia==1 ){
//		alert("请输入你的评分意见");
//		theForm.dianping.focus();
//		return false;
//	}

}


function checkGuest( theForm ){
	if ( theForm.nickname.value<=0 ){
		alert("请输入您的姓名");
		theForm.nickname.focus();
		return false;
	}
	var myreg = /^(((13[0-9]{1})|(14[0-9]{1})|(17[0]{1})|(15[0-3]{1})|(15[5-9]{1})|(18[0-9]{1}))+\d{8})$/;
	var tel = theForm.tel.value;
	if ( theForm.tel.value<=0 ){
		alert("请输入您的手机号码");
		theForm.tel.focus();
		return false;
	}
	if ( !myreg.test( tel ) ){
		alert("手机号码格式不正确");
		theForm.tel.focus();
		return false;
	}
//	if ( theForm.codeForm.value<=0 ){
//		alert("请输入您收到的短信验证码");
//		theForm.codeForm.focus();
//		return false;
//	}
}



