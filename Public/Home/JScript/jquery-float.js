(function($){
	$.fn.floatQQ=function(o)
	{
		o=typeof(o)=="object"?o:{};
		var qq=$(this);
		qq.css({position:"absolute",zIndex:1000,left:$(window).width()-140});
		o.top=parseInt(o.top);
		o.bottom=parseInt(o.bottom);
		o.x=o.x||qq.position().left;
		o.isHide=qq.position().left<0?true:false;
		o.h=qq.height();
		function qqDoset()
		{
			if(qqDoset.doset)
			{clearTimeout(qqDoset.doset)}
			qqDoset.doset=setTimeout(qqPoset,50);
		}
		function qqPoset()
		{
			var scrollTop=$(document).scrollTop();
			var winHeight=$(window).height();
			//自动居中
			var _top=o.bottom?parseInt(winHeight+scrollTop-o.bottom-o.h+20)+"px":parseInt(scrollTop+(o.top||(winHeight/2 - o.h/2))+20)+"px";
			//固定高度
			//var _top=scrollTop+100;
			qq.stop(true,false)
			.animate({top:_top},{duration:o.duration||2200,easing:o.easing||"elasout"});
			if(o.type)
			{qq.click(qqShow)}
			else
			{qq.hover(qqShow,qqShow)}
		}
		function qqShow()
		{
			if(qq.show)
			{clearTimeout(qq.timeoOut)}
			qq.show=setTimeout(function(){qq.stop(true,false).animate({},{easing:"easeout"})},50)
		}
		function getPos()
		{
			o.isHide=o.isHide?false:true;
			return o.isHide?o.x:0;
		}
		function qqIni()
		{
			qqDoset();
			$(window).scroll(qqDoset);
		}
		qqIni();
		return this;
	}
})(jQuery)