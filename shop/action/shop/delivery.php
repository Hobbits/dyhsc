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
$shipping_name=short_check(get_args('shipping_name'));
$shipping_no = short_check(get_args('shipping_no'));
$shipping_type = short_check(get_args('shipping_type'));

//数据表定义区
$t_order_info = $tablePreStr."order_info";
$t_users = $tablePreStr."users";
$t_order_goods = $tablePreStr."order_goods";
$t_goods = $tablePreStr."goods";
$t_shipping_list = $tablePreStr."shipping_list";
$t_receiv_list = $tablePreStr."receiv_list";

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
$user_name = get_sess_user_name();
$sql = "update `$t_order_info` set shipping_name='$shipping_name',shipping_no='$shipping_no',shipping_type='$shipping_type',transport_status=1,shipping_time='$shipping_time' where order_id=$oid and shop_id='$shop_id'";
if($dbo->exeUpdate($sql)) {
	
	//添加发货单
	$sql = "insert into `$t_shipping_list` (order_id,pay_sn,shop_id,shipping_type,shipping_company,shipping_no,add_date,consignee,consignee_address,consignee_tel,operator)values
			({$rs['order_id']},'{$rs['payid']}',$user_id,'$shipping_type','$shipping_name','$shipping_no','$shipping_time','{$rs['consignee']}','{$rs['address']}','{$rs['telphone']}','$user_name')";
	$dbo->exeUpdate($sql);
	
	action_return(1,$m_langpackage->m_add_success,'modules.php?app=shop_my_order');
} else {
	action_return(0,$m_langpackage->m_add_fail,'modules.php?app=shop_my_order');
}
?>