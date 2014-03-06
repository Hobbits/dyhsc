<?php
	/*
		-----------------------------------------
		文件：shipping_list.php。
		功能: 商铺发货单列表。
		日期：2010-11-23
		-----------------------------------------
	*/
	
	if(!$IWEB_SHOP_IN) {
		trigger_error('Hacking attempt');
	}

	//引入语言包
	$m_langpackage = new moduleslp;

	//数据表定义区
	$t_shipping_list = $tablePreStr."shipping_list";
	$t_users = $tablePreStr."users";
	
	//获取Post数据
	$start_time = short_check(get_args('start_time'));
	$end_time = short_check(get_args('end_time'));
	$shipping_no = short_check(get_args('shipping_no'));
	$consignee = short_check(get_args('consignee'));

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

	$sql = "select * from `$t_shipping_list` where shop_id='$user_id' ";
	if($shipping_no)
	{
		$sql .= " and shipping_no like '%$shipping_no%'";
	}
	if($consignee)
	{
		$sql .= " and consignee like '%$consignee%'";
	}
	if($start_time)
	{
		$sql .= " and add_date >= '$start_time'";
	}
	if($end_time)
	{
		$sql .= " and add_date <= '$end_time'";
	}
	$sql .= " order by add_date desc";

	$result = $dbo->fetch_page($sql,10);

?>