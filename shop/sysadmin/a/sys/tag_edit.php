<?php
	/*
	***********************************************
	*$ID:
	*$NAME:
	*$AUTHOR:E.T.Wei
	*DATE:Mon Jun 07 15:27:29 CST 2010
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		die('Hacking attempt');
	}
	$tag_id = intval(get_args("tag_id"));

	if (!$tag_id) {
		exit("非法请求！");
	}
	$tag_info['tag_name'] = short_check(get_args("tag_name"));
	$tag_info['is_blod'] = intval(get_args("is_blod"));
	$tag_info['tag_color'] = get_args("tag_color");
	$tag_info['short_order'] = intval(get_args("short_order"));
	//文件引入
	include("../foundation/module_tag.php");
	//引入语言包
	$a_langpackage=new adminlp;
	//数据表定义区
	$t_tag = $tablePreStr."tag";
	$t_goods = $tablePreStr."goods";
	$right_array=array(
		"tag_del"    =>   "0",
	    "tag_edit"    =>   "0",
	);
	foreach($right_array as $key => $value){
		$right_array[$key]=check_rights($key);
	}
	if (!$right_array['tag_edit']) {
		trigger_error($a_langpackage->a_no_rights);
	//	exit;
	}
	//读写分类定义方法
	$dbo = new dbex;
	dbtarget("w",$dbServs);

	$tag_update = update_tag_info($dbo,$t_tag,$tag_info,$tag_id);

	if($tag_update){
		action_return(1,$a_langpackage->a_upd_suc,"m.php?app=tag_list");
	}else{
		action_return(1,$a_langpackage->a_upd_lose,"m.php?app=tag_list");
	}

?>