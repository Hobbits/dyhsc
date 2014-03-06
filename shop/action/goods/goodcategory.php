<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require("foundation/module_category.php");

$t_category = $tablePreStr."category";
//读写分离定义方法
	$dbo = new dbex;
	dbtarget('r',$dbServs);
	
	$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
	$cat_id = $_GET['cat_id'] ? $_GET['cat_id']:'0';
	$category_info = get_sub_category($dbo,$t_category,$cat_id);
	//$category_info = get_category_info($dbo,$t_category);
	$result = array();
	if ($category_info){
		foreach ($category_info as $k => $value){
			$result[$k] = $value;
		}
	}
	
	if ($result){
		echo $callback . '(' . json_encode( $result ) . ')';
		exit;
	}