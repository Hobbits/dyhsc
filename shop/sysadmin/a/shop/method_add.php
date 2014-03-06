<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//语言包引入
$a_langpackage=new adminlp;

require_once("../foundation/module_remind.php");

//权限管理
$right=check_rights("shop_method_add");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}

$post['tran_name'] = short_check(get_args('tran_name'));
$post['content'] = short_check(get_args('content'));
$post['ifopen'] = 1;

//数据表定义
$t_transport = $tablePreStr."transport";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

if(insert_remind_info($dbo,$t_transport,$post)) {
	action_return(1,$a_langpackage->a_put_suc,'m.php?app=method_add');
} else {
	action_return(0,$a_langpackage->a_put_lose,'-1');
}
?>