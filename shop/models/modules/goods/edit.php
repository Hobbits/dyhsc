<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require("foundation/acheck_shop_creat.php");
require("foundation/module_category.php");
require("foundation/module_goods.php");
require("foundation/module_attr.php");
require("foundation/module_shop.php");
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
$s_langpackage=new shoplp;
 if(get_session('shop_open')!=null&&get_session('shop_open')==1){
 	trigger_error("店铺已关闭，请开启后修改!");
 }
//数据表定义区
$t_goods = $tablePreStr."goods";
$t_category = $tablePreStr."category";
$t_attribute = $tablePreStr."attribute";
$t_shop_category = $tablePreStr."shop_category";
$t_goods_attr = $tablePreStr."goods_attr";
$t_goods_transport = $tablePreStr."goods_transport";
$t_shop_payment = $tablePreStr."shop_payment";
$t_payment = $tablePreStr."payment";
$t_image_size = $tablePreStr."img_size";
$t_users = $tablePreStr."users";

$goods_id = intval(get_args('id'));

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);
//判断商品是否锁定，锁定则不许操作
include("foundation/fgoods_locked.php");
//判断用户是否锁定，锁定则不许操作
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	trigger_error($m_langpackage->m_user_locked);//非法操作
}
$goods_info = get_goods_info($dbo,$t_goods,'*',$goods_id,$shop_id);
if(empty($goods_info)) {
	trigger_error($m_langpackage->m_handle_err);//非法操作
}
$transport_template_list = get_transport_template_list($dbo,$t_goods_transport);
$category_info = get_category_info($dbo,$t_category);
$select_category_name="";
$asd_id=1;
$test1=0;
foreach($category_info as $value) {
	if($goods_info['cat_id']==$value['cat_id']) {
		$select_category_name = $value['cat_name'];
		$asd_id= $value['parent_id'];
		$test1=$value['cat_id'];
		if($asd_id!=0){
			$test1=$asd_id;
		}
		break;
	}
}

if($asd_id!=0){
	foreach($category_info as $value) {
		if($asd_id==$value['cat_id']) {
			$select_category_name = $value['cat_name']." > ".$select_category_name;
			$asd_id= $value['parent_id'];
			if($asd_id!=0){
				$test1=$asd_id;
			}
			break;
		}
	}
}
if($asd_id!=0){
	foreach($category_info as $value) {
		if($asd_id==$value['cat_id']) {
			$select_category_name = $value['cat_name']." > ".$select_category_name;
			$asd_id= $value['parent_id'];
			if($asd_id!=0){
				$test1=$asd_id;
			}
			break;
		}
	}
}
if($asd_id!=0){
	foreach($category_info as $value) {
		if($asd_id==$value['cat_id']) {
			$select_category_name = $value['cat_name']." > ".$select_category_name;
			$asd_id= $value['parent_id'];
			if($asd_id!=0){
				$test1=$asd_id;
			}
			break;
		}
	}
}

$shop_category = get_shop_category_list($dbo,$t_shop_category,$shop_id);
$html_shop_category = html_format_shop_category($shop_category,$goods_info['ucat_id']);

$attribute_info = array();
if($goods_info['cat_id']) {
	$attribute_info = get_attribute_info($dbo,$t_attribute,$goods_info['cat_id']);
}
$js_attribute_info = json_encode($attribute_info);

$goods_attr = get_goods_attr($dbo,$t_goods_attr,$goods_id);
/* 判断支付方式 */
$sql = "SELECT b.pay_id,b.pay_code FROM $t_shop_payment AS a, $t_payment AS b WHERE a.pay_id=b.pay_id AND a.shop_id=$shop_id AND a.enabled=1";
$isset_payment = $dbo->getRs($sql);

/** 取出图片 */
$sql2="select * from $t_image_size where goods_id=$goods_id";
$result = $dbo->fetch_page($sql2,10);
$imagelistid="";
if($result){
	foreach ($result['result'] as $v){
		$imagelistid.=$v['id'].",";
	}
	if($imagelistid){
		$imagelistid=substr($imagelistid,0,strlen($imagelistid)-1);
	}
}
set_session("goodsvercode",md5(rand(10000,999999)));
?>