<?php

	if(!$IWEB_SHOP_IN) {
		die('Hacking attempt');
	}
	//引入语言包
	$a_langpackage=new adminlp;
	//数据表定义区
	$t_word = $tablePreStr."word";
	//读写分类定义方法
	$dbo = new dbex;
	dbtarget("r",$dbServs);
	//权限管理
	$right=check_rights("word_del");
	if(!$right){
		action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=word_list');
	}
	$word_id=get_args('word_id');
	if($word_id){
		$id=implode(",", $word_id);
	}else{
		$id = intval(get_args('id'));
	}
	
	if(!$id) {
		action_return(0,$a_langpackage->a_error,'-1');
	}
	$sql = "DELETE FROM $t_word WHERE word_id in ($id)";
	if ($dbo->exeUpdate($sql)) {
		action_return(1,$a_langpackage->a_handle_suc,'m.php?app=word_list');
	}else{
		action_return(0,"$a_langpackage->a_operate_fail",'m.php?app=word_list');
	}
?>