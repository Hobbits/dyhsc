<?php
/*
	-----------------------------------------
	文件：proctect_rights.action.php。
	功能: 商家处理用户维权。
	日期：2010-11-11
	-----------------------------------------
*/

if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
require("foundation/module_order.php");
require("foundation/module_goods.php");

//语言包引入
$m_langpackage = new moduleslp;
$s_langpackage = new shoplp;

//定义文件表
$t_order_info = $tablePreStr."order_info";
$t_order_goods = $tablePreStr."order_goods";
$t_goods = $tablePreStr."goods";
$t_shop_info = $tablePreStr."shop_info";
$t_users = $tablePreStr."users";
$t_protect_rights = $tablePreStr."protect_rights";

// 处理post变量
$order_id = intval(get_args('id'));
$protect_content = big_check(get_args('protect_content'));
$agree = short_check(get_args('agree'));

//数据库操作
dbtarget('r',$dbServs);
$dbo = new dbex();

//判断商品是否锁定，锁定则不许操作
$sql = "select b.goods_id from $t_order_info as a join $t_order_goods as b on a.order_id=b.order_id where a.order_id=$order_id";
$row = $dbo->getRow($sql);
if($row){
	$goods_id=$row['goods_id'];
}
include("foundation/fgoods_locked.php");

//判断用户是否锁定，锁定则不许操作
$sql = "select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	trigger_error($m_langpackage->m_user_locked);//非法操作
}

//判断订单是否存在，锁定则不许操作
$sql = "select * from $t_order_info where order_id=$order_id and shop_id =$user_id";
$order_info = $dbo->getRow($sql);

if(!$order_info) {
	action_return(0,$m_langpackage->m_noex_thisorder);
}
//判断订单状态，锁定则不许操作
if($order_info['order_status']=='0') 
{
	action_return(0,$m_langpackage->m_order_cancel);
} 
elseif ($order_info['order_status']!='3') 
{
	action_return(0,'该订单还未确定收货!');
}elseif ( $order_info['protect_status']=='3') 
{
	action_return(0,'用户维权完成！');
}

//数据库操作
dbtarget('w',$dbServs);
$dbo = new dbex();

$add_time = $ctime->long_time();

//是否同意客户维权
$status = 0;
if($agree)
{
	$status = 1;
}
$sql = "insert into `$t_protect_rights` (order_id,user_id,protect_item,user_type,shop_id,content,protect_date,status) values($order_id,$user_id,1,1,{$order_info['shop_id']},'$protect_content','$add_time',$status)";
if($dbo->exeUpdate($sql)) 
{
	if($agree)
	{
		$sql = "update `$t_order_info` set protect_status=2 where order_id='$order_id' and shop_id='$user_id'";
		$dbo->exeUpdate($sql);
	}
	action_return(1,'回复维权成功！');
} 
else 
{
	action_return(0,'回复维权失败！','-1');
}
?>