<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require("alipay_notify.php");
require("alipay_service.php");

function get_code($orderinfo,$payinfo){
	// 获取支付配置信息
	global $baseUrl;
	$payment_info	= unserialize($payinfo['pay_config']);
	$partner        = $payment_info['partner'];
	$security_code  = $payment_info['security_code'];
	$seller_email   = $payment_info['seller_email'];
	$_input_charset = "utf-8";
	$sign_type      = "MD5";
	$transport      = "http";
	$notify_url     = $baseUrl."payrespond.php";
	$return_url     = $baseUrl."payrespond.php";
	$show_url       = $orderinfo['show_url'];
	unset($payinfo);
	unset($payment_info);
	
	$parameter = array(
		"service"        => "create_partner_trade_by_buyer",
		"partner"        => $partner,
		"return_url"     => $baseUrl."payrespond.php",
		"notify_url"     => $baseUrl."payrespond.php",
		"_input_charset" => $_input_charset,
		"subject"        => iconv("UTF-8", "GBK", $orderinfo['payid']),
	
		"body"           => $orderinfo['message'],
		"out_trade_no"   => $orderinfo['payid'],
		"price"          => $orderinfo['order_amount'],
		"payment_type"	 => "1",
		"quantity"       => "1",
	
		"logistics_fee"      =>'0.00',
		"logistics_payment"  =>'BUYER_PAY',
		"logistics_type"     =>'EXPRESS',
	
		"show_url"       => $show_url,
		"seller_email"   => $seller_email
	);
	
	$alipay = new alipay_service($parameter,$security_code,$sign_type);
	$link=$alipay->create_url();
	echo "<script>window.location =\"$link\";</script>";
}

function respond($orderinfo,$payinfo){
	
	global $baseUrl;
	//获取支付宝的反馈参数
	$dingdan   		 = get_args('out_trade_no');    //获取订单号
	$total_fee  	 = get_args('total_fee');       //获取总价格
	$receive_name    = get_args('receive_name');    //获取收货人姓名
	$receive_address = get_args('receive_address'); //获取收货人地址
	$receive_zip     = get_args('receive_zip');     //获取收货人邮编
	$receive_phone   = get_args('receive_phone');   //获取收货人电话
	$receive_mobile  = get_args('receive_mobile');  //获取收货人手机

	$payment_info 	= unserialize($payinfo['pay_config']);
	$partner        = $payment_info['partner'];
	$security_code  = $payment_info['security_code'];
	$seller_email   = $payment_info['seller_email'];
	$_input_charset = "utf-8";
	$sign_type      = "MD5";
	$transport      = "http";
	$notify_url     = $baseUrl."payrespond.php";
	$return_url     = $baseUrl."payrespond.php";
	$show_url       = $orderinfo['show_url'];
	unset($payinfo);
	unset($payment_info);
	
	if(isset($_POST['notify_id'])){
		
		$alipay = new alipay_notify($partner,$security_code,$sign_type,$_input_charset,$transport);
		$verify_result = $alipay->notify_verify();
		
	}else{
		
		$alipay = new alipay_notify($partner,$security_code,$sign_type,$_input_charset,$transport);
		$verify_result = $alipay->return_verify();
		
	}
	
	if($verify_result) {  //认证合格

		if(get_args('trade_status') == 'WAIT_SELLER_SEND_GOODS') {      //买家付款成功,等待卖家发货
	
			return 1;

		} else if(get_args('trade_status') == 'WAIT_BUYER_CONFIRM_GOODS') {    //卖家已经发货等待买家确认

			return 2;

		} else if(get_args('trade_status') == 'TRADE_FINISHED' || get_args('trade_status') == 'TRADE_SUCCESS') {	//交易成功结束
	
			return 3;

		} else {
			
			return 0;
			
		}
		
	}else{
		
		return 0;
		
	}
	
}
?>