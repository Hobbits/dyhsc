<?php
	/*
	***********************************************
	*$ID:
	*$NAME:
	*$AUTHOR:E.T.Wei
	*DATE:Tue Mar 30 09:58:29 CST 2010
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		trigger_error("Hacking attempt");
	}
	//文件引入
	require("foundation/module_goods.php");
	require("foundation/module_areas.php");
	//引入语言包
	$m_langpackage=new moduleslp;
	$i_langpackage=new indexlp;
	//数据表定义区
	$t_goods_transport = $tablePreStr."goods_transport";
	$t_transport = $tablePreStr."transport";
	$t_areas = $tablePreStr."areas";
	//读写分类定义方法
	$dbo = new dbex;
	dbtarget('r',$dbServs);
	$area_list = get_area_list_bytype($dbo,$t_areas,1);
	//查询开启的配送方式
	$sql="select * from $t_transport where ifopen=1";
	$arr_list=$dbo->getRs($sql);
?>