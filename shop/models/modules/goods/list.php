<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require("foundation/acheck_shop_creat.php");
require("foundation/ashop_news_category.php");
require("foundation/module_category.php");
require("foundation/module_type.php");
require("foundation/module_shop.php");

//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
$s_langpackage=new shoplp;

$k = short_check(get_args('k'));
$ucat_id = intval(get_args('ucat_id'));

//数据表定义区
$t_goods = $tablePreStr."goods";
$t_brand = $tablePreStr."brand";
$t_goods_types = $tablePreStr."goods_types";
$t_shop_category = $tablePreStr."shop_category";
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
$sql = "select * from `$t_goods` where shop_id='$shop_id'";
if($k && $k!=$m_langpackage->m_goods_keyword) {
	$sql .= " and goods_name like '%$k%' ";
}
if($ucat_id) {
	$sql .= " and ucat_id='$ucat_id' ";
}

$sql .= " order by sort_order asc,goods_id desc";

$result = $dbo->fetch_page($sql,10);
$rowset = get_shop_category_list($dbo,$t_shop_category,$shop_id);
$shop_category_info = array();
if($rowset) {
	foreach($rowset as $value) {
		$shop_category_info[$value['shop_cat_id']] = $value['shop_cat_name'];
	}
}

$typeinfo = get_goods_type($dbo,$t_goods_types);

$shop_category = get_shop_category_list($dbo,$t_shop_category,$shop_id);
$html_shop_category = html_format_shop_category($shop_category,$ucat_id);
?>