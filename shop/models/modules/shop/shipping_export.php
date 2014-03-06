<?php

	/*
		-----------------------------------------
		文件：shipping_export.php。
		功能: 商铺发货单导出。
		日期：2010-11-11
		-----------------------------------------
	*/

	if(!$IWEB_SHOP_IN) {
		trigger_error('Hacking attempt');
	}
	
	//文件引入
	include_once("foundation/asystem_info.php");

	//引入语言包
	$m_langpackage=new moduleslp;
	$i_langpackage=new indexlp;

	//取得当前商铺的信息
	$shop_id = get_sess_shop_id();

?>