<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require("foundation/module_shop_category.php");
$t_shop_categories = $tablePreStr."shop_categories";


$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
$id = $_GET['businessid'];


//读写分离定义方法
$dbo=new dbex;
dbtarget('r',$dbServs);
$shop_categories_info = get_categories_item_parentid($dbo,$t_shop_categories,$id);
$result = array();
if ($shop_categories_info){
	foreach($shop_categories_info as $key => $v) {
		$result[$key] = $v;	
	}
}
if ($result){
	echo $callback . '(' . json_encode( $result ) . ')';
	exit;
}
