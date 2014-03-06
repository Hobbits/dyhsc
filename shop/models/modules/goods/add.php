<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt1');
}

require("foundation/acheck_shop_creat.php");
require("foundation/module_category.php");
require("foundation/module_goods.php");
require("foundation/module_shop.php");

//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
 if(get_session('shop_open')!=null&&get_session('shop_open')==1){
 	trigger_error("店铺已关闭，请开启后添加!");
 }
//数据表定义区
$t_goods = $tablePreStr."goods";
$t_category = $tablePreStr."category";
$t_shop_category = $tablePreStr."shop_category";
$t_shop_payment = $tablePreStr."shop_payment";
$t_payment = $tablePreStr."payment";
$t_goods_transport = $tablePreStr."goods_transport";
$t_image_size=$tablePreStr."img_size";
//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

$rank_name=get_sess_rank_name();
$transport_template_list = get_transport_template_list($dbo,$t_goods_transport);
$this_shop_goods_num = get_goods_num($dbo,$t_goods,$shop_id);
if($user_privilege[2]<=$this_shop_goods_num) {
	$error_message = str_replace("{name}",$rank_name,$m_langpackage->m_error_message1);
	$error_message = str_replace("{num}",intval($user_privilege[2]),$error_message);
	set_sess_err_msg($error_message);
	echo '<script language="JavaScript">location.href="modules.php?app=message"</script>';
	exit;
}

$goods_info = array(
	'goods_name'	=> '',
	'cat_id'		=> 0,
	'ucat_id'		=> 0,
	'goods_intro'	=> '',
	'goods_number'	=> 99,
	'keyword'		=> '',
	'goods_price'	=> '0.00',
	'is_on_sale'	=> 1,
	'is_best'		=> 0,
	'is_new'		=> 0,
	'is_hot'		=> 0,
	'is_promote'	=> 0,
	'goods_wholesale'=> '',
	'transport_price'=> '0.00'
);

$category_info = get_category_info($dbo,$t_category);

$shop_category = get_shop_category_list($dbo,$t_shop_category,$shop_id);
$html_shop_category = html_format_shop_category($shop_category,$goods_info['ucat_id']);
/* 判断支付方式 */
$isset_payment = get_shop_payment($dbo,$t_shop_payment,$t_payment,$shop_id);
/** 取出图片 */
$sql2="select * from $t_image_size where uid=$user_id and is_intro_img=1 and goods_id=0 order by upl_time asc";
$result = $dbo->fetch_page($sql2,5);
$imagelistid="";
foreach ($result['result'] as $v){
	$imagelistid.=$v['id'].",";
}
if($imagelistid){
	$imagelistid=substr($imagelistid,0,strlen($imagelistid)-1);
}

set_session("goodsvercode",md5(rand(10000,999999)));

?>