<?php
//我买的
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
require("foundation/module_order.php");
require("foundation/module_goods.php");
//定义文件表
$t_order_info = $tablePreStr."order_info";
$t_order_goods = $tablePreStr."order_goods";
$t_goods = $tablePreStr."goods_attachment";
$t_users = $tablePreStr."users";

$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
$userid = $_GET['userid'];
//$userid = 20;
//数据库操作
dbtarget('r',$dbServs);
$dbo=new dbex();
$info = array('payid','goods_name','order_amount','transport_status');
//我买的
$sql1="select i.order_id,i.payid,i.shop_id,i.order_amount,i.mobile,i.order_status,i.pay_status,i.transport_status,i.order_time,g.photoid,g.goods_name,g.order_num from `$t_order_info` as i , `$t_order_goods` as g where i.user_id='$userid' and i.order_id = g.order_id ";
$result1 = $dbo->getRs($sql1);
if ($result1){
	foreach ($result1 as $r){
		$return[$r['order_id']]['payid'] = $r['payid'];
		$return[$r['order_id']]['goods_name'] = $r['goods_name'];
		$aid = $r['photoid'];
		$sql = "select img_thumb from $t_goods  where aid = $aid and is_delete = 1";
		$img = $dbo->getRow($sql);
		$return[$r['order_id']]['img_thumb'] = $img['img_thumb'];
		if ($r['order_time']){
			$return[$r['order_id']]['order_time'] = date('Y-m-d',strtotime($r['order_time']));
		}
	}
	if ($return){
		foreach ($return as $r){
			$b[] = $r;
		}
	}
}

if ($b){
	$back = array('buy' => $b);
}else{
	$back = array('sell'=> array());
}

if ($back){
	$r = new returnobj('ok',$back,$chatnums);
	print_r($callback . '(' . json_encode( $r ) . ')');
	exit;
}
