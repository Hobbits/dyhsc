<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require("foundation/acheck_shop_creat.php");
require("foundation/module_payment.php");
require("foundation/module_order.php");
require("foundation/module_shop.php");

//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
$s_langpackage=new shoplp;
//数据表定义区
$t_order_info = $tablePreStr."order_info";
$t_goods = $tablePreStr."goods";
$t_shop_info = $tablePreStr."shop_info";
$t_payment = $tablePreStr."payment";
$t_order_goods = $tablePreStr."order_goods";
$t_users = $tablePreStr."users";

$group_id = intval(get_args('id'));
$state = intval(get_args('state'));
$dbo = new dbex;
dbtarget('r',$dbServs);
/* 商铺信息处理 */
include("foundation/fshop_locked.php");
//判断用户是否锁定，锁定则不许操作
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	trigger_error($m_langpackage->m_user_locked);//非法操作
}
if(empty($group_id)){
	$result = get_myoder_list($dbo,$t_order_info,$t_order_goods,$t_goods,$t_shop_info,$shop_id,13,'shop',$state,$t_users);
}else{
	$result = get_myoder_list($dbo,$t_order_info,$t_order_goods,$t_goods,$t_shop_info,$group_id,13,'groupbuy',$state,$t_users);
}
$payment_info = get_payment_info($dbo,$t_payment);
?>