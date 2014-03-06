<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("foundation/module_goods.php");
$t_goods_attachment = $tablePreStr."goods_attachment";
$t_goods = $tablePreStr."goods";
$t_shop_info = $tablePreStr."shop_info";
//数据库操作
$dbo=new dbex();
dbtarget('w',$dbServs);
$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
$imgid = $_GET['imgid'];
$goods_id = $_GET['goodsid'];

//获取店主
$sql = "select s.user_id from `$t_goods` AS g,`$t_shop_info` AS s where g.goods_id =$goods_id and s.shop_id = g.shop_id ";
$shopuser = $dbo->getRow($sql);
if ($sessionuserid == $shopuser['user_id']){
	
if ($imgid){
//获取主图
	$mainimg = is_goods_imgs($dbo,$t_goods_attachment,$goods_id);
	if ($mainimg['aid'] == $imgid){
		$r = new returnobj('-1','商品主图不能删除');
		print_r($callback . '(' . json_encode( $r ) . ')');
	    exit;
	}else{
	
	$re = delimg($dbo,$t_goods_attachment,$imgid);
	if($re){
		
	$result = array();
/* 数据库操作 */
	dbtarget('r',$dbServs);
	$dbo=new dbex();
	/* 产品信息获取 */
	$sql = "select goods_id,shop_id,goods_name,cat_id,email,telphone,address,goods_intro,goods_price,goods_thumb,add_time from `$t_goods` where goods_id=$goods_id and is_delete = 1";

	$goodsinfo = $dbo->getRow($sql);
	$result['goodsid'] = $goodsinfo['goods_id'];
	$result['shopid'] = $goodsinfo['shop_id'];
	$result['name'] = $goodsinfo['goods_name'];
	$result['category'] = $goodsinfo['cat_id'];
	$result['introduction'] = $goodsinfo['goods_intro'];
	$result['price'] = $goodsinfo['goods_price'];
	//$thum = basename($goodsinfo['goods_thumb']);
	//$dir = dirname($goodsinfo['goods_thumb']);
	//判断是否存在缩略图
	
//	if (file_exists($webRoot.$dir.'/thumb'.$thum)){
//	$result['picture'] = array($goodsinfo['goods_thumb'],$dir.'/thumb'.$thum);
//	}else{
//		$result['picture'] = array($goodsinfo['goods_thumb'],'');
//	}
	$result['addtime'] = $goodsinfo['add_time'];
	
	//获取店铺联系电话，邮件 ，联系地址
	$shopsql = "select shop_contact,telphone,shop_email,shop_address from $t_shop_info where shop_id=$goodsinfo[shop_id]";
	$shop_info = $dbo->getRow($shopsql);
	
	if ( $goodsinfo['email']){
		$result['contact'] = $goodsinfo['email'];
	}else{
		$result['email'] = $shop_info['shop_email'];
	}
	if ($goodsinfo['telphone']){
		$result['telphone'] = $goodsinfo['telphone'];
	}else{
		$result['telphone'] = $shop_info['telphone'];
	}
	if ($goodsinfo['address']){
		$result['address'] = $goodsinfo['address'];
	}else{
		$result['address'] = $shop_info['shop_address'];
	}
	$result['contact'] = $shop_info['shop_contact'];
	//多图
	$imgs = get_goods_pics($dbo,$t_goods_attachment,$goods_id);
	//主图
	$pic = is_goods_imgs($dbo,$t_goods_attachment,$goods_id);
	if ($pic){	
		$return[$pic['aid']]['main_img'] = $pic['main_img'];
		$return[$pic['aid']]['imgid'] = $pic['aid'];
		$return[$pic['aid']]['img_url'] = $pic['img_url'];
		$return[$pic['aid']]['img_thumb'] = $pic['img_thumb'];
		$picsrc = $webRoot.$pic['img_url'];
	  	list($width, $height, $type, $attr) = getimagesize($picsrc);
		$return[$pic['aid']]['orwidth'] = $width;
		$return[$pic['aid']]['orheight'] = $height ;
	}
	if ($imgs){
		foreach ($imgs as $img){
			$picsrc = '';
			if ($pic['aid'] != $img['aid']){
			$return[$img['aid']]['imgid'] = $img['aid'];
			$return[$img['aid']]['img_url'] = $img['img_url'];
			$return[$img['aid']]['img_thumb'] = $img['img_thumb'];	
			$picsrc = $webRoot.$img['img_url'];
		  	list($width, $height, $type, $attr) = getimagesize($picsrc);
			$return[$img['aid']]['orwidth'] = $width;
			$return[$img['aid']]['orheight'] = $height ;	
			}
	 	}
	 	if ($return){
	 		foreach ($return as $v){
	 			$rt[] = $v;
	 		}
	 	}
	 	$result['imgs'] = $rt;
	}

	if ($result){
		$r = new returnobj('ok',$result,$chatnums);
		print_r($callback . '(' . json_encode( $r ) . ')');
		exit;
	}
		
	}else{
		$r = new returnobj('-1','图片删除失败');
		print_r($callback . '(' . json_encode( $r ) . ')');
	    exit;
	}
	}
}
}else{
	$r = new returnobj('401','');
	print_r($callback . '(' . json_encode( $r ) . ')');
	exit;
}
