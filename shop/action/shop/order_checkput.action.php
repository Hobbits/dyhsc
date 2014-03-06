<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
require("foundation/module_order.php");
include("foundation/module_remind.php");
require("foundation/module_goods.php");
//语言包引入
$m_langpackage=new moduleslp;
$s_langpackage=new shoplp;
//定义文件表
$t_order_info = $tablePreStr."order_info";
$t_goods = $tablePreStr."goods";
$t_shop_info = $tablePreStr."shop_info";
$t_payment = $tablePreStr."payment";
$t_order_goods = $tablePreStr."order_goods";
$t_remind_user = $tablePreStr."remind_user";
$t_remind = $tablePreStr."remind";
$t_remind_info = $tablePreStr."remind_info";

$t_users = $tablePreStr."users";
// 处理post变量
$order_id = intval(get_args('id'));

dbtarget('r',$dbServs);
$dbo=new dbex();

$order_info = get_order_info($dbo,$t_order_info,$t_order_goods,$t_goods,$t_shop_info,$order_id);

if(!$order_info) {
	action_return(0,$m_langpackage->m_noex_thisorder,'-1');
}
if($order_info['order_status']!='2') {
	action_return(0,$m_langpackage->m_order_cancel,'-1');
}
if($order_info['transport_status']=='1') {
	action_return(0,$m_langpackage->m_order_transported);
}

$shipping_time = $ctime->long_time();
//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();
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
$sql = "update `$t_order_info` set transport_status=1,shipping_time='$shipping_time' where order_id='$order_id' and shop_id='$shop_id'";

if($dbo->exeUpdate($sql)) {
	// 发送提醒
		$remind_id = 8;

		// 获取提醒信息
		$reminds = get_remind($dbo,$t_remind,$remind_id);
		if(!$reminds['enable']) {
			exit;
		}
		$remind_tpl = $reminds['remind_tpl'];

		// 获取用户id
		$sql = "select user_id,payid from $t_order_info where order_id='$order_id'";
		$order_row = $dbo->getRow($sql);
		if(!$order_row){
			exit;
		}
		$user_id = $order_row['user_id'];

		// 获取用户的提醒设置
		$row = get_remind_user($dbo,$t_remind_user,$user_id,$remind_id);
		if(!$row) {
			exit;
		}
		
		$nowtime = $ctime->long_time();
		$remind_info = remind_info_replace($remind_tpl,array('orders'=>$order_row['payid'],'time'=>$nowtime));
		if($row['site']) {
			$array = array(
				'user_id' => $user_id,
				'remind_info' => $remind_info,
				'remind_time' => $nowtime,
			);
			if($reminds['enable']==1){
				insert_remind_info($dbo,$t_remind_info,$array);
			}
		} elseif($row['mail']) {
			
		} elseif($row['im']) {
			
		} elseif($row['mobile']) {
			exit;
		}	
	action_return(1,$m_langpackage->m_sure_shippingnow);
} else {
	action_return(0,$m_langpackage->m_sure_shippingnowfail,'-1');
}
?>