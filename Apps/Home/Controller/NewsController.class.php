<?php
namespace Home\Controller;
use Think\Page;
header("Content-type: text/html; charset=utf-8");
class NewsController extends BaseController{
	public function lists(){
		$news = M('news');
		$newssort = M('newssort');
		if( isset($_REQUEST['rootId']) ){
			$where['rootId'] = $_REQUEST['rootId'];
			$rootId = $_REQUEST['rootId'];
		}
		if( isset($_REQUEST['sort']) ){
			$where['sort'] = $_REQUEST['sort'];
			$thissort = $newssort->find( $_REQUEST['sort'] );
			$rootId = $thissort['rootId'];
		}
		
		$rootsort = $newssort->find( $rootId );
		$this->assign("rootsort",$rootsort);
		
		$sortlist = $newssort->where("pid=".$rootId)->order("serialNum desc,id desc")->select();
		$this->assign("sortlist",$sortlist);
		
		switch( $rootId ){
			case 3:
				$size = 3;
				$tpl = "productlist";
				break;
			case 4:
				$size = 16;
				$tpl = "newslist";
				break;
		}
		
		$page = $this->getpage($news,$where,$size);
		$show = $page->show();
		$lists = $news->where($where)->order("serialNum desc,id desc")->select();
		$this->assign("list",$lists);
		$this->assign("page",$show);
		
		$this->display( $tpl );
	}
	
	
	public function show( $id ){
		$news = M('news');
		$data = $news->find($id);
		
		/*匹配img取出src*/
		$pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/"; 
		preg_match_all($pattern,$data['imgGroup'],$match);
		$data['imgGroup'] = $match[1];
		
		$this->assign("data",$data);
		
		
		$this->assign("prevNext",$this->prevNext($id));//上一页下一页
		
		$this->assign("navIndex",6);
		
		$this->display();
	}
	
}