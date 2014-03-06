<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("foundation/module_photo.php");
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

$id = intval(get_args('id'));
$path = short_check(get_args('path'));
if(!$id) { trigger_error($m_langpackage->m_handle_err); }

//数据表定义区
$t_order_goods = $tablePreStr."order_goods";

$dbo=new dbex;
//读写分离定义方法
dbtarget('r',$dbServs);

$info = get_photo_info($dbo,$t_order_goods,$id);

?>