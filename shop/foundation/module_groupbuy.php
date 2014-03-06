<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入公共方法
function get_groupbuy_info(&$dbo,$select_items,$table,$group_id) {
	$item_sql = get_select_item($select_items);
	$sql="select $item_sql from `$table` where group_id='$group_id'";
	return $dbo->getRow($sql);
}

function get_groupbuy_list(&$dbo,$select_items,$table,$shop_id) {
	$item_sql = get_select_item($select_items);
	$sql="select $item_sql from `$table` where shop_id='$shop_id'";
	return $dbo->getRs($sql);
}

function insert_groupbuy(&$dbo,$table,$insert_items){
	$item_sql = get_insert_item($insert_items);
	$sql = "insert into `$table` $item_sql ";
	$dbo->exeUpdate($sql);
	return mysql_insert_id();

}

function update_groupbuy_release(&$dbo,$table,$update_items,$group_id) {
	$item_sql = get_update_item($update_items);
	$sql = "update `$table` set $item_sql where group_id=$group_id";
	return $dbo->exeUpdate($sql);
}

function del_groupbuy(&$dbo,$table,$group_id) {
	$sql = "delete from `$table` where group_id=$group_id";
	return $dbo->exeUpdate($sql);
}

//===========================
function get_groupbuylog_list(&$dbo,$select_items,$table,$group_id) {
	$item_sql = get_select_item($select_items);
	$sql="select $item_sql from `$table` where group_id='$group_id'";
	return $dbo->getRs($sql);
}
/* 我的团购信息 */
function get_my_groupbuy(&$dbo,$t_groupbuy,$t_goods,$t_groupbuy_log,$t_shop_info,$user_id,$page){
	$sql="select a.*,b.*,c.*,d.lock_flg,d.open_flg from $t_groupbuy as a,$t_goods as b,$t_groupbuy_log as c,$t_shop_info as d where c.user_id=$user_id and c.group_id=a.group_id and a.goods_id=b.goods_id and b.shop_id=d.shop_id and a.group_condition ='0' and a.examine = '1'";
	return $dbo->fetch_page($sql,$page);
}
/* 团购列表信息 */

function get_groupbuy_lst(&$dbo,$t_groupbuy,$t_goods,$shop_id,$page){
	$sql="select a.*,b.* from $t_groupbuy as a,$t_goods as b where a.shop_id='$shop_id' and a.goods_id=b.goods_id  and a.group_condition ='0'";

	return $dbo->fetch_page($sql,10);
}
?>
