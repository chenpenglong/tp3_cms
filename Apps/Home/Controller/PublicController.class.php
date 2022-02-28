<?php

use Home\Controller\BaseController;
class PublicController extends BaseController{
	public function top(){
		$this->display('top.html');
	}
	public function bottom(){
		$this->display('bottom.html');
	}
	public function left(){
		$this->display();
	}
	public function showPf(){
		$this->display('showPf.html');
	}
}