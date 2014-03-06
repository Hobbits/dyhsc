<?php
//header('Content-type: text/json');
echo header("Access-Control-Allow-Origin:*");
echo header("Access-Control-Allow-Headers: *");
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
require("foundation/module_goods.php");
//定义文件表
$t_goods = $tablePreStr."goods";
$t_goods_attachment = $tablePreStr."goods_attachment";
$t_shop_info = $tablePreStr."shop_info";
//数据库操作
$dbo=new dbex();
dbtarget('r',$dbServs);

$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
//获取店铺的商品
$shop_id = $_GET['shopid'];
$shopsql = "select shop_name from $t_shop_info where user_id='$shop_id'";
$shopname = $dbo->getRow($shopsql);
//$shop_id = '20';
$sql = "select goods_id,goods_name,goods_thumb,telphone,goods_intro  from `$t_goods` where shop_id='$shop_id'";
$result = $dbo->getRs($sql);
$return = array();
if ($result){
	foreach ($result as $value){
		$return[$value['goods_id']]['goods_id'] = $value['goods_id'];
		$return[$value['goods_id']]['goods_name'] = $value['goods_name'];
		//判断是否存在缩略图
		$pic = is_goods_imgs($dbo,$t_goods_attachment,$value['goods_id']);
		if ($pic){
			$return[$value['goods_id']]['goods_thumb'] = $pic['img_thumb'];
		}else{
			$return[$value['goods_id']]['goods_thumb'] = $goodthumbimg;
		}
		$return[$value['goods_id']]['telphone'] = $value['telphone'];
		$return[$value['goods_id']]['goods_intro'] = $value['goods_intro'];
		
	}
	$rs = array();
	$rs['shopname'] = $shopname['shop_name'];
	if ($return){
		foreach ($return as $v){
		$rs['goodslist'][] = $v;	
		}
	}
	$r = new returnobj('ok',$rs,$chatnums);
	print_r($callback . '(' . json_encode( $r ) . ')');
    exit;
}else {
	$r = new returnobj('ok',array('shopname'=> $shopname['shop_name'],'goodslist' => array()),$chatnums);
	print_r($callback . '(' . json_encode( $r ) . ')');
    exit;
}