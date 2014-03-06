<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require_once("../foundation/module_users.php");
require_once("../foundation/module_admin_logs.php");
require_once("../foundation/module_remind.php");
//语言包引入
$a_langpackage=new adminlp;

//权限管理
$right=check_rights("user_update");
$shop_right=check_rights("shop_update");
if(!$right and !$shop_right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}

$post['email_check'] = intval(get_args('email_check'));
$post['locked'] = intval(get_args('locked_status'));
$post['rank_id'] = intval(get_args('rank_id'));
$post['user_email'] = short_check(get_args('user_email'));
if(get_args('password')) {
	$post['user_passwd'] = md5(get_args('password'));
}
$user_id = intval(get_args('user_id'));
if(!$user_id) { trigger_error($a_langpackage->a_error);}

//数据表定义区
$t_users = $tablePreStr."users";
$t_admin_log = $tablePreStr."admin_log";
$t_remind_info = $tablePreStr."remind_info";

//定义写操作
$dbo = new dbex;
dbtarget('w',$dbServs);

//查询$t_users表中的数据，与原数据对比，如果修改了，则发送站内消息给用户
$sql = "select * from `$t_users` where user_id=$user_id";
$rs = $dbo->getRow($sql);

if($rs){
	$nowtime = $ctime->long_time();
	if(intval(get_args('rank_id'))) {
		if($rs['rank_id']!=$post['rank_id']){
			$array = array(
				'user_id' => $user_id,
				'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_mem_level,
				'remind_time' => $nowtime,
			);
			insert_remind_info($dbo,$t_remind_info,$array);
		}
	}
	if(get_args('password')) {
		if($rs['user_passwd']!=md5($post['user_passwd'])){
			$array = array(
				'user_id' => $user_id,
				'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_mi_ti,
				'remind_time' => $nowtime,
			);
			insert_remind_info($dbo,$t_remind_info,$array);
		}
	}
}

if(update_user_info($dbo,$t_users,$post,$user_id)) {
	admin_log($dbo,$t_admin_log,$sn = $a_langpackage->a_modify_user_info);//'修改用户信息');
	action_return(1,$a_langpackage->a_amend_suc,'m.php?app=member_reinfo&id='.$user_id);
} else {
	action_return(0,$a_langpackage->a_amend_lose,'-1');
}
?>