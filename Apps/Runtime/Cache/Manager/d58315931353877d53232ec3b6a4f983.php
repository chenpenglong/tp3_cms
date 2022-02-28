<?php if (!defined('THINK_PATH')) exit(); ob_start (); $valInt = (false == empty ( $_POST ['pInt'] )) ? $_POST ['pInt'] : "未测试"; $valFloat = (false == empty ( $_POST ['pFloat'] )) ? $_POST ['pFloat'] : "未测试"; $valIo = (false == empty ( $_POST ['pIo'] )) ? $_POST ['pIo'] : "未测试"; $mysqlReShow = "none"; $mailReShow = "none"; $funReShow = "none"; $opReShow = "none"; $sysReShow = "none"; define ( "YES", "<span class='resYes'>YES</span>" ); define ( "NO", "<span class='resNo'>NO</span>" ); define ( "ICON", "<span class='icon'>2</span>&nbsp;" ); $phpSelf = null; if (array_key_exists ( 'PHP_SELF', $_SERVER )) { $phpSelf = $_SERVER ['PHP_SELF']; } else { $phpSelf = $_SERVER ['SCRIPT_NAME']; } define ( "PHPSELF", preg_replace ( '/(.{0,}?\/+)/', "", $phpSelf ) ); switch (PHP_OS) { case "Linux" : $sysReShow = (false !== ($sysInfo = sys_linux ())) ? "show" : "none"; break; case "FreeBSD" : $sysReShow = (false !== ($sysInfo = sys_freebsd ())) ? "show" : "none"; break; default : break; } if(array_key_exists('action', $_GET) && $_GET['action']=="showphpinfo"){ echo phpinfo(); die(); } ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理系统</title>
<link rel="stylesheet" type="text/css" href="/Public/Manager/Css/RightFrm.css" />
<!--[if lt IE 9]>
<script type="text/javascript" src="__STATIC__/jquery-1.10.2.min.js"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type="text/javascript" src="/Public/Manager/JScript//jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="/Public/Manager/JScript//Comm.js"></script>
<!--<![endif]-->

