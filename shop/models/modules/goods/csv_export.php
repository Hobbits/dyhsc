<?php
	/*
	***********************************************
	*$ID:
	*$NAME:
	*$AUTHOR:E.T.Wei
	*DATE:Wed Mar 24 08:57:03 CST 2010
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		trigger_error('Hacking attempt');
	}

	//文件引入
	include_once("foundation/asystem_info.php");
	include_once("foundation/module_goods.php");
	//引入语言包
	$m_langpackage=new moduleslp;
	$i_langpackage=new indexlp;
	//数据表定义区
	$g_tables = $tablePreStr."goods";
	//读写分类定义方法
	$dbo=new dbex;
	dbtarget('r',$dbServs);
	//取得当前用户的信息
	$shop_id = get_sess_shop_id();
	$goods_list = export_csv_info($dbo,$g_tables,$shop_id);
?>