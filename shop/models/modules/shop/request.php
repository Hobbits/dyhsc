<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

//数据表定义区
$t_shop_request = $tablePreStr."shop_request";
$t_shop_info = $tablePreStr."shop_info";

//读写分离定义方法
$dbo=new dbex;
dbtarget('r',$dbServs);

$sql = "select * from `$t_shop_request` where user_id='$user_id'";
$shopsql="select * from `$t_shop_info` where user_id='$user_id'";

$request_info = $dbo->getRow($sql);
$shop_info = $dbo->getRow($shopsql);
$privilege=get_sess_privilege();
if($privilege) {
	$user_privilege = unserialize($privilege);
}

if($request_info&&$request_info['status']=='0'&&$shop_info){
	echo '<script language="JavaScript">location.href="modules.php?app=shop_message&status=0"</script>';
	exit;
}
if($request_info&&$request_info['status']=='1'&&$shop_info){
	echo '<script language="JavaScript">location.href="modules.php?app=shop_message&status=1"</script>';
	exit;
}

?>