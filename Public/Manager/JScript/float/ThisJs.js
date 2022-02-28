/**
 * 浮动Js
 */
//单页验证
function ckTheForm(theForm){
	if (theForm.title_txt.value.length == 0 && theForm.code_txt.value.length == 0) {
		alert("请输入标题与代码不能同时为空");
		theForm.title_txt.focus();
		return false;
	}
}