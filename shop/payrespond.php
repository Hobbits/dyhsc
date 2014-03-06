<?php
header("content-type:text/html;charset=utf-8");
$IWEB_SHOP_IN = true;

require('foundation/asession.php');
require('configuration.php');
require('includes.php');
require("foundation/module_order.php");
require("foundation/module_users.php");
require("foundation/module_payment.php");
require("foundation/module_goods.php");

$user_id = get_sess_user_id();
$user_name = get_sess_user_name();

//引入语言包
$m_langpackage=new moduleslp;



$t_shop_payment=$tablePreStr."shop_payment";
$t_order_info=$tablePreStr."order_info";
$t_payment=$tablePreStr."payment";




//取得返回的订单号
$pay_code = get_payment_code();
if(!$pay_code){
	exit("非法请求");
}
$dbo=new dbex;
//读写分离定义方法
dbtarget('r',$dbServs);
if(strlen($pay_code) != 16){	//用户充值
	$account_id = intval(substr($pay_code,4));
	$info = get_user_account($dbo,$t_user_account,$account_id);
	$pay_info = get_one_shopandpayment($dbo,$t_shop_payment,$t_payment,$shop_id,$info['pay_id']);
	$order_info['message'] 		= $info['user_note'];
	$order_info['payid']		= $info['tempcode'];
	$order_info['order_amount'] = $info['money_num'];
	$order_info['show_url'] 	= $baseUrl."modules.php?app=user_money";

	if(!$order_info or !$pay_info){
		exit($m_langpackage->m_order_info_not_right);
	}else{
		require("payment/".$pay_info['pay_code']."/".$pay_info['pay_code'].".php");
		$result = respond($order_info,$pay_info);
		if($result == 1){		//买家付款成功
			dbtarget('w',$dbServs);
			if($info['is_verify'] == 0){
				$sql = "update `$t_users` set user_money = user_money+$info[money_num] where user_id = $info[user_id] ";
				$dbo->exeUpdate($sql);
			}

			$verify_time = $ctime->long_time();
			$sql = "update `$t_user_account` set is_verify=1,verify_time='$verify_time' where account_id='".$info['account_id']."'";
			$dbo->exeUpdate($sql);

			echo $m_langpackage->m_pay_success."！<a href=\"".$baseUrl."modules.php?app=user_my_order\">$m_langpackage->m_click_to_money</a>";
		}else if($result == 0){	//交易失败
			echo $m_langpackage->m_pay_lose."！<a href=\"".$baseUrl."modules.php?app=user_money\">$m_langpackage->m_click_to_money</a>";
		}
	}
}else{							//订单付款
	$order_info = get_order_info_bypayid($dbo,$t_order_info,$pay_code);
	$pay_info = get_one_shopandpayment($dbo,$t_shop_payment,$t_payment,$order_info['shop_id'],$order_info['pay_id']);
	$order_info['show_url'] = $baseUrl."modules.php?app=user_order_view&order_id=".$order_info['order_id'];

	if(!$order_info or !$pay_info){
		exit($m_langpackage->m_order_info_not_right);
	}else{

		require("payment/".$pay_info['pay_code']."/".$pay_info['pay_code'].".php");

		$result = respond($order_info,$pay_info);
		if($result == 1){		//买家付款成功

			//获取赠送的积分
//			$order_goods = get_order_goods($dbo,$t_order_goods,$order_info['order_id']);
//			$goods_id = get_arr_goods_id($order_goods);
//			$coin = get_goods_coin($dbo,$t_goods,$goods_id);
			if($order_info['pay_status']==0){
				dbtarget('w',$dbServs);
				$pay_time = $ctime->long_time();
				$sql = "update `$t_order_info` set pay_status=1,pay_time='$pay_time' where payid='".$order_info['payid']."'";
				$dbo->exeUpdate($sql);

//				foreach($coin as $value){
//					$sql = "update `$t_users` set points = points+$value[points],coin = coin+$value[coin] where user_id = $order_info[user_id]";
//					$dbo->exeUpdate($sql);
//				}
			}
			echo "支付成功.！<a href=\"".$baseUrl."modules.php?app=user_my_order\">支付成功</a>";

		}else if($result == 2){	//卖家发货成功

			dbtarget('w',$dbServs);
			$shipping_time = $ctime->long_time();
			$sql = "update `$t_order_info` set transport_status=1,shipping_time='$shipping_time' where payid='".$order_info['payid']."'";
			$dbo->exeUpdate($sql);

		}else if($result == 3){	//买家收货确认，交易成功

			dbtarget('w',$dbServs);
			$receive_time = $ctime->long_time();
			$sql = "update `$t_order_info` set order_status=3,receive_time='$receive_time' where payid='".$order_info['payid']."'";
			$dbo->exeUpdate($sql);

		}else if($result == 0){	//交易失败
			echo "支付失败！<a href=\"".$baseUrl."modules.php?app=user_my_order\">支付失败</a>";
		}

	}
}

function get_payment_code(){
	$code_arr = array('out_trade_no','sp_billno','v_oid','c_order','orderId','balance_id');
	foreach($code_arr as $value){
		if(get_args($value)){
			return get_args($value);
		}
	}
}
?>