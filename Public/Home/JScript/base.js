function GetHttpRequest() 
{ 
 if ( window.XMLHttpRequest ) // Gecko 
 return new XMLHttpRequest() ; 
 else if ( window.ActiveXObject ) // IE 
 return new ActiveXObject("MsXml2.XmlHttp") ; 
} 
  
function ajaxPage(sId, url){ 
 var oXmlHttp = GetHttpRequest() ; 
 oXmlHttp.onreadystatechange = function() 
 { 
 if (oXmlHttp.readyState == 4) 
 { 
 includeJS( sId, url, oXmlHttp.responseText ); 
 } 
 } 
 oXmlHttp.open('GET', url, false);//同步操作 
 oXmlHttp.send(null); 
} 
  
function includeJS(sId, fileUrl, source) 
{ 
 if ( ( source != null ) && ( !document.getElementById( sId ) ) ){ 
 var oHead = document.getElementsByTagName('HEAD').item(0); 
 var oScript = document.createElement( "script" ); 
 oScript.type = "text/javascript"; 
 oScript.id = sId; 
 oScript.text = source; 
 oHead.appendChild( oScript ); 
 } 
}

var host = window.location.protocol+"//"+window.location.host;

ajaxPage("js_jquery",host+"/Public/Home/JScript/jquery-1.9.1.min.js");
ajaxPage("js_swiper",host+"/Public/Home/JScript/idangerous.swiper.min.js");
ajaxPage("js_wow",host+"/Public/Home/JScript/wow.js");
ajaxPage("js_comm",host+"/Public/Home/JScript/Comm.js");
