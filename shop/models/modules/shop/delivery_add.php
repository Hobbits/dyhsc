<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("foundation/acheck_shop_creat.php");
require("foundation/module_areas.php");
require("foundation/module_order.php");
require("foundation/module_goods.php");
//语言包引入
$m_langpackage=new moduleslp;
$s_langpackage=new shoplp;
//数据表定义区
$t_order_info = $tablePreStr."order_info";
$t_users = $tablePreStr."users";
$t_order_goods = $tablePreStr."order_goods";
$t_goods = $tablePreStr."goods";
$order_id = intval(get_args('order_id'));
if(!$order_id) { exit($m_langpackage->m_handle_err); }
//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

//判断商品是否锁定，锁定则不许操作
$sql="select b.goods_id,a.transport_type from $t_order_info as a join $t_order_goods as b on a.order_id=b.order_id where a.order_id=$order_id";
$row1=$dbo->getRow($sql);
if($row1){
	$goods_id=$row1['goods_id'];
}
include("foundation/fgoods_locked.php");
//判断用户是否锁定，锁定则不许操作
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	trigger_error($m_langpackage->m_user_locked);//非法操作
}
?>