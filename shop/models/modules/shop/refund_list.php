<?php

	/*
		-----------------------------------------
		文件：refund_list.php。
		功能: 商铺退款单。
		日期：2010-11-23
		-----------------------------------------
	*/
	
	if(!$IWEB_SHOP_IN) {
		trigger_error('Hacking attempt');
	}

	//引入语言包
	$m_langpackage = new moduleslp;

	//获取Post数据
	$start_time = short_check(get_args('start_time'));
	$end_time = short_check(get_args('end_time'));
	$user_name = short_check(get_args('user_name'));
	$refund_account = short_check(get_args('refund_account'));

	//数据表定义区
	$t_refund_list = $tablePreStr."refund_list";
	$t_users = $tablePreStr."users";

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

	$sql = "select * from `$t_refund_list` where shop_id='$user_id'";
	if($refund_account)
	{
		$sql .= " and refund_account like '%$refund_account%'";
	}
	if($user_name)
	{
		$sql .= " and user_name like '%$user_name%'";
	}
	if($start_time)
	{
		$sql .= " and operator_date >= '$start_time'";
	}
	if($end_time)
	{
		$sql .= " and operator_date <= '$end_time'";
	}
	$sql .= " order by operator_date desc";
	$result = $dbo->fetch_page($sql,10);

?>