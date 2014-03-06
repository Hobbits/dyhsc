<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入公共方法

function insert_photo_info (&$dbo,$table,$insert_items){
	$item_sql = get_insert_item($insert_items);
	$sql = "insert `$table` $item_sql";
	if($dbo->exeUpdate($sql)) {
		return mysql_insert_id();
	} else {
		return false;
	}
}

function get_photo_info (&$dbo,$table,$photoid){
	$sql="select * from `$table` where id='$photoid' ";
	$v = $dbo->getRow($sql);
	return $v;
}
?>