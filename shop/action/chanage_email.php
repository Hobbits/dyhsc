<?php
	/*
	***********************************************
	*$ID:chanage_email
	*$NAME:chanage_email
	*$AUTHOR:E.T.Wei
	*DATE:Tue May 25 10:51:25 CST 2010
	***********************************************
	*/
   
	
	if(!$IWEB_SHOP_IN) {
		trigger_error('Hacking attempt');
	}
	 //引入语言包
	$m_langpackage=new moduleslp;
	$user_id = intval(get_args("user_id"));
	if (!$user_id) {
		
		trigger_error($m_langpackage->m_select_user_error);//查无此人
	}
	$user_name = short_check(get_args("user_name"),1);
	$password = md5(short_check(get_args("user_password")));
	$user_email = short_check(get_args("user_email"),1);
	//文件引入
	require("foundation/module_users.php");
	require("foundation/csmtp.class.php");
	require("foundation/asystem_info.php");
	
	//数据表定义区
	$t_users = $tablePreStr."users";
	$t_user_info = $tablePreStr."user_info";
	$t_mailtpl = $tablePreStr."mailtpl";
	//读写分类定义方法
	$dbo = new dbex;
	dbtarget("r",$dbServs);
	$sql = "SELECT user_id FROM $t_users WHERE user_email='$user_email'";
	$user_info = $dbo->getRow($sql);
	if (isset($user_info['user_id'])) {
		$errorurl=$m_langpackage->m_mail_use;//邮箱被占用
		trigger_error($errorurl);
	}
	$sql="SELECT user_name,user_email,email_check,locked FROM $t_users WHERE user_id='{$user_id}' AND user_name='$user_name' AND user_passwd='$password'";
	$user_info = $dbo->getRow($sql);
	if (!is_array($user_info)) {
		$errorurl=$m_langpackage->m_enter_info;//输入信息错误
		trigger_error($errorurl);
	}
	if ($user_info['locked']) {
		$errorurl=$m_langpackage->m_user_locked;//被锁定
		trigger_error($errorurl);
	}
	$user_info['email_check_code']=md5($user_info['user_name'].$ctime->time_stamp());
	$sql = "select * from `$t_mailtpl` where tpl_id=2";
	$mail_row = $dbo->getRow($sql);
	$arr1 = array('{user_name}','{site_name}','{baseUrl}','{user_id}','{email_check_code}');
	$arr2 = array($user_info['user_name'],$SYSINFO['sys_name'],$baseUrl,$user_id,$user_info['email_check_code']);
	$mailbody = str_replace($arr1,$arr2,$mail_row['tpl_content']);
	//修改数据库记录
	$sql = "UPDATE $t_users SET user_email='$user_email',email_check_code='{$user_info['email_check_code']}' WHERE user_id = '{$user_id}'";
	if($dbo->exeUpdate($sql)){
		if($SYSINFO['email_send']=='true'&&$user_info['email_check']==0){
			$mailbody = iconv('UTF-8','GBK',$mailbody);
			$mailtitle = str_replace('{site_name}',$SYSINFO['sys_name'],$mail_row['tpl_title']);
			$mailtitle = iconv('UTF-8','GBK',$mailtitle);
			$smtp = new smtp($SYSINFO['sys_smtpserver'],$SYSINFO['sys_smtpserverport'],true,$SYSINFO['sys_smtpuser'],$SYSINFO['sys_smtppass']);
			if($smtp->sendmail($user_email, $SYSINFO['sys_smtpusermail'], $mailtitle, $mailbody, 'HTML')){
				action_return(1,$m_langpackage->m_mail_send_succ."！","modules.php?app=email_verify&user_id={$user_id}");
			}else{
				action_return(0,$m_langpackage->m_mail_config_error."！","modules.php?app=email_verify&user_id={$user_id}");
			}
		}else{
			action_return(0,$m_langpackage->m_mail_config_error."！","modules.php?app=email_verify&user_id={$user_id}");
		}
	}
?>