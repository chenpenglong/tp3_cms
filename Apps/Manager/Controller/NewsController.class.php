<?php
namespace Manager\Controller;

class NewsController extends BaseController{

	public function lists(){
		$news = M('news');
		$sort = M('newssort');
		$theObj = $sort->where("id=".I('get.id'))->find();
		$this->assign("theObj",$theObj);

		if( $theObj['pid']!=0 ){
			$sortlist = $sort->where("pid=".$theObj['pid'])->order('serialNum desc')->select();
			$this->assign("sortlist",$sortlist);
		}

		$contidion['sort'] = I('get.id');

		$page = $this->getpage($news, $contidion,20);
		$show = $page->show();// 分页显示输出
		$newsList = $news->where($contidion)->order('serialNum desc')->field("id,picture,title,serialNum,sort,rootId,status")->select();
		$newsList = $this->getFatherSortName("news", $newsList);//添加所在父类
		$this->assign('page',$show);// 赋值分页输出
		$this->assign("newsList",$newsList);
		$this->display();
	}

	public function move(){
		$news = M('news');


		$idList = $_POST['theList'];
		$idList = explode(",", $idList);

		$data['sort'] = $_POST['sort'];

		for( $i=0;$i<count($idList);$i++ ){
			$data['id'] = $idList[$i];
			$res = $news->save($data);
		}
		$this->success("移动成功");
	}

	public function add(){
		$sort = M('newssort');
		$sortObj = $sort->where("id=".I('get.id'))->find();
		$this->assign("sortObj",$sortObj);
		$this->assign("findId",$sortObj['id']);
		$this->display();
	}

	public function edit(){
		$news = M('news');
		$theObj = $news->where("id=".I('get.id'))->find();
		$this->assign("theObj",$theObj);
		$this->assign("findId",$theObj['sort']);
		$this->display();
	}

	public function setTJ(){
		$news = M('news');
		$id = $_REQUEST['id'];
		$data = $news->find( $id );
		$data['status'] = $data['status']==0?1:0;
		$res = $news->save( $data );
		if( $res ){
			$this->success("修改成功");
		}else{
			$this->error("修改失败");
		}
	}

	public function setTJone(){
		$news = M('news');
		$id = $_REQUEST['id'];
		$data = $news->find( $id );

		$where['status'] = 1;
		$where['sort'] = $data['sort'];
		$where['id'] = array("neq",$id);
		$lists = $news->where($where)->select();
		foreach( $lists as $key ){
			$key['status'] = 0;
			$news->save( $key );
		}

		$data['status'] = $data['status']==0?1:0;
		$res = $news->save( $data );
		if( $res ){
			$this->success("修改成功");
		}else{
			$this->error("修改失败");
		}
	}

	public function addnews(){
		$news = M('news');
		$data = I();
		if( empty($data['addTime']) ){
			$data['addTime'] = time();
		}else{
	    	$data['addTime'] = strtotime($data['addTime']);
		}
		$res = $news->add($data);
		if( $res>0 ){
			$data['id'] = $res;
			$data['serialNum'] = $res;
			$rootId = $this->getRootId("newssort", $data['sort'] );
			$data['rootId'] = $rootId ;

			$news->save($data);
			$this->success("添加成功",U('news/lists?id='.$data['sort']));
		}else{
			$this->error("添加失败");
		}
	}

	public function editnews(){
		$news = M('news');
		$data = I();
		if( !empty($data['addTime']) ){
		    $data['addTime'] = strtotime($data['addTime']);
		}
		$res = $news->save($data);
		if( $res>0 ){
			$this->success("修改成功",U('news/edit?id='.$data['id']));
		}else{
			$this->error("修改失败");
		}
	}

	public function delete(){
		$news = M('news');
		$res = $news->delete( I('theList') );
		$this->ajaxReturn($res);
	}

	public function serialNumDesc(){
		$news = M('news');
		$res = $news->save(I());
		$this->ajaxReturn($res);
	}

	public function SortSerialNumDesc(){
		$newssort = M('newssort');
		$res = $newssort->save(I());
		$this->ajaxReturn($res);
	}

	public function sortList(){
		$sort = M('newssort');
		$id = isset($_REQUEST['id'])?$_REQUEST['id']:0;
		$sortlist = $this->getsortlist("newssort",$id);
		//$this->assign("list",json_encode($sortlist));
		$this->assign("id", $id);
		$this->assign("list", $this->getSortListHtml("newssort", $id) );
		$this->display();
	}

	public function dataList(){
		$sort = M('newssort');
		$id = isset($_REQUEST['id'])?$_REQUEST['id']:0;
		$sortlist = $this->getsortlist("newssort",$id);
		$this->assign("id", $id);
		$this->assign("list", $this->getDataListHtml("newssort", $id) );
		$this->display();
	}

	public function sortAdd(){
		$sort = M('newssort');
		$this->assign("pid",I('id'));
		$this->assign("rootId", $this->getRootId("newssort", I('id')) );
		$this->display();
	}

	public function sortInsert(){
		$sort = M('newssort');

		$rootId = $this->getRootId("newssort", I('pid'));
		$res = $sort->add(I());
		if( $res>0 ){
			$dataSort = $sort->where("id=$res")->find();
			$dataSort['serialNum'] = $res;
			$dataSort['rootId'] = $rootId;
			$sort->save($dataSort);
			$this->success("添加成功",U('news/sortlist?id='.$rootId));
		}else{
			$this->error("添加失败");
		}
	}

	public function sortEdit(){
		$sort = M('newssort');
		$sortObj = $sort->where("id=".I('id'))->find();
		$this->assign("sortObj",$sortObj);
		$this->assign("rootId", $this->getRootId("newssort", I('id')) );
		$this->display();
	}

	public function sortUpdate(){
		$sort = M('newssort');
		$res = $sort->save(I());
		$rootId = $this->getRootId("newssort", I('id'));
		if( $res>0 ){
			$this->success("修改成功",U('news/sortlist?id='.$rootId));
		}else{
			$this->error("修改失败");
		}
	}

	public function sortDelete(){
		$sort = M('newssort');
		$res = $sort->delete(I('id'));
		if( $res>0 ){
			$this->success("删除成功");
		}else{
			$this->error("删除失败");
		}
	}

	public function root(){
		$news = M('news');
		$newsList = $news->select();
		foreach( $newsList as $n ){
			$rootId = $this->getRootId("news", $n['sort'] );
			$n['rootId'] = $rootId;
			$res = $news->save($n);
		}
		var_dump( $newsList );
	}

}