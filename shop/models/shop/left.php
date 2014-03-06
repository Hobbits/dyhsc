<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require_once("foundation/module_credit.php");

$t_credit = $tablePreStr."credit";
$t_integral = $tablePreStr."integral";
$t_user_rank = $tablePreStr."user_rank";
$t_users = $tablePreStr."users";



/* 处理商铺自定义分类 */
$category_list = get_shop_category_list($dbo,$t_shop_category,$shop_id);
$category_list_new = array();
if(!empty($category_list)) {
	foreach($category_list as $v) {
		$category_list_new[$v['shop_cat_id']]['shop_cat_id'] = $v['shop_cat_id'];
		$category_list_new[$v['shop_cat_id']]['shop_cat_name'] = $v['shop_cat_name'];
		$category_list_new[$v['shop_cat_id']]['parent_id'] = $v['parent_id'];
		$category_list_new[$v['shop_cat_id']]['shop_cat_unit'] = $v['shop_cat_unit'];
		$category_list_new[$v['shop_cat_id']]['sort_order'] = $v['sort_order'];
	}
}
unset($category_list);

	function get_sub_category ($category_list,$parent_id) {
		$array = array();
		foreach($category_list as $k=>$v) {
			if($v['parent_id']==$parent_id) {
				$array[$k] = $v;
			}
		}
		return $array;
	}

$sql="select b.rank_name from $t_users as a,$t_user_rank as b where a.user_id=$shop_id and a.rank_id=b.rank_id";
$rank_name=$dbo->getRow($sql);

//获取商家信用值
$credit=get_credit($dbo,$t_credit,$shop_id);
$credit['SUM(seller_credit)']=intval($credit['SUM(seller_credit)']);
$integral=get_integral($dbo,$t_integral,$credit['SUM(seller_credit)']);
if( $credit['SUM(seller_credit)'] < 0 )
	$credit['SUM(seller_credit)'] = 0;
$seller_credit = $credit['SUM(seller_credit)'];
$sql = "select * from `$t_integral` where $seller_credit>=int_min and $seller_credit <= int_max";
$credit_row = $dbo->getRow($sql);

//引入语言包
if(!isset($s_langpackage)){
	$s_langpackage=new shoplp;
}
?>