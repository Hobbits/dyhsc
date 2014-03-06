<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
require("foundation/module_order.php");
require("foundation/module_goods.php");
require("foundation/module_photo.php");
require("foundation/module_areas.php");
require("foundation/module_shop.php");

//定义文件表
$t_order_info = $tablePreStr."order_info";

$t_goods = $tablePreStr."goods";
$t_order_goods = $tablePreStr."order_goods";
$t_goods_attachment = $tablePreStr."goods_attachment";
$t_shop_info = $tablePreStr."shop_info";
$t_areas = $tablePreStr."areas";

//数据库操作
dbtarget('r',$dbServs);
$dbo=new dbex();

$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
$orderid = $_GET['payid'];
//$orderid = '2013070309564379';
$sql = "select i.payid,g.photoid,i.user_id,g.goods_id,g.goods_name,g.goods_price,g.order_num,i.transport_price,i.order_amount,i.consignee,i.province,i.city,i.address,i.mobile,i.order_time,i.message from `$t_order_info` AS i ,`$t_order_goods` AS g where payid=$orderid and i.order_id = g.order_id";
$order = $dbo->getRsassoc($sql);
$order = $order[0];
$infoarray = array('payid','photoid','user_id','goods_id','goods_name','goods_price','order_num','transport_price','order_amount','consignee','province','city','address','mobile','order_time','message');
foreach ($infoarray as $i){
	if ($i == 'photoid'){
		$goodid = $order['goods_id'];
		$psql = "select img_url,img_thumb from `$t_goods_attachment` where goods_id= $goodid and main_img= 1 and is_delete = 1 ";
		$imgurl = $dbo->getRow($psql);
		$result['img_url'] = $imgurl['img_url'];
		$result['img_thumb'] = $imgurl['img_thumb'];
	}elseif ($i == 'province'){
		$province = getarea($dbo,$t_areas,$order['province']);
		$result['province'] = $province;
	}elseif ($i == 'city'){
		$city = getarea($dbo,$t_areas,$order['city']);
		$result['city'] = $city;
	}elseif ($i == 'order_time'){
		$result['order_time'] = $order['order_time'];
	}elseif ($i == 'user_id'){
		$result['buyerid'] = $order['user_id'];
	}else{
		$result[$i] = $order[$i];
	}
}
//卖家信息
$gid = $order['goods_id'];
//$gid = '50';
$sid = $order['shop_id'];
$goodinfo = get_goods_attr($dbo,$t_goods,$gid);
$shopinfo = get_shop_info($dbo,$t_shop_info,$sid);
$result['shop_contact'] = $shopinfo['shop_contact'];
if ($goodinfo[0]['telphone']){
	$result['telphone'] = $goodinfo[0]['telphone'];
}else{
	$result['telphone'] =$shopinfo['telphone'];
	
}
if ($goodinfo[0]['address']){
	$result['goodaddress'] = $goodinfo[0]['address'];
}else{
	$result['goodaddress'] = $shopinfo['shop_address'];
}
$result['shop_id'] = $order['shop_id'];
//我是卖家
if ($order['shop_id'] == $sessionuserid){
	//查看订单是否已查看
	if (empty($order['read'])){
		//改变订单的状态
		$update_items = array('read' => '1');
		upd_order_info($dbo,$t_order_info,$update_items,$order['order_id']);
	}
}


if ($result){
	$r = new returnobj('ok',$result,$chatnums);
	print_r($callback . '(' . json_encode( $r ) . ')');
	exit;
}