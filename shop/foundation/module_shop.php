<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入公共方法

function get_shop_info_item(&$dbo,$select_items,$table,$shop_id)
{
	$item_sql = get_select_item($select_items);
	$sql = "select $item_sql from `$table` where shop_id='$shop_id' ";
	return $dbo->getRsassoc($sql);
}

function get_shop_info(&$dbo,$table,$shop_id)
{
	return get_shop_info_item($dbo,'*',$table,$shop_id);
}


function update_shop_info(&$dbo,$table,$update_items,$shop_id) {
	$item_sql = get_update_item($update_items);
	$sql = "update `$table` set $item_sql where shop_id='$shop_id'";

	return $dbo->exeUpdate($sql);
}

function insert_shop_info(&$dbo,$table,$insert_items) {
	$item_sql = get_insert_item($insert_items);
	$sql = "insert `$table` $item_sql";
	return $dbo->exeUpdate($sql);
}

function get_shop_category_list(&$dbo,$table,$shop_id) {
	$sql = "select * from `$table` where shop_id='$shop_id' order by sort_order asc";
	return $dbo->getRs($sql);
}
/* 获取文章头部 */
function get_shop_header($head_index,$shop_arr){
	$header = array();
	$header['title'] = $head_index." - ".$shop_arr['shop_name'];
	$header['keywords'] = $shop_arr['shop_management'];
	$header['description'] = sub_str(strip_tags($shop_arr['shop_intro']),100);
	return $header;
}

/* 检查是否存在指定的域名 */
function check_shop_domain(&$dbo,$table,$shop_id,$shop_domain){
	$sql = "select count(shop_domain) from `$table` where shop_id!='$shop_id' and shop_domain='$shop_domain'";
	return $dbo->getRow($sql);
}

?>