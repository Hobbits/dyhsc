<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("foundation/module_news.php");
//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);
$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
//数据表定义区
$t_article_cat = $tablePreStr."article_cat";

$cat_info = get_news_cat_lists($dbo,$t_article_cat);
if($cat_info){
	foreach ($cat_info as $info){
		$result[] = $info;
	}
	$r = new returnobj('ok',$result,$chatnums);
	$rs =  $callback . '(' . json_encode( $r) . ')';
	print_r($rs);
}else{
	$r = new returnobj('ok',array(),$chatnums);
	$rs =  $callback . '(' . json_encode( $r) . ')';
	print_r($rs);
}
