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
	$t_word = $tablePreStr."word";
	//读写分类定义方法
	$dbo = new dbex;
	dbtarget("r",$dbServs);
	//权限管理
	$right=check_rights("word_add");
	if(!$right){
		action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=word_list');
	}
	$word_name = short_check(get_args("word_name"));
	$content = short_check(get_args("content"));
	$ctime = new time_class;
	$nav_info = array(
		"word_name"=>$word_name,
		"content"=>$content,
		"add_time"=>$ctime->long_time()
	);
	$word_id = $dbo->createbyarr($nav_info,$t_word);
	if ($word_id) {
		action_return(1,$a_langpackage->a_handle_suc,'m.php?app=word_list');
	}else{
		action_return(0,$a_langpackage->a_operate_fail,'m.php?app=word_list');
	}
?>