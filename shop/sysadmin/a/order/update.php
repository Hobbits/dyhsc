<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
/*管理员修改订单模块*/
require_once("../foundation/module_payment.php");
require_once("../foundation/module_admin_logs.php");
require_once("../foundation/module_remind.php");
require_once("../foundation/module_order.php");
//语言包引入
$a_langpackage=new adminlp;
//权限管理
$right=check_rights("order_status");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}

//定义读操作
dbtarget('r',$dbServs);
$dbo=new dbex;
//定义数据表
$t_order_info = $tablePreStr."order_info";
$t_admin_log = $tablePreStr."admin_log";
$t_remind_info = $tablePreStr."remind_info";
$t_order_goods = $tablePreStr."order_goods";
$t_goods = $tablePreStr."goods";
$t_shop_info = $tablePreStr."shop_info";

//定义两个数组，分别以站内信的形式将修改状态发送给买卖双方
$array = array();
$shoparr = array();
$nowtime = $ctime->long_time();
$order_id = intval(get_args('order_id'));

$order_value = intval(get_args('order_value'));
$user_id="";
$info = get_order_info($dbo,$t_order_info,$t_order_goods,$t_goods,$t_shop_info,$order_id,$user_id);
if($info['order_value']!=$order_value){
	//买方发送消息
	$array['user_id'] = $info['user_id'];
	$array['remind_info'] = $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_order_goal_admin.$info['payid'];
	$array['remind_time'] = $nowtime;
	//卖方发送消息
	$shoparr['user_id'] = $info['shop_id'];
	$shoparr['remind_info'] = $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_order_goal_admin.$info['payid'];
	$shoparr['remind_time'] = $nowtime;
}
$post['order_value']=intval(get_args('order_value'));
$post['consignee']=short_check(get_args('consignee'));
$post['mobile']=short_check(get_args('mobile'));
$post['telphone']=short_check(get_args('telphone'));
$post['email']=short_check(get_args('email'));
$post['country']=short_check(get_args('country'));
$post['province']=short_check(get_args('province'));
$post['city']=short_check(get_args('city'));
$post['district']=short_check(get_args('district'));
$post['address']=short_check(get_args('address'));
$post['zipcode']=short_check(get_args('zipcode'));
$post['shipping_name']=short_check(get_args('shipping_name'));
$post['shipping_no']=short_check(get_args('shipping_no'));
$post['shipping_type']=short_check(get_args('shipping_type'));
$post['pay_name']=short_check(get_args('pay_name'));

if(upd_order_info($dbo,$t_order_info,$post,$order_id)) {
	admin_log($dbo,$t_admin_log,"订单被修改，订单号为:".$order_id);//'修改订单状态');
	if($info['order_value']!=$order_value){
		insert_remind_info($dbo,$t_remind_info,$array);//发送给买方
		insert_remind_info($dbo,$t_remind_info,$shoparr);//发送给卖方
	}
	action_return(1,$a_langpackage->a_edit_success,"-1");
} else {
	action_return(0,$a_langpackage->a_operate_fail,'-1');
}
?>