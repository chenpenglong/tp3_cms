<?php

namespace Manager\Controller;
class WebSetController extends BaseController{
	public function edit(){
		$webset = M("config");
		$theObj = $webset->where("id=1")->find();
		
		$data = unserialize($theObj['siteconfig']);
		$this->assign("data",$data);
		
		$this->display();
	}
	
	public function editWebSet(){
		$webset = M("config");
		$data = I();
		
		$configdata = array();
		$configdata['id'] = 1;
		$configdata['siteconfig'] = serialize($data);
		
		$res = $webset->save( $configdata );
		if( $res>0 ){
			$this->success("修改成功",U('webSet/edit'));
		}else{
			$this->error("修改失败");
		}
	}
}