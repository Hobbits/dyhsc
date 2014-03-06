<?php
//echo 'fdahd';
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}
///* 公共信息处理 header, left, footer */
require("foundation/module_shop.php");
//require("foundation/module_users.php");
//require("foundation/asystem_info.php");
require("foundation/module_shop_category.php");

dbtarget('r',$dbServs);
$dbo=new dbex();
//
///* 定义文件表 */

$t_shop_info = $tablePreStr."shop_info";

$t_shop_categories = $tablePreStr."shop_categories";
$t_goods = $tablePreStr."goods";
$t_goods_attachment = $tablePreStr."goods_attachment";
$t_areas = $tablePreStr."areas";
//引入模块公共方法文件
require("foundation/module_goods.php");
require("foundation/module_areas.php");
////获取店铺信息
$shop_info = get_shop_info($dbo,$t_shop_info,$shop_id);
if ($shop_info[0]['shop_categories']){
	$categoryname = get_categories_info_catid($dbo,$t_shop_categories,$shop_info[0]['shop_categories']);
}
if ($shop_info[0]['shop_province']){
	$pname = getarea($dbo,$t_areas,$shop_info[0]['shop_province']);
	$cname = getarea($dbo,$t_areas,$shop_info[0]['shop_city']);
}

if (!$shop_info[0]['logo_thumb']){
	$img = $shopthumbimg;
}else{
	$img= $baseUrl.$shop_info[0]['logo_thumb'];
}

$limit = 8;
//判断当前页码
if(empty($_GET['page'])||$_GET['page']<0){
	$page=1;
}else {
	$page=$_GET['page'];
}
$sql = "select count(*) num from `$t_goods` where shop_id='$shop_id' ";

$number = $dbo->getRow($sql);
$num = $number['num'];
$pre = $page-1;
$next = $page+1;
		
$totalPage=ceil($num/$limit); //计算出总页数
$startCount=($page-1)*$limit; //分页开始,根据此方法计算出开始的记录
$sou = "select goods_id,goods_name from `$t_goods` where shop_id='$shop_id'  limit $startCount, $limit";
$results = $dbo->getRs($sou);
//print_r($results);exit;
$return = array();
if ($results){
	foreach ($results as $value){
		$return[$value['goods_id']]['goods_id'] = $value['goods_id'];
		$return[$value['goods_id']]['goods_name'] = $value['goods_name'];
		//判断是否存在缩略图
		$pic = is_goods_imgs($dbo,$t_goods_attachment,$value['goods_id']);
		if ($pic){
			$return[$value['goods_id']]['goods_thumb'] = $pic['img_thumb'];
		}else{
			$return[$value['goods_id']]['goods_thumb'] = $goodthumbimg;
		}
		//$return[$value['goods_id']]['telphone'] = $value['telphone'];
		//$return[$value['goods_id']]['goods_intro'] = $value['goods_intro'];
		
	}
}

//获取产品信息

//$result = $dbo->fetch_page($sql,8);
//$nav_selected =3;
	
	//include '../template/main.htm';
include 'templates/default/shop.html';

?>