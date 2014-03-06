<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//引入模块公共方法文件
require("foundation/module_goods.php");
require_once("foundation/fsqlitem_set.php");

/* post 数据处理 */
$goods_id = intval(get_args('id'));
$num = intval(get_args('num'));

//数据表定义区
$t_cart = $tablePreStr."cart";
$t_goods = $tablePreStr."goods";

dbtarget('r',$dbServs);
$dbo=new dbex;
$goods_info = get_goods_info($dbo,$t_goods,array('goods_name','goods_price','goods_number'),$goods_id);
//写入session
if (!get_session('cart')) {
	set_session('cart',array());
}
if($goods_info) {
	if($num > $goods_info['goods_number']) {
		exit('-2');
	}
} else {
	exit(0);
}
if (get_session('cart')) {
	$car=get_session('cart');
	if(isset($car[$goods_id])){
		$car[$goods_id]['num']=$car[$goods_id]['num']+$num;
		$car[$goods_id]['add_time']=date("Y-m-d H:i:s");
		set_session('cart',$car);
	}
}else{
	$car=get_session('cart');
	$car[$goods_id]=array();
	$car[$goods_id]['num']=$num;
	$car[$goods_id]['add_time']=date("Y-m-d H:i:s");
	set_session('cart',$car);
}


if(!$goods_id || !$num) {
	exit();
}

//定义写操作

$sql = "select * from `$t_cart` where goods_id='$goods_id' and user_id='$user_id'";
$row = $dbo->getRow($sql);
if($row) {
	exit('-1');
}

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;
$insert_array = array(
	'user_id' => $user_id,
	'goods_id' => $goods_id,
	'goods_number' => $num,
	'add_time' => $ctime->long_time(),
);

if ($user_id) {
	$item_sql = get_insert_item($insert_array);
	$sql = "insert into `$t_cart` $item_sql ";
	if($dbo->exeUpdate($sql)) {
		echo "1";
		/* 此处不在减少商品库存，在生成订单时减少 */
//		$new_goods_num = $goods_info['goods_number'] - $num;
//		$sql = "update `$t_goods` set goods_number='$new_goods_num' where goods_id='$goods_id'";
//		$dbo->exeUpdate($sql);
	}
}else{
	echo "-3";
}
?>