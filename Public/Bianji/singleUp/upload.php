<?php
session_start ();
/*
 * ! upload demo for php @requires xhEditor @author Yanis.Wang<yanis.wang@gmail.com> @site http://xheditor.com/ @licence LGPL(http://www.opensource.org/licenses/lgpl-license.php) @Version: 0.9.6 (build 111027) 注1：本程序仅为演示用，请您务必根据自己需求进行相应修改，或者重开发 注2：本程序特别针对HTML5上传，加入了特殊处理
 */
header ( 'Content-Type: text/html; charset=UTF-8' );
error_reporting(0);
//$configObj = $_SESSION['config'];
//$picPath = "Upload/2019-04-17/1026049069_AUTO.png";
////echo $picPath;die;
//SetWaterMark( $picPath );
//die;

$err = "";
if ( empty($_COOKIE['adminTheObj']) ) {
	$err = "Session丢失，请重新登录!";
} else {
	//$configObj = BLL_WebSet::getOne ( 1, 'editorImgExt,editorLinkExt,editorMaxSize,isWaterMark,waterMarkPath,waterMarkWidth,waterMarkHeight,waterMarkPosition,waterMarkMarginW,waterMarkMarginH' );
	$configObj = $_SESSION['config'];
	$type = $_GET ['type'];
	$upExt = ""; // 上传扩展名
	switch ($type) {
		case "image" :
			$upExt = $configObj ['editorImgExt'];
			break;
		case "file" :
			$upExt = $configObj ['editorLinkExt'];
			break;
		default :
			$err = "允许的类型为：image,file";
			break;
	}
	if ($err == '') {
		$attachDir = '../../../Upload'; // 上传文件保存路径，结尾不要带/
		$msg = "''";
		$tempPath = $attachDir . '/' . date ( "YmdHis" ) . mt_rand ( 10000, 99999 ) . '.tmp';
		$localName = '';
		$_SESSION['filedata'] = @$_FILES ["filedata"];
		$upfile = @$_FILES ["filedata"];
		if (! isset ( $upfile ))
			$err = '文件域的name错误';
		elseif (! empty ( $upfile ['error'] )) {
			switch ($upfile ['error']) {
				case '1' :
					$err = '文件大小超过了php.ini定义的upload_max_filesize值';
					break;
				case '2' :
					$err = '文件大小超过了HTML定义的MAX_FILE_SIZE值';
					break;
				case '3' :
					$err = '文件上传不完全';
					break;
				case '4' :
					$err = '无文件上传';
					break;
				case '6' :
					$err = '缺少临时文件夹';
					break;
				case '7' :
					$err = '写文件失败';
					break;
				case '8' :
					$err = '上传被其它扩展中断';
					break;
				case '999' :
				default :
					$err = '无有效错误代码';
			}
		} elseif (empty ( $upfile ['tmp_name'] ) || $upfile ['tmp_name'] == 'none') {
			$err = '无文件上传';
		} else {
			move_uploaded_file ( $upfile ['tmp_name'], $tempPath );
			$localName = $upfile ['name'];
		}
	}
}

if ($err == '') {
	$fileInfo = pathinfo ( $localName );
	$extension = $fileInfo ['extension'];
	if (preg_match ( '/^(' . $upExt . ')$/i', $extension )) {
		$bytes = filesize ( $tempPath );
		$maxAttachSize = intval ( $configObj ['editorMaxSize'] ) * 1024 * 1024; // 最大上传大小
		if ($bytes > $maxAttachSize) {
			$err = '请不要上传大小超过' . formatBytes ( $maxAttachSize ) . '的文件';
		} else {
			$attachDir = $attachDir . '/' . date ( "Y-m-d" );
			if (! is_dir ( $attachDir )) {
				@mkdir ( $attachDir, 0777 );
				@fclose ( fopen ( $attachDir . '/index.htm', 'w' ) );
			}
			
			// 单独上传
			$newFilename = "";
			if (array_key_exists ( 'isslt', $_POST ) && intval ( $_POST ['isslt'] ) === 1) {
				$newFilename = date ( "His" ) . mt_rand ( 1000, 9999 ) . '_AUTO.' . $extension;
			} else {
				$newFilename = date ( "His" ) . mt_rand ( 1000, 9999 ) . '.' . $extension;
			}
			$targetPath = $attachDir . '/' . $newFilename;
			
			rename ( $tempPath, $targetPath );
			@chmod ( $targetPath, 0755 );
			$targetPath = jsonString ( $targetPath );
			
			$tempurl = str_replace ( '..\/', '', $targetPath );
			$msg = "{'url':'" . $tempurl . "','localname':'" . jsonString ( $localName ) . "','id':'1'}";
			
			if ($type == "image") {
				SetWaterMark ( $attachDir . '/' . $newFilename );
			}
		}
	} else {
		$err = '上传文件扩展名必需为：' . $upExt;
	}
	@unlink ( $tempPath );
}

