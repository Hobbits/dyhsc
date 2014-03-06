<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

$t_users = $tablePreStr."users";

//定义读操作
dbtarget('r',$dbServs);
$dbo=new dbex;
//判断用户是否锁定，锁定则不许操作
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	trigger_error($m_langpackage->m_user_locked);//非法操作
}
?>