<?php
namespace Manager\Controller;

class FloatController extends BaseController{
	public function lists(){
		$float = M('float');
		$list = $float->order('serialNum asc')->select();
		$this->assign("list",$this->getType($list));
		$this->display();
	}
	
	public function add(){
		$float = M('float');
		$this->display();
	}
	
	public function edit(){
		$float = M('float');
		$data = $float->find( $_REQUEST['id'] );
		$this->assign("data",$data);
		$this->display();
	}
	
	public function addFloat(){
		$float = M('float');
		$data = I();
		$res = $float->add($data);
		if( $res>0 ){
			$data['id'] = $res;
			$data['serialNum'] = $res;
			$float->save($data);
			$this->success("添加成功",U('float/lists'));
		}else{
			$this->error("添加失败");
		}
	}
	
	public function editFloat(){
		$float = M('float');
		$data = I();
		$res = $float->save($data);
		if( $res>0 ){
			$this->success("编辑成功");
		}else{
			$this->error("编辑失败");
		}
	}
	
	public function delete(){
		$float = M('float');
		$res = $float->delete( I('theList') );
		$this->ajaxReturn($res);
	}
	
	public function serialNumDesc(){
		$float = M('float');
		$res = $float->save(I());
		$this->ajaxReturn($res);
	}
	
	private function getType( $list ){
		if( empty($list) ){
			return array();
		}
		
		foreach ($list as $k=>$row){
			switch ( $row['type'] ){
				case 1:
					$type = "QQ";
					break;
				case 2:
					$type = "邮箱";
					break;
				case 3:
					$type = "Msn";
					break;
				case 4:
					$type = "Skype";
					break;
				case 5:
					$type = "电话";
					break;
				case 6:
					$type = "图片";
					break;
				default:
					$type = " ";
					break;
			}
			$list[$k]['type'] = $type;
		}
		return $list;
	}
}