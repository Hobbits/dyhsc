<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//引入公共方法

function get_guestbook_info(&$dbo,$table,$user_id,$page){
	$sql = "select * from `$table` where user_id='$user_id' and user_del_status=1";
	$sql .= " order by add_time desc";
	return $dbo->fetch_page($sql,$page);
}
function del_guestbook(&$dbo,$table,$gid,$user_id){
	$sql = "update `$table` set user_del_status=0 where gid in($gid) and user_id='$user_id'";
	return $dbo->exeUpdate($sql);
}
function shop_guestbook_list(&$dbo,$table,$shop_id,$page,$state){
	$str="";
	if(!empty($state)){
		if($state==1){
			$str=" and read_status=0 ";
		}
	}
	$sql = "select * from `$table` where shop_id='$shop_id' and shop_del_status=1";
	$sql = $sql.$str." order by add_time desc";
	return $dbo->fetch_page($sql,$page);
}
/* 标为已读 */
function edit_shop_guestbook(&$dbo,$table,$gid,$status){
	$sql = "update `$table` set read_status ='$status' where gid = $gid ";
	return $dbo->exeUpdate($sql);
}
/* del 收到的留言 */
function del_shop_guestbook(&$dbo,$table,$gid,$shop_id){
	$sql = "update `$table` set shop_del_status=0 where gid in($gid) and shop_id='$shop_id'";
	return $dbo->exeUpdate($sql);
}
?>