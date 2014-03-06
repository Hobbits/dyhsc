<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

//引入语言包
$i_langpackage=new indexlp;

require_once("foundation/asystem_info.php");

/* GET */
$user_id = intval(get_args('uid'));
$email_check_code = get_args('ucode');

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();

/* 定义文件表 */
$t_users = $tablePreStr."users";

if($user_id && $email_check_code) {
	$sql = "select email_check_code,email_check from `$t_users` where user_id='$user_id'";
	$row = $dbo->getRow($sql);
	if($row['email_check']) {
		echo '<script language="JavaScript">alert("'.$i_langpackage->i_email_check.'"); location.href="modules.php"</script>';
		exit;
	}else{
		if($row['email_check_code'] == $email_check_code){
			/* 数据库操作 */
			dbtarget('w',$dbServs);
			$dbo=new dbex();

			$sql = "update `$t_users` set email_check=1 where user_id='$user_id'";
			$dbo->exeUpdate($sql);

			echo '<script language="JavaScript">alert("'.$i_langpackage->i_pass_check.'"); location.href="modules.php"</script>';
			exit;
		}else{
			echo '<script language="JavaScript">alert("'.$i_langpackage->i_again_send.'"); location.href="modules.php?app=send_code"</script>';
			exit;
		}
	}
} else {
	echo '<script language="JavaScript">alert("'.$i_langpackage->i_check_url_error.'"); location.href="modules.php?app=reg2"</script>';
	exit;
}
?>