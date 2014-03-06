<?php
/*
	-----------------------------------------
	文件：proctect_rights.action.php。
	功能: 用户申请维权。
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
$protect_item = short_check(get_args('protect_item'));
$ask_service = big_check(get_args('ask_service'));

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
$order_info = get_order_info($dbo,$t_order_info,$t_order_goods,$t_goods,$t_shop_info,$order_id,$user_id);
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
	action_return(0,$m_langpackage->m_not_sure_receiv);
}

//数据库操作
dbtarget('w',$dbServs);
$dbo = new dbex();

$add_time = $ctime->long_time();
$status = 0;

//是否申请客服介入
if($ask_service == $m_langpackage->m_ask_service)
	$status = 2;

//插入维权信息
$sql = "insert into `$t_protect_rights` (order_id,protect_item,user_id,user_type,shop_id,content,protect_date,status) values($order_id,$protect_item,$user_id,0,{$order_info['shop_id']},'$protect_content','$add_time',$status)";
if($dbo->exeUpdate($sql)) 
{
	//修改订单维权状态
	if(!$order_info['protect_status'])
	{
		$sql = "update `$t_order_info` set protect_status = 1 where order_id='$order_id' and user_id='$user_id'";
		$dbo->exeUpdate($sql);
	}
	action_return(1,$m_langpackage->m_ask_protect_suc);
} 
else 
{
	action_return(0,$m_langpackage->m_ask_protect_fail,'-1');
}
?>