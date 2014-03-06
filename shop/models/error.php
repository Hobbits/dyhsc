<?php

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
$errno=get_args("paths");
$errorarray=explode("-",$errstr);
if(!$errorarray){
	$errorarray[0]=$i_langpackage->i_page_error;
}
if(!$errorarray[1]){
	$errorarray[1]=$baseUrl;
}

?>