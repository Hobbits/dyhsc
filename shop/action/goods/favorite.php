<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}


/* post 数据处理 */
$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
$goods_id = $_GET['goodid']?$_GET['goodid']:'';
$shopid = $_GET['shopid']?$_GET['shopid']:'';
if(!$goods_id && !$shopid) {
	$re = new returnobj('-1','不存在收藏的物品',$chatnums);
	print_r(json_encode($re));
	exit();
}

//数据表定义区
$t_user_favorite = $tablePreStr."user_favorite";
$t_goods = $tablePreStr."goods";

//定义写操作
dbtarget('r',$dbServs);
$dbo=new dbex;
if ($shopid == $sessionuserid){
	$re2 = new returnobj('ok','不能收藏自己的店铺',$chatnums);
	print_r($callback . '(' . json_encode( $re2 ) . ')');
	exit; 
}


if ($goods_id){
	$goodsql = "select shop_id from `$t_goods` where goods_id = $goods_id";
	$goodinfo = $dbo->getRow($goodsql);
	if ($goodinfo['shop_id'] == $sessionuserid){
		$re2 = new returnobj('ok','不能收藏自己的商品',$chatnums);
		print_r($callback . '(' . json_encode( $re2 ) . ')');
		exit; 
	}
	$sql1 = "select * from `$t_user_favorite` where goods_id='$goods_id' and user_id='$sessionuserid'";
	$row1 = $dbo->getRow($sql1);
}
if ($shopid){
	$sql2 = "select * from `$t_user_favorite` where shop_id='$shopid' and user_id='$sessionuserid'";
	$row2 = $dbo->getRow($sql2);
}
if($row1) {
	
	$re1 = new returnobj('ok','商品已收藏',$chatnums);
	print_r($callback . '(' . json_encode( $re1 ) . ')');
	exit;      //已经收藏过了
}elseif ($row2){
	$re2 = new returnobj('ok','店铺已收藏',$chatnums);
	print_r($callback . '(' . json_encode( $re2 ) . ')');
	exit; 
}

//if (){
//	
//}

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

$add_time = $ctime->long_time();
if ($goods_id){
	$sql = "insert into `$t_user_favorite` (user_id,goods_id,add_time) values ('$sessionuserid','$goods_id','$add_time');";
}elseif ($shopid){
	$sql = "insert into `$t_user_favorite` (user_id,add_time,shop_id) values ('$sessionuserid','$add_time','$shopid');";	
}
if($dbo->exeUpdate($sql)) {
	$re = new returnobj('ok','收藏成功',$chatnums);
	print_r($callback . '(' . json_encode( $re ) . ')');
	exit;
}
?>
