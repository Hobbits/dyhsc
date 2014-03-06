<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("foundation/module_areas.php");
require("foundation/module_order.php");
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

$dbo=new dbex;
//读写分离定义方法
dbtarget('r',$dbServs);

$info = get_order_info($dbo,$t_order_info,$t_order_goods,$t_goods,$t_shop_info,$order_id,$user_id);

if(!$info)
	trigger_error($m_langpackage->m_no_order);

$areas = get_areas_kv($dbo,$t_areas);
?>