<?php
namespace Home\Controller;

class IndexController extends BaseController {
    public function index(){
    	$link = M('link');
    	$bannerList = $link->where("sort=1")->order("serialNum desc,id desc")->select();
		$bannerList = $this->AttrUrl($bannerList);
		$this->assign('bannerList',$bannerList);
		
    	$this->display();
    }
}