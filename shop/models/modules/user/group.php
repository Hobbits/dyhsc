<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require("foundation/ashop_news_category.php");
require("foundation/module_category.php");
require("foundation/module_type.php");
require("foundation/module_groupbuy.php");

//引入语言包
$m_langpackage=new moduleslp;
$s_langpackage=new shoplp;
$i_langpackage=new indexlp;

$ucat_id = intval(get_args('ucat_id'));
$ctime=new time_class;
$now_time=$ctime->long_time();

//数据表定义区
$t_goods = $tablePreStr."goods";
$t_brand = $tablePreStr."brand";
$t_goods_types = $tablePreStr."goods_types";
$t_shop_category = $tablePreStr."shop_category";
$t_groupbuy = $tablePreStr."groupbuy";
$t_groupbuy_log = $tablePreStr."groupbuy_log";
$t_shop_info = $tablePreStr."shop_info";


//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);
$result = get_my_groupbuy($dbo,$t_groupbuy,$t_goods,$t_groupbuy_log,$t_shop_info,$user_id,10);
?>