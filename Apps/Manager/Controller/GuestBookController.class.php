<?php
namespace Manager\Controller;
use Manager\Controller\BaseController;
class GuestBookController extends BaseController{
	public function lists(){
		$guestbook = M('guestbook');
		
		$where = array();
		if( isset($_REQUEST['status']) ){
			$where['status'] = $_REQUEST['status'];
		}
		
		$page = $this->getpage($guestbook, $where,20);
		$guestList = $guestbook->where($where)->order('id desc')->select();
		$this->assign("list",$guestList);
		$this->assign("page",$page->show());
		$this->display();
	}
	
	public function ready(){
		$guestbook = M('guestbook');
		$row = $guestbook->where("id=".I('id'))->find();
		$this->assign("theObj",$row);
		$this->display();
	}
	
	public function isSh(){
		$guestbook = M('guestbook');
		$condition['id'] = I('post.id');
		$row = $guestbook->where( $condition )->find();
		$condition['isSh'] = $row['isSh']==0?1:0;
		$guestbook->save($condition);
		$this->ajaxReturn($condition);
	}
	
	public function delete(){
		$guestbook = M('guestbook');
		$res = $guestbook->delete( I('theList') );
		$this->ajaxReturn($res);
	}
}