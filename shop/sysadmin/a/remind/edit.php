<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require_once("../foundation/module_news.php");
require_once("../foundation/module_admin_logs.php");
//语言包引入
$a_langpackage=new adminlp;

//权限管理
$right=check_rights("remind_edit");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}
/* post 数据处理 */
$nowtime = $ctime->long_time();
$remind_info = short_check(get_args('remind_info'));
$remind_time = $nowtime;
$rinfo_id = intval(get_args('rinfo_id'));
//数据表定义区
$t_remind_info = $tablePreStr."remind_info";
//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

$sql = "update $t_remind_info set remind_info='$remind_info',remind_time = '$remind_time' where rinfo_id = $rinfo_id";

if($dbo->exeUpdate($sql)) {
	action_return(1,$a_langpackage->a_edit_success,"m.php?app=message_list");
} else {
	action_return(0,$a_langpackage->a_operate_fail,'-1');
}
?>