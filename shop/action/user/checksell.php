<?php
//我卖的
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
//$userid = '15';

//数据库操作
dbtarget('r',$dbServs);
$dbo=new dbex();
$info = array('payid','goods_name','order_amount','transport_status');



//我卖的
$sql2="select i.order_id,i.payid,i.shop_id,i.user_id,i.order_amount,i.mobile,i.order_status,i.pay_status,i.transport_status,i.read,i.order_time,g.photoid,g.goods_name,g.order_num from `$t_order_info` as i , `$t_order_goods` as g where i.shop_id='$userid' and i.order_id = g.order_id ";
$result2 = $dbo->getRsassoc($sql2);
if ($result2){
	foreach ($result2 as $r2) {
		$u = '';$uid = '';$aid='';$img= '';
		//$return[$r2['order_id']]['payid'] = $r2['order_id'];
		$return[$r2['order_id']]['payid'] = $r2['payid'];
		//$return[$r2['order_id']]['shop_id'] = $r2['shop_id'];
		//$return[$r2['order_id']]['user_id'] = $r2['user_id'];
		$uid = $r2['user_id'];
		$sql = "select user_name from $t_users  where user_id =$uid ";
		$u = $dbo->getRow($sql);
		$return[$r2['order_id']]['username'] = $u['user_name'];
		
		//$return[$r2['order_id']]['order_amount'] = $r2['order_amount'];
		//$return[$r2['order_id']]['mobile'] = $r2['mobile'];
		//$return[$r2['order_id']]['order_status'] = $r2['order_status'];
		//$return[$r2['order_id']]['transport_status'] = $r2['transport_status'];
		$return[$r2['order_id']]['read'] = $r2['read'];
		if ($r2['order_time']){
		$return[$r2['order_id']]['order_time'] = date('Y-m-d',strtotime($r2['order_time']));
		}
		//$return[$r2['order_id']]['photoid'] = $r2['photoid'];
		$aid = $r2['photoid'];
		$sql2 = "select img_thumb from $t_goods  where aid = $aid and is_delete = 1";
		$img = $dbo->getRow($sql2);
		$return[$r2['order_id']]['img_thumb'] = $img['img_thumb'];
		
		$return[$r2['order_id']]['goods_name'] = $r2['goods_name'];
		//$return[$r2['order_id']]['order_num'] = $r2['order_num'];
	}
	if ($return){
		foreach ($return as $r){
			$b[] = $r;
		}
	}
}
if ($b){
	$back = array('sell'=>$b);
}else{
	$back = array('sell'=> array());
}
if ($back){
	$r = new returnobj('ok',$back,$chatnums);
	print_r($callback . '(' . json_encode( $r ) . ')');
	exit;
}
