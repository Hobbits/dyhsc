<?php
	/*
	***********************************************
	*$ID:
	*$NAME:
	*$AUTHOR:E.T.Wei
	*DATE:Mon Jun 07 16:27:25 CST 2010
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		die('Hacking attempt');
	}
	$tag_key=get_args("tagkey");
	$tag=get_args("v");
	$str="";
	if (is_array($tag_key)) {
		foreach ($tag_key as $k=>$v){
			$tag_key[$k]=intval($v);
			$str.="$v,";
		}
		$str = substr($str,0,-1);
	}else{
		$str=$tag_key;
	}
	//文件引入
	include("../foundation/module_tag.php");
	//引入语言包
	$a_langpackage=new adminlp;
	//数据表定义区
	$t_tag = $tablePreStr."tag";
	$t_goods = $tablePreStr."goods";
	$tagcommend=intval(get_args('tagcommend'));
	$right_array=array(
		"tag_del"    =>   "0",
	    "tag_edit"    =>   "0",
	);
	foreach($right_array as $key => $value){
		$right_array[$key]=check_rights($key);
	}
	if (!$right_array['tag_del']) {
		trigger_error($a_langpackage->a_no_rights);
		//exit;
	}
	//读写分类定义方法
	$dbo = new dbex;
	dbtarget("w",$dbServs);
	if($tag==0){
			$sql="DELETE FROM $t_tag WHERE tag_id IN ($str)";
		}
	if($tag==1){
		$sql="update $t_tag set is_recommend=1 where tag_id IN ($str)";
	}
	if($tag==2){
		$sql="update $t_tag set is_recommend=0 where tag_id IN ($str)";
	}
	if ($dbo->exeUpdate($sql)) {
			action_return(1,$a_langpackage->a_handle_suc."！","m.php?app=tag_list");
	}else{
		action_return(0,$a_langpackage->a_operate_fail."！","m.php?app=tag_list");
	}

?>