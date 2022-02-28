<?php
namespace Home\Controller;

use Think\Page;
use Think\Controller;
use Think\Verify;
class BaseController extends Controller{
	public $webSet;
	public function _initialize(){
		$config = M('config');
		$configData = $config->where('id=1')->find();
		$configData['webLogo'] = __ROOT__."/".$configData['webLogo'];
		$this->assign("config",$configData);
		$float = M('float');
		$piaoFuDataList = $float->order('serialNum asc')->select();
		$this->assign("piaoFuDataList",$piaoFuDataList);

    	$link = M('link');
    	$bannerList = $link->where("sort=1")->order("serialNum desc,id desc")->select();
		$this->assign('bannerList',$bannerList);

    $this->assign('version',rand(1000, 9999));

	}
	
	/*
	* 注册发送短信通知
	*/
	public function reg_send_sms($data){
		vendor("sms.sms");
		
		$phone = $this->config['warn_phone'];
		$parameter = json_encode(array(
			"name"=>$data['a2'],
			"phone"=>$data['a1'],
			"company"=>$data['a3'],
			"needs"=>$data['a4'],
		),JSON_UNESCAPED_UNICODE);
		$tempcode = "SMS_190274105";
		$autograph = "华盎科技";
		$sms = new \Sms($phone,$tempcode,$autograph,$parameter);
		$response = $sms->sendSms();
	}

 	 public function scerweima($url=''){
	    /*生成二维码*/
	    vendor("phpqrcode.phpqrcode");
	    $data =$url;
	    $level = 'L';// 纠错级别：L、M、Q、H
	    $size =4;// 点的大小：1到10,用于手机端4就可以了
	    $QRcode = new \QRcode();
	    ob_start();
	    $QRcode->png($data,false,$level,$size,2);
	    $imageString = base64_encode(ob_get_contents());
	    ob_end_clean();
	    return "data:image/jpg;base64,".$imageString;
  	}

