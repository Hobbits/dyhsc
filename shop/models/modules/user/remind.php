<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//require("foundation/module_remind.php");

//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

//数据表定义区
$t_remind = $tablePreStr."remind";
$t_remind_user = $tablePreStr."remind_user";
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
$sql="select * from $t_remind where enable=1 order by remind_type";
$remind_rs=$dbo->getRs($sql);

$sql="select * from $t_remind_user where user_id=$user_id";
$remind_user_rs=$dbo->getRs($sql);

$remind_user_arr=array();
foreach($remind_user_rs as $val){
	$remind_user_arr[$val['remind_id']]=$val;
}


$type=array(
	"1"=>$m_langpackage->m_buy_prompt,
	"2"=>$m_langpackage->m_sell_prompt,
);


?>