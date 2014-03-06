<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//数据表定义区
$t_user_favorite = $tablePreStr."user_favorite";
$t_goods = $tablePreStr."goods";
$t_shop_info = $tablePreStr."shop_info";
$t_goods_img = $tablePreStr."goods_attachment";

require("foundation/module_goods.php");
dbtarget('r',$dbServs);
$dbo=new dbex;
$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
$favorite_type = $_GET['favorite_type'];
$result = array();
//$sessionuserid = '15';
if ($favorite_type == "shop"){
	//查收藏的店铺
	$sql1 = "select f.favorite_id,f.shop_id,s.shop_name,s.logo_thumb,s.shop_management from `$t_user_favorite` AS f,`$t_shop_info` AS s where f.shop_id = s.shop_id and f.user_id = $sessionuserid";
	$shops = $dbo->getRsassoc($sql1);
	if ($shops){
		foreach ($shops as $shop){
			$result[$shop['favorite_id']]['favorite_id'] = $shop['favorite_id'];
			$result[$shop['favorite_id']]['shop_id'] = $shop['shop_id'];
			$result[$shop['favorite_id']]['shop_name'] = $shop['shop_name'];
			$result[$shop['favorite_id']]['logo_thumb'] = $shop['logo_thumb'];
			$result[$shop['favorite_id']]['shop_management'] = $shop['shop_management'];
		}
	}
}elseif ($favorite_type == 'good'){
	//查收藏的商品
	$sql2 = "select f.favorite_id,f.goods_id,g.goods_name,g.goods_intro,g.goods_price from `$t_user_favorite` AS f,`$t_goods` AS g where f.goods_id = g.goods_id and f.user_id = $sessionuserid";
	$goods = $dbo->getRsassoc($sql2);
	if ($goods){
		foreach ($goods as $good){
			$img = '';
			$result[$good['favorite_id']]['favorite_id'] = $good['favorite_id'];
			$result[$good['favorite_id']]['goods_id'] = $good['goods_id'];
			$result[$good['favorite_id']]['goods_name'] = $good['goods_name'];
			$result[$good['favorite_id']]['goods_price'] = $good['goods_price'];
			//商品图片
			$img = is_goods_imgs($dbo,$t_goods_img,$good['goods_id']);
			$result[$good['favorite_id']]['img_thumb'] = $img['img_thumb'];
			$result[$good['favorite_id']]['goods_intro'] = $good['goods_intro'];
		}
	}
}

if ($result){
	foreach ($result as $r){
		$final[] = $r;
	}
	$re = new returnobj('ok',$final,$chatnums);
	print_r($callback . '(' . json_encode( $re ) . ')');
	exit;
}else{
	$re = new returnobj('ok',array(),$chatnums);
	print_r($callback . '(' . json_encode( $re ) . ')');
	exit;
}






