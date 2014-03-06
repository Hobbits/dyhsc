<?php
header("content-type:text/html;charset=utf-8");
$IWEB_SHOP_IN = true;

require("foundation/asession.php");
require("configuration.php");
require("includes.php");
require_once("foundation/asystem_info.php");

//引入语言包
$i_langpackage=new indexlp;
$verifycode = unserialize($SYSINFO['verifycode']);
/* 用户信息处理 */
if(get_sess_user_id()) {
	$USER['login'] = 1;
	$USER['user_name'] = get_sess_user_name();
	$USER['user_id'] = get_sess_user_id();
	$USER['user_email'] = get_sess_user_email();
	$USER['shop_id'] = get_sess_shop_id();
	header('Location: modules.php');
} else {
	$USER['login'] = 0;
	$USER['user_name'] = '';
	$USER['user_id'] = '';
	$USER['user_email'] = '';
	$USER['shop_id'] = '';
}
$url = get_args('url');
if($url){
	$_SERVER['HTTP_REFERER']=urldecode($url);
}
$iweb_shop=get_cookie('iweb_login');
$outuserid=get_args('outuserid')?get_args('outuserid'):'0';
/*导航位置*/
$nav_selected=1;
?>