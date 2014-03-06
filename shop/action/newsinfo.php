<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("foundation/module_news.php");

//数据表定义区
$t_article = $tablePreStr."article";
$t_admin = $tablePreStr."admin_user";
//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);
$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';

$article_id = $_GET['article_id'];
//$article_id = '1';
$artile = get_news_infos($dbo,$t_article,$article_id);
if ($article_id){
	if ($artile['admin_id']){
		$adminid = $artile['admin_id'];
		$sql = "select admin_name from `$t_admin` where admin_id =$adminid  ";
		$name = $dbo->getRow($sql);
		$artile['admin_name'] = $name['admin_name'];
	}
	$r = new returnobj('ok',$artile,$chatnums);
	$rs =  $callback . '(' . json_encode( $r) . ')';
	print_r($rs);
}
