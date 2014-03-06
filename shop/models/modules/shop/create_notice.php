<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
if(isset($user_privilege[1])&&!$user_privilege[1]) {
	set_sess_err_msg($m_langpackage->m_error_createshop);
	echo '<script language="JavaScript">location.href="modules.php?app=message"</script>';
	exit;
}
?>