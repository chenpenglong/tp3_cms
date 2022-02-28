<?php
namespace Manager\Controller;

class AdminController extends BaseController{
	
	public function AdminList(){
		$admin = M('admin');
		
		$page = $this->getpage($admin, array(),20);
		$adminList = $admin->select();
		$this->assign("page",$page->show());
		$this->assign("list",$adminList);

		$this->assign("adminTheObj",cookie('adminTheObj'));
		
		$this->display('adminList');
	}
	
	public function add(){
		$this->display('add');
	}
	
	public function add2(){
		$admin = M('admin');
		$data['username'] = I('post.user');
		$data['password'] = md5( I('post.pass2') );
		$data['nickname'] = I('post.nickname');
		$res = $admin->add($data);
		if( $res>0 ){
			$this->success("新增成功",U('admin/AdminList'));
		}else{
			$this->error("新增失败");
		}
	}
	
	public function edit(){
		$admin = M('admin');
		$adminObj = $admin->where("id=".I('id'))->find();
		$this->assign("theObj",$adminObj);
		$this->display('edit');
	}
	
	public function edit2(){
		$admin = M('admin');
		$condition['nickname'] = I('post.nickname');
		$post = I();
		
		if( !empty( $post['pass2'] ) ){
			$condition['password'] = md5( I('post.pass2') );
		}
		$res = $admin->where("id=".I('post.theId'))->save($condition);
		if( $res>0 ){
			$this->success("修改成功");
		}else{
			$this->error("修改失败");
		}
	}
	


	public function delete(){
		$admin = M('admin');
		$res = $admin->delete( I('theList') );
		$this->ajaxReturn($res);
	}
}