<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
require("foundation/module_order.php");
require("foundation/module_goods.php");

//语言包引入
$m_langpackage=new moduleslp;
$s_langpackage=new shoplp;

//定义文件表
$t_order_info = $tablePreStr."order_info";
$t_order_goods = $tablePreStr."order_goods";
$t_goods = $tablePreStr."goods";
$t_shop_info = $tablePreStr."shop_info";
$t_users = $tablePreStr."users";
// 处理post变量
$order_id = intval(get_args('id'));

dbtarget('r',$dbServs);
$dbo=new dbex();
//
//判断商品是否锁定，锁定则不许操作
$sql="select b.goods_id from $t_order_info as a join $t_order_goods as b on a.order_id=b.order_id where a.order_id=$order_id";
$row=$dbo->getRow($sql);
if($row){
	$goods_id=$row['goods_id'];
}
include("foundation/fgoods_locked.php");
//判断用户是否锁定，锁定则不许操作
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	trigger_error($m_langpackage->m_user_locked);//非法操作
}
$order_info = get_order_info($dbo,$t_order_info,$t_order_goods,$t_goods,$t_shop_info,$order_id,$user_id);
if(!$order_info) {
	action_return(0,$m_langpackage->m_noex_thisorder);
}
if($order_info['order_status']=='0') {
	action_return(0,$m_langpackage->m_order_cancel);
} elseif ($order_info['order_status']=='3') {
	action_return(0,$m_langpackage->m_order_notcancel);
}elseif ($order_info['order_status']=='2') {
	action_return(0,$m_langpackage->m_order_not);
}

//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();

$sql = "update `$t_order_info` set order_status=0 where order_id='$order_id' and user_id='$user_id'";

if($dbo->exeUpdate($sql)) {
	action_return(1,$m_langpackage->m_order_becanceled);
} else {
	action_return(0,$m_langpackage->m_order_becanceledfail,'-1');
}
?>