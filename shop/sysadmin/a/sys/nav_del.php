<?php
	/*
	***********************************************
	*$ID:
	*$NAME:
	*$AUTHOR:E.T.Wei
	*DATE:Mon Jun 21 11:31:05 CST 2010
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		die('Hacking attempt');
	}
	//文件引入
	require("../foundation/module_nav.php");
	//引入语言包
	$a_langpackage=new adminlp;
	//数据表定义区
	$t_nav = $tablePreStr."nav";
	//读写分类定义方法
	$dbo = new dbex;
	dbtarget("r",$dbServs);
	//权限管理
	$right=check_rights("nav_eidt");
	if(!$right){
		action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=nav_list');
	}
	$id = intval(get_args("nav_id"));
	$sql = "DELETE FROM $t_nav WHERE id='$id'";
	if ($dbo->exeUpdate($sql)) {
		action_return(1,$a_langpackage->a_handle_suc,'m.php?app=nav_list');
	}else{
		action_return(0,"$a_langpackage->a_operate_fail",'m.php?app=nav_list');
	}
?>