<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//引入模块公共方法文件
require("foundation/module_goods.php");
require_once("foundation/fsqlitem_set.php");
$m_langpackage=new moduleslp;
/* post 数据处理 */
$group_id = intval(get_args('id'));
$num = intval(get_args('num'));
$groupbuyname = short_check(get_args('groupbuyname'));
$groupbuytel = short_check(get_args('groupbuytel'));

if(!$group_id || !$num || !$groupbuyname || !$groupbuytel) {
	if (!$group_id){
		exit();
	}
	if (!$num){
		exit('-1');
	}
	if (!$groupbuyname){
		exit('-2');
	}
	if (!$groupbuytel){
		exit('-3');
	}
}
//数据表定义区
$t_cart = $tablePreStr."cart";
$t_goods = $tablePreStr."goods";
$t_goods_groupbuy = $tablePreStr."groupbuy";
$t_goods_groupbuy_log = $tablePreStr."groupbuy_log";
$t_users = $tablePreStr."users";


//定义读操作
dbtarget('r',$dbServs);
$dbo=new dbex;
$sql = "select min_quantity,shop_id,purchase_num,order_num,one_num,all_num,goods_id,examine from `$t_goods_groupbuy` where group_id='$group_id'";
$groupbuyinfo = $dbo->getRow($sql);
if($groupbuyinfo['examine']==0){//当被锁定时
	echo '5';exit;
}
//判断用户是否锁定，锁定则不许操作
$user_id = get_sess_user_id();
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	echo '6';exit;
}
if($groupbuyinfo['all_num']==0){//当总限购是0时，他的值为总库存数
	$goodssql="select goods_number from `$t_goods` where goods_id=".$groupbuyinfo['goods_id'];
	$goodsnum=$dbo->getRow($goodssql);
	$groupbuyinfo['all_num']=$goodsnum['goods_number'];
}
if($groupbuyinfo['one_num']==0){//当单人限购是0时，他的值为总限购数
	$groupbuyinfo['one_num']=$groupbuyinfo['all_num'];
}
if($groupbuyinfo['one_num']==0&&$num>intval($groupbuyinfo['all_num'])){
	echo '4';
	exit;
}
if($num>intval($groupbuyinfo['one_num'])){
	echo '2';
	exit;
}
if($num>(intval($groupbuyinfo['all_num'])-intval($groupbuyinfo['purchase_num']))){
	echo '3';
	exit;
}

//if ($groupbuyinfo['min_quantity'] < $num){
//	exit('-4');
//}

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;
$insert_array = array(
	'group_id' => $group_id,
	'user_id' => $user_id,
	'user_name' => $user_name,
	'quantity' => $num,//购买数量
	'linkman' => $groupbuyname,//真实姓名
	'tel' => $groupbuytel,//联系电话
	'add_time' => $ctime->long_time(),
);
$item_sql = get_insert_item($insert_array);
$sql = "insert into `$t_goods_groupbuy_log` $item_sql ";
if($dbo->exeUpdate($sql)) {
	echo "1";
//	$new_groupbuy_num = $groupbuyinfo['min_quantity'] - $num;
	$new_groupbuy_order_num = $groupbuyinfo['purchase_num'] + $num;//订购数
	$new_groupbuy_order_number = $groupbuyinfo['order_num'];//订单数
	$sql = "update `$t_goods_groupbuy` set order_num='$new_groupbuy_order_number' where group_id='$group_id'";
	$sql_order = "update `$t_goods_groupbuy` set purchase_num='$new_groupbuy_order_num' where group_id='$group_id'";
	$dbo->exeUpdate($sql);
	$dbo->exeUpdate($sql_order);
}
?>