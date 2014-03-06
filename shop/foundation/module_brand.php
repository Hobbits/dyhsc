<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

function get_brand_info(&$dbo,$table) {
	$sql = "select * from `$table` where is_show=1";
	$result = $dbo->getRs($sql);
	$array = array();
	if($result) {
		foreach($result as $k=>$v) {
			$array[$v['brand_id']]['brand_id'] = $v['brand_id'];
			$array[$v['brand_id']]['brand_name'] = $v['brand_name'];
			$array[$v['brand_id']]['brand_logo'] = $v['brand_logo'];
			$array[$v['brand_id']]['brand_desc'] = $v['brand_desc'];
			$array[$v['brand_id']]['site_url'] = $v['site_url'];
		}
	}
	return $array;
}

function get_one_brand_info(&$dbo,$table,$brand_id) {
	$sql = "select * from `$table` where brand_id='$brand_id'";
	$result = $dbo->getRow($sql);
	return $result;
}

function update_brand_info(&$dbo,$table,$update_items,$brand_id) {
	$item_sql = get_update_item($update_items);
	$sql = "update `$table` set $item_sql where brand_id='$brand_id'";
	return $dbo->exeUpdate($sql);
}

function del_brand_info(&$dbo,$table,$id) {
	$sql = "delete from `$table` where brand_id='$id'";
	return $dbo->exeUpdate($sql);
}

function insert_brand_info(&$dbo,$table,$insert_items){
	$item_sql = get_insert_item($insert_items);
	$sql = "insert `$table` $item_sql";
	return $dbo->exeUpdate($sql);
}
/* 品牌列表 */
function get_brand_list(&$dbo,$table,$limit='',$page=''){
	if ($page){
		$sql = "select * from $table where is_show=1 and brand_logo!='' ORDER BY brand_id DESC";
		return $dbo->fetch_page($sql,$page);
	}else {
		$sql = "select * from $table where is_show=1 and brand_logo!='' ORDER BY brand_id DESC limit $limit";
		return $dbo->getRs($sql);
	}
}

?>