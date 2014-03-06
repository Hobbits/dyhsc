<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require("foundation/acheck_shop_creat.php");
require("foundation/ashop_news_category.php");
require("foundation/module_category.php");
require("foundation/module_type.php");
require("foundation/module_shop.php");
require("foundation/module_groupbuy.php");

//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
$s_langpackage=new shoplp;
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
$t_users = $tablePreStr."users";
//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

/* 商铺信息处理 */
include("foundation/fshop_locked.php");
//判断用户是否锁定，锁定则不许操作
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	trigger_error($m_langpackage->m_user_locked);//非法操作
}
$result = get_groupbuy_lst($dbo,$t_groupbuy,$t_goods,$shop_id,10);
$shop_category = get_shop_category_list($dbo,$t_shop_category,$shop_id);
$html_shop_category = html_format_shop_category($shop_category,$ucat_id);
?>