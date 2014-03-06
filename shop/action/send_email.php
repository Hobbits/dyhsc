<?php
	/*
	***********************************************
	*$ID:send_email
	*$NAME:send_email
	*$AUTHOR:E.T.Wei
	*DATE:Tue May 25 10:51:25 CST 2010
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		die('Hacking attempt');
	}
	//引入语言包
	$m_langpackage=new moduleslp;
	
	$user_id = intval(get_args("user_id"));
	$checkcode = get_args("code");
	
	if(!get_session("verifyCode")||strtolower(get_session('verifyCode'))!=strtolower($checkcode)){	
	    action_return(0,$m_langpackage->m_verifycode_error."！","modules.php?app=email_verify&user_id={$user_id}");
	}
	
	//文件引入
	require("foundation/module_users.php");
	require("foundation/csmtp.class.php");
	require("foundation/asystem_info.php");
	
	//数据表定义区
	$t_users = $tablePreStr."users";
	$t_user_info = $tablePreStr."user_info";
	$t_mailtpl = $tablePreStr."mailtpl";
	
	set_session('verifyCode',"");
	
	//读写分类定义方法
	$dbo = new dbex;
	dbtarget("r",$dbServs);
	$sql="SELECT user_name,user_email,email_check FROM $t_users WHERE user_id='{$user_id}'";
	$user_info = $dbo->getRow($sql);
	$user_info['email_check_code']=md5($user_info['user_name'].$ctime->time_stamp());
	$sql = "select * from `$t_mailtpl` where tpl_id=2";
	$mail_row = $dbo->getRow($sql);
	$arr1 = array('{user_name}','{site_name}','{baseUrl}','{user_id}','{email_check_code}');
	$arr2 = array($user_info['user_name'],$SYSINFO['sys_name'],$baseUrl,$user_id,$user_info['email_check_code']);
	$mailbody = str_replace($arr1,$arr2,$mail_row['tpl_content']);
	//修改数据库记录
	$sql = "UPDATE $t_users SET email_check_code='{$user_info['email_check_code']}' WHERE user_id = '{$user_id}'";
	if($dbo->exeUpdate($sql)){
		if($SYSINFO['email_send']=='true'&&$user_info['email_check']==0){
			$mailbody = iconv('UTF-8','GBK',$mailbody);
			$mailtitle = str_replace('{site_name}',$SYSINFO['sys_name'],$mail_row['tpl_title']);
			$mailtitle = iconv('UTF-8','GBK',$mailtitle);
			$smtp = new smtp($SYSINFO['sys_smtpserver'],$SYSINFO['sys_smtpserverport'],true,$SYSINFO['sys_smtpuser'],$SYSINFO['sys_smtppass']);
			if($smtp->sendmail($user_info['user_email'], $SYSINFO['sys_smtpusermail'], $mailtitle, $mailbody, 'HTML')){
				action_return(1,$m_langpackage->m_mail_send_succ."！","modules.php?app=email_verify&user_id={$user_id}");//发送成功
			}else{
				action_return(0,$m_langpackage->m_mail_config_error."！","modules.php?app=email_verify&user_id={$user_id}");
			}
		}else{
			action_return(0,$m_langpackage->m_mail_config_error."！","modules.php?app=email_verify&user_id={$user_id}");//邮件不支持此服务
		}
	}
?>