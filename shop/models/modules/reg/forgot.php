<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

//引入语言包
$i_langpackage=new indexlp;
$m_langpackage=new moduleslp;

$header['keywords'] = $SYSINFO['sys_keywords'];
$header['description'] = $SYSINFO['sys_description'];

require_once("foundation/asystem_info.php");

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
$nav_selected = '1';
?>