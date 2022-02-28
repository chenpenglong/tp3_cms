<?php
namespace Manager\Controller;
header("Content-type:text/html;charset=utf-8");
class PublicController extends BaseController{
	public function index(){
		$this->display("Frame");
	}

	public function TopFrm(){
		$admin = M('admin');
		$this->assign("theObj",cookie("adminTheObj"));
		$this->display('TopFrm');
	}
	public function MenuFrm(){


//		$newssort = M("newssort");
//		$hdsortlist = $newssort->where("pid=3")->order("serialNum desc,id desc")->select();
//		$hdmenu = array();
//		foreach( $hdsortlist as $k=>$v ){
//			$slist = $newssort->where("pid=".$v['id'])->order("serialNum desc,id desc")->select();
//			if( !empty($slist) ){
//				$sonarr = array();
//				foreach( $slist as $n=>$m ){
//					$sonarr[$m['sortName']] = U('news/lists/id/'.$m['id']);
//				}
//				$hdmenu[$v['sortName']] = $sonarr;
//			}else{
//				$hdmenu[$v['sortName']] = U('news/lists/id/'.$v['id']);
//			}
//		}
//		$menu[]=array(
//			'name'=>'近期活动',
//			'list'=>$hdmenu,
//			);


//		$menu[]=array(
//			'name'=>'关于我们',
//			'list'=>array(
//						'文章列表'=>U('news/lists/id/3'),
//					),
//			);

//		 $menu[]=array(
//			'name'=>'新闻动态',
//			'list'=>array(
//						'类别列表'=>U('news/sortlist/id/4'),
//						'文章列表'=>U('news/datalist/id/4'),
//					),
//			);

//		$menu[]=array(
//			'name'=>'联系我们',
//			'list'=>array(
//						'联系我们'=>U('onePage/edit/id/1'),
//					),
//			);

		 $menu[]=array(
			'name'=>'单页管理',
			'list'=>array(
						'信息管理'=>U('onePage/lists'),
					),
			);

		 $menu[]=array(
			'name'=>'类别管理',
			'list'=>array(
						'新闻文章列表'=>U('news/datalist'),
						'新闻类别列表'=>U('news/sortlist'),
						'链接文章列表'=>U('link/datalist'),
						'链接类别列表'=>U('link/sortlist'),
					),
			);

		 $menu[]=array(
			'name'=>'留言板管理',
			'list'=>array(
						'留言列表'=>U('guestBook/lists'),
					),
			);
			
		 $menu[]=array(
			'name'=>'幻灯管理',
			'list'=>array(
						'首页幻灯'=>U('link/lists/id/1'),
						'内页幻灯'=>U('link/lists/id/2'),
					),
			);

     $menu[]=array(
      'name'=>'其它管理',
      'list'=>array(
            '系统设置'=>U('webSet/edit'),
            '右侧漂浮'=>U('float/lists'),
          ),
      );


		$this->assign("menu",$menu);
		$this->display('MenuFrm');
	}
	public function RightFrm(){
		$this->display('RightFrm');
	}
	public function phpdata(){
		echo phpinfo();
	}
}