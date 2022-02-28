/**
 * 管理员Js
 */

//验证字符串是否只含数字，字母，汉字和下划线 是则返回True 否则返回False
function isUser(str){
	var reg = /[^A-Za-z0-9\u4e00-\u9fa5_]/g;
	if (reg.test(str)) {
		return (false);
	}
	else {
		return (true);
	}
}

//管理员添加验证
function ckAdd(theForm){
	if (theForm.user.value.length == 0) {
		alert("用户名长度在4位-20位之间,一个汉字占2位");
		theForm.user.focus();
		return false;
	}
	if (!isUser(theForm.user.value)) {
		alert("用户名只能为数字，字母，汉字或下划线");
		theForm.user.focus();
		return false;
	}
	
	var uservalue = theForm.user.value.replace(/[\u4e00-\u9fa5]/g, "aa");
	if (uservalue.length < 4 || uservalue.length > 20) {
		alert("用户名长度在4位-20位之间,一个汉字占2位");
		theForm.user.focus();
		return false;
	}
	if (theForm.pass1.value.length < 4 || theForm.pass1.value.length > 20) {
		alert("密码长度在4位-20位之间");
		theForm.pass1.focus();
		return false;
	}
	if (theForm.pass1.value != theForm.pass2.value) {
		alert("两次输入密码不一致");
		theForm.pass1.focus();
		return false;
	}
	if (!isHf(theForm.pass1.value)) {
		alert("密码只能为数字，字母或下划线");
		theForm.pass1.focus();
		return false;
	}
	if (theForm.nickname.value == "") {
		alert("请输入昵称");
		theForm.nickname.focus();
		return false;
	}
}

//管理员修改的验证
function ckEdit(theForm){
	if (theForm.pass1.value.length != 0 || theForm.pass2.value.length != 0) {
		if (theForm.pass1.value.length == 0 || theForm.pass2.value.length == 0) {
			alert("两次输入新密码不一致");
			theForm.pass1.focus();
			return false;
		}
		if (theForm.pass1.value.length < 4 || theForm.pass1.value.length > 20) {
			alert("密码长度在4位-20位之间");
			theForm.pass1.focus();
			return false;
		}
		if (theForm.pass1.value != theForm.pass2.value) {
			alert("两次输入密码不一致");
			theForm.pass1.focus();
			return false;
		}
		if (!isHf(theForm.pass1.value)) {
			alert("密码只能为数字，字母或下划线");
			theForm.pass1.focus();
			return false;
		}
	}
	if (theForm.nickname.value == "") {
		alert("请输入昵称");
		theForm.nickname.focus();
		return false;
	}
}