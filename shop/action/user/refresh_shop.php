<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

include("foundation/module_users.php");
require('foundation/module_shop.php');
$m_langpackage=new moduleslp;

//数据表定义区
$t_users = $tablePreStr."users";
$t_user_rank = $tablePreStr."user_rank";
$t_shop_info = $tablePreStr."shop_info";

//定义读操作
dbtarget('r',$dbServs);
$dbo=new dbex;
$sql="select * from $t_users where user_id=".get_sess_user_id();
$user_info=$dbo->getRow($sql);
if(empty($user_info)){
	action_return(0, $m_langpackage->m_usernot_exi,'login.php');
}
	$user_rank = get_userrank_info($dbo,$t_user_rank,$user_info['rank_id']);
	set_sess_rank_id($user_info['rank_id']);
	set_sess_rank_name($user_rank['rank_name']);
	set_sess_privilege($user_rank['privilege']);
	$sql = "select shop_id from $t_shop_info where user_id='".$user_info['user_id']."'";
	$shop_info = $dbo->getRow($sql);
	if($shop_info) {
		set_sess_shop_id($shop_info['shop_id']);
	}
	action_return(0, '刷新成功','modules.php');
?>