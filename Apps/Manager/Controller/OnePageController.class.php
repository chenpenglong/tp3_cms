<?php
namespace Manager\Controller;
class OnePageController extends BaseController{
	public function lists(){
		$onePage = M('onepage');
		$page = $this->getpage($onePage, array(),20);
		
		$list = $onePage->select();
		$this->assign("list",$list);
		$this->assign("page",$page->show());
		$this->display();
	}
	
	public function add(){
		$this->display();
	}
	
	public function addOnePage(){
		$onePage = M('onepage');
		$res = $onePage->add(I());
		if( $res>0 ){
			$this->success("新增成功",U('onePage/lists'));
		}else{
			$this->error("新增失败");
		}
	}
	
	public function edit(){
		$onePage = M('onepage');
		$theObj = $onePage->where("id=".I('id'))->find();
		$this->assign("theObj",$theObj);
		$this->display();
	}
	
	public function editOnePage(){
		$onePage = M('onepage');
		$res = $onePage->save(I());
		if( $res>0 ){
			$this->success("修改成功");
		}else{
			$this->error("修改失败");
		}
	}
	
	public function delete(){
		$onePage = M('onepage');
		$res = $onePage->delete( I('theList') );
		$this->ajaxReturn($res);
	}
}