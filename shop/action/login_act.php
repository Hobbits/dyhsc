<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
$m_langpackage=new moduleslp;
$user_email = short_check(get_args('user_email'),1); //用户名已经记录了
$user_passwd = short_check(get_args('user_passwd'),1); //密码已经记录了
//$remember = short_check(get_args('remember')); //是否记住密码
$user_passwd=md5($user_passwd);
if(empty($user_email)) {
	action_return(0, $m_langpackage->m_useremail_notnonoe,'-1');
}

if(!login_check($user_email)){
	action_return(0, $m_langpackage->m_inputtrue_useremail,'-1');
}

if(empty($user_passwd)){
	action_return(0, $m_langpackage->m_ppassword_notnone,'-1');
}

//if(strtolower(short_check(get_args('verifyCode'))) != strtolower(get_session('verifyCode'))) {
//	action_return(0, $m_langpackage->m_verifycode_error,'-1');
//}


include("foundation/module_users.php");
require('foundation/module_shop.php');
require_once("foundation/asystem_info.php");


//数据表定义区
$t_users = $tablePreStr."users";
$t_user_rank = $tablePreStr."user_rank";
$t_shop_info = $tablePreStr."shop_info";

$verifycode = unserialize($SYSINFO['verifycode']);
if($verifycode['1']==1){
	if(strtolower(short_check(get_args('veriCode'))) != strtolower(get_session('verifyCode'))) {
		action_return(0, $m_langpackage->m_verifycode_error,'-1');
		
	}
}

// 清空验证码值
set_session('verifyCode','');

//定义读操作
dbtarget('r',$dbServs);
$dbo=new dbex;

$sql="select * from $t_users where user_email='$user_email' or user_name='$user_email'";
$user_info=$dbo->getRow($sql);

if(empty($user_info)){
	action_return(0, $m_langpackage->m_usernot_exi,'-1');
}

if($user_passwd != $user_info['user_passwd']){
	action_return(0, $m_langpackage->m_inputerror_emailpassword,'-1');
}

if($user_info['locked']=='1') {
	action_return(0, $m_langpackage->m_youbelocked,'-1');
}

if($user_info['email_check']!='1'){
	action_return(1,"",'modules.php?app=email_verify&user_id='.$user_info['user_id']);
	exit;
}else{

	//设置cookie---------------------------------------------------------
	$name = $user_email;
	set_cookie('iweb_login',$name);

	set_sess_user_name($user_info['user_name']);
	set_sess_user_id($user_info['user_id']);
	set_sess_user_email($user_info['user_email']);
	set_sess_email_check($user_info['email_check']);
    //判断商铺是否关闭
	$rs = get_shop_info_item($dbo,array('open_flg'),$t_shop_info,$user_info['user_id']);
	set_session('shop_open',$rs['open_flg']); 
	//判断商铺是否锁定
	$rs = get_shop_info_item($dbo,array('lock_flg'),$t_shop_info,$user_info['user_id']);
	set_session('shop_lock',$rs['lock_flg']);
	$user_id = $user_info['user_id'];

	$url = get_args('url');
    
	$sql = "select shop_id from $t_shop_info where user_id='$user_id'";
	$shop_info = $dbo->getRow($sql);
   
	if($shop_info) {
		set_sess_shop_id($shop_info['shop_id']);
	}

	$user_rank = get_userrank_info($dbo,$t_user_rank,$user_info['rank_id']);

	set_sess_rank_id($user_info['rank_id']);
	set_sess_rank_name($user_rank['rank_name']);
	set_sess_privilege($user_rank['privilege']);

	//定义写操作
	dbtarget('w',$dbServs);
	$last_ip = $_SERVER['REMOTE_ADDR'];
	$sql="update $t_users set last_login_time=now(),last_ip='$last_ip' where user_id='$user_id'";
	$dbo->exeUpdate($sql);
	
	$outuserid=get_args('outuserid');
	if($outuserid!=0&&$outuserid!=$user_id){
		$url="";
	}


	if($user_info['email_check']) {
		if($im_enable) {
			echo "<script language='JavaScript'>location.href='iwebim.php'</script>";
		} else {
			if($url){
				header('Location: ' . $url);
			}
			echo "<script language='JavaScript'>location.href='modules.php'</script>";
		}
	} else {
		echo "<script language='JavaScript'>location.href='modules.php?app=reg2'</script>";
		if($im_enable) {
			echo "<script language='JavaScript'>location.href='iwebim.php'</script>";
		} else {
			if($url){
				header('Location: ' . $url);
			}
			echo "<script language='JavaScript'>location.href='modules.php'</script>";
		}
	}
}

?>