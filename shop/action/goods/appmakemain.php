<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("foundation/module_goods.php");
$t_goods = $tablePreStr."goods";
$t_goods_attachment = $tablePreStr."goods_attachment";
$t_shop_info = $tablePreStr."shop_info";
//数据库操作
$dbo=new dbex();
dbtarget('w',$dbServs);
$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
$imgid = $_GET['imgid'];
$goods_id = $_GET['goodsid'];

//店主id
$sql = "select s.user_id from `$t_goods` AS g,`$t_shop_info` AS s where g.goods_id =$goods_id and s.shop_id = g.shop_id ";
$shopuser = $dbo->getRow($sql);
if ($shopuser['user_id'] == $sessionuserid){

//获取商品主图
$img = is_goods_imgs($dbo,$t_goods_attachment,$goods_id);
if ($img['aid'] == $imgid){
	$r = new returnobj('ok','此图片为当前商品的主图',$chatnums);
	print_r($callback . '(' . json_encode( $r ) . ')');
	exit;
}else{
	//讲原来的主图删除
	$mainimg = is_goods_imgs($dbo,$t_goods_attachment,$goods_id);
	$mid = $mainimg['aid'];
	goodmovemain($dbo,$t_goods_attachment,$goods_id,$mid);
	$s = goodmakemain($dbo,$t_goods_attachment,$goods_id,$imgid);
	if ($s){
		$r = new returnobj('ok','商品主图设置成功',$chatnums);
		print_r($callback . '(' . json_encode( $r ) . ')');
		exit;
	}
}

}else{
	$r = new returnobj('401','');
	print_r($callback . '(' . json_encode( $r ) . ')');
	exit;
}
