<?php
	/*
	***********************************************
	*$ID:
	*$NAME:
	*$AUTHOR:E.T.Wei
	*DATE:Mon May 24 15:10:41 CST 2010
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		trigger_error('Hacking attempt');
	}
	$user_id = intval(get_args("user_id"));
	//文件引入
	require("foundation/module_users.php");
	require("foundation/csmtp.class.php");
	require("foundation/asystem_info.php");
	//引入语言包
	$m_langpackage=new moduleslp;
	$i_langpackage=new indexlp;

	if(get_sess_user_id()) {
		$USER['login'] = 1;
		$USER['user_name'] = get_sess_user_name();
		$USER['user_id'] = get_sess_user_id();
		$USER['user_email'] = get_sess_user_email();
		$USER['shop_id'] = get_sess_shop_id();
	} else {
		$USER['login'] = 0;
		$USER['user_name'] = '';
		$USER['user_id'] = '';
		$USER['user_email'] = '';
		$USER['shop_id'] = '';
	}

	//数据表定义区
	$t_users = $tablePreStr."users";
	$t_user_info = $tablePreStr."user_info";
	$t_mailtpl = $tablePreStr."mailtpl";
	//读写分类定义方法
	$dbo = new dbex;
	dbtarget("r",$dbServs);
	$sql =  "SELECT `user_name`,`user_email`,`locked`,`email_check`,`email_check_code` FROM `$t_users` WHERE user_id='$user_id'";
	$user_info = $dbo->getRow($sql);
	if($user_info['locked']||$user_info['email_check']){
		 echo"<script language=javascript>
			alert(\"".$m_langpackage->m_changeemail_error."！\");
			location.href = \"index.php\"
			</script>";
	}
?>