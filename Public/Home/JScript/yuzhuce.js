function ckYuzhuce(theForm){

	  if ( theForm.unitName.value<=0 ){
	    alert("单位不能为空");
	    theForm.unitName.focus();
	    return false;
	  }
	  if ( theForm.kpxinxi.value<=0 ){
		    alert("开票信息不能为空");
		    theForm.kpxinxi.focus();
		    return false;
		  }
	  if ( theForm.usergroup.value<=0 ){
		    alert("请增加参会人员");
		    $('#username').focus();
		    return false;
		  }

}

function deluser( index ){
	var userGroup = $('#usergroup').val();//获取参会人员列表

	if( userGroup.length<=0 ){
      userGroup = [];
	}else{
      userGroup =  JSON.parse(userGroup);//反序立化
	}
	userGroup.splice(index, 1);
	var list = JSON.stringify( userGroup );
	  $('#usergroup').val( list );
	  userEach( list );
}

function ckAdduser(){
  var userGroup = $('#usergroup').val();//获取参会人员列表

  if( userGroup.length<=0 ){
      userGroup = [];
  }else{
      userGroup =  JSON.parse(userGroup);//反序立化
  }
  var user = new Object();
  var username = $('#username').val();
  var tel = $('#tel').val();
  var position = $('#position').val();

  if( $.trim(username).length==0 ){
	  alert("请输入参会人员的姓名");
	  $('#username').focus();
	  return false;
  }
  if( $.trim(tel).length==0 ){
	  alert("请输入参会人员的电话");
	  $('#tel').focus();
	  return false;
  }
  if( $.trim(position).length==0 ){
	  alert("请输入参会人员的职位");
	  $('#position').focus();
	  return false;
  }
  
  user.username = username;
  user.tel = tel;
  user.position = position;

  userGroup.push( user );//向列表里添加人员
  var list = JSON.stringify( userGroup );
  $('#usergroup').val( list );
  userEach( list );
}

function userEach( list ){
  var str = "";
    $.each(JSON.parse(list),function(index,obj){
        str += "<li>";
        str += "<span class=\"l1\">姓名："+obj.username+"</span>";
        str += "<span class=\"l2\">电话："+obj.tel+"</span>";
        str += "<span class=\"l3\">职位："+obj.position+"</span>";
        str += "<span class=\"l4\" onclick='javascript:deluser( "+index+" );'>x</span>";
        str += "</li>";
    });
  $('.list').html( str );
}