      /*生成带logo二维码*/
	public function creatQrcode( $url,$id ){
		vendor("phpqrcode.phpqrcode");
	    //设置二维码的容错级别
	    /*
	     * 容错级别：容错级别百分比越高，就越容易识别，容错级别：
	     * 按照效果排序依次是  H -> Q -> M -> L
	     */
	    $errorCorrectionLevel = 'H';
	    //设置生成二维码图片的大小
	    $matrixPointSize = 7;
	    //设置生成二维码的图片名称
	    $return_img_url = __ROOT__.'/Public/Home/Images/qrlogo'.$id.'.png';
	    $QRlogo = $filename = substr(dirname(__FILE__),0,-21).'/Public/Home/Images/qrlogo'.$id.'.png';
		 $QRcode = new \QRcode();
	    $QRcode->png($url, $filename, $errorCorrectionLevel, $matrixPointSize, 1);
	    $logo = substr(dirname(__FILE__),0,-21).'/Public/Home/Images/logo.png';
		//echo $logo;die;
	    $QR = $filename;
	    if(file_exists($logo)){
	        // 函数：imagecreatefromstring()：创建一块画布，并从字符串中的图像流新建一副图像
	        $QR = imagecreatefromstring(file_get_contents($QR));        //目标图象连接资源。
	        $logo = imagecreatefromstring(file_get_contents($logo));     //源图象连接资源。
	        // php函数：imagesx(resource image):获取图像宽度
	        // PHP函数：imagesy(resource image):获取图像高度
	        $QR_width = imagesx($QR);
	        $QR_height = imagesy($QR);
	        $logo_width = imagesx($logo);//logo图片宽度
	        $logo_height = imagesy($logo);//logo图片高度

	        $logo_qr_width = $QR_width / 5;   //组合之后logo的宽度(占二维码的1/5)
	        $scale = $logo_width/$logo_qr_width;  //logo的宽度缩放比(本身宽度/组合后的宽度)
	        $logo_qr_height = $logo_height/$scale; //组合之后logo的高度
	        $from_width = ($QR_width - $logo_qr_width) / 2;  //组合之后logo左上角所在坐标点

	        //重新组合图片，并调整大小
	        /**
	         * 函数 imagecopyresampled():将一幅图像中的一块正方形区域拷贝到另一个图像中，平滑地插入像素值，因此，尤其是，减小了图像的大小而仍然保持了极大的清晰度。参数详解
	         *
	         * bool imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
	         *
	         * dst_image 目标图象连接资源。
	         * src_image 源图象连接资源。
	         * dst_x 目标 X 坐标点。
	         * dst_y 目标 Y 坐标点。
	         * src_x 源的 X 坐标点。
	         * src_y 源的 Y 坐标点。
	         * dst_w 目标宽度。
	         * dst_h 目标高度。
	         * src_w 源图象的宽度。
	         * src_h 源图象的高度。
	         */
	        imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,$logo_qr_height, $logo_width, $logo_height);
	        // PHP函数:imagepng ( resource image [, string filename] ):以 PNG 格式将图像输出到浏览器或文件
	        imagepng($QR,$QRlogo);
//	        echo '<image src="'.$QRlogo.'"/>';
			return $return_img_url;
	    }else{
	    	echo "生成失败";
			die;
	    }
	}

  public function read_all($dir){
      if(!is_dir($dir)) return false;

      $handle = opendir($dir);

      if($handle){
          while(($fl = readdir($handle)) !== false){
              $temp = iconv('GBK','utf-8',$dir.DIRECTORY_SEPARATOR.$fl);//转换成utf-8格式
              //如果不加  $fl!='.' && $fl != '..'  则会造成把$dir的父级目录也读取出来
              if(is_dir($temp) && $fl!='.' && $fl != '..'){
                  echo '目录：'.$temp.'<br>';
                  $this->read_all($temp);
              }else{
                  if($fl!='.' && $fl != '..'){
            if( in_array(substr($temp, strpos($temp, ".")+1), array("png","jpg")) ){
                        echo '文件：'.$temp.'<br>';
            }
                  }
              }
          }
      }
  }

	/*二维数组字符串截取*/

	function noHtmlCutStr($newsList,$length=30,$str='...'){
		if(empty($newsList)){
			return array();
		}
		for($i=0;$i<count($newsList);$i++){
			$newsList[$i]['content']=$this->noHtml($newsList[$i]['content']);
			$newsList[$i]['content']=$this->CutStr($newsList[$i]['content'],$length,$str);
		}
		return $newsList;

	}
	/*二维数组标题截取*/

	function titCutStr($newsList,$length=30,$str='...'){
		if(empty($newsList)){
			return array();
		}
		for($i=0;$i<count($newsList);$i++){
			$newsList[$i]['title']=$this->noHtml($newsList[$i]['title']);
			$newsList[$i]['title']=$this->CutStr($newsList[$i]['title'],$length,$str);
		}
		return $newsList;

	}
	/*地址替换*/

	function AttrUrl($newsList,$str='picture'){
		if(empty($newsList)){
			return array();
		}
		for($i=0;$i<count($newsList);$i++){
			if( !empty($newsList[$i][$str]) ){
				$newsList[$i][$str] = __ROOT__.'/'.$newsList[$i][$str];
			}
		}
		return $newsList;

	}
	/**
	 * 去除HTML JS CSS
	 *
	 * @param string $string 需要处理的字符串
	 * @return string 纯文本字符串
	 */
	public static function noHtml($string) {
		if (empty ( $string )) {
			return "";
		}
		$search = array ("'<script[^>]*?>.*?</script>'si","'<style[^>]*?>.*?</style>'si","'<[/!]*?[^<>]*?>'si","'<!--[/!]*?[^<>]*?>'si" );
		$replace = array ("","","","" );
		$string = preg_replace ( $search, $replace, $string );
		return str_replace ( array ("　"," ","\r","\n","&nbsp;" ), "", $string );
	}
	/**
	 * 字符串截取
	 *
	 * @param string $sourcestr 是要处理的字符串
	 * @param int $cutlength 为截取的长度(即字数)
	 */
	public static function CutStr($sourcestr, $cutlength) {
		$returnstr = "";
		$i = 0;
		$n = 0;
		$str_length = strlen ( $sourcestr );
		// 字符串的字节数
		while ( ($n < $cutlength) and ($i <= $str_length) ) {
			$temp_str = substr ( $sourcestr, $i, 1 );
			$ascnum = Ord ( $temp_str );
			// 得到字符串中第$i位字符的ascii码
			// 如果ASCII位高与224，
			if ($ascnum >= 224) {
				$returnstr .= substr ( $sourcestr, $i, 3 );
				// 根据UTF-8编码规范，将3个连续的字符计为单个字符
				$i = $i + 3;
				// 实际Byte计为3
				$n ++; // 字串长度计1
				// 如果ASCII位高与192，
			} elseif ($ascnum >= 192) {
				$returnstr = $returnstr . substr ( $sourcestr, $i, 2 );
				// 根据UTF-8编码规范，将2个连续的字符计为单个字符
				$i = $i + 2;
				// 实际Byte计为2
				$n ++; // 字串长度计1
				// 如果是大写字母，
			} elseif ($ascnum >= 65 && $ascnum <= 90) {
				$returnstr = $returnstr . substr ( $sourcestr, $i, 1 );
				$i = $i + 1;
				// 实际的Byte数仍计1个
				$n ++; // 但考虑整体美观，大写字母计成一个高位字符
			} else { // 其他情况下，包括小写字母和半角标点符号，
				$returnstr = $returnstr . substr ( $sourcestr, $i, 1 );
				$i = $i + 1;
				// 实际的Byte数计1个
				$n = $n + 0.5; // 小写字母和半角标点等与半个高位字符宽…
			}
		}
		if ($str_length > $i) {
			$returnstr .= "...";

			// 超过长度时在尾处加上省略号
		}
		return $returnstr;
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
		//$p->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录 第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
		$p->setConfig('prev','&nbsp;');
		$p->setConfig('next','&nbsp;');
		$p->setConfig('last','<em>末页</em> ');
		$p->setConfig('first','<em>首页</em> ');
		$p->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');

		$p->parameter=$where;

		$m->limit($p->firstRow,$p->listRows);

		return $p;
	}

	public function getVerify (){
    	$config =    array(
    			'fontSize'    =>    14,    // 验证码字体大小
    			'length'      =>    4,     // 验证码位数
    			'useNoise'    =>    false, // 关闭验证码杂点
    	);
    	$Verify = new Verify($config);
    	// 设置验证码字符为纯数字
		$Verify->codeSet = '0123456789';
		$Verify->entry();
    }

    public function check_Verify($code,$id = ''){
    	$Verify = new Verify();
    	return $Verify->check($code, $id);
    }

    public function prevNext( $id ){
    	$news = M('news');
    	$data = $news->field("id,sort,serialNum")->find($id);
    	$prevDada = $news->where("serialNum>".$data['serialNum']." and sort=".$data['sort'])->order('serialNum asc')->limit(1)->field("id,title")->find();//上一条数据信息
    	$newsDada = $news->where("serialNum<".$data['serialNum']." and sort=".$data['sort'])->order('serialNum desc')->limit(1)->field("id,title")->find();//下一条数据信息
    	$str = "<div id='prevNext' class='container'>";
    	if( !empty($prevDada) ){
	    	$str .= "<div class='prev'><a href='".U('news/show?id='.$prevDada['id'])."'>上一篇：".$prevDada['title']."</a></div>";
    	}
    	if( !empty($newsDada) ){
	    	$str .= "<div class='next'><a href='".U('news/show?id='.$newsDada['id'])."'>下一篇：".$newsDada['title']."</a></div>";
    	}
    	//$str .= "<a class='returnList' href='".U('news/kepianList?id='.$data['sort'])."'>返回列表</a>";
    	$str .= "</div>";
    	return $str;
    }

    public function prevNext2( $id ){
    	$news = M('news');
    	$data = $news->field("id,sort,serialNum")->find($id);
    	$prevDada = $news->where("serialNum<".$data['serialNum']." and sort=".$data['sort'])->order('serialNum desc')->limit(1)->field("id,title")->find();//上一条数据信息
    	$newsDada = $news->where("serialNum>".$data['serialNum']." and sort=".$data['sort'])->order('serialNum asc')->limit(1)->field("id,title")->find();//下一条数据信息
    	$str = "<div id='prevNext' class='container'>";
    	if( !empty($prevDada) ){
	    	$str .= "<a class='prev' href='".U('dingzhi/ready?id='.$prevDada['id'])."'>上一套</a>";
    	}
    	if( !empty($newsDada) ){
	    	$str .= "<a class='next' href='".U('dingzhi/ready?id='.$newsDada['id'])."'>下一套</a>";
    	}
    	//$str .= "<a class='returnList' href='".U('news/kepianList?id='.$data['sort'])."'>返回列表</a>";
    	$str .= "</div>";
    	return $str;
    }

	public function getsortlist( $table, $pid, $z_index=10 )
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
	public function getRootId($table,$sortId){
		$sort = M( $table )->where("id=$sortId")->find();
		if( $sort['pid']==0 ){
			return $sort['id'];
		}else{
			return $this->getRootId($table, $sort['pid']);
		}
	}
}
