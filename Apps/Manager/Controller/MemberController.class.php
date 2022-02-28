<?php

namespace Manager\Controller;

class MemberController extends BaseController{
	public function lists(){
		$member = M('member');
		$where['position'] = I('id');
		$page = $this->getpage($member,$where);
		$lists = $member->where($where)->select();
		$this->assign("memberList",$lists);
		$this->assign("page",$page->show());
		$this->assign("posId",I('id'));
		$this->display();
	}

	public function ready(){
		$member = M('member');
		$post = I();
		if( empty( $post['shenHeType'] ) ){
				$where['id'] = I('id');
				$data = $member->where($where)->find();
				$typeList = M('linksort')->where('pid=4')->select();
				$this->assign("theObj",$data);
				$this->assign("typeList",$typeList);
				$this->display();
		}else{
			$res = $member->save( I() );
			if( $res>0 ){
					$this->success("审核类型更改成功");
			}else{
					$this->error('审核类型更改失败');
			}
		}

	}
	
	public function editPassWord(){
		$member = M('member');
		$data['id'] = $_REQUEST['id'];
		$data['password'] = md5( $_REQUEST['password'] );
		$res = $member->save( $data );
		if( $res>0 ){
			$this->success("密码更改成功");
		}else{
			$this->error('密码更改失败');
		}
	}


	/*
	 *
	 * 增加投稿者
	 * */
	public function addTgz(){
		$member = M('member');
		$post = I();
		if( empty( $post ) ){
			$typeList = M('linksort')->where('pid=4')->select();
			$this->assign("typeList",$typeList);
			$this->display();
		}else{
			$data['username'] = I('username');
			$data['email'] = I('email');
			$data['position'] = 2;
			$data['shenHeType'] = I('shenHeType');
			$data['password'] = md5( I('pass2') );
			$res = $member->add($data);
			if( $res>0 ){
				$this->success("添加成功",U('lists?id=2'));
			}else{
				$this->error("添加失败");
			}
		}
	}

	public function delete(){
		$member = M('member');
		$res = $member->delete(I('theList'));
		$this->ajaxReturn($res);
	}
}