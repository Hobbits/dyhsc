<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
function get_code($orderinfo,$payinfo){
	// 获取支付配置信息
	global $baseUrl;
	$payment_info	= unserialize($payinfo['pay_config']);
	$s_pass		= $payment_info['key'];
	$s_srcStr = MD5($s_pass);
	unset($payinfo);
	unset($payment_info);
	header('Location: payrespond.php?balance_id='.$orderinfo['payid'].'&srcstr='.$s_srcStr);
	
}

function respond($orderinfo,$payinfo){
	global $baseUrl;
	global $dbServs;
	$srcstr		= get_args('srcstr');
	$payment_info	= unserialize($payinfo['pay_config']);
	$r_pass		= $payment_info['key'];
	$r_srcstr = MD5($r_pass);
	global $tablePreStr;
	$userid=get_sess_user_id();
if($r_srcstr == $srcstr){
	if($userid) {
		dbtarget('r',$dbServs);
		$dbo=new dbex();
		/* 处理系统分类 */
		$t_users = $tablePreStr."users";
		$sql_users = "select user_money from `$t_users` where `user_id` =".$orderinfo['user_id']." limit 1";
		$user_info = $dbo->getRow($sql_users);
		if($userid==$orderinfo['user_id'] && $user_info['user_money']>=$orderinfo['order_amount']){
			$result=$user_info['user_money']-$orderinfo['order_amount'];
			dbtarget('w',$dbServs);
			$dbo=new dbex();
			$sql="UPDATE `ishop_users` SET `user_money` = ".$result." WHERE `user_id` =".$orderinfo['user_id']." LIMIT 1";
			if($dbo->exeUpdate($sql)){
				return 1;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}else{
			return 0;
	}
	}
}
?>