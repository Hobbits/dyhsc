<?php

	/*
		-----------------------------------------
		文件：receiv_list.php。
		功能: 商铺收款单。
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
	$payid = short_check(get_args('payid'));

	//数据表定义区
	$t_receiv_list = $tablePreStr."receiv_list";
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

	$sql = "select * from `$t_receiv_list` where shop_id='$user_id'";
	if($payid)
	{
		$sql .= " and payid like '%$payid%'";
	}
	if($user_name)
	{
		$sql .= " and receiver like '%$user_name%'";
	}
	if($start_time)
	{
		$sql .= " and receiv_date >= '$start_time'";
	}
	if($end_time)
	{
		$sql .= " and receiv_date <= '$end_time'";
	}
	$sql .= " order by receiv_date desc";
	$result = $dbo->fetch_page($sql,10);

?>