<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require_once("../foundation/module_brand.php");
require("../foundation/module_admin_logs.php");

//语言包引入
$a_langpackage=new adminlp;
//权限管理
$right=check_rights("flink_del");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}
/* get */
$value = intval(get_args('v'));
$brandid=get_args('brand_id');
if($brandid){
	$id=implode(",", $brandid);
}else{
	$id = intval(get_args('id'));
}
if(!$id) {
	action_return(0,$a_langpackage->a_error,'-1');
}
//数据表定义区
$t_brand = $tablePreStr."flink";
$t_admin_log = $tablePreStr."admin_log";
//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;
$sql = "delete from `$t_brand` where brand_id in($id)";
if($dbo->exeUpdate($sql)) {
	/** 添加log */
	$admin_log =$a_langpackage->a_del_flink;
	admin_log($dbo,$t_admin_log,$admin_log);

	action_return(1,$a_langpackage->a_del_suc,'-1');
} else {
	action_return(0,$a_langpackage->a_del_lose,'-1');
}
?>