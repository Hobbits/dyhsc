<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//语言包引入
$a_langpackage=new adminlp;

require_once("../foundation/module_remind.php");

$tranid = intval(get_args('tranid'));
//权限管理
$right=check_rights("shop_method_edit");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}

$post['tran_name'] = short_check(get_args('tran_name'));
$post['content'] = short_check(get_args('content'));

//数据表定义
$t_transport = $tablePreStr."transport";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

$item_sql = get_update_item($post);
$sql = "update `$t_transport` set $item_sql where tranid='$tranid'";
if($dbo->exeUpdate($sql)) {
	action_return(1,$a_langpackage->a_amend_suc,'m.php?app=method_edit&id='.$tranid);
} else {
	action_return(0,$a_langpackage->a_amend_lose,'-1');
}
?>