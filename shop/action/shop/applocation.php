<?php

if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}
require("foundation/module_areas.php");

$t_areas = $tablePreStr."areas";
//读写分离定义方法
$dbo=new dbex;
dbtarget('r',$dbServs);
$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
$parent_id = $_GET['area_id'] ? $_GET['area_id'] : '1';
//获取地区
$areas= get_areas_list($dbo,$t_areas,$parent_id);
$result = array();
if ($areas){
	foreach ($areas as $v){
		$result[$v['area_id']] = $v['area_name'];
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