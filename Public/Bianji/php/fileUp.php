<?php
    /**
     * Created by JetBrains PhpStorm.
     * User: taoqili
     * Date: 12-7-26
     * Time: 上午10:32
     */
	require_once '../../Config.php';
	session_id($_REQUEST['PHPSESSID']);

    header("Content-Type: text/html; charset=utf-8");
    error_reporting( E_ERROR | E_WARNING );
    include "Uploader.class.php";
    
    $configObj=BLL_WebSet::getOne(1,'editorBase,editorLinkExt,editorMaxSize');
    $tempExt=explode("|", $configObj['editorLinkExt']);
    for($i=0;$i<count($tempExt);$i++){
    	$tempExt[$i]='.'.$tempExt[$i];
    }
    
    //上传配置
    $config = array(
        "savePath" => "../../Upload/" , //保存路径
        "allowFiles" => $tempExt , //文件允许格式
        "maxSize" => intval($configObj['editorMaxSize'])*1024 //文件大小限制，单位KB
    );
    //生成上传实例对象并完成上传
    $up = new Uploader( "upfile" , $config );

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

    /**
     * 向浏览器返回数据json数据
     * {
     *   'url'      :'a.rar',        //保存后的文件路径
     *   'fileType' :'.rar',         //文件描述，对图片来说在前端会添加到title属性上
     *   'original' :'编辑器.jpg',   //原始文件名
     *   'state'    :'SUCCESS'       //上传状态，成功时返回SUCCESS,其他任何值将原样返回至图片上传框中
     * }
     */
    echo '{"url":"' .str_replace("../../Upload/", $configObj['editorBase']."Upload/", $info["url"]) . '","fileType":"' . $info[ "type" ] . '","original":"' . $info[ "originalName" ] . '","state":"' . $info["state"] . '"}';

