<?php

namespace Home\Controller;
class OnepageController extends BaseController{
	public function index( $id ){
		$onePage = M('onepage');
		$data = $onePage->find( $id );
		$this->assign("onepage",$data);
		$this->display();
	}
}