if (array_key_exists ( 'action', $_GET ) && $_GET ['action'] == "swaraj") {
	$value = '';
	$value .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	$value .= '<html xmlns="http://www.w3.org/1999/xhtml">';
	$value .= '<head>';
	$value .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	$value .= '</head>';
	$value .= '<body>';
	$value .= '<script type="text/javascript">';
	$value .= "var thejson={'err':'" . jsonString ( $err ) . "','msg':" . $msg . "};";
	$value .= "console.log(thejson);";
	$value .= "parent.UpFileOk(thejson);";
	$value .= '</script>';
	$value .= '</body>';
	$value .= '</html>';
	echo $value;
}
function jsonString($str) {
	return preg_replace ( "/([\\\\\/'])/", '\\\$1', $str );
}
function formatBytes($bytes) {
	if ($bytes >= 1073741824) {
		$bytes = round ( $bytes / 1073741824 * 100 ) / 100 . 'GB';
	} elseif ($bytes >= 1048576) {
		$bytes = round ( $bytes / 1048576 * 100 ) / 100 . 'MB';
	} elseif ($bytes >= 1024) {
		$bytes = round ( $bytes / 1024 * 100 ) / 100 . 'KB';
	} else {
		$bytes = $bytes . 'Bytes';
	}
	return $bytes;
}

// 生成水印
function SetWaterMark($picPath) {
	global $configObj;
//	if (intval ( $configObj ['isWaterMark'] ) === 0) {
//		return; // 没有开启水印
//	}
//	if (! file_exists ( "../../" . $configObj ['waterMarkPath'] )) {
//		return; // 水印文件不存在
//	}
	$picPath = str_replace ( '\/', '/', $picPath );
	$BgImgInfo = getimagesize ( $picPath );
//	if (intval ( $BgImgInfo [0] ) < intval ( $configObj ['waterMarkWidth'] ) || intval ( $BgImgInfo [1] ) < intval ( $configObj ['waterMarkHeight'] )) {
//		return; // 没有达到显示水印的宽度获取高度
//	}
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
	
	
	$waterMarkPath = $picPath;
	
	$waterMarkInfo = getimagesize ( $waterMarkPath );
	$waterMarkImgObj = ImageCreateFromPNG ( $waterMarkPath );
	
	$left = 0;
	$top = 0;
	$width = $waterMarkInfo [0];
	$height = $waterMarkInfo [1];
	
//	switch (intval ( $configObj ['waterMarkPosition'] )) {
//		case 1 : // 左上
//			$left = intval ( $configObj ['waterMarkMarginW'] );
//			$top = intval ( $configObj ['waterMarkMarginH'] );
//			break;
//		case 2 : // 左中
//			$left = intval ( $configObj ['waterMarkMarginW'] );
//			$top = (intval ( $BgImgInfo [1] ) - intval ( $height )) / 2 - intval ( $configObj ['waterMarkMarginH'] );
//			break;
//		case 3 : // 左下
//			$left = intval ( $configObj ['waterMarkMarginW'] );
//			$top = intval ( $BgImgInfo [1] ) - intval ( $height ) - intval ( $configObj ['waterMarkMarginH'] ) * 2;
//			break;
//		case 4 : // 中上
//			$left = (intval ( $BgImgInfo [0] ) - intval ( $width )) / 2 - intval ( $configObj ['waterMarkMarginW'] );
//			$top = intval ( $configObj ['waterMarkMarginH'] );
//			break;
//		case 5 : // 中中
//			$left = (intval ( $BgImgInfo [0] ) - intval ( $width )) / 2 - intval ( $configObj ['waterMarkMarginW'] );
//			$top = (intval ( $BgImgInfo [1] ) - intval ( $height )) / 2 - intval ( $configObj ['waterMarkMarginH'] );
//			break;
//		case 6 : // 中下
//			$left = (intval ( $BgImgInfo [0] ) - intval ( $width )) / 2 - intval ( $configObj ['waterMarkMarginW'] );
//			$top = intval ( $BgImgInfo [1] ) - intval ( $height ) - intval ( $configObj ['waterMarkMarginH'] ) * 2;
//			break;
//		case 7 : // 右上
//			$left = intval ( $BgImgInfo [0] ) - intval ( $width ) - intval ( $configObj ['waterMarkMarginW'] ) * 2;
//			$top = intval ( $configObj ['waterMarkMarginH'] );
//			break;
//		case 8 : // 右中
//			$left = intval ( $BgImgInfo [0] ) - intval ( $width ) - intval ( $configObj ['waterMarkMarginW'] ) * 2;
//			$top = (intval ( $BgImgInfo [1] ) - intval ( $height )) / 2 - intval ( $configObj ['waterMarkMarginH'] );
//			break;
//		case 9 : // 右下
//			$left = intval ( $BgImgInfo [0] ) - intval ( $width ) - intval ( $configObj ['waterMarkMarginW'] ) * 2;
//			$top = intval ( $BgImgInfo [1] ) - intval ( $height ) - intval ( $configObj ['waterMarkMarginH'] ) * 2;
//			break;
//	}
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
?>