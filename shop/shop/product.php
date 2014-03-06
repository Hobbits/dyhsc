<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("foundation/module_shop.php");
require("foundation/module_goods.php");
require("foundation/module_users.php");
require("foundation/module_shop_category.php");

require("foundation/module_areas.php");
$t_shop_info = $tablePreStr."shop_info";
$t_user_info = $tablePreStr."user_info";
$t_users = $tablePreStr."users";
$t_goods = $tablePreStr."goods";
$t_areas = $tablePreStr."areas";
$t_goods_attachment = $tablePreStr."goods_attachment";
$t_category = $tablePreStr."category";
$t_shop_categories = $tablePreStr."shop_categories";

$goods_id = $_GET['productid'] ? $_GET['productid']:'0';
$shopid = $_GET['shopid'];

//$goods_id = 39;
$result = array();
/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();
	
	//获取店铺信息
	$shop_info = get_shop_info($dbo,$t_shop_info,$shopid);
//	print_r($shop_info);
	if ($shop_info[0]['shop_categories']){
		$categoryname = get_categories_info_catid($dbo,$t_shop_categories,$shop_info[0]['shop_categories']);
	}
	/* 产品信息获取 */
	$sql = "select goods_id,shop_id,goods_name,cat_id,email,telphone,address,goods_intro,goods_price,goods_thumb,add_time from `$t_goods` where goods_id=$goods_id and is_delete = 1";

	$goodsinfo = $dbo->getRow($sql);
	$result['goodsid'] = $goodsinfo['goods_id'];
	$result['shopid'] = $goodsinfo['shop_id'];
	$result['name'] = $goodsinfo['goods_name'];
	$result['category'] = $goodsinfo['cat_id'];
	//一级分类
	$c = $goodsinfo['cat_id'];
	$catesql = "select parent_id from `$t_category` where cat_id = $c";
	$pid = $dbo->getRow($catesql);
	$result['maincategory'] = $pid['parent_id']; 
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
	//$shopsql = "select shop_contact,telphone,shop_email,shop_address from $t_shop_info where shop_id=$goodsinfo[shop_id]";
	//$shop_info = $dbo->getRow($shopsql);
	if ($shop_info[0]['shop_province']){
	$pname = getarea($dbo,$t_areas,$shop_info[0]['shop_province']);
	$cname = getarea($dbo,$t_areas,$shop_info[0]['shop_city']);
	}
	
	if ( $goodsinfo['email']){
		$result['contact'] = $goodsinfo['email'];
	}else{
		$result['email'] = $shop_info[0]['shop_email'];
	}
	if ($goodsinfo['telphone']){
		$result['telphone'] = $goodsinfo['telphone'];
	}else{
		$result['telphone'] = $shop_info[0]['telphone'];
	}
	if ($goodsinfo['address']){
		$result['address'] = $goodsinfo['address'];
	}else{
		$result['address'] = $shop_info[0]['shop_address'];
	}
	$result['contact'] = $shop_info[0]['shop_contact'];
	$pic = is_goods_imgs($dbo,$t_goods_attachment,$goods_id);
	if (!$pic){
		$pic['img_url'] = $goodimg;
	}
	//多图
//	$imgs = get_goods_pics($dbo,$t_goods_attachment,$goods_id);
//
//	if ($imgs){
//		$pic = is_goods_imgs($dbo,$t_goods_attachment,$goods_id);
//		if ($pic){
//			$return[$pic['aid']]['main_img'] = $pic['main_img'];
//			$return[$pic['aid']]['imgid'] = $pic['aid'];
//			$return[$pic['aid']]['img_url'] = $pic['img_url'];
//			$return[$pic['aid']]['img_thumb'] = $pic['img_thumb'];
//		    $picsrc = $webRoot.$pic['img_url'];
//		  	list($width, $height, $type, $attr) = getimagesize($picsrc);
//			$return[$pic['aid']]['orwidth'] = $width;
//			$return[$pic['aid']]['orheight'] = $height ;
//		}
//		foreach ($imgs as $img){
//			$picsrc = '';
//			if ($pic['aid'] != $img['aid']){
//
//			$return[$img['aid']]['imgid'] = $img['aid'];
//			$return[$img['aid']]['img_url'] = $img['img_url'];
//			$return[$img['aid']]['img_thumb'] = $img['img_thumb'];
//			$picsrc = $webRoot.$img['img_url'];
//		  	list($width, $height, $type, $attr) = getimagesize($picsrc);
//			$return[$img['aid']]['orwidth'] = $width;
//			$return[$img['aid']]['orheight'] = $height ;
//			}
//	 	}
//	 	if ($return){
//	 		foreach ($return as $v){
//	 			$rt[] = $v;
//	 		}
//	 	}
//	 	$result['imgs'] = $rt;
//	}

	include 'templates/default/product.html';
	