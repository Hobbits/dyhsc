<?php

	/*
		-----------------------------------------
		文件：shipping_print.php。
		功能: 商铺发货单打印。
		日期：2010-11-24
		-----------------------------------------
	*/

	if(!$IWEB_SHOP_IN) {
		trigger_error('Hacking attempt');
	}
	
	//引入语言包
	$m_langpackage=new moduleslp;
	$i_langpackage=new indexlp;
	
	//引入文件
	require("foundation/module_order.php");
	
	//数据表定义区
	$t_shipping_list = $tablePreStr."shipping_list";
	$t_order_goods = $tablePreStr."order_goods";
	$t_users = $tablePreStr."users";
	$t_order_info = $tablePreStr."order_info";
	$t_goods = $tablePreStr."goods";
	$t_shop_info = $tablePreStr."shop_info";
	
	//获取Post数据
	$shipping_id = intval(get_args('shipping_id'));

	//读写分离定义方法
	$dbo = new dbex;
	dbtarget('r',$dbServs);

	//判断用户是否锁定，锁定则不许操作
	$sql ="select locked from $t_users where user_id=$user_id";
	$row = $dbo->getRow($sql);
	if($row['locked']==1){
		session_destroy();
		trigger_error($m_langpackage->m_user_locked);//非法操作
	}
	
	$sql = "select * from `$t_shipping_list` where shipping_id='$shipping_id'";
	$info = $dbo->getRow($sql);
	
	if(!$info)
		trigger_error("发货单不存在！");
	
	$order_info = get_order_info($dbo,$t_order_info,$t_order_goods,$t_goods,$t_shop_info,$info['order_id'],0,$user_id);
	
	if(!$order_info)
		trigger_error("没有该订单！");


?>