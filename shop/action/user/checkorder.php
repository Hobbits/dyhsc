<?php
//查看时分卖家和买家
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
require("foundation/module_order.php");
require("foundation/module_goods.php");
//定义文件表
$t_order_info = $tablePreStr."order_info";
$t_order_goods = $tablePreStr."order_goods";

$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
$userid = $_GET['userid'];
$userid = '20';

//数据库操作
dbtarget('r',$dbServs);
$dbo=new dbex();
$info = array('payid','goods_name','order_amount','transport_status');
//我买的
$sql1="select i.payid,i.shop_id,i.order_amount,i.mobile,i.order_status,i.pay_status,i.transport_status,g.goods_name,g.order_num from `$t_order_info` as i , `$t_order_goods` as g where i.user_id='$userid' and i.order_id = g.order_id ";
$result1 = $dbo->getRs($sql1);
if ($result1){
	foreach ($result1 as $r1){
		foreach ($info as $i){
			$return1[][$i]= $r1[$i];
		}
	}
}


//我卖的
$sql2="select i.payid,i.shop_id,i.order_amount,i.mobile,i.order_status,i.pay_status,i.transport_status,g.goods_name,g.order_num from `$t_order_info` as i , `$t_order_goods` as g where i.shop_id='$userid' and i.order_id = g.order_id ";
$result2 = $dbo->getRs($sql2);
if ($result2){
	foreach ($result2 as $r2){
		foreach ($info as $j){
			$return2[$r2['payid']][$j]= $r2[$j];
		}
	}
}
if ($result1 && !$result2){
	$back = array('buy' => $return1,'sell'=> '');
}elseif (!$result1 && $result2){
	$back = array('buy' => '','sell'=> $result2);
}elseif ($result1 && $result2){
	$back = array('buy' => $return1,'sell'=> $result2);
}
if ($back){
	$r = new returnobj('ok',$back);
	print_r($callback . '(' . json_encode( $r ) . ')');
	exit;
}