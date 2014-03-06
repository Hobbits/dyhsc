<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

if($USER['shop_id']) {
	$url=shop_url($USER['shop_id']);
} else {
	$url='modules.php?app=shop_info';
}
$search_header_type = short_check(get_args("search_type"));
//引入语言包
if(!isset($i_langpackage)){
	$i_langpackage = new indexlp;
}
$ksearch=short_check(get_args("k"));
if($i_langpackage->i_search_keyword==$ksearch){
	$ksearch="";
}
?>