<?php
/*
	-----------------------------------------
	文件：shop_back_money.action.php。
	功能: 商铺退款处理。
	日期：2010-11-11
	-----------------------------------------
*/
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//语言包引入
$m_langpackage = new moduleslp;
$s_langpackage = new shoplp;
/* post 数据处理 */
$oid = intval(get_args('id'));
$back_money_way = short_check(get_args('back_money_way'));
$back_money_accout = short_check(get_args('back_money_accout'));
$back_money = floatval(short_check(get_args('back_money')));

//数据表定义区
$t_refund_list = $tablePreStr."refund_list";
$t_order_info = $tablePreStr."order_info";
$t_users = $tablePreStr."users";

$back_money_time = $ctime->long_time();

//数据库操作
dbtarget('r',$dbServs);
$dbo = new dbex();

//判断商品是否锁定，锁定则不许操作
$sql = "select oi.*,u.user_name from `$t_order_info` as oi join `$t_users` as u on oi.user_id = u.user_id  where oi.order_id='$oid'";
$row = $dbo->getRow($sql);
if(!$row)
{
	action_return(0,'该订单不存在！','modules.php?app=shop_my_order');
}

//定义写操作
dbtarget('w',$dbServs);
$dbo = new dbex;

$user_id = get_sess_user_id();
$sql = "insert into $t_refund_list(order_id,shop_id,refund_way,refund_account,refund_money,user_name,operator,operator_date)values($oid,$user_id,'$back_money_way','$back_money_accout',$back_money,'{$row['user_name']}','$user_name','$back_money_time')";
if($dbo->exeUpdate($sql)) 
{
	$sql = "update `$t_order_info` set pay_status=3 where order_id='$oid' ";
	$dbo->exeUpdate($sql);
	action_return(1,'退款成功！','modules.php?app=shop_my_order');
} 
else 
{
	action_return(0,'退款失败！','-1');
}
?>