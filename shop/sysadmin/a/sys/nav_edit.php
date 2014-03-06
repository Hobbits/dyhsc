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
	$nav_name = short_check(get_args("nav_name"));
	$url = short_check(get_args("url"),1);
	$short_order = intval(get_args("short_order"));
	$type = intval(get_args("type"));
	if (empty($nav_name)||empty($url)) {
		action_return(0,$a_langpackage->a_param_error.'！','m.php?app=nav_list');
		exit;
	}
	
	$nav_info = array(
		"nav_name"=>$nav_name,
		"url"=>$url,
		"short_order"=>$short_order,
		"type"=>$type
	);
	$nav_id = $dbo->updatebyarr($nav_info,$t_nav,"id='$id'");
	if ($nav_id) {
		action_return(1,$a_langpackage->a_handle_suc."！",'m.php?app=nav_list');
	}else{
		action_return(0,$a_langpackage->a_operate_fail."！",'m.php?app=nav_list');
	}
?>