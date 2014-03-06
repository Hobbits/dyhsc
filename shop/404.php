<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/404.html
 * 如果您的模型要进行修改，请修改 models/404.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
/*
 * 此段代码由debug模式下生成运行，请勿改动！
 * 如果debug模式下出错不能再次自动编译时，请进入后台手动编译！
 */
/* debug模式运行生成代码 开始 */
if(!function_exists("tpl_engine")) {
	require("foundation/ftpl_compile.php");
}
if(filemtime("templates/default/404.html") > filemtime(__file__) || (file_exists("models/404.php") && filemtime("models/404.php") > filemtime(__file__)) ) {
	tpl_engine("default","404.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php

$IWEB_SHOP_IN = true;

require("foundation/asession.php");
require("configuration.php");
require("includes.php");

/* 用户信息处理 */
if(get_sess_user_id()) {
	$USER['login'] = 1;
	$USER['user_name'] = get_sess_user_name();
	$USER['user_id'] = get_sess_user_id();
	$USER['user_email'] = get_sess_user_email();
	$USER['shop_id'] = get_sess_shop_id();
} else {
	$USER['login'] = 0;
	$USER['user_name'] = '';
	$USER['user_id'] = '';
	$USER['user_email'] = '';
	$USER['shop_id'] = '';
}

$i_langpackage=new indexlp;
$errstr=get_args("errstr");
$errno=get_args("asd");
$errorarray=explode("-",$errstr);
if(!$errorarray){
	$errorarray[0]=$i_langpackage->i_page_error;
}
if(!$errorarray[1]){
	$errorarray[1]=$baseUrl;
}

?>														<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $i_langpackage->i_member_login;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta  http-equiv="Refresh" content="3;url=<?php echo $errorarray[1];?>" />
<base href="<?php echo  $baseUrl;?>" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/index.css" rel="stylesheet" type="text/css" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/area.js"></script>
<script type='text/javascript' src='./servtools/md5.js'></script>
</head>
<?php if($errno) {?>
<body onload= "javascript:setTimeout( 'window.close() ',3000);">
<?php  } else {?>
<body>
<?php }?>
<div id="wrapper">
<?php  include("shop/index_header.php");?>

<div class="error_box">

  <p><?php echo $errorarray[0];?></p>
  
  <p><?php echo $i_langpackage->i_href;?></p>
  <p><a title="<?php echo $i_langpackage->i_hand_index;?>" href="<?php echo $errorarray[1];?>"><?php echo $i_langpackage->i_hand_index;?>>></a></p>
</div><!-- main end -->
<?php  require("shop/index_footer.php");?>
<!--footer end-->
</div>
<script type='text/javascript'>
function countDown(secs,surl){
	if($('skip')){
	  $("skip").innerHTML=secs;
	  --secs > 0 ? setTimeout("countDown("+secs+",'"+surl+"')",1000):location.href=surl;
	}
}
countDown(5,'<?php echo $siteDomain;?><?php echo $indexFile;?>');
</script>
</body>
</html>
																																			<?php } ?>