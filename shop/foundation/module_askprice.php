<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
/* 收到的询价列表 */
function get_shop_askprice_list(&$dbo,$table,$shop_id,$page){
	$sql = "select * from `$table` where shop_id='$shop_id' and shop_del_status=1";
	$sql .= " order by add_time desc";
	return $dbo->fetch_page($sql,$page);
}
/* 删除收到的询价 */
function del_shop_askprice(&$dbo,$table,$iid,$shop_id){
	$sql = "update `$table` set shop_del_status=0 where iid in($iid) and shop_id='$shop_id'";
	return $dbo->exeUpdate($sql);
}
?>