<style type="text/css">
.jump { float:right; width:15px; padding-left:5px; line-height:11px; }	
.resYes { font-size: 12px;  color: #33CC00; } 
.resNo { font-size: 12px;  color: #FF0000; }
</style>
</head>
<body>
<table  border=0 cellpadding=0 cellspacing=1  class="listTable">
  <tr>
    <th align=left colspan="4">&nbsp;服务器特征</th>
  </tr>
  <tr>
    <td width="20%" align=left>&nbsp;服务器时间</td>
    <td width="30%"><?php echo '北京时间：'.gmdate ( "Y年n月j日 H:i:s", time () + 8 * 3600 ); ?></td>
    <td width="20%"  align=left>&nbsp;服务器域名/IP地址</td>
    <td width="30%" ><?php echo $_SERVER ['SERVER_NAME'].'('.@gethostbyname ( $_SERVER ['SERVER_NAME'] ).')'; ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;服务器操作系统</td>
    <td><?php $os = explode ( " ", php_uname () );echo $os [0].'&nbsp;内核版本：'.$os [2]; ?></td>
    <td align=left>&nbsp;主机名称</td>
    <td><?php echo $os [1]; ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;服务器解译引擎</td>
    <td><?php echo $_SERVER ['SERVER_SOFTWARE']; ?></td>
    <td align=left>&nbsp;Web服务端口</td>
    <td><?php echo $_SERVER ['SERVER_PORT']; ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;服务器管理员</td>
    <td><?php echo array_key_exists ( 'SERVER_ADMIN', $_SERVER )?$_SERVER ['SERVER_ADMIN']:''; ?></td>
    <td align=left></td>
    <td></td>
  </tr>
</table>
<?php $theWfList=getXtwf(); if(count($theWfList)>0){ ?>
<table  border=0 cellpadding=0 cellspacing=1  class="listTable" style="margin-top:-1px;">
  <tr>
    <th align=left colspan="4">&nbsp;系统维护</th>
  </tr>
  <?php for($i=0;$i<count($theWfList);$i++){ ?>
  <tr>
    <td style="color:#ff0000;"><?php echo ($i+1).'：'.$theWfList[$i]; ?></th>
  </tr>
  <?php } ?>
</table>
<?php } ?>
<table  border=0 cellpadding=0 cellspacing=1  class="listTable" style="margin-top:-1px;">
  <tr>
    <th align=left colspan="4">&nbsp;PHP基本特征 [<a href="?action=showphpinfo" style="color:#000;">查看更多</a>]</th>
  </tr>
  <tr>
    <td width="35%" align=left>&nbsp;PHP运行方式</td>
    <td width="15%"><?php echo strtoupper ( php_sapi_name () ); ?></td>
    <td width="35%"  align=left>&nbsp;PHP版本</td>
    <td width="15%" ><?php echo PHP_VERSION; ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;运行于安全模式</td>
    <td><?php echo getcon ( "safe_mode" ); ?></td>
    <td align=left>&nbsp;支持ZEND编译运行</td>
    <td><?php echo (get_cfg_var ( "zend_optimizer.optimization_level" ) || get_cfg_var ( "zend_extension_manager.optimizer_ts" ) || get_cfg_var ( "zend_extension_ts" )) ? YES : NO; ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;允许使用URL打开文件&nbsp;allow_url_fopen</td>
    <td><?php echo getcon ( "allow_url_fopen" ); ?></td>
    <td align=left>&nbsp;允许动态加载链接库&nbsp;enable_dl</td>
    <td><?php echo getcon ( "enable_dl" ); ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;显示错误信息&nbsp;display_errors</td>
    <td><?php echo getcon ( "display_errors" ); ?></td>
    <td align=left>&nbsp;自动定义全局变量&nbsp;register_globals</td>
    <td><?php echo getcon ( "register_globals" ); ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;magic_quotes_runtime</td>
    <td><?php echo (1 === get_magic_quotes_runtime ()) ? YES : NO; ?></td>
    <td align=left>&nbsp;magic_quotes_gpc</td>
    <td><?php echo (1 === get_magic_quotes_gpc ()) ? YES : NO; ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;单次上传最大文件限制</td>
    <td><?php echo getcon ( "upload_max_filesize" ); ?></td>
    <td align=left>&nbsp;程序最长运行时间&nbsp;max_execution_time</td>
    <td><?php echo getcon ( "max_execution_time" ).'秒'; ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;被禁用的函数&nbsp;disable_functions</td>
    <td colspan="3"><?php echo ("" == ($disFuns = get_cfg_var ( "disable_functions" ))) ? "无" : str_replace ( ",", "<br />", $disFuns ); ?></td>
  </tr>
</table>

<table  border=0 cellpadding=0 cellspacing=1  class="listTable" style="margin-top:-1px;">
  <tr>
    <th align=left colspan="4">&nbsp;组件支持状况</th>
  </tr>
  <tr>
    <td width="35%" align=left>&nbsp;Session支持</td>
    <td width="15%"><?php echo isfun ( "session_start" ); ?></td>
    <td width="35%" align=left>&nbsp;Socket支持</td>
    <td width="15%"><?php echo isfun ( "fsockopen" ); ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;FTP</td>
    <td><?php echo isfun ( "ftp_login" ); ?></td>
    <td align=left>&nbsp;ODBC数据库连接</td>
    <td><?php echo isfun ( "odbc_close" ); ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;压缩文件支持(Zlib)</td>
    <td><?php echo isfun ( "gzclose" ); ?></td>
    <td align=left>&nbsp;XML解析</td>
    <td><?php echo isfun ( "xml_set_object" ); ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;高精度数学运算 BCMath</td>
    <td><?php echo isfun ( "bcadd" ); ?></td>
    <td align=left>&nbsp;图形处理 GD Library</td>
    <td><?php echo isfun ( "gd_info" ); ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;历法运算 Calendar</td>
    <td><?php echo isfun ( "cal_days_in_month" ); ?></td>
    <td align=left>&nbsp;WDDX支持</td>
    <td><?php echo isfun ( "wddx_add_vars" ); ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;PREL相容语法 PCRE</td>
    <td><?php echo isfun ( "preg_match" ); ?></td>
    <td align=left>&nbsp;MySQL数据库</td>
    <td><?php echo isfun ( "mysql_close" ); ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;SQL Server数据库</td>
    <td><?php echo isfun ( "mssql_close" ); ?></td>
    <td align=left>&nbsp;SyBase数据库</td>
    <td><?php echo isfun ( "sybase_close" ); ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;Oracle数据库</td>
    <td><?php echo isfun ( "ora_close" ); ?></td>
    <td align=left>&nbsp;Oracle 8 数据库</td>
    <td><?php echo isfun ( "OCILogOff" ); ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;dBase数据库</td>
    <td><?php echo isfun ( "dbase_close" ); ?></td>
    <td align=left>&nbsp;DBM数据库</td>
    <td><?php echo isfun ( "dbmclose" ); ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;DBA数据库</td>
    <td><?php echo isfun ( "dba_close" ); ?></td>
    <td align=left>&nbsp;FilePro数据库</td>
    <td><?php echo isfun ( "filepro_fieldcount" ); ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;mSQL数据库</td>
    <td><?php echo isfun ( "msql_close" ); ?></td>
    <td align=left>&nbsp;Hyperwave数据库</td>
    <td><?php echo isfun ( "hw_close" ); ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;Postgre SQL数据库</td>
    <td><?php echo isfun ( "pg_close" ); ?></td>
    <td align=left>&nbsp;Yellow Page系统</td>
    <td><?php echo isfun ( "yp_match" ); ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;VMailMgr邮件处理</td>
    <td><?php echo isfun ( "vm_adduser" ); ?></td>
    <td align=left>&nbsp;FDF表单资料格式</td>
    <td><?php echo isfun ( "fdf_get_ap" ); ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;哈稀计算 MHash</td>
    <td><?php echo isfun ( "mhash_count" ); ?></td>
    <td align=left>&nbsp;SNMP网络管理协议</td>
    <td><?php echo isfun ( "snmpget" ); ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;IMAP电子邮件系统</td>
    <td><?php echo isfun ( "imap_close" ); ?></td>
    <td align=left>&nbsp;Informix数据库</td>
    <td><?php echo isfun ( "ifx_close" ); ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;LDAP目录协议</td>
    <td><?php echo isfun ( "ldap_close" ); ?></td>
    <td align=left>&nbsp;MCrypt加密处理</td>
    <td><?php echo isfun ( "mcrypt_cbc" ); ?></td>
  </tr>
  <tr>
    <td align=left>&nbsp;拼写检查 ASpell Library</td>
    <td><?php echo isfun ( "aspell_check_raw" ); ?></td>
    <td align=left>&nbsp;PDF文档支持</td>
    <td><?php echo isfun ( "pdf_close" ); ?></td>
  </tr> 
</table>
<script type="text/javascript">$(function(){setTableColor();});</script>
</body>
</html>
<?php function getcon($varName) { switch ($res = get_cfg_var ( $varName )) { case 0 : return NO; break; case 1 : return YES; break; default : return $res; break; } } function isfun($funName) { return (false !== function_exists($funName))?YES:NO; } function test_io() { $fp = fopen ( PHPSELF, "r" ); $timeStart = gettimeofday (); for($i = 0; $i < 10000; $i ++) { fread ( $fp, 10240 ); rewind ( $fp ); } $timeEnd = gettimeofday (); fclose ( $fp ); $time = ($timeEnd ["usec"] - $timeStart ["usec"]) / 1000000 + $timeEnd ["sec"] - $timeStart ["sec"]; $time = round ( $time, 3 ) . "秒"; return ($time); } function bar($percent) { echo '<ul class=\"bar\">'; echo "<li style=\"width:$percent%\">&nbsp;</li>"; echo '</ul>'; } function sys_linux() { if (false === ($str = @file ( "/proc/cpuinfo" ))) return false; $str = implode ( "", $str ); @preg_match_all ( '/model\s+name\s{0,}\:+\s{0,}([\w\s\)\(.]+)[\r\n]+/', $str, $model ); @preg_match_all ( '/cache\s+size\s{0,}\:+\s{0,}([\d\.]+\s{0,}[A-Z]+[\r\n]+)/', $str, $cache ); if (false !== is_array ( $model [1] )) { $res ['cpu'] ['num'] = sizeof ( $model [1] ); for($i = 0; $i < $res ['cpu'] ['num']; $i ++) { $res ['cpu'] ['detail'] [] = "类型：" . $model [1] [$i] . " 缓存：" . $cache [1] [$i]; } if (array_key_exists('detail', $res ['cpu']) && false !== is_array ( $res ['cpu'] ['detail'] )) { $res ['cpu'] ['detail'] = implode ( "<br />", $res ['cpu'] ['detail'] ); } } if (false === ($str = @file ( "/proc/uptime" ))) return false; $str = explode ( " ", implode ( "", $str ) ); $str = trim ( $str [0] ); $min = $str / 60; $hours = $min / 60; $days = floor ( $hours / 24 ); $hours = floor ( $hours - ($days * 24) ); $min = floor ( $min - ($days * 60 * 24) - ($hours * 60) ); if ($days !== 0) $res ['uptime'] = $days . "天"; if ($hours !== 0) $res ['uptime'] .= $hours . "小时"; $res ['uptime'] .= $min . "分钟"; if (false === ($str = @file ( "/proc/meminfo" ))) return false; $str = implode ( "", $str ); preg_match_all ( '/MemTotal\s{0,}\:+\s{0,}([\d\.]+).+?MemFree\s{0,}\:+\s{0,}([\d\.]+).+?SwapTotal\s{0,}\:+\s{0,}([\d\.]+).+?SwapFree\s{0,}\:+\s{0,}([\d\.]+)/s', $str, $buf ); $res ['memTotal'] = round ( $buf [1] [0] / 1024, 2 ); $res ['memFree'] = round ( $buf [2] [0] / 1024, 2 ); $res ['memUsed'] = ($res ['memTotal'] - $res ['memFree']); $res ['memPercent'] = (floatval ( $res ['memTotal'] ) != 0) ? round ( $res ['memUsed'] / $res ['memTotal'] * 100, 2 ) : 0; $res ['swapTotal'] = round ( $buf [3] [0] / 1024, 2 ); $res ['swapFree'] = round ( $buf [4] [0] / 1024, 2 ); $res ['swapUsed'] = ($res ['swapTotal'] - $res ['swapFree']); $res ['swapPercent'] = (floatval ( $res ['swapTotal'] ) != 0) ? round ( $res ['swapUsed'] / $res ['swapTotal'] * 100, 2 ) : 0; if (false === ($str = @file ( "/proc/loadavg" ))) return false; $str = explode ( " ", implode ( "", $str ) ); $str = array_chunk ( $str, 3 ); $res ['loadAvg'] = implode ( " ", $str [0] ); return $res; } function sys_freebsd() { if (false === ($res ['cpu'] ['num'] = get_key ( "hw.ncpu" ))) return false; $res ['cpu'] ['detail'] = get_key ( "hw.model" ); if (false === ($res ['loadAvg'] = get_key ( "vm.loadavg" ))) return false; $res ['loadAvg'] = str_replace ( "{", "", $res ['loadAvg'] ); $res ['loadAvg'] = str_replace ( "}", "", $res ['loadAvg'] ); if (false === ($buf = get_key ( "kern.boottime" ))) return false; $buf = explode ( ' ', $buf ); $sys_ticks = time () - intval ( $buf [3] ); $min = $sys_ticks / 60; $hours = $min / 60; $days = floor ( $hours / 24 ); $hours = floor ( $hours - ($days * 24) ); $min = floor ( $min - ($days * 60 * 24) - ($hours * 60) ); if ($days !== 0) $res ['uptime'] = $days . "天"; if ($hours !== 0) $res ['uptime'] .= $hours . "小时"; $res ['uptime'] .= $min . "分钟"; if (false === ($buf = get_key ( "hw.physmem" ))) return false; $res ['memTotal'] = round ( $buf / 1024 / 1024, 2 ); $buf = explode ( "\n", do_command ( "vmstat", "" ) ); $buf = explode ( " ", trim ( $buf [2] ) ); $res ['memFree'] = round ( $buf [5] / 1024, 2 ); $res ['memUsed'] = ($res ['memTotal'] - $res ['memFree']); $res ['memPercent'] = (floatval ( $res ['memTotal'] ) != 0) ? round ( $res ['memUsed'] / $res ['memTotal'] * 100, 2 ) : 0; $buf = explode ( "\n", do_command ( "swapinfo", "-k" ) ); $buf = $buf [1]; preg_match_all ( '/([0-9]+)\s+([0-9]+)\s+([0-9]+)/', $buf, $bufArr ); $res ['swapTotal'] = round ( $bufArr [1] [0] / 1024, 2 ); $res ['swapUsed'] = round ( $bufArr [2] [0] / 1024, 2 ); $res ['swapFree'] = round ( $bufArr [3] [0] / 1024, 2 ); $res ['swapPercent'] = (floatval ( $res ['swapTotal'] ) != 0) ? round ( $res ['swapUsed'] / $res ['swapTotal'] * 100, 2 ) : 0; return $res; } function get_key($keyName) { return do_command ( 'sysctl', "-n $keyName" ); } function find_command($commandName) { $path = array ('/bin', '/sbin', '/usr/bin', '/usr/sbin', '/usr/local/bin', '/usr/local/sbin' ); foreach ( $path as $p ) { if (@is_executable ( "$p/$commandName" )) return "$p/$commandName"; } return false; } function do_command($commandName, $args) { $buffer = ""; if (false === ($command = find_command ( $commandName ))) return false; if (($fp = @popen ( "$command $args", 'r' ))==true) { while ( ! @feof ( $fp ) ) { $buffer .= @fgets ( $fp, 4096 ); } return trim ( $buffer ); } return false; } function getXtwf(){ $theArray=array(); if(1 === get_magic_quotes_gpc ()){ $theArray[]="网站服务器 PHP magic_quotes_gpc 自动转义没有关闭，将导致图片等信息无法正常显示"; } $temp=str_replace("M", "", get_cfg_var("memory_limit")); if(intval($temp) < 128){ $theArray[]="网站服务器程序最多允许使用内存量为".get_cfg_var("memory_limit")."，在条件允许的情况下请调整到128M以上，过小将有可能导致时常网站无法正常打开"; } if(intval(get_cfg_var("display_errors"))===1){ $theArray[]="网站服务器显示错误信息 display_errors没有关闭，对安全有一定影响"; } return $theArray; } ?>