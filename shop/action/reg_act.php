<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//引入模块公共方法文件
include("foundation/module_users.php");
include("foundation/module_word.php");
require("foundation/csmtp.class.php");
require_once("foundation/asystem_info.php");
$m_langpackage=new moduleslp;
// 数据表定义区
$t_users = $tablePreStr."users";
$t_user_info = $tablePreStr."user_info";
$t_mailtpl = $tablePreStr."mailtpl";
$t_user_rank = $tablePreStr."user_rank";
$t_word= $tablePreStr."word";

dbtarget('r',$dbServs);
$dbo=new dbex();

$post['user_name'] = short_check(get_args('user_name'),1);
$post['user_email'] = short_check(get_args('user_email'),1);
$post['user_passwd'] = md5(short_check(get_args('user_password'),1));
//$post_info['user_truename'] = short_check(get_args('true_name'));
//$post_info['user_telphone'] = short_check(get_args('user_telphone'));
//$post_info['user_mobile'] = short_check(get_args('user_mobile'));
$user_repassword=md5(short_check(get_args('user_repassword'),1));

if($user_repassword!=$post['user_passwd']){
	action_return(0, $m_langpackage->m_password_notsame,'-1');
}
$verifycode = unserialize($SYSINFO['verifycode']);
if($verifycode['2']==1){
	if(strtolower(short_check(get_args('veriCode'))) != strtolower(get_session('verifyCode'))) {
		action_return(0, $m_langpackage->m_verifycode_error,'-1');
		
	}
}
//判断是否有敏感词
$sql="select * from $t_word";
$row = $dbo->getRs($sql);
if($row){
	foreach ($row as $v){
		if(stristr($post['user_name'],$v['word_name'])){
			action_return(0, $m_langpackage->m_rigst_no.$v['word_name'],'-1');
		}
	}
}
// 清空验证码值
set_session('verifyCode','');

if(preg_match("/[~|`|!|@|#|$|%|^|&|*|(|)|-|+|=|;|:|\"|'|<|,|>|.|\\/|?|\\\|\||\[|\{|\}|\]| ]/",$post['user_name'])){
    action_return(0,$m_langpackage->m_inputtrue_username,"-1");
}
if(empty($post['user_name'])) {
	action_return(0,$m_langpackage->m_username_notnone,"modules.php?app=reg&rmail=".$post['user_email']."&ruser=".$post['user_name']);
}
if(empty($post['user_email'])) {
	action_return(0,$m_langpackage->m_useremail_notnonoe,"modules.php?app=reg&rmail=".$post['user_email']."&ruser=".$post['user_name']);
}
if(!preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/",$post['user_email'])) {
	action_return(0,$m_langpackage->m_inputtrue_useremail,"modules.php?app=reg&rmail=".$post['user_email']."&ruser=".$post['user_name']);
}

dbtarget('r',$dbServs);
$dbo=new dbex();
$sql = "select user_id from `$t_users` where user_name='$post[user_name]' or user_email='$post[user_email]'";
$row = $dbo->getRow($sql);
$sql = "select * from `$t_mailtpl` where tpl_id=2";
$mail_row = $dbo->getRow($sql);

if($row) {
	action_return(0,$m_langpackage->m_usernameoremail_exied,"modules.php?app=reg&rmail=".$post['user_email']."&ruser=".$post['user_name']);
}

if(empty($post['user_passwd'])) {
	action_return(0,$m_langpackage->m_ppassword_notnone,"modules.php?app=reg&rmail=".$post['user_email']."&ruser=".$post['user_name']);
}

//if(empty($post_info['user_truename'])) {
//	action_return(0,$m_langpackage->m_truename_nonone,"-1");
//}

$post['reg_time'] = $ctime->long_time();
$post['email_check_code'] = md5($post['user_name'].$ctime->time_stamp());

///* 设置用户rank_id */
	$user_rank = get_userrank_info($dbo,$t_user_rank,2);
///*  */

dbtarget('w',$dbServs);
$dbo=new dbex();
if($SYSINFO['email_send']=='true'){
	$user_id = insert_user_info($dbo,$t_users,$post);
	$arr1 = array('{user_name}','{site_name}','{baseUrl}','{user_id}','{email_check_code}');
	$arr2 = array($post['user_name'],$SYSINFO['sys_name'],$baseUrl,$user_id,$post['email_check_code']);
	$mailbody = str_replace($arr1,$arr2,$mail_row['tpl_content']);
//	$mailbody = "亲爱的".$post['user_name']."，欢迎您成为".$SYSINFO['sys_name']."的一员，现在开始商城之旅。<br />
//	激活你的帐号请<a href='".$baseUrl."modules.php?app=reg3&uid=".$user_id."&ucode=".$post['email_check_code']."' target='_blank'>点击这里</a>， 如果无法点击，请将下列地址复制到地址栏进行激活。<br />
//	".$baseUrl."modules.php?app=reg3&uid=".$user_id."&ucode=".$post['email_check_code']."<br />
//	感谢对".$SYSINFO['sys_name']."的支持，再次希望您在".$SYSINFO['sys_name']."完成交易！<br /><br />
//	( 这是系统自动产生的邮件，请勿回复。) <br />";
	$mailbody = iconv('UTF-8','GBK',$mailbody);
	$mailtitle = str_replace('{site_name}',$SYSINFO['sys_name'],$mail_row['tpl_title']);
	$mailtitle = iconv('UTF-8','GBK',$mailtitle);
	$smtp = new smtp($SYSINFO['sys_smtpserver'],$SYSINFO['sys_smtpserverport'],true,$SYSINFO['sys_smtpuser'],$SYSINFO['sys_smtppass']);
	if($smtp->sendmail($post['user_email'], $SYSINFO['sys_smtpusermail'], $mailtitle, $mailbody, 'HTML')){
		if($user_id) {
			$post_info['user_id'] = $user_id;
			insert_user_info($dbo,$t_user_info,$post_info);
			echo "<script language='JavaScript'>location.href='modules.php?app=email_verify&user_id={$user_id}'</script>";
		} else {
			action_return(0,$m_langpackage->m_register_fail,"-1");
		}
	}else {
		 action_return(0,"发送邮箱验证失败,请重新发送或者联系管理员!","modules.php?app=reg");
	}
	exit;
}else{
	$user_id = insert_user_info($dbo,$t_users,$post);
	$post_info['user_id'] = $user_id;
	insert_user_info($dbo,$t_user_info,$post_info);
	$post_upd['email_check']='1';
	update_user_info($dbo,$t_users,$post_upd,$user_id);
	set_sess_user_name($post['user_name']);
	set_sess_user_id($post_info['user_id']);
	set_sess_user_email($post['user_email']);

	
	set_sess_rank_id(2);
	set_sess_rank_name($user_rank['rank_name']);
	set_sess_privilege($user_rank['privilege']);
	

	set_sess_email_check('0');
	echo "<script language='JavaScript'>location.href='modules.php'</script>";
}
?>