<?php
/*
	-----------------------------------------
	文件：goods_record.php。
	功能: ajax方式获取商品成交记录。
	日期：2010-11-01
	-----------------------------------------
*/
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

// post 数据处理
$page = intval(get_args('page'));
$goods_id = intval(get_args('goods_id'));

// 数据表定义区
$t_order_goods = $tablePreStr."order_goods";
$t_order_info = $tablePreStr."order_info";
$t_users = $tablePreStr."users";

// 定义写操作
dbtarget('r' , $dbServs);
$dbo = new dbex;

// 查询商品成交记录
$sql = "select u.user_id,u.user_name,og.goods_id,og.goods_name,og.goods_price,og.order_num,oi.shipping_time from `$t_order_goods` as og join `$t_order_info` as oi on og.order_id = oi.order_id join `$t_users`  as u on oi.user_id = u.user_id where og.goods_id=$goods_id and oi.order_status=3 ";
$result = $dbo->fetch_page($sql,10);
// 返回json数据
if($result['result'])
{
	echo json_encode($result);
}
else
{
	exit('-1');
}


?>