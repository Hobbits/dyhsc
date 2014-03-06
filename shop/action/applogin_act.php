<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

$user_email = short_check(get_args('name'),1);

$user_passwd = short_check(get_args('psw'),1);
$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';

$user_passwd=md5($user_passwd);

include("foundation/module_users.php");
require('foundation/module_shop.php');



//数据表定义区
$t_users = $tablePreStr."users";
$t_user_rank = $tablePreStr."user_rank";
$t_shop_info = $tablePreStr."shop_info";


//定义读操作
dbtarget('r',$dbServs);
$dbo=new dbex;

$sql="select * from $t_users where user_email='$user_email' or user_name='$user_email'";
$user_info=$dbo->getRow($sql);

if(empty($user_info)){
	$result = '-1';
	echo $callback . '(' . json_encode( $result ) . ')';
	exit;
}

if($user_passwd != $user_info['user_passwd']){
	$result = '-2';
	echo $callback . '(' . json_encode( $result ) . ')';
	exit;
}

else{

	$USER['userid'] = $user_info['user_id'];
	$USER['username'] = $user_info['user_name'];
	$USER['password'] = short_check(get_args('psw'),1);
	set_session('userid',$USER['userid']);
	
	$user_id = $user_info['user_id'];
	$sql = "select shop_id from $t_shop_info where user_id='$user_id'";
	$shop_info = $dbo->getRow($sql);
	 
	
	if($shop_info) {
		$USER['shopid'] = $shop_info['shop_id'];
	}

	//定义写操作
	dbtarget('w',$dbServs);
	$last_ip = $_SERVER['REMOTE_ADDR'];
	$sql="update $t_users set last_login_time=now(),last_ip='$last_ip' where user_id='$user_id'";
	$dbo->exeUpdate($sql);


	echo $callback . '(' . json_encode( $USER ) . ')';
	exit;
}

?>
