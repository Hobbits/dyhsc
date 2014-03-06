<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require("foundation/acheck_shop_creat.php");
require("foundation/module_category.php");
require("foundation/module_goods.php");
require("foundation/module_shop.php");

//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
 if(get_session('shop_open')!=null&&get_session('shop_open')==1){
 	trigger_error("店铺已关闭，请开启后添加!");
 }
//数据表定义区
$t_shop_category = $tablePreStr."shop_category";
$t_groupbuy = $tablePreStr."groupbuy";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

$sql="select count(*) from $t_groupbuy where shop_id=$shop_id";
$num=$dbo->getRow($sql);


$goods_info = array(
	'goods_name'	=> '',
	'cat_id'		=> 0,
	'ucat_id'		=> 0,
	'goods_intro'	=> '',
	'goods_number'	=> 99,
	'keyword'		=> '',
	'goods_price'	=> '0.00',
	'is_on_sale'	=> 1,
	'is_best'		=> 0,
	'is_new'		=> 0,
	'is_hot'		=> 0,
	'is_promote'	=> 0,
	'goods_wholesale'=> '',
	'transport_price'=> '0.00'
);

$shop_category = get_shop_category_list($dbo,$t_shop_category,$shop_id);
$html_shop_category = html_format_shop_category($shop_category,$goods_info['ucat_id']);


?>