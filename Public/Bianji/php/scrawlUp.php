<?php
	require_once '../../Config.php';

	header("Content-Type:text/html;charset=utf-8");
    error_reporting( E_ERROR | E_WARNING );
    include "Uploader.class.php";
    
    $configObj=BLL_WebSet::getOne(1,'editorBase,editorImgExt,editorMaxSize,isWaterMark,waterMarkPath,waterMarkWidth,waterMarkHeight,waterMarkPosition,waterMarkMarginW,waterMarkMarginH');
    $tempExt=explode("|", $configObj['editorImgExt']);
    for($i=0;$i<count($tempExt);$i++){
    	$tempExt[$i]='.'.$tempExt[$i];
    }
    
    //上传配置
    $config = array(
        "savePath" => "../../Upload/",             //存储文件夹
        "maxSize" => intval($configObj['editorMaxSize'])*1024,                   //允许的文件最大尺寸，单位KB
        "allowFiles" => $tempExt  //允许的文件格式
    );
    
    //临时文件目录
    $tmpPath = "../../Upload/tmp/";

    //获取当前上传的类型
    $action = htmlspecialchars( $_GET[ "action" ] );
    if ( $action == "tmpImg" ) { // 背景上传
        //背景保存在临时目录中
        $config[ "savePath" ] = $tmpPath;
        $up = new Uploader( "upfile" , $config );
        $info = $up->getFileInfo();
        /**
         * 返回数据，调用父页面的ue_callback回调
         */
        echo "<script>parent.ue_callback('" . str_replace('../../Upload/', $configObj['editorBase']."Upload/", $info[ "url" ]) . "','" . $info[ "state" ] . "')</script>";
    } else {
        //涂鸦上传，上传方式采用了base64编码模式，所以第三个参数设置为true
        $up = new Uploader( "content" , $config , true );
        //上传成功后删除临时目录
        if(file_exists($tmpPath)){
            delDir($tmpPath);
        }
        $info = $up->getFileInfo();
        SetWaterMark($info[ "url" ]);
        
        echo "{'url':'" . str_replace('../../Upload/', $configObj['editorBase']."Upload/", $info[ "url" ]) . "',state:'" . $info[ "state" ] . "'}";
    }
    
    /**
     * 删除整个目录
     * @param $dir
     * @return bool
     */
    function delDir( $dir )
    {
        //先删除目录下的所有文件：
        $dh = opendir( $dir );
        while ( $file = readdir( $dh ) ) {
            if ( $file != "." && $file != ".." ) {
                $fullpath = $dir . "/" . $file;
                if ( !is_dir( $fullpath ) ) {
                    unlink( $fullpath );
                } else {
                    delDir( $fullpath );
                }
            }
        }
        closedir( $dh );
        //删除当前文件夹：
        return rmdir( $dir );
    }

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

