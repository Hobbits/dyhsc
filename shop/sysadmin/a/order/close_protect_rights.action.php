<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require_once("../foundation/module_admin_logs.php");

/* post 数据处理 */
$pid = intval(get_args('pid'));
$order_id = intval(get_args('order_id'));

if(!$pid) {
	exit();
}

if(!$order_id) {
	exit();
}

//数据表定义区
$t_protect_rights = $tablePreStr."protect_rights";
$t_order_info = $tablePreStr."order_info";
$t_admin_log = $tablePreStr."admin_log";

//定义写操作
dbtarget('w',$dbServs);
$dbo = new dbex;

//语言包引入
$a_langpackage=new adminlp;

$sql = "update `$t_order_info` set protect_status = 3 where order_id = $order_id ";

if($dbo->exeUpdate($sql)) {
	/** 添加log */
	$admin_log = "结束维权";
	admin_log($dbo,$t_admin_log,$admin_log);
	
	$sql = "update `$t_protect_rights` set status = 3 where pid = $pid ";
	$dbo->exeUpdate($sql);
	
	action_return(1,"结束维权成功！","-1");
} else {
	action_return(1,"结束维权失败！","-1");
}
exit;
?>