<?php
//引入模块公共方法文件
include("foundation/module_users.php");

$t_users = $tablePreStr."users";
$t_user_open = $tablePreStr."openuser";
$t_shop_info = $tablePreStr."shop_info";
$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
$random = $_GET['random'];
//$random = '1373678818844.1624';
//定义读操作
dbtarget('r',$dbServs);
$dbo=new dbex;

$sql="select * from `$t_user_open` as o,`$t_users` as u where o.random = '$random' and o.user_id = u.user_id ";
$user_info=$dbo->getRow($sql);

$USER['userid'] = $user_info['user_id'];
$USER['username'] = $user_info['user_name'];
$USER['user_ico'] = $user_info['user_ico'];
set_session('userid',$USER['userid']);

$user_id = $user_info['user_id'];
$sql2 = "select shop_id from $t_shop_info where user_id='$user_id'";
$shop_info = $dbo->getRow($sql2);
 

if($shop_info) {
	$USER['shopid'] = $shop_info['shop_id'];
}

//定义写操作
	dbtarget('w',$dbServs);
	$last_ip = $_SERVER['REMOTE_ADDR'];
	$sql2="update $t_users set last_login_time=now(),last_ip='$last_ip' where user_id='$user_id'";
	$dbo->exeUpdate($sql2);
if ($USER['userid']){
	$re = new returnobj('ok',$USER,$chatnums);
	print_r($callback . '(' . json_encode( $re ) . ')');
	exit;
}else{
	$re = new returnobj('-1','登陆失败');
	print_r($callback . '(' . json_encode( $re ) . ')');
	exit;
}