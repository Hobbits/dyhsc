<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

function get_code($orderinfo,$payinfo){
	require_once ("classes/PayRequestHandler.class.php");
	global $baseUrl;
	$payment_info = unserialize($payinfo['pay_config']);

	/* 财付通商户号 */
	$bargainor_id = $payment_info['bargainor_id'];
	
	/* 财付通密钥 */
	$key = $payment_info['key'];
	
	/* 返回处理地址 */
	$return_url = $baseUrl."payrespond.php";
	
	//date_default_timezone_set(PRC);
	$strDate = date("Ymd");
	$strTime = date("His");
	
	//4位随机数
	$randNum = rand(1000, 9999);
	
	//10位序列号,可以自行调整。
	$strReq = $strTime . $randNum;
	//
	/* 商家订单号,长度若超过32位，取前32位。财付通只记录商家订单号，不保证唯一。 */
	$sp_billno = $orderinfo['payid'];
	
	/* 财付通交易单号，规则为：10位商户号+8位时间（YYYYmmdd)+10位流水号 */
	$transaction_id = $bargainor_id . $strDate . $strReq;
	
	/* 商品价格（包含运费），以分为单位 */
	$total_fee = $orderinfo['order_amount']*100;
	
	/* 商品名称 */
	//$transaction_id=$orderinfo['payid'];
	$desc = "订单号：" . $transaction_id;
	
	/* 创建支付请求对象 */
	$reqHandler = new PayRequestHandler();
	$reqHandler->init();
	$reqHandler->setKey($key);
	
	//----------------------------------------
	//设置支付参数
	//----------------------------------------
	$reqHandler->setParameter("bargainor_id", $bargainor_id);			//商户号
	$reqHandler->setParameter("sp_billno", $sp_billno);					//商户订单号
	$reqHandler->setParameter("transaction_id", $transaction_id);		//财付通交易单号
	$reqHandler->setParameter("total_fee", $total_fee);					//商品总金额,以分为单位
	$reqHandler->setParameter("return_url", $return_url);				//返回处理地址
	$reqHandler->setParameter("desc", "订单号：" . $transaction_id);	    //商品名称
	$reqHandler->setParameter("cs", "utf8");	    					//编码参数
	$reqHandler->setParameter("attach", "$orderinfo[payid]");	    				//返回信息
	
	//用户ip,测试环境时不要加这个ip参数，正式环境再加此参数
	$reqHandler->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']);
	
	//请求的URL
	$reqUrl = $reqHandler->getRequestURL();
	//debug信息
	$debugInfo = $reqHandler->getDebugInfo();
	
	//重定向到财付通支付
	$reqHandler->doSend();
}

function respond($orderinfo,$payinfo){
	require_once ("classes/PayResponseHandler.class.php");
	global $baseUrl;
	/* 创建支付应答对象 */
	$resHandler = new PayResponseHandler();
	
	$sp_billno = $resHandler->getParameter("sp_billno");
	$payment_info = unserialize($payinfo['pay_config']);
	
	$pay_name=$payinfo['pay_name'];
	
	/* 密钥 */
	$key = $payment_info['key'];
	
	$resHandler->setKey($key);
	
	//判断签名
	if($resHandler->isTenpaySign()) {
		
		//交易单号
		$transaction_id = $resHandler->getParameter("transaction_id");
		
		//金额,以分为单位
		$total_fee = $resHandler->getParameter("total_fee");
		
		//支付结果
		$pay_result = $resHandler->getParameter("pay_result");
	
		if( "0" == $pay_result ) {
			if($orderinfo['order_amount']*100==$total_fee){
				return 1;
				
			}else{
				
				return 0;
			}
		} else {
			//当做不成功处理
			return 0;
		}
		
	} else {
		//认证签名失败
		return 0;
	}
	
	//echo $resHandler->getDebugInfo();

}

?>