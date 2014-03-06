<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

// require("../foundation/module_areas.php");
require_once("../foundation/module_admin_logs.php");
//语言包引入
$a_langpackage=new adminlp;

/* post 数据处理 */

$int_id = short_check(get_args('id'));

//数据表定义区
$t_integral = $tablePreStr."integral";
$t_admin_log = $tablePreStr."admin_log";
//权限管理
$credit_update=check_rights("credit_update");
if(!$credit_update){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}
//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

if(get_args('id')){
	$sql = "delete from `$t_integral` where int_id= $int_id ";
	$upd_suc=$dbo->exeUpdate($sql);
	if($upd_suc) {
		/** 添加log */
		$admin_log =$a_langpackage->a_integral_del_log;
		admin_log($dbo,$t_admin_log,$admin_log);
		action_return(1,$a_langpackage->a_del_suc,'-1');
	}else {
		action_return(0,$a_langpackage->a_del_lose,'-1');
	}

}
?>