<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("foundation/module_order.php");
require("foundation/module_payment.php");
require("foundation/module_goods.php");
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
$s_langpackage=new shoplp;
$order_id = intval(get_args('id'));
if(!$order_id) { trigger_error($m_langpackage->m_handle_err); }

//数据表定义区
$t_order_info = $tablePreStr."order_info";
$t_shop_payment = $tablePreStr."shop_payment";
$t_payment = $tablePreStr."payment";
$t_order_goods = $tablePreStr."order_goods";
$t_goods = $tablePreStr."goods";
$t_shop_info = $tablePreStr."shop_info";
$t_users = $tablePreStr."users";
$dbo=new dbex;
//读写分离定义方法
dbtarget('r',$dbServs);
//判断商品是否锁定，锁定则不许操作
$sql="select b.goods_id from $t_order_info as a join $t_order_goods as b on a.order_id=b.order_id where a.order_id=$order_id";
$row=$dbo->getRow($sql);
if($row){
	$goods_id=$row['goods_id'];
}
include("foundation/fgoods_locked.php");
//判断用户是否锁定，锁定则不许操作
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	trigger_error($m_langpackage->m_user_locked);//非法操作
}
$order_info = get_order_info($dbo,$t_order_info,$t_order_goods,$t_goods,$t_shop_info,$order_id,$user_id);
if(!$order_info){
	trigger_error('订单不存在');
}
if($order_info['order_status']=='0'||$order_info['order_status']=='3'||$order_info['pay_status']=='1'){
	trigger_error($m_langpackage->m_handle_err);
}

$payment_shop_info = get_shop_payment_info($dbo,$t_shop_payment,$order_info['shop_id'],1);
$payment_info = get_payment_info($dbo,$t_payment,1);

?>