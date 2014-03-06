<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require('foundation/module_start.php');

//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

//数据表定义区
$t_user_favorite = $tablePreStr."user_favorite";
$t_goods = $tablePreStr."goods";
$t_shop_info = $tablePreStr."shop_info";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);
$result = get_myfavorite_info($dbo,$t_user_favorite,$t_goods,$t_shop_info,$user_id,10);
$my_favorite = $result;
/* 店铺收藏 */
$result = get_shop_favorite($dbo,$t_user_favorite,$t_shop_info,$user_id,10);
$shop_favorite = $result;
?>