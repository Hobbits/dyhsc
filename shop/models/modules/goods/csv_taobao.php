<?php
	/*
	***********************************************
	*$ID:csv_import
	*$NAME:csv_import
	*$AUTHOR:E.T.Wei
	*DATE:Wed Mar 24 13:58:49 CST 2010
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		trigger_error('Hacking attempt');
	}
	//文件引入
	require("foundation/module_goods.php");
	require("foundation/module_category.php");
	
	//引入语言包
	$m_langpackage=new moduleslp;
	$i_langpackage=new indexlp;
	//数据表定义区
    $t_category=$tablePreStr."category";
	//读写分类定义方法

	//获得店铺ID
	$shop_id = get_sess_shop_id();
	$dbo = new dbex;
	dbtarget("r",$dbServs);
	
	$catearr=get_sub_category($dbo,$t_category,'0');
?>