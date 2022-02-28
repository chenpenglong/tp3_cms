<?php
    /**
     * Created by JetBrains PhpStorm.
     * User: taoqili
     * Date: 12-7-18
     * Time: 上午10:42
     */
	require_once '../../Config.php';
	
	header("Content-Type: text/html; charset=utf-8");
    error_reporting(E_ERROR | E_WARNING);
    include "Uploader.class.php";
    
    //上传图片框中的描述表单名称，
    $title = htmlspecialchars($_POST['pictitle'], ENT_QUOTES);
    $path = htmlspecialchars($_POST['dir'], ENT_QUOTES);

    $configObj=BLL_WebSet::getOne(1,'editorBase,editorImgExt,editorMaxSize,isWaterMark,waterMarkPath,waterMarkWidth,waterMarkHeight,waterMarkPosition,waterMarkMarginW,waterMarkMarginH');
    $tempExt=explode("|", $configObj['editorImgExt']);
    for($i=0;$i<count($tempExt);$i++){
    	$tempExt[$i]='.'.$tempExt[$i];
    }
    
    //上传配置
    $config = array(
        "savePath" => "../../Upload/",
        "maxSize" => intval($configObj['editorMaxSize'])*1024, //单位KB
        "allowFiles" =>  $tempExt
    );

    //生成上传实例对象并完成上传
    $up = new Uploader("upfile", $config);

    /**
     * 得到上传文件所对应的各个参数,数组结构
     * array(
     *     "originalName" => "",   //原始文件名
     *     "name" => "",           //新文件名
     *     "url" => "",            //返回的地址
     *     "size" => "",           //文件大小
     *     "type" => "" ,          //文件类型
     *     "state" => ""           //上传状态，上传成功时必须返回"SUCCESS"
     * )
     */
    $info = $up->getFileInfo();

    
    //加水印
    if($info["state"]=="SUCCESS"){
    	SetWaterMark($info["url"]);
    }
    
    /**
     * 向浏览器返回数据json数据
     * {
     *   'url'      :'a.jpg',   //保存后的文件路径
     *   'title'    :'hello',   //文件描述，对图片来说在前端会添加到title属性上
     *   'original' :'b.jpg',   //原始文件名
     *   'state'    :'SUCCESS'  //上传状态，成功时返回SUCCESS,其他任何值将原样返回至图片上传框中
     * }
     */
    
    echo "{'url':'" . str_replace("../../Upload/", $configObj['editorBase']."Upload/", $info["url"]) . "','title':'" . $title . "','original':'" . $info["originalName"] . "','state':'" . $info["state"] . "'}";


    // 生成水印
    function SetWaterMark($picPath) {
    	global $configObj;
    	if (intval ( $configObj ['isWaterMark'] ) === 0) {
    		return; // 没有开启水印
    	}
    	if (! file_exists ( "../../" . $configObj ['waterMarkPath'] )) {
    		return; // 水印文件不存在
    	}
    	$BgImgInfo = getimagesize ( $picPath );
    	if (intval ( $BgImgInfo [0] ) < intval ( $configObj ['waterMarkWidth'] ) || intval ( $BgImgInfo [1] ) < intval ( $configObj ['waterMarkHeight'] )) {
    		return; // 没有达到显示水印的宽度获取高度
    	}
    	switch ($BgImgInfo [2]) {
    		case 1 : // gif
    			$BgImgObj = ImageCreateFromGIF ( $picPath );
    			break;
    		case 2 : // jpg
    			$BgImgObj = ImageCreateFromJpeg ( $picPath );
    			break;
    		case 3 : // png
    			$BgImgObj = ImageCreateFromPNG ( $picPath );
    			break;
    		default :
    			return; // 不支持此格式
    			break;
    	}
    
    	$waterMarkInfo = getimagesize ( "../../" . $configObj ['waterMarkPath'] );
    	$waterMarkImgObj = ImageCreateFromPNG ( "../../" . $configObj ['waterMarkPath'] );
    
    	$left = 0;
    	$top = 0;
    	$width = $waterMarkInfo [0];
    	$height = $waterMarkInfo [1];
    
    	switch (intval ( $configObj ['waterMarkPosition'] )) {
    		case 1 : // 左上
    			$left = intval ( $configObj ['waterMarkMarginW'] );
    			$top = intval ( $configObj ['waterMarkMarginH'] );
    			break;
    		case 2 : // 左中
    			$left = intval ( $configObj ['waterMarkMarginW'] );
    			$top = (intval ( $BgImgInfo [1] ) - intval ( $height )) / 2 - intval ( $configObj ['waterMarkMarginH'] );
    			break;
    		case 3 : // 左下
    			$left = intval ( $configObj ['waterMarkMarginW'] );
    			$top = intval ( $BgImgInfo [1] ) - intval ( $height ) - intval ( $configObj ['waterMarkMarginH'] ) * 2;
    			break;
    		case 4 : // 中上
    			$left = (intval ( $BgImgInfo [0] ) - intval ( $width )) / 2 - intval ( $configObj ['waterMarkMarginW'] );
    			$top = intval ( $configObj ['waterMarkMarginH'] );
    			break;
    		case 5 : // 中中
    			$left = (intval ( $BgImgInfo [0] ) - intval ( $width )) / 2 - intval ( $configObj ['waterMarkMarginW'] );
    			$top = (intval ( $BgImgInfo [1] ) - intval ( $height )) / 2 - intval ( $configObj ['waterMarkMarginH'] );
    			break;
    		case 6 : // 中下
    			$left = (intval ( $BgImgInfo [0] ) - intval ( $width )) / 2 - intval ( $configObj ['waterMarkMarginW'] );
    			$top = intval ( $BgImgInfo [1] ) - intval ( $height ) - intval ( $configObj ['waterMarkMarginH'] ) * 2;
    			break;
    		case 7 : // 右上
    			$left = intval ( $BgImgInfo [0] ) - intval ( $width ) - intval ( $configObj ['waterMarkMarginW'] ) * 2;
    			$top = intval ( $configObj ['waterMarkMarginH'] );
    			break;
    		case 8 : // 右中
    			$left = intval ( $BgImgInfo [0] ) - intval ( $width ) - intval ( $configObj ['waterMarkMarginW'] ) * 2;
    			$top = (intval ( $BgImgInfo [1] ) - intval ( $height )) / 2 - intval ( $configObj ['waterMarkMarginH'] );
    			break;
    		case 9 : // 右下
    			$left = intval ( $BgImgInfo [0] ) - intval ( $width ) - intval ( $configObj ['waterMarkMarginW'] ) * 2;
    			$top = intval ( $BgImgInfo [1] ) - intval ( $height ) - intval ( $configObj ['waterMarkMarginH'] ) * 2;
    			break;
    	}
    	imagecopy ( $BgImgObj, $waterMarkImgObj, $left, $top, 0, 0, $width, $height );
    	@unlink ( $picPath );
    	switch ($BgImgInfo [2]) {
    		case 1 : // gif
    			imagegif ( $BgImgObj, $picPath );
    			break;
    		case 2 : // jpg
    			imagejpeg ( $BgImgObj, $picPath );
    			break;
    		case 3 : // png
    			imagepng ( $BgImgObj, $picPath );
    			break;
    	}
    
    	imagedestroy ( $waterMarkImgObj );
    	imagedestroy ( $BgImgObj );
    }