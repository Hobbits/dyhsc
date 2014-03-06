<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

/* 公共信息处理 header, left, footer */
require("foundation/module_shop.php");
require("foundation/module_users.php");
require("foundation/module_shop_category.php");

//引入语言包
$s_langpackage=new shoplp;
$i_langpackage=new indexlp;
/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();

/* 定义文件表 */
$t_shop_info = $tablePreStr."shop_info";
$t_user_info = $tablePreStr."user_info";
$t_users = $tablePreStr."users";
$t_shop_category = $tablePreStr."shop_category";
$t_goods = $tablePreStr."goods";
$t_shop_categories = $tablePreStr."shop_categories";

/* 商铺信息处理 */
$SHOP = get_shop_info($dbo,$t_shop_info,$shop_id);
if(!$SHOP) { trigger_error($s_langpackage->s_shop_error);}//无此商铺
//商铺分类
$shop_rank = $SHOP['shop_categories'];
$shop_rank_arr = get_categories_rank($shop_rank,$dbo,$t_shop_categories);
if ($shop_rank_arr){
	$num = count($shop_rank_arr) - 1;
}

$sql = "select rank_id,user_name,last_login_time from $t_users where user_id='".$SHOP['user_id']."'";
$ranks = $dbo->getRow($sql);
$SHOP['rank_id'] = $ranks[0];
/* 获取文章头部 */
$header = get_shop_header($s_langpackage->s_products,$SHOP);

$sql = "select goods_id,goods_name,goods_price,goods_thumb,is_set_image,transport_template_price from `$t_goods` where shop_id='$shop_id' and is_on_sale=1 order by sort_order asc,goods_id desc";
$result = $dbo->fetch_page($sql,20);
$nav_selected =3;
?>