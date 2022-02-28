<?php
    /**
     * Created by JetBrains PhpStorm.
     * User: taoqili
     * Date: 11-12-28
     * Time: 上午9:54
     * To change this template use File | Settings | File Templates.
     */
	require_once '../../Config.php';

    header("Content-Type: text/html; charset=utf-8");
    error_reporting(E_ERROR|E_WARNING);

    $configObj=BLL_WebSet::getOne(1,'editorBase,editorImgExt,editorMaxSize,isWaterMark,waterMarkPath,waterMarkWidth,waterMarkHeight,waterMarkPosition,waterMarkMarginW,waterMarkMarginH');
    $tempExt=explode("|", $configObj['editorImgExt']);
    for($i=0;$i<count($tempExt);$i++){
    	$tempExt[$i]='.'.$tempExt[$i];
    }
    
    //远程抓取图片配置
    $config = array(
        "savePath" => "../../Upload/".date("Y-m-d").'/' ,            //保存路径
        "allowFiles" => $tempExt , //文件允许格式
        "maxSize" => intval($configObj['editorMaxSize'])*1024                    //文件大小限制，单位KB
    );
    $uri = htmlspecialchars( $_POST[ 'upfile' ] );
    $uri = str_replace( "&amp;" , "&" , $uri );
    
    //判断后台是否登录--王泽彬添加
    if (intval ( BLL_Admin::isLogin () ) === 0) {
    	$tmpNames = explode( "ue_separate_ue" , $uri );
    	for($i=0;$i<count($tmpNames);$i++){
    		$tmpNames[$i]='error';
    	}
    	echo "{'url':'".implode( "ue_separate_ue" , $tmpNames )."','tip':'请先登录后台！','srcUrl':'" . $uri . "'}";
    	
    }else{
    	//原始代码
    	getRemoteImage( $uri,$config );
    }
    
    /**
     * 远程抓取
     * @param $uri
     * @param $config
     */
    function getRemoteImage( $uri,$config)
    {
    	global $configObj;
        //忽略抓取时间限制
        set_time_limit( 0 );
        //ue_separate_ue  ue用于传递数据分割符号
        $imgUrls = explode( "ue_separate_ue" , $uri );
        $tmpNames = array();
        foreach ( $imgUrls as $imgUrl ) {
            //http开头验证
            if(strpos($imgUrl,"http")!==0){
                array_push( $tmpNames , "error" );
                continue;
            }
            //获取请求头
            $heads = get_headers( $imgUrl );
            //死链检测
            if ( !( stristr( $heads[ 0 ] , "200" ) && stristr( $heads[ 0 ] , "OK" ) ) ) {
                array_push( $tmpNames , "error" );
                continue;
            }

            //格式验证(扩展名验证和Content-Type验证)
            $fileType = strtolower( strrchr( $imgUrl , '.' ) );
            if ( !in_array( $fileType , $config[ 'allowFiles' ] ) || stristr( $heads[ 'Content-Type' ] , "image" ) ) {
                array_push( $tmpNames , "error" );
                continue;
            }

            //打开输出缓冲区并获取远程图片
            ob_start();
            $context = stream_context_create(
                array (
                    'http' => array (
                        'follow_location' => false // don't follow redirects
                    )
                )
            );
            //请确保php.ini中的fopen wrappers已经激活
            readfile( $imgUrl,false,$context);
            $img = ob_get_contents();
            ob_end_clean();

            //大小验证
            $uriSize = strlen( $img ); //得到图片大小
            $allowSize = 1024 * $config[ 'maxSize' ];
            if ( $uriSize > $allowSize ) {
                array_push( $tmpNames , "error" );
                continue;
            }
            //创建保存位置
            $savePath = $config[ 'savePath' ];
            if ( !file_exists( $savePath ) ) {
                mkdir( "$savePath" , 0777 );
            }
            //写入文件
            $tmpName = $savePath . rand( 1 , 10000 ) . time() . strrchr( $imgUrl , '.' );
            try {
                $fp2 = @fopen( $tmpName , "a" );
                fwrite( $fp2 , $img );
                fclose( $fp2 );
                SetWaterMark($tmpName);
                array_push( $tmpNames ,str_replace('../../Upload/', $configObj['editorBase']."Upload/", $tmpName)   );
            } catch ( Exception $e ) {
                array_push( $tmpNames , "error" );
            }
        }
        /**
         * 返回数据格式
         * {
         *   'url'   : '新地址一ue_separate_ue新地址二ue_separate_ue新地址三',
         *   'srcUrl': '原始地址一ue_separate_ue原始地址二ue_separate_ue原始地址三'，
         *   'tip'   : '状态提示'
         * }
         */
        echo "{'url':'" . implode( "ue_separate_ue" , $tmpNames ) . "','tip':'远程图片抓取成功！','srcUrl':'" . $uri . "'}";
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