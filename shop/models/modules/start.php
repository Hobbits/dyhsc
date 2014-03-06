<?php
require('foundation/module_start.php');
require('foundation/module_users.php');
require('foundation/module_shop.php');

$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
$t_user_favorite = $tablePreStr."user_favorite";
$t_users = $tablePreStr."users";
$t_cart = $tablePreStr."cart";
$t_goods = $tablePreStr."goods";
$t_shop_info = $tablePreStr."shop_info";
$t_remind_info = $tablePreStr."remind_info";
$t_order_info = $tablePreStr."order_info";
$t_groupbuy_log = $tablePreStr."groupbuy_log";
$t_groupbuy = $tablePreStr."groupbuy";
$t_order_goods = $tablePreStr."order_goods";
$t_shop_guestbook = $tablePreStr."shop_guestbook";
//读写分离定义方法
$dbo=new dbex;
dbtarget('r',$dbServs);

$sql = "SELECT COUNT(favorite_id) FROM `$t_user_favorite` WHERE user_id='$user_id'";
$row = $dbo->getRow($sql);
$my_favorite_num = $row[0];

$sql = "SELECT COUNT(cart_id) FROM `$t_cart` WHERE user_id='$user_id'";
$row = $dbo->getRow($sql);
$my_cart_num = $row[0];

$sql = "select goods_id,is_best,is_new,is_promote,is_hot,goods_number from `$t_goods` where shop_id='$shop_id'";
$rs = $dbo->getRs($sql);
$countgoods = 0;
$hot_num = 0;
$best_num = 0;
$new_num = 0;
$promote_num = 0;
$kucun_num = 0;
foreach($rs as $value) {
	if($value['is_best']) { $best_num++; }
	if($value['is_hot']) { $hot_num++; }
	if($value['is_new']) { $new_num++; }
	if($value['is_promote']) { $promote_num++; }
	if($value['goods_number']<5) { $kucun_num++; }
	$countgoods++;
}
//我的订单
//$result = get_myorder_info($dbo,$t_order_info,$t_shop_info,$t_goods,$t_order_goods,$user_id,10);
//$order_rs = $result;
//我的收藏
//$result = get_myfavorite_info($dbo,$t_user_favorite,$t_goods,$t_shop_info,$user_id,10);
//$favorite_rs = $result;
//判断商铺是否关闭
$rs = get_shop_info_item($dbo,array('open_flg'),$t_shop_info,$shop_id);
set_session('shop_open',$rs['open_flg']);
//判断商铺是否锁定
$rs = get_shop_info_item($dbo,array('lock_flg'),$t_shop_info,$shop_id);
set_session('shop_lock',$rs['lock_flg']);
//获取用户信息
$user_info = get_user_info_item($dbo,array('last_login_time','last_ip'),$t_users,$user_id);
//获取未读站内信
$sql="SELECT COUNT(rinfo_id) FROM $t_remind_info WHERE user_id='$user_id' AND isread='0'";
$row = $dbo->getRow($sql);
$remind_num = $row[0];
//获得未付款订单数
$sql="SELECT COUNT(order_id) FROM $t_order_info WHERE user_id='$user_id' AND pay_status='0' AND transport_status='0' AND order_status <>'0' AND order_status<>'3'";
$row = $dbo->getRow($sql);
$order_num_need_pay=$row[0];
//获得已发货订单数
$sql="SELECT COUNT(order_id) FROM $t_order_info WHERE user_id='$user_id' AND pay_status='1' AND transport_status='1' AND order_status<>0 AND order_status<>'3'";
$row = $dbo->getRow($sql);
$order_num_send=$row[0];
//获得已完成订单数
$sql="SELECT COUNT(order_id) FROM $t_order_info WHERE user_id='$user_id' AND pay_status='1' AND transport_status='1' AND order_status='3' AND buyer_reply='0' ";
$row = $dbo->getRow($sql);
$order_num=$row[0];
//获得参加的团购活动数量
$sql="SELECT group_id FROM $t_groupbuy_log WHERE user_id='$user_id' ";
$row = $dbo->getRs($sql);
$str='0,';
foreach ($row as $value){
	$str.=$value['group_id'].",";
}
$str = substr($str,0,-1);
$group_buy_num="";

$sql="SELECT COUNT(group_id) FROM $t_groupbuy WHERE group_id IN ($str) AND recommended=1";
$row=$dbo->getRow($sql);
$group_buy_num = $row[0];

//卖家提醒
//未确认订单
$sql="SELECT COUNT(order_id) FROM $t_order_info WHERE shop_id='$shop_id' and order_status=1 ORDER BY order_time DESC";
$row = $dbo->getRow($sql);
$order_sale_no_pay=$row[0];
//未发货订单
$sql="SELECT COUNT(order_id) FROM $t_order_info WHERE shop_id='$shop_id' and transport_status=0 and pay_status=1 ORDER BY order_time DESC";
$row = $dbo->getRow($sql);
$order_sale_no_huo=$row[0];
//未评价订单
$sql="SELECT COUNT(order_id) FROM $t_order_info WHERE shop_id='$shop_id' and order_status=3 and seller_reply='0' ORDER BY order_time DESC";
$row = $dbo->getRow($sql);
$order_sale_no_ping=$row[0];
//未读的留言
$sql="select COUNT(gid) from $t_shop_guestbook where shop_id='$shop_id' and shop_del_status=1 and read_status=0 order by add_time desc";
$row = $dbo->getRow($sql);
$order_sale_no_liu=$row[0];
?>