<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

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

/* POST */
$userpwd_id = intval(get_args('uid'));
$code = short_check(get_args('ucode'));

if(!$userpwd_id || !$code) {
	echo '<script language="JavaScript">alert("'.$m_langpackage->m_forgot_info.'"); location.href="modules.php"</script>';
	exit;
}

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();

/* 定义文件表 */
$t_users = $tablePreStr."users";

$sql = "select * from `$t_users` where user_id='$userpwd_id'";
$row = $dbo->getRow($sql);
if($row['forgot_check_code'] != $code) {
	echo '<script language="JavaScript">alert('.$m_langpackage->m_forgot_info.'); location.href="modules.php"</script>';
	exit;
}
?>