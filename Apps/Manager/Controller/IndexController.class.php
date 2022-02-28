<?php
namespace Manager\Controller;
use Think\Verify;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	if( cookie('adminTheObj')==null ){
	    	$this->display();
    	}else{
    		$this->redirect('Public/index');
    		//U('Public/index');
    	}
    }
    
    public function getVerify (){
    	$config =    array(
    			'fontSize'    =>    14,    // 验证码字体大小
    			'length'      =>    4,     // 验证码位数
    			'useNoise'    =>    false, // 关闭验证码杂点
    	);
    	$Verify = new Verify($config);
    	$Verify->fontttf = '5.ttf';
    	// 设置验证码字符为纯数字
    	$Verify->codeSet = '0123456789';
		$Verify->entry();
    }
    
    public function login(){
    	if( $this->check_Verify(I('ckCode')) ){
    		$admin = M('admin');
    		$user_contion = array('username'=>I('post.user'),'password'=>md5(I('post.pass')));
    		$res = $admin->where($user_contion)->find();
    		if( count($res)>0 ){
    			cookie('adminTheObj',$res);
    			
    			$contidon['id'] = $res['id'];
    			$contidon['lastLoginTime'] = $res['nowLoginTime'];
    			$contidon['nowLoginTime'] = date('Y-m-d H:i:s',time());
    			$contidon['loginNum'] = $res['loginNum'] +1;
    			$res2 = $admin->save( $contidon );
    			
    			$this->success("登录成功",U('Public/index'));
    		}else{
    			$this->error("帐号或密码错误，请重新登录");
    		}
    	}else{
    		$this->error("验证码错误");
    	}
    }
    
    public function loginOut(){
    	cookie('adminTheObj',null);
		$this->success("注销成功",U('Index/index'));
    }
    
    public function check_Verify($code,$id = ''){
    	$Verify = new Verify();
    	return $Verify->check($code, $id);
    }
}