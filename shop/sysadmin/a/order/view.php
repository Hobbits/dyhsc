<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
/*管理员更改订单状态模块*/
require_once("../foundation/module_payment.php");
require_once("../foundation/module_admin_logs.php");
require_once("../foundation/module_remind.php");

//语言包引入
$a_langpackage=new adminlp;
//权限管理
$right=check_rights("order_status");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}
//定义数据表
$t_order_info = $tablePreStr."order_info";
$t_admin_log = $tablePreStr."admin_log";
$t_remind_info = $tablePreStr."remind_info";
/* post */
$order_id = intval(get_args('order_id'));
$state = intval(get_args('state'));

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

$sn = '';

//查询出订单的内容
$sql = "select * from $t_order_info where order_id = $order_id";
$row = $dbo->getRow($sql);
$nowtime = $ctime->long_time();
//定义两个数组，分别以站内信的形式将修改状态发送给买卖双方
$array = array();
$post = array();
$sql = "update `$t_order_info` set ";
/* 取消订单*/
if($state==1){
	$sql .= " order_status=0 ";
	$sn = '取消订单，订单id为'.$order_id;

	$array['user_id'] = $row['user_id'];
	$array['remind_info'] = $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_admin_can.$row['payid'];
	$array['remind_time'] = $nowtime;
	
	$post['user_id'] = $row['shop_id'];
	$post['remind_info'] = $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_admin_can.$row['payid'];
	$post['remind_time'] = $nowtime;

}
/* 付款*/
if($state==2){
	$sql .= " order_status=2,pay_status=1, pay_time=sysdate() ";
	$sn = '付款，订单id为'.$order_id;
	
	$array['user_id'] = $row['user_id'];
	$array['remind_info'] = $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_admin_pay.$row['payid'];
	$array['remind_time'] = $nowtime;
	
	$post['user_id'] = $row['shop_id'];
	$post['remind_info'] = $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_admin_pay.$row['payid'];
	$post['remind_time'] = $nowtime;
}
/* 商家发货*/
if($state==3){
	$sql .= " transport_status=1 ";
	$sn = '商家发货，订单id为'.$order_id;
	
	$array['user_id'] = $row['user_id'];
	$array['remind_info'] = $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_admin_tran.$row['payid'];
	$array['remind_time'] = $nowtime;
	
	$post['user_id'] = $row['shop_id'];
	$post['remind_info'] = $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_admin_tran.$row['payid'];
	$post['remind_time'] = $nowtime;
}
/* 确认收货*/
if($state==4){
	$sql .= " order_status=3 ";
	$sn = '确认收货，订单id为'.$order_id;
	
	$array['user_id'] = $row['user_id'];
	$array['remind_info'] = $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_admin_shou.$row['payid'];
	$array['remind_time'] = $nowtime;
	
	$post['user_id'] = $row['shop_id'];
	$post['remind_info'] = $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_admin_shou.$row['payid'];
	$post['remind_time'] = $nowtime;
}
$sql .= " where order_id= $order_id";

if($dbo->exeUpdate($sql)) {
	admin_log($dbo,$t_admin_log,$sn);//'修改订单状态');
	insert_remind_info($dbo,$t_remind_info,$array);//发送给买方
	insert_remind_info($dbo,$t_remind_info,$post);//发送给卖方
	action_return(1,$a_langpackage->a_amend_suc,"-1");
} else {
	action_return(0,$a_langpackage->a_amend_lose,'-1');
}
?>