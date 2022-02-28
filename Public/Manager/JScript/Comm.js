function setTableColor(){
	
}
//设置表格颜色、最小高度
function setTableColor2(){
	var isSetColor=arguments[0]?0:1
	//设置表格颜色
	if (isSetColor>0) {
		var theTable = $("table");
		var theTr, thetd, thecolor, n;
		for (var i = 0; i < theTable.length; i++) {
			theTr = $(theTable[i]).find("tr");
			n = 1;
			for (var j = 0; j < theTr.length; j++) {
				var thetd = $(theTr[j]).find("td");
				var theth = $(theTr[j]).find("th");
				if (thetd.length > 0) {
					if (n == 0) {
						thecolor = "#FFFFFF";
					}
					else {
						thecolor = "#E7EBEE";
					}
					for (var s = 0; s < thetd.length; s++) {
						thetd[s].style.backgroundColor = thecolor;
						$(thetd[s]).attr("morenys", thecolor);
					}
					for (var s = 0; s < theth.length; s++) {
						theth[s].style.backgroundColor = thecolor;
						$(theth[s]).attr("morenys", thecolor);
					}
					
					$(theTr[j]).hover(function(){
						var thetd = $(this).find("td");
						var theth = $(this).find("th");
						for (var s = 0; s < thetd.length; s++) {
							thetd[s].style.backgroundColor = "#FFFFCC";
						}
						for (var s = 0; s < theth.length; s++) {
							theth[s].style.backgroundColor = "#FFFFCC";
						}
					}, function(){
						var thetd = $(this).find("td");
						var theth = $(this).find("th");
						for (var s = 0; s < thetd.length; s++) {
							thetd[s].style.backgroundColor = $(thetd[s]).attr("morenys");
						}
						for (var s = 0; s < theth.length; s++) {
							theth[s].style.backgroundColor = $(theth[s]).attr("morenys");
						}
					});
					if (n == 1) {
						n = 0;
					}
					else {
						n = 1;
					}
				}
			}
		}
	}
	//设置占位高度
	if ($(document.body).outerHeight(true) < $(document).height()) {
		$("body").append("<div id='rightZw'>&nbsp;</div>");
		$("#rightZw").css({
			"top": "100%"
		});
	}
}

//验证字符串是否只含数字，字母和下划线 是则返回True 否则返回False
function isHf(str){
	var reg = /[^A-Za-z0-9_]/g;
	if (reg.test(str)) {
		return (false);
	}
	else {
		return (true);
	}
}

//翻页的跳转
function goToTheUrl(TheSelect){
	location.href = TheSelect.value;
}

//全选
function selectAll(name){
	var n = document.getElementsByName(name).length;
	for (var i = 0; i < n; i++) {
		document.getElementsByName(name)[i].checked = true;
	}
}
//全不选
function unSelectAll(name){
	var n = document.getElementsByName(name).length;
	for (var i = 0; i < n; i++) {
		document.getElementsByName(name)[i].checked = false;
	}
}
//反选
function antiSelectAll(name){
	var n = document.getElementsByName(name).length;
	for (var i = 0; i < n; i++) {
		var e = document.getElementsByName(name)[i];
		if (e.checked) {
			e.checked = false;
		}
		else {
			e.checked = true;
		}
	}
}

//判读是否有选中的复选框（有则返回用"-"分割的值的字符串）
function ifChecked(chkboxname){
	var myValue = "";
	for (var i = 0; i < document.getElementsByName(chkboxname).length; i++) {
		var e = document.getElementsByName(chkboxname)[i];
		if (e.checked) {
			if (myValue == "") {
				myValue = e.value;
			}
			else {
				myValue = myValue + "," + e.value;
			}
		}
	}
	return myValue;
}

//警告框
function theWarn(){
	var mess = "你确定要执行吗？执行后无法恢复!";
	var question = confirm(mess);
	if (question == '0') {
		return false;
	}
	else {
		return true;
	}
}


// 参数说明
// s_Type : 文件类型，可用值为"image","file"
// s_Link : 文件上传后，用于接收上传文件路径文件名的表单名
function showUploadDialog(s_Type, s_Link, s_public){
	var txt="";
	switch (s_Type) {
		case "image":
			txt = "图片";
			break;
		case "file":
			txt = "附件";
			break;
		default:
			alert('参数错误');
			return;	}
	var DiZhi = s_public+"/Bianji/singleUp/swaraj_upload.php?type=" + s_Type + "&link=" + s_Link + "&rnd=" + Math.random();
	var html="<div id='showUploadDialogBg'>&nbsp;</div>";
	html+="<div id='showUploadDialog'>";
	html+="<div class='title'>上传("+txt+")- 管理系统 </div>";
	html+="<div class='close'>&nbsp;</div>";
	html+="<div class='content'><iframe src='"+DiZhi+"' scrolling='no' style='border:0px;width:400px;height:180px;'></iframe></div>";
	html+="</div>";
	
	$("body").append(html);
	
	$("#showUploadDialogBg").css({height:$(document).height()});
	var thetop=$(document).scrollTop()+$(window).height()/2;
	$("#showUploadDialog").css({"top":thetop+"px"});
	$("#showUploadDialog .close").hover(function(){
		$(this).css({"backgroundPosition":"0px -19px"});
	},function(){
		$(this).css({"backgroundPosition":"0px 0px"});
	});
	$("#showUploadDialog .close").click(function(){
		$("#showUploadDialogBg").remove();
		$("#showUploadDialog").remove();
	});
}

// 参数说明
function showWaterMarkDialog(s_public){
	var DiZhi = s_public+"Bianji/singleUp/wateMark_upload.php?rnd=" + Math.random();
	var html="<div id='showUploadDialogBg'>&nbsp;</div>";
	html+="<div id='showUploadDialog'>";
	html+="<div class='title'>上传(水印图片)- 管理系统 </div>";
	html+="<div class='close'>&nbsp;</div>";
	html+="<div class='content'><iframe src='"+DiZhi+"' scrolling='no' style='border:0px;width:400px;height:180px;'></iframe></div>";
	html+="</div>";
	
	$("body").append(html);
	
	$("#showUploadDialogBg").css({height:$(document).height()});
	var thetop=$(document).scrollTop()+$(window).height()/2;
	$("#showUploadDialog").css({"top":thetop+"px"});
	$("#showUploadDialog .close").hover(function(){
		$(this).css({"backgroundPosition":"0px -19px"});
	},function(){
		$(this).css({"backgroundPosition":"0px 0px"});
	});
	$("#showUploadDialog .close").click(function(){
		$("#showUploadDialogBg").remove();
		$("#showUploadDialog").remove();
	});
}

//设置单选框
function setDxk(chkboxname, theValue){
	var e;
	for (var i = 0; i < document.getElementsByName(chkboxname).length; i++) {
		e = document.getElementsByName(chkboxname)[i];
		if (e.value == theValue) {
			e.checked = true;
		}
	}
}

//设置复选框
function setFxk(theName, theValue){
	var e;
	var chkboxname = "temp" + theName;
	if (theValue == "") {
		var thelist = '';
		for (var i = 0; i < document.getElementsByName(chkboxname).length; i++) {
			e = document.getElementsByName(chkboxname)[i];
			if (e.checked) {
				if (thelist != '') {
					thelist += ",";
				}
				thelist += e.value;
			}
		}
		document.getElementById(theName).value = thelist;
	}
	else {
		var theArray = theValue.split(",");
		for (var i = 0; i < theArray.length; i++) {
			for (var j = 0; j < document.getElementsByName(chkboxname).length; j++) {
				e = document.getElementsByName(chkboxname)[j];
				if (e.value == theArray[i]) {
					e.checked = true;
				}
			}
		}
	}
}

//点击移动
function ClickMove(theAObj){
	var temp=$(theAObj).parent("td").get(0);
	$("td.move").html("");
	$(temp).html("<img src='../Images/jindu.gif' height='20' />");
}

//类别收缩初始化
function SortShrink(i){
		var s = $(i).parent();
		var status = $(i).attr('rel');
		var tid = s.data('id');
		var tpid = s.data('pid');
		ergodic( tid,tpid,status,$(i) );
}

//类别收缩绑定事件
function ergodic( tid,tpid,status,s ){
	var upImg = "../../../../../Public/Manager/Images/jia.gif";
	var downImg = "../../../../../Public/Manager/Images/jian.gif";
	$('.listTable tr').each(function(){
		var o = $(this).find('td:eq(0)');
		if( o.data('pid')==tid ){
			if( status=="shou" ){
				o.parent().hide();
				s.attr('rel','fang');
				s.attr('src',upImg);
			}else{
				o.parent().show();
				s.attr('rel','shou');
				s.attr('src',downImg);
			}
		}
		if( tpid==0 && o.data('rootId')==tid && o.data('id')!=tid  ){
			if( status=="shou" ){
				o.parent().hide();
				s.attr('rel','fang');
				s.attr('src',upImg);
			}else{
				o.parent().show();
				s.attr('rel','shou');
				s.attr('src',downImg);
			}
		}			
	})
}


function serialNumDesc( inp,id,href ){
	var serialNum = $(inp).val();
	$.post(href,{'id':id,'serialNum':serialNum},function(){
		window.location.reload();
	},'json')
}

function handleSelect(name,href){
	var theList = ifChecked(name);
	var b = confirm('你确定要删除吗？');
	if( b ){
		$.ajax({
			type: "POST",
	    	url: href,
	     	data: {"theList":theList},
	     	dataType: "json",
	    	success: function(data){
				window.location.reload();
	  		}
		});	
	}
	
}

function emailSelect(name,href,content){
	var theList = ifChecked(name);
	var b = confirm('你确定要发送吗？');
	if( b ){
		$.ajax({
			type: "POST",
	    	url: href,
	     	data: {"theList":theList,'content':content},
	     	dataType: "json",
	    	success: function(data){
	    		var str = "";
	    		for( var i in data ){
	    			if( data[i]['status']==1 ){
	    				str += "<div style=\"color:#008000\">"+data[i]['msg']+"</div>";
	    			}else{
	    				str += "<div style=\"color:#D41D1D\">"+data[i]['msg']+"</div>";
	    			}
	    		}
	    		document.getElementById('sendInfo').innerHTML = str;
	  		}
		});	
	}
	
}

function isSh(id,href){
	$.ajax({
		type: "POST",
    	url: href,
     	data: {"id":id},
     	dataType: "json",
    	success: function(data){
			window.location.reload();
  		}
	});	
}

function show_confirm( text,href ){
	var b = confirm( text );
	if( b ){
		window.location.href = href;
	}
}

