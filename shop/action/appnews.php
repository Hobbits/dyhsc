<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//echo 'tee';exit;
require("foundation/module_news.php");

//数据表定义区
$t_article = $tablePreStr."article";
$t_article_cat = $tablePreStr."article_cat";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);
$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
$cat_id = $_GET['cat_id'];
if($cat_id) {
	$sql = "select article_id,title,thumb,add_time from `$t_article` ";
	
	$sql .= " where cat_id='$cat_id' and is_show = 1";
	$csql = "select cat_name from `$t_article_cat` where cat_id = $cat_id ";
	$cat_name = $dbo->getRow($csql);
	$carname = array('categoryname' => $cat_name['cat_name']);
	$conbine = array_merge($chatnums, $carname);
	
	$sql .= " order by add_time desc";
	
	$result = $dbo->getRsassoc($sql);
	if ($result){
		foreach ($result as $value){
			$return[$value['article_id']]['article_id'] = $value['article_id'];
			$return[$value['article_id']]['thumb'] = $value['thumb'];
			$return[$value['article_id']]['title'] = $value['title'];
			$return[$value['article_id']]['add_time'] = date("Y-m-d",strtotime($value['add_time']));
		}
		foreach ($return as $re ){
			$final[] = $re;
		}
		$r = new returnobj('ok',$final,$conbine);
		$rs =  $callback . '(' . json_encode( $r) . ')';
		print_r($rs);
	}else{
		$r = new returnobj('ok',array(),$conbine);
		$rs =  $callback . '(' . json_encode( $r) . ')';
		print_r($rs);
	}
}else{
	$r = new returnobj('-1','没分类');
	$rs =  $callback . '(' . json_encode( $r) . ')';
	print_r($rs);
}