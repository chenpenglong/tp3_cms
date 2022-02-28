<?php

namespace Manager\Controller;
class LinkController extends BaseController{
	public function lists(){
		$link = M('link');
		$sort = M('linksort');
		$theObj = $sort->where("id=".I('get.id'))->find();
		$this->assign("theObj",$theObj);
		$where['sort'] = I('id');
		$page = $this->getpage($link, $where,20);
		$linkList = $link->where($where)->order('serialNum desc')->select();
		$linkList = $this->getFatherSortName("link", $linkList);//添加所在父类
		$this->assign("page",$page->show());
		$this->assign("linkList",$linkList);
		
		if( isset($_REQUEST['newsid']) ){
			$newsdata = M("news")->find( $_REQUEST['newsid'] );
			$this->assign("newsdata",$newsdata);
		}

		$this->display();
	}

	public function serialNumDesc(){
		$link = M('link');
		$res = $link->save(I());
		$this->ajaxReturn($res);
	}

	public function add(){
		$link = M('link');
		$sort = M('linksort');
		$theObj = $sort->where("id=".I('get.id'))->find();
		$this->assign("theObj",$theObj);
		
		if( isset($_REQUEST['newsid']) ){
			$newsdata = M("news")->find( $_REQUEST['newsid'] );
			$this->assign("newsdata",$newsdata);
		}
		
		$this->display();
	}

	public function addLink(){
		$link = M('link');
		$res = $link->add(I());
		if( $res>0 ){
			$data = $link->find( $res );
			$data['id'] = $res;
			$data['serialNum'] = $res;
			$rootId = $this->getRootId("linksort", $data['sort'] );
			$data['rootId'] = $rootId ;

			$link->save($data);
			$this->success("新增成功",U('link/lists?id='.$data['sort']));
		}else{
			$this->error("新增失败");
		}
	}

	public function edit(){
		$link = M('link');
		$theObj = $link->where("id=".I('get.id'))->find();
		$this->assign("theObj",$theObj);

		$where['id']=I('id');
		$theObj = $link->where($where)->find();
		
		if( $theObj['newsid']!=0 ){
			$newsdata = M("news")->find( $theObj['newsid'] );
			$this->assign("newsdata",$newsdata);
		}
		
		$this->display();
	}

	public function editLink(){
		$link = M('link');
		$res = $link->save(I());
		if( $res>0 ){
			$this->success("修改成功",U('link/edit?id='.I('id')));
		}else{
			$this->error("修改失败");
		}
	}

	public function delete(){
		$link = M('link');
		$res = $link->delete(I('theList'));
		$this->ajaxReturn($res);
	}


	public function SortSerialNumDesc(){
		$linksort = M('linksort');
		$res = $linksort->save(I());
		$this->ajaxReturn($res);
	}

	public function dataList(){
		$sort = M('linksort');
		$id = isset($_REQUEST['id'])?$_REQUEST['id']:0;
		$sortlist = $this->getsortlist("linksort",$id);
		$this->assign("id", $id);
		$this->assign("list", $this->getDataListHtml("linksort", $id) );
		$this->display();
	}

	public function sortList( $id=0 ){
		$sort = M('linksort');
		$sortlist = $this->getsortlist("linksort",$id);
		//$this->assign("list",json_encode($sortlist));
		$this->assign("id", $id );
		$this->assign("list", $this->getSortListHtml("linksort", $id) );
		$this->display();
	}


	public function sortAdd(){
		$sort = M('linksort');
		$this->assign("pid",I('id'));
		$this->assign("rootId", $this->getRootId("linksort", I('id')) );

		$this->display();
	}

	public function sortInsert(){
		$sort = M('linksort');

		$rootId = $this->getRootId("linksort", I('pid'));
		$res = $sort->add(I());
		if( $res>0 ){
			$dataSort = $sort->where("id=$res")->find();
			$dataSort['serialNum'] = $res;
			$dataSort['rootId'] = $rootId;
			$sort->save($dataSort);
			$this->success("添加成功",U('link/sortlist?id='.$rootId));
		}else{
			$this->error("添加失败");
		}
	}

	public function sortEdit(){
		$sort = M('linksort');
		$sortObj = $sort->where("id=".I('id'))->find();
		$this->assign("sortObj",$sortObj);
		$this->assign("rootId", $this->getRootId("linksort", I('id')) );
		$this->display();
	}

	public function sortUpdate(){
		$sort = M('linksort');
		$res = $sort->save(I());
		$rootId = $this->getRootId("linksort", I('id'));
		if( $res>0 ){
			$this->success("修改成功",U('link/sortlist?id='.$rootId));
		}else{
			$this->error("修改失败");
		}
	}

	public function sortDelete(){
		$sort = M('linksort');
		$res = $sort->delete(I('id'));
		if( $res>0 ){
			$this->success("删除成功");
		}else{
			$this->error("删除失败");
		}
	}
}