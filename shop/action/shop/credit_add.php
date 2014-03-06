<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("foundation/module_goods.php");
//语言包引入
$m_langpackage=new moduleslp;
$s_langpackage=new shoplp;
/* post 数据处理 */
$oid=intval(get_args('id'));
$t=short_check(get_args('t'));
$grade = short_check(get_args('grade'));
$content = short_check(get_args('content'));

//数据表定义区
$t_credit = $tablePreStr."credit";
$t_order_info = $tablePreStr."order_info";
$t_users = $tablePreStr."users";
$t_goods = $tablePreStr."goods";
$t_order_goods = $tablePreStr."order_goods";
//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;
//判断sessionid和userid是不是同一个，如果不是则不需删除
if($t=="seller"){
	$sql = "select shop_id from $t_order_info where order_id=$oid";
	$rs = $dbo->getRow($sql);
	if($rs['shop_id'] != get_sess_user_id()){
		action_return(1,$m_langpackage->m_not_err,'-1');
	}
}else{
	$sql = "select user_id,order_status,buyer_reply from $t_order_info where order_id=$oid";
	$rs = $dbo->getRow($sql);
	if($rs['user_id'] != get_sess_user_id()){
		action_return(1,$m_langpackage->m_not_err,'-1');
	}
	if($rs['order_status'] != 3){
		action_return(1,$m_langpackage->m_appraised,'-1');
	}
	if($rs['buyer_reply'] == 1){
		action_return(1,$m_langpackage->m_not_appraised,'-1');
	}
}
//判断商品是否锁定，锁定则不许操作
$sql="select b.goods_id,a.transport_type from $t_order_info as a join $t_order_goods as b on a.order_id=b.order_id where a.order_id=$oid";
$row1=$dbo->getRow($sql);
if($row1){
	$goods_id=$row1['goods_id'];
}
include("foundation/fgoods_locked.php");
//判断用户是否锁定，锁定则不许操作
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	trigger_error($m_langpackage->m_user_locked);//非法操作
}

$time = $ctime->long_time();
if($t=="buyer"){
	$sql = "update `$t_credit` set seller_credit='$grade',seller_evaluate='$content',seller_evaltime='$time' where order_id=$oid and buyer=$user_id";

	$sql1 = "update `$t_order_info` set buyer_reply='1' where order_id=$oid ";
}elseif($t=="seller"){
	$sql = "update `$t_credit` set buyer_credit='$grade',buyer_evaluate='$content',buyer_evaltime='$time' where order_id=$oid and seller=$user_id";

	$sql1 = "update `$t_order_info` set seller_reply='1' where order_id=$oid ";
}
if($dbo->exeUpdate($sql) && $dbo->exeUpdate($sql1)) {
	action_return(1,$m_langpackage->m_add_success,'modules.php?app=user_my_order');
} else {
	action_return(0,$m_langpackage->m_add_fail,'modules.php?app=user_my_order');
}
?>