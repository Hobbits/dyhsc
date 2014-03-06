<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

/********************************************
'文件名：SendOrder.php
'主要功能：该示范程序主要完成将商户订单信息提交至云网支付网关的功能
'版本：v1.1（Build2006-4-19）
'描述：假设商户的订单系统都已完成，本页面主要是帮助商户按照云网支付网关要求的格式将订单信息提交至云网支付@网的支付接口，进行支付操作
'版权所有：北京云网无限网络技术有限公司
'技术支持联系方式：86-010-84853768/69 转技术部
'*******************************************/

function get_code($orderinfo,$payinfo){
	// 获取支付配置信息
	global $baseUrl;
	$payment_info	= unserialize($payinfo['pay_config']);

	$c_mid		= $payment_info['cncard_id'];						//商户编号，在申请商户成功后即可获得，可以在申请商户成功的邮件中获取该编号

	$c_order	= $orderinfo['payid'];					    //商户网站依照订单号规则生成的订单号，不能重复
	$c_name		= '';						//商户订单中的收货人姓名
	$c_address	= '';				//商户订单中的收货人地址
	$c_tel		= $orderinfo['telphone'];				//商户订单中的收货人电话
	$c_post		= $orderinfo['zipcode'];						//商户订单中的收货人邮编
	$c_email	= $orderinfo['email'];		//商户订单中的收货人Email
	$c_orderamount = $orderinfo['order_amount'];					//商户订单总金额
	$c_ymd		= date("Ymd");					//商户订单的产生日期，格式为"yyyymmdd"，如20050102
	$c_moneytype= "0";							//支付币种，0为人民币
	$c_retflag	= "1";							//商户订单支付成功后是否需要返回商户指定的文件，0：不用返回 1：需要返回
	$c_paygate	= "3";							//如果在商户网站选择银行则设置该值，具体值可参见《云网支付@网技术接口手册》附录一；如果来云网支付@网选择银行此项为空值。
	$c_returl	= $baseUrl."payrespond.php";	//如果c_retflag为1时，该地址代表商户接收云网支付结果通知的页面，请提交完整文件名(对应范例文件：GetPayNotify.php)
	$c_memo1	= "ABCDE";						//商户需要在支付结果通知中转发的商户参数一
	$c_memo2	= "12345";						//商户需要在支付结果通知中转发的商户参数二
	$c_pass		= $payment_info['key'];		//支付密钥，请登录商户管理后台，在帐户信息-基本信息-安全信息中的支付密钥项
	$notifytype	= "1";							//0普通通知方式/1服务器通知方式，空值为普通通知方式
	$c_language	= "0";							//对启用了国际卡支付时，可使用该值定义消费者在银行支付时的页面语种，值为：0银行页面显示为中文/1银行页面显示为英文

	$srcStr = $c_mid . $c_order . $c_orderamount . $c_ymd . $c_moneytype . $c_retflag . $c_returl . $c_paygate . $c_memo1 . $c_memo2 . $notifytype . $c_language . $c_pass;
	//$srcStr11 = $c_mid ."<br />". $c_order ."<br />". $c_orderamount ."<br />". $c_ymd ."<br />". $c_moneytype ."<br />". $c_retflag ."<br />". $c_returl ."<br />". $c_paygate ."<br />". $c_memo1 ."<br />". $c_memo2 ."<br />". $notifytype ."<br />". $c_language ."<br />". $c_pass;
	//说明：如果您想指定支付方式(c_paygate)的值时，需要先让用户选择支付方式，然后再根据用户选择的结果在这里进行MD5加密，也就是说，此时，本页面应该拆分为两个页面，分为两个步骤完成。
	
	//--对订单信息进行MD5加密
	//商户对订单信息进行MD5签名后的字符串

	$c_signstr	= md5($srcStr);

require("sendorder.php");
}

function respond($orderinfo,$payinfo){
	
	global $baseUrl;
	//获取支付宝的反馈参数
	$payment_info 	= unserialize($payinfo['pay_config']);


	$c_mid			= get_args('c_mid');		//商户编号，在申请商户成功后即可获得，可以在申请商户成功的邮件中获取该编号
	$c_order		= get_args('c_order');			//商户提供的订单号
	$c_orderamount	= get_args('c_orderamount');	//商户提供的订单总金额，以元为单位，小数点后保留两位，如：13.05
	$c_ymd			= get_args('c_ymd');			//商户传输过来的订单产生日期，格式为"yyyymmdd"，如20050102
	$c_transnum		= get_args('c_transnum');		//云网支付网关提供的该笔订单的交易流水号，供日后查询、核对使用；
	$c_succmark		= get_args('c_succmark');		//交易成功标志，Y-成功 N-失败			
	$c_moneytype	= get_args('c_moneytype');		//支付币种，0为人民币
	$c_cause		= get_args('c_cause');			//如果订单支付失败，则该值代表失败原因		
	$c_memo1		= get_args('c_memo1');			//商户提供的需要在支付结果通知中转发的商户参数一
	$c_memo2		= get_args('c_memo2');			//商户提供的需要在支付结果通知中转发的商户参数二
	$c_signstr		= get_args('c_signstr');		//云网支付网关对已上信息进行MD5加密后的字符串

		$c_pass = $payment_info['key'];
		
		$srcStr = $c_mid . $c_order . $c_orderamount . $c_ymd . $c_transnum . $c_succmark . $c_moneytype . $c_memo1 . $c_memo2 . $c_pass;

	//--对支付通知信息进行MD5加密
		$r_signstr	= md5($srcStr);
	if($r_signstr=$c_signstr){
			
	   if($c_succmark=="Y")
		{
		   return 1;
			//商户系统的逻辑处理（例如判断金额，判断支付状态(20成功,30失败),更新订单状态等等）......
		}
	   if($c_succmark=="N")
		{
		   return 0;
			//商户系统的逻辑处理（例如判断金额，判断支付状态(20成功,30失败),更新订单状态等等）......
		}
 
	}else{
	   return 0;
	}
	
}
?>