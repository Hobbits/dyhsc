<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//语言包引入
$m_langpackage=new moduleslp;
require("foundation/module_category.php");

/* post 数据处理 */
$post['shop_cat_name'] = short_check(get_args('shop_cat_name'));
$post['parent_id'] = intval(get_args('parent_id'));
$post['shop_cat_unit'] = short_check(get_args('shop_cat_unit'));
$post['sort_order'] = intval(get_args('sort_order'));
$post['shop_id'] = $shop_id;

if(empty($post['shop_cat_name'])) {
	action_return(0,$m_langpackage->m_shopcatname_notnone,'-1');
	exit;
}

//数据表定义区
$t_shop_category = $tablePreStr."shop_category";
//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

$count = count_category_bycatname($dbo,$t_shop_category,0,$post['shop_cat_name'],$post['shop_id'],$post['parent_id']);
if($count > 0)
	action_return(0,$m_langpackage->m_category_exits,'-1','/modules.php?app=shop_category_add');
$item_sql = get_insert_item($post);
$sql = "insert `$t_shop_category` $item_sql";
if($dbo->exeUpdate($sql)) {
	action_return(1,$m_langpackage->m_add_success);
} else {
	action_return(0,$m_langpackage->m_add_fail,'-1');
}
?>