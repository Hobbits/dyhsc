<?php

	/*
		-----------------------------------------
		文件：shipping_view.php。
		功能: 商铺发货单查看。
		日期：2010-11-23
		-----------------------------------------
	*/

	if(!$IWEB_SHOP_IN) {
		trigger_error('Hacking attempt');
	}
	
	//引入语言包
	$m_langpackage=new moduleslp;
	$i_langpackage=new indexlp;

	//数据表定义区
	$t_shipping_list = $tablePreStr."shipping_list";
	$t_users = $tablePreStr."users";
	
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



?>