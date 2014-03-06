<?php
	/*
	***********************************************
	*$ID:
	*$NAME:
	*$AUTHOR:E.T.Wei
	*DATE:Mon Mar 22 16:19:15 CST 2010
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		trigger_error('Hacking attempt');
	}

	//文件引入
	include_once("foundation/asystem_info.php");
	include_once("foundation/module_users.php");

	//引入语言包
	$m_langpackage=new moduleslp;
	//数据表定义区
	$user_table = $tablePreStr."users";
	$t_order_info = $tablePreStr."order_info";
	$t_shop_inquiry = $tablePreStr."shop_inquiry";
	$t_shop_guestbook = $tablePreStr."shop_guestbook";
	$t_shop_info = $tablePreStr."shop_info";
	$t_shop_request = $tablePreStr."shop_request";
	//读写分类定义方法
	$dbo=new dbex;
	dbtarget('r',$dbServs);
	$user_id = get_sess_user_id();
	$userinfo = get_user_info($dbo,$user_table,$user_id);
	$user_rank = $userinfo['rank_id'];
	/* 收到的询价 */
	$sql = "select shop_id from `$t_shop_inquiry` where shop_id='$user_id' and shop_del_status=1 and read_status=0";
	$rs = $dbo->getRs($sql);
	$shop_inquiry_num = 0;
	foreach($rs as $value) {
		$shop_inquiry_num++;
	}
	/* 收到的留言 */
	$sql = "SELECT shop_id FROM `$t_shop_guestbook` WHERE shop_id='$user_id' and shop_del_status=1 and read_status=0";
	$rs = $dbo->getRs($sql);
	$shop_guestbook_num = 0;
	foreach($rs as $value) {
		$shop_guestbook_num++;
	}
	/* 我的留言 */
	$sql = "SELECT shop_id FROM `$t_shop_guestbook` WHERE user_id='$user_id' and user_del_status=1";
	$rs = $dbo->getRs($sql);
	$my_guestbook_num = 0;
	foreach($rs as $value) {
		$my_guestbook_num++;
	}
	/* 我的,收到的订单 */
	$sql = "SELECT shop_id,user_id,order_status FROM `$t_order_info` WHERE (shop_id='$user_id' OR user_id='$user_id') and order_status>0";
	$rs = $dbo->getRs($sql);
	$my_order_num = 0;
	$get_order_num = 0;
	$u_order_num = 0;
	$s_order_num = 0;
	foreach($rs as $value) {
		if($value['shop_id']==$user_id) {
			if($value['order_status']=='3') {
				$u_order_num++;
			}else{
				$get_order_num++;
			}
		}
		if($value['user_id']==$user_id) {
			$my_order_num++;
			if($value['order_status']=='3') {
				$s_order_num++;
			}
		}
	}
	
		/* 提醒设置 */
	$sql = "SELECT shop_id FROM `$t_shop_info` WHERE user_id='$user_id'";
	$rs = $dbo->getRs($sql);
	$my_shop_info_num = 0;
	foreach($rs as $value) {
		$my_shop_info_num++;
	}
	$shop_open_flg = 0;
	$shop_lock_flg = 0;
	$shop_pass_flg = 0;
	$shop_exist_flg = 0;
	$sql = "select si.shop_id,si.lock_flg,si.open_flg,sr.status from $t_shop_info as si left join $t_shop_request sr on si.shop_id = sr.user_id where si.user_id='$user_id'";
	$row = $dbo->getRow($sql);
	 // print_r($row);
	if($row){
		$shop_exist_flg = 1;
		if($row["lock_flg"])
			$shop_lock_flg = $row["lock_flg"];
		if($row["open_flg"])
			$shop_open_flg = $row["open_flg"];
		if($row["status"] !=null && $row["status"] == 0)
			$shop_pass_flg = 0;
		else 
			$shop_pass_flg = 1;
	}
?>