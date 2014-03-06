<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require("foundation/module_shop_category.php");
$t_shop_categories = $tablePreStr."shop_categories";


$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';


//读写分离定义方法
$dbo=new dbex;
dbtarget('r',$dbServs);
$cat_id = $_GET['cat_id'] ? $_GET['cat_id'] : '0';
$shop_categories_parent = get_categories_item_parentid($dbo,$t_shop_categories,$cat_id);
$result = array();
if ($shop_categories_parent){
	foreach($shop_categories_parent as  $v) {
		$result[$v['cat_id']] = $v['cat_name'];	
	}
}
if ($result){
	echo $callback . '(' . json_encode( $result ) . ')';
	exit;
}else{
	$r = '-1';
	echo $callback . '(' . json_encode( $r ) . ')';
	exit;
}
