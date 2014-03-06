<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//require("foundation/module_remind.php");

//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

//数据表定义区
$t_remind_info = $tablePreStr."remind_info";
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
$sql="select * from $t_remind_info where user_id=$user_id or user_id=0 order by remind_time desc";
$remind_rs=$dbo->getRs($sql);

//print_r($remind_rs);

$type=array(
	"0"=>$m_langpackage->m_unread,
	"1"=>$m_langpackage->m_read,
	"2"=>$m_langpackage->m_admin_unread,
);

?>