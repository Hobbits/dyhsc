<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

function get_code($orderinfo,$payinfo){
	require_once ("classes/MediPayRequestHandler.class.php");
	global $baseUrl;
	
	$payment_info = unserialize($payinfo['pay_config']);
	
	//date_default_timezone_set(PRC);
	$curDateTime = date("YmdHis");
	$randNum = rand(1000, 9999);
	
	/* 平台商密钥 */
	$key = $payment_info['key'];
	
	/* 平台商帐号 */
	$chnid = $payment_info['bargainor_id'];
	
	/* 卖家 */
	$seller = $payment_info['bargainor_id'];
	
	/* 交易说明 */
	$mch_desc = $orderinfo['payid'];
	
	/* 商品名称 */
	$mch_name = $orderinfo['payid'];
	
	/* 商品总价，单位为分 */
	$mch_price = $orderinfo['order_amount']*100;
	
	/* 回调通知URL */
	$mch_returl = $baseUrl."payrespond.php";
	
	/* 商家的定单号 */
	$mch_vno = $orderinfo['payid'];
	
	/* 支付后的商户支付结果展示页面 */
	$show_url = $baseUrl."payrespond.php";
	
	/* 物流公司或物流方式说明 */
	$transport_desc = "0";
	
	/* 需买方另支付的物流费用,以分为单位 */
	$transport_fee = "0";
	
	/* 创建支付请求对象 */
	$reqHandler = new MediPayRequestHandler();
	$reqHandler->init();
	$reqHandler->setKey($key);
	
	//----------------------------------------
	//设置支付参数
	//----------------------------------------
	$reqHandler->setParameter("chnid", $chnid);						//平台商帐号
	$reqHandler->setParameter("encode_type", "2");					//编码类型 1:gbk 2:utf-8
	$reqHandler->setParameter("mch_desc", $mch_desc);				//交易说明
	$reqHandler->setParameter("mch_name", $mch_name);				//商品名称
	$reqHandler->setParameter("mch_price", $mch_price);				//商品总价，单位为分
	$reqHandler->setParameter("mch_returl", $mch_returl);			//回调通知URL
	$reqHandler->setParameter("mch_type", "1");						//交易类型：1、实物交易，2、虚拟交易
	$reqHandler->setParameter("mch_vno", $mch_vno);					//商家的定单号
	$reqHandler->setParameter("need_buyerinfo", "2");				//是否需要在财付通填定物流信息，1：需要，2：不需要。
	$reqHandler->setParameter("seller", $seller);					//卖家财付通帐号
	$reqHandler->setParameter("show_url",	$show_url);				//支付后的商户支付结果展示页面
	$reqHandler->setParameter("transport_desc", $transport_desc);	//物流公司或物流方式说明
	$reqHandler->setParameter("transport_fee", $transport_fee);		//需买方另支付的物流费用
	
	//请求的URL
	$reqUrl = $reqHandler->getRequestURL();
	
	//debug信息
	//$debugInfo = $reqHandler->getDebugInfo();
	
	//重定向到财付通支付
	$reqHandler->doSend();
}

function respond($orderinfo,$payinfo){
	require_once("classes/MediPayResponseHandler.class.php");

	/* 创建支付应答对象 */
	$resHandler = new MediPayResponseHandler();
	
	$mch_vno = $resHandler->getParameter("mch_vno");
	
	$payment_info = unserialize($payinfo['pay_config']);
	/* 平台商密钥 */
	$key = $payment_info['key'];
	
	$resHandler->setKey($key);
	
	//判断签名
	if($resHandler->isTenpaySign()) {
		
		//财付通交易单号
		$cft_tid = $resHandler->getParameter("cft_tid");
		
		//金额,以分为单位
		$total_fee = $resHandler->getParameter("total_fee");
		
		//返回码
		$retcode = $resHandler->getParameter("retcode");
		
		//状态
		$status = $resHandler->getParameter("status");	
			
		//------------------------------
		//处理业务开始
		//------------------------------
		
		//注意交易单不要重复处理
		//注意判断返回金额
		
		//返回码判断
		if( "0" == $retcode ) {
			switch ($status) {
				case "1":	//交易创建
				
					break;
					
				case "2":	//收获地址填写完毕
				
					break;
					
				case "3":	//买家付款成功，注意判断订单是否重复的逻辑
				
					return 1;
					break;
					
				case "4":	//卖家发货成功
					
					return 2;
					break;
					
				case "5":	//买家收货确认，交易成功
			
					return 3;
					break;
					
				case "6":	//交易关闭，未完成超时关闭
				
					break;
				case "7":	//修改交易价格成功
				
					break;
				case "8":	//买家发起退款
					
					break;
				case "9":	//退款成功
				
					break;
				case "10":	//退款关闭			
					
					break;
				default:
					
					break;
			}
		} else {
			
			return 0;  		//支付失败
		}
	
		//调用doShow
		$resHandler->doShow();
		
		
	} else {
		return 0;
	}
	
	//echo $resHandler->getDebugInfo();
		
}
?>