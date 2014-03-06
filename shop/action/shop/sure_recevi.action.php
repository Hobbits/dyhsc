<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("foundation/module_goods.php");
require("foundation/module_payment.php");
//语言包引入
$m_langpackage=new moduleslp;
$s_langpackage=new shoplp;

/* post 数据处理 */
$oid=intval(get_args('id'));
$receiv_account = short_check(get_args('receiv_account'));

//数据表定义区
$t_order_info = $tablePreStr."order_info";
$t_users = $tablePreStr."users";
$t_order_goods = $tablePreStr."order_goods";
$t_goods = $tablePreStr."goods";
$t_shipping_list = $tablePreStr."shipping_list";
$t_receiv_list = $tablePreStr."receiv_list";
$t_shop_payment = $tablePreStr."shop_payment";

$shipping_time = $ctime->long_time();
//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;
//判断商品是否锁定，锁定则不许操作
$sql="select b.goods_id from $t_order_info as a join $t_order_goods as b on a.order_id=b.order_id where a.order_id=$oid";
$row=$dbo->getRow($sql);
if($row){
	$goods_id=$row['goods_id'];
}
$user_id = get_sess_user_id();
include("foundation/fgoods_locked.php");
//判断用户是否锁定，锁定则不许操作
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	trigger_error($m_langpackage->m_user_locked);//非法操作
}
//判断sessionid和userid是不是同一个，如果不是则不需删除
$sql = "select * from $t_order_info where order_id=$oid";
$rs = $dbo->getRow($sql);
if($rs['shop_id'] != get_sess_user_id()){
	action_return(1,$m_langpackage->m_not_err,'-1');
}

if($rs['pay_id'] != 4 && $rs['pay_id'] != 5)
{
	$pay_info = get_one_shop_payment($dbo,$t_shop_payment,$rs['shop_id'],$rs['pay_id']);
	
	if($rs['pay_id']=='1')
		$receiv_account = $pay_info[3];
	else
		$receiv_account = $pay_info[1];
}

$sql = "insert into `$t_receiv_list` (order_id,payid,shop_id,payment_type,pay_date,receiver,receiv_date,receiv_account,receiv_money,operator)values
				($oid,'{$rs['payid']}',$user_id,'{$rs['pay_name']}','$shipping_time','$user_name','$shipping_time','$receiv_account',{$rs['order_amount']},'$user_name')";
		
if($dbo->exeUpdate($sql)) {
	action_return(1,$m_langpackage->m_add_success,'modules.php?app=shop_delivery_add&order_id='.$oid);
} else {
	action_return(0,$m_langpackage->m_add_fail,'modules.php?app=shop_my_order');
}
?>