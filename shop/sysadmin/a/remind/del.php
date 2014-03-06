<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require_once("../foundation/module_news.php");
require_once("../foundation/module_admin_logs.php");
//语言包引入
$a_langpackage=new adminlp;

//权限管理
$right=check_rights("remind_del");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');	
}
/* get */
$id=intval(get_args('id'));
if(!$id) {
	action_return(0,$a_langpackage->a_error,'-1');
}

//数据表定义区
$t_remind_info = $tablePreStr."remind_info";
//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

$sql = "delete from `$t_remind_info` where rinfo_id = $id";

if($dbo->exeUpdate($sql)) {
	action_return(1,$a_langpackage->a_del_suc,"m.php?app=message_list");
} else {
	action_return(0,$a_langpackage->a_del_lose,'-1');
}
?>