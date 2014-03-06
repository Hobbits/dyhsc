<?php
header("content-type:text/html;charset=utf-8");
$IWEB_SHOP_IN = true;

require('foundation/asession.php');
require('configuration.php');
require('includes.php');

$user_id = get_sess_user_id();
$user_name = get_sess_user_name();

/* 判断用户是否登陆 */
if(!$user_id) {
	echo '<script>location.href="login.php"</script>';
	exit;
}

require("foundation/module_order.php");
require("foundation/module_users.php");
require("foundation/module_payment.php");

//引入语言包
$m_langpackage=new moduleslp;

$order_id = short_check(get_args('order_id'));
$pay_id = short_check(get_args('pay_id'));
$shop_id = short_check(get_args('shop_id'));
$action = short_check(get_args("action"));
if(!$order_id) { exit("非法操作"); }
if(!$pay_id) { exit("非法操作"); }

$t_shop_payment=$tablePreStr."shop_payment";
$t_order_info=$tablePreStr."order_info";
$t_payment=$tablePreStr."payment";
$t_order_goods = $tablePreStr."order_goods";
$t_goods = $tablePreStr."goods";
$t_shop_info = $tablePreStr."shop_info";

$nowtime = $ctime->long_time();
$dbo=new dbex;
//读写分离定义方法
dbtarget('r',$dbServs);
$pay_info = get_one_shopandpayment($dbo,$t_shop_payment,$t_payment,$shop_id,$pay_id);
if($pay_info['enabled']=='0'){
	 trigger_error("非法操作！");
}
if($pay_id=='4'||$pay_id=='5'){
	require("payment/".$pay_info['pay_code']."/".$pay_info['pay_code'].".php");
	exit;
}
if($action == 'money_append'){  //用户充值
	$info = get_user_account($dbo,$t_user_account,$order_id);
	//print_r($info);
	$order_info['message']		= $info['user_note'];
	$order_info['payid'] 		= rand(1000,9999).str_pad($info['account_id'],6,'0','str_pad_left');
	$order_info['order_amount'] = $info['money_num'];
	$order_info['show_url'] 	= $baseUrl."modules.php?app=user_money";

	require("payment/".$pay_info['pay_code']."/".$pay_info['pay_code'].".php");
	$update['pay_id'] = $pay_id;
	$update['tempcode'] = $order_info['payid'];
	if(update_user_account($dbo,$t_user_account,$update,$info['account_id'])){
		get_code($order_info,$pay_info);
	}
	//print_r($order_info);
	exit;
}else{	
	//订单付款
	$order_info = get_order_info($dbo,$t_order_info,$t_order_goods,$t_goods,$t_shop_info,$order_id,$user_id);
	$order_info['show_url'] = $baseUrl."modules.php?app=user_order_view&order_id=".$order_info['order_id'];
	require("payment/".$pay_info['pay_code']."/".$pay_info['pay_code'].".php");
	
	$update['pay_id'] = $pay_id;
	$update['pay_time'] = $nowtime;
	$order_info['order_amount'] = $order_info['order_value'];
	if(upd_order_info($dbo,$t_order_info,$update,$order_id)){
		get_code($order_info,$pay_info);
	}
}
?>