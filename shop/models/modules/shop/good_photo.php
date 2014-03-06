<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}
require("foundation/acheck_shop_creat.php");
require("foundation/module_areas.php");
require("foundation/module_order.php");
require("foundation/module_payment.php");

//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

$order_id = intval(get_args('order_id'));
if(!$order_id) { trigger_error($m_langpackage->m_handle_err); }

//数据表定义区
$t_order_info = $tablePreStr."order_info";
$t_areas = $tablePreStr."areas";
$t_order_goods = $tablePreStr."order_goods";
$t_goods = $tablePreStr."goods";
$t_shop_info = $tablePreStr."shop_info";
$t_payment = $tablePreStr."payment";

$dbo=new dbex;
//读写分离定义方法
dbtarget('r',$dbServs);

$info = get_order_info($dbo,$t_order_info,$t_order_goods,$t_goods,$t_shop_info,$order_id,0,$shop_id);
if(!$info)
	trigger_error($m_langpackage->m_no_order);
$areas = get_areas_kv($dbo,$t_areas);
$payment_info = get_payment_info($dbo,$t_payment);
?>