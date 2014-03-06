<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}



function get_code($orderinfo,$payinfo){
	// 获取支付配置信息
	
	global $baseUrl;
	$pay_config = unserialize($payinfo['pay_config']);
	$v_amount = $orderinfo['order_amount'];
	$v_oid = $orderinfo['payid'];
	$v_mid = $pay_config['chinabank_id'];		// 商户号，这里为测试商户号1001，替换为自己的商户号(老版商户号为4位或5位,新版为8位)即可
	$v_url = $baseUrl."payrespond.php";	// 请填写返回url,地址应为绝对路径,带有http协议
	$key   = $pay_config['key'];								    // 如果您还没有设置MD5密钥请登陆我们为您提供商户后台，地址
    $v_moneytype = "CNY";                                            //币种
	$text = $v_amount.$v_moneytype.$v_oid.$v_mid.$v_url.$key;        //md5加密拼凑串,注意顺序不能变
    $v_md5info = strtoupper(md5($text));                             //md5函数加密并转化成大写字母
	$v_rcvname   = trim($orderinfo['consignee'])  ;		// 收货人
	$v_rcvaddr   = trim($orderinfo['address'])  ;		// 收货地址
	$v_rcvtel    = trim($orderinfo['telphone'])   ;		// 收货人电话
	$v_rcvpost   = trim($orderinfo['zipcode'])  ;		// 收货人邮编
	$v_rcvemail  = trim($orderinfo['email']) ;		// 收货人邮件
	$v_rcvmobile = trim($orderinfo['mobile']);		// 收货人手机号
	$remark1 = "";					 //备注字段1
	$remark2 = "";                    //备注字段2
	unset($payinfo);

	
require("send.php");
}

function respond($orderinfo,$payinfo){
	
global $baseUrl;
$payment_info 	= unserialize($payinfo['pay_config']);

$key=$payment_info['key'];
$v_oid     =trim(get_args('v_oid'));
$v_pmode   =trim(get_args('v_pmode'));
$v_pstatus =trim(get_args('v_pstatus'));
$v_pstring =trim(get_args('v_pstring'));
$v_amount  =trim(get_args('v_amount'));
$v_moneytype  =trim(get_args('v_moneytype'));

$v_md5str  =trim(get_args('v_md5str'));
	unset($payinfo);

	
/**
 * 重新计算md5的值
 */
                           
$md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key)); //拼凑加密串
if ($v_md5str==$md5string)
{
	
   if($v_pstatus=="20")
	{
	   return 1;
		//商户系统的逻辑处理（例如判断金额，判断支付状态(20成功,30失败),更新订单状态等等）......
	}
   if($v_pstatus=="30")
	{
	   return 0;
		//商户系统的逻辑处理（例如判断金额，判断支付状态(20成功,30失败),更新订单状态等等）......
	}
 
	
}else{
	return 0;
}


}
?>