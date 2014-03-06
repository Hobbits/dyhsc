<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require("../foundation/module_mailtpl.php");
require_once("../foundation/module_admin_logs.php");

//语言包引入
$a_langpackage=new adminlp;

$group_id = get_args('id');
$examine = short_check(get_args('examine'));
if($group_id){
	$group_id=implode(",", $group_id);
}else{
	$group_id = intval(get_args('group_id'));
}


//数据表定义区
$t_groupbuy = $tablePreStr."groupbuy";
$t_groupbuy_log = $tablePreStr."groupbuy_log";

//定义读操作
dbtarget('w',$dbServs);
$dbo=new dbex;

$sql="update $t_groupbuy set examine=$examine where group_id in($group_id)";
$upd=$dbo->exeUpdate($sql);

if($upd){
	action_return(1,$a_langpackage->a_upd_suc,'-1');
} else {
	action_return(0,$a_langpackage->a_upd_lose,'-1');
}

?>