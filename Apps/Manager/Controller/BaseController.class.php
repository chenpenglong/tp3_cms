<?php
namespace Manager\Controller;
use Think\Controller;
use Think\Page;
class BaseController extends Controller{
  public $config;
  public function _initialize(){
  	$adminTheObj = cookie('adminTheObj');
		$admin = M("admin");
		@$count = $admin->where("username="."'".$adminTheObj['username']."'")->count();
    if( $adminTheObj==null || $count==0 ){
    	cookie('adminTheObj',null);
      $this->redirect('Manager/index/index',array(), 3, '请重新登录...');
    }
    $config = M('config');
    $configdata = $config->where('id=1')->find();
		$this->config = unserialize($configdata['siteconfig']);
    $_SESSION['config'] = $this->config;
    $this->assign("config",$this->config );
  }

  /**
   * 刷新父窗口
   *
   * @param string $anchor='' 锚点
   */
  public static function parentRefurbish($anchor = '') {
    if (! empty ( $anchor )) {
      $js = "parent.location.href=parent.location.href+'$anchor';";
    } else {
      $js = "parent.location.href=parent.location.href;";
    }
    echo $this->_commHtml ( $js );
  }
  /**
   * 基础THML
   *
   * @param string $javaScript
   * @param bool $isjs 是否为JS 默认值：true
   * @return string
   */
  public function _commHtml($javaScript, $isjs = true) {
    $value = '';
    $value .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
    $value .= '<html xmlns="http://www.w3.org/1999/xhtml">';
    $value .= '<head>';
    $value .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
    $value .= '</head>';
    $value .= '<body>';
    if ($isjs) {
      $value .= '<script type="text/javascript">';
      $value .= $javaScript;
      $value .= '</script>';
    } else {
      $value .= $javaScript;
    }
    $value .= '</body>';
    $value .= '</html>';
    return $value;
  }

  /**
   * TODO 基础分页的相同代码封装，使前台的代码更少
   * @param $m 模型，引用传递
   * @param $where 查询条件
   * @param int $pagesize 每页查询条数
   * @return \Think\Page
   */
  public function getpage(&$m,$where=array(),$pagesize=20){
    $m1=clone $m;//浅复制一个模型
    $count = $m->where($where)->count();//连惯操作后会对join等操作进行重置
    $m=$m1;//为保持在为定的连惯操作，浅复制一个模型
    $p=new Page($count,$pagesize);
    $p->lastSuffix=false;
    $p->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录 第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
    $p->setConfig('prev','<em>上一页</em> ');
    $p->setConfig('next','<em>下一页</em> ');
    $p->setConfig('last','<em>末页</em> ');
    $p->setConfig('first','<em>首页</em> ');
    $p->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

    $p->parameter=I('get.');

    $m->limit($p->firstRow,$p->listRows);

    return $p;
  }
  /*
   * 列表统一获取自己的父类sortName
   * */
  public function getFatherSortName( $action,$data ){
    $m = M($action.'sort');
    if( empty($data) ){
      return array();
    }
    foreach ( $data as $k=>$row ){
      $sort = $m->where("id=".$row['sort'])->find();
      $data[$k]['fatherSortName'] = $sort['sortName'];
    }
    return $data;
  }

  /*
   * 获取指定分类的所有子分类ID号
  * $dataList 需要处理的数据
  * */
  function getsortlist( $table, $pid, $z_index=10 )
  {
    $m1 = M( $table);

    $sortList = $m1->where("pid=".$pid)->select();

    if( empty($sortList) ){
      return false;
    }
    foreach ( $sortList as $k=>$v ){
      $sortList[$k]['rootId'] = $this->getRootId($table, $v['id']);
      if( $z_index>1 ){
        $data = self::getsortlist($table,$v['id'],$z_index-1);
        if( !empty($data) ){
          $sortList[$k]['list'] = $data;
        }
      }
    }
    return $sortList;
  }

  function getRootId($table,$sortId){
    $sort = M( $table )->where("id=$sortId")->find();
    if( $sort['pid']==0 ){
      return $sort['id'];
    }else{
      return $this->getRootId($table, $sort['pid']);
    }
  }

  /*
   * 获取类别列表
  */
  function getSortListHtml( $table,$pid, $z_index = 10,$kongGe="") {
    $m1 = M( $table);
    $contro = str_replace("sort","",$table);
    $sortList = $m1->where("pid=".$pid)->order('serialNum desc')->select();
    $html = "";
    if( empty($sortList) ){
      return false;
    }
    if( empty($kongGe) ){
      $kongGe = "&nbsp;&nbsp;&nbsp;&nbsp;";
    }

    $img1 = '<img src="'.__ROOT__.'/Public/Manager/Images/x1.gif" align="absmiddle">';
    $img2 = '<img src="'.__ROOT__.'/Public/Manager/Images/x2.gif" align="absmiddle">';
    $jian = '<img class="ck" rel="shou" onclick="SortShrink(this);" src="'.__ROOT__.'/Public/Manager/Images/jian.gif" align="absmiddle">';
    $jia = '<img src="'.__ROOT__.'/Public/Manager/Images/jia.gif" align="absmiddle">';

    foreach( $sortList as $k=>$v ){

      $rootId = $this->getRootId($table, $v['id']);

      $html .= "<tr>";
      $html .= "<td data-rootId=".$rootId." data-id=".$v['id']." data-pid=".$v['pid'].">".$kongGe.$img2.$jian.$v['sortName']."</td>";
      $html .= "<td class='center'><input class='sortInput' value=".$v['serialNum']." onblur=\"serialNumDesc(this,".$v['id'].",'".U($contro.'/SortSerialNumDesc')."')\" /></td>";
      $html .= "<td class='center'>";

      if( in_array($v['pid'], array()) ){//禁止新增的pid
        $html .= "<a href='".U($contro.'/sortAdd?id='.$v['id'])."'>【新增】</a>";
      }else{
        $html .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
      }

      $html .= "<a href='".U($contro.'/sortEdit?id='.$v['id'])."'>【修改】</a>";
      if( $this->isDel($table,$contro,$v['id']) ){//禁止删除的id
        $html .= "<a href='javascript:show_confirm(\"你确定要删除吗？\",\"".U($contro.'/sortDelete?id='.$v['id'])."\");' >【删除】</a>";
      }else{
        $html .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
      }
      $html .= "</td>";
      $html .= "</tr>";
      if( $z_index>1 ){
        $data = self::getSortListHtml($table,$v['id'],$z_index-1,$kongGe.$img1);
        if( !empty($data) ){
          $html .= $data;
        }
      }
    }

    return $html;
  }

  /*
   * 获取数据列表
  */
  function getDataListHtml( $table,$pid, $z_index = 10,$kongGe="") {
    $m1 = M( $table);
    $contro = str_replace("sort","",$table);
    $sortList = $m1->where("pid=".$pid)->order('serialNum desc')->select();
    $html = "";
    if( empty($sortList) ){
      return false;
    }
    if( empty($kongGe) ){
      $kongGe = "&nbsp;&nbsp;&nbsp;&nbsp;";
    }

    $img1 = '<img src="'.__ROOT__.'/Public/Manager/Images/x1.gif" align="absmiddle">';
    $img2 = '<img src="'.__ROOT__.'/Public/Manager/Images/x2.gif" align="absmiddle">';
    $jian = '<img class="ck" rel="shou" onclick="SortShrink(this);" src="'.__ROOT__.'/Public/Manager/Images/jian.gif" align="absmiddle">';
    $jia = '<img src="'.__ROOT__.'/Public/Manager/Images/jia.gif" align="absmiddle">';

    foreach( $sortList as $k=>$v ){

      $rootId = $this->getRootId($table, $v['id']);

      $sonsortlist = $m1->where("pid=".$v['id'])->order('serialNum desc')->select();

      $html .= "<tr>";
      $html .= "<td data-rootId=".$rootId." data-id=".$v['id']." data-pid=".$v['pid'].">".$kongGe.$img2.$jian.$v['sortName']."</td>";
      $html .= "<td class='center'><input class='sortInput' value=".$v['serialNum']." onblur=\"serialNumDesc(this,".$v['id'].",'".U($contro.'/SortSerialNumDesc')."')\" /></td>";
      $html .= "<td class='center'>";

      if( !in_array($v['pid'], array()) && empty($sonsortlist)  ){//禁止新增的pid
        $html .= "<a href='".U($contro.'/lists?id='.$v['id'])."'>【查看】</a>";
      }else{
        $html .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
      }

      $html .= "</td>";
      $html .= "</tr>";
      if( $z_index>1 ){
        $data = self::getDataListHtml($table,$v['id'],$z_index-1,$kongGe.$img1);
        if( !empty($data) ){
          $html .= $data;
        }
      }
    }

    return $html;
  }

  public function isDel( $table,$contro,$id ){
    $m1 = M( $table );
    $m2 = M( $contro );

    $newslist = $m2->where("sort=".$id)->select();
    $sortlist = $m1->where("pid=".$id)->select();
    if( empty($newslist) && empty($sortlist) ){
      return true;
    }else{
      return false;
    }
  }
  public function emailSend( $email,$number,$content ){
    $smtpserver = "smtp.163.com"; //SMTP服务器
    $smtpserverport = 25; //SMTP服务器端口
    $smtpusermail = "15892671690@163.com"; //SMTP服务器的用户邮箱
    $smtpuser = "15892671690@163.com"; //SMTP服务器的用户帐号
    $smtppass = "xiaochen2016"; //SMTP服务器的用户密码
    $smtp = new \Smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass); //这里面的一个true是表示使用身份验证,否则不使用身份验证.
    $emailtype = "HTML"; //信件类型，文本:text；网页：HTML
    $smtpemailto = $email;
    $smtpemailfrom = $smtpusermail;
    $emailsubject = "投稿通知";

    $emailbody = htmlspecialchars_decode($content);
    $rs = $smtp->sendmail($smtpemailto, $smtpemailfrom, $emailsubject, $emailbody, $emailtype);
    if ($rs == 1) {
      $res['status'] = 1;
      $res['msg'] = "编号 ".$number.":".'邮件发送成功!';
    } else {
      $res['status'] = 2;
      $res['msg'] = "编号 ".$number.':'.'邮件发送失败!';
    }

    return $res;
  }

  public function emailSend2( $to,$content ){
    header("content-type:text/html;charset=utf-8");
    ini_set("magic_quotes_runtime",0);
    require 'phpmailer/class.phpmailer.php';

    $mail = new \PHPMailer(true);
    $mail->IsSMTP();
    $mail->CharSet='UTF-8'; //设置邮件的字符编码，这很重要，不然中文乱码
    $mail->SMTPAuth = true; //开启认证
    $mail->Port = 25;
    $mail->Host = "smtp.163.com";
    $mail->Username = "15892671690@163.com";
    $mail->Password = "xiaochen2016";
    //$mail->IsSendmail(); //如果没有sendmail组件就注释掉，否则出现“Could not execute: /var/qmail/bin/sendmail ”的错误提示
    $mail->AddReplyTo("15892671690@163.com","亲");//回复地址
    $mail->From = "15892671690@163.com";
    $mail->FromName = "微波学会";
    $mail->AddAddress($to);
    $mail->Subject = "投稿通知";
    $mail->Body = htmlspecialchars_decode($content);
    $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; //当邮件不支持html时备用显示，可以省略
    $mail->WordWrap = 80; // 设置每行字符串的长度
    //$mail->AddAttachment("f:/test.png"); //可以添加附件
    $mail->IsHTML(true);

    //发送
    if(!$mail->Send()) {
      $res = "邮件发送失败：".$mail->ErrorInfo;
    } else {
      $res = '邮件已发送';
    }
    return $res.'<br/>';
  }

  public function emailHtml(){
    $this->display();
  }

}