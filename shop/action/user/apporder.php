<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
require("foundation/module_order.php");
require("foundation/module_goods.php");
//require("foundation/module_photo.php");

//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();

//定义文件表
$t_order_info = $tablePreStr."order_info";

$t_goods = $tablePreStr."goods";
$t_goods_attachment = $tablePreStr."goods_attachment";
$t_order_goods = $tablePreStr."order_goods";

// 处理post变量

$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
$rand = rand(10,99);
$post['payid'] = date("YmdHis".$rand);
$info['goods_id'] = intval(get_args('goods_id'));
$goodid = $info['goods_id'];
//获取商品的价格
$sql = "select goods_price,shop_id,goods_name from `$t_goods` where goods_id = $goodid ";
$p = $dbo->getRow($sql);

$post['shop_id'] = $p['shop_id'];
$post['user_id'] = $sessionuserid;
if ($sessionuserid != $p['shop_id'] ){
$post['consignee'] =get_args('consignee');
$post['mobile'] = get_args('mobile');
$post['address'] = get_args('address');
$post['message'] = get_args('message');
$post['order_time'] =  $ctime->long_time();



$price = $p['goods_price'];
$info['order_num'] = intval(get_args('order_num'));
$info['goods_name'] = $p['goods_name'];
$imgsql = "select aid from `$t_goods_attachment` where goods_id = $goodid and main_img = 1";
$img = $dbo->getRow($imgsql);
//保存主图
$info['photoid'] = $img['aid'];
$post['transport_price'] = get_args('fee');
$post['order_amount'] = $price*$info['order_num']+$info['good_tran'];

//生成订单
//$err_no=0;
$order_id = $dbo->createbyarr($post,$t_order_info);
if ($order_id) {
	$info['order_id'] = $order_id;
	$info['goods_price'] = $price;
	
	$info['add_time'] = $ctime->long_time();
	if($dbo->createbyarr($info,$t_order_goods)){
		//$post['goods_name'] = $p['goods_name'];
		$r = new returnobj('ok',$post['payid'],$chatnums);
		print_r($callback . '(' . json_encode( $r ) . ')');
		exit;
		
	}
}
}else{
	$r = new returnobj('-1','不能购买自己的商品');
	print_r($callback . '(' . json_encode( $r ) . ')');
	exit;
}
?>
