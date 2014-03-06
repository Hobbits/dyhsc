<?php
header("content-type:text/html;charset=utf-8");
$IWEB_SHOP_IN = true;
require("foundation/asession.php");
require("configuration.php");
require("includes.php");
require_once("foundation/fstring.php");
require_once("foundation/module_areas.php");
require_once("foundation/module_tag.php");
require("foundation/module_goods.php");
//引入语言包
$i_langpackage = new indexlp;
/* 用户信息处理 */
if(get_sess_user_id()) {
	$USER['login'] = 1;
	$USER['user_name'] = get_sess_user_name();
	$USER['user_id'] = get_sess_user_id();
	$USER['user_email'] = get_sess_user_email();
	$USER['shop_id'] = get_sess_shop_id();
} else {
	$USER['login'] = 0;
	$USER['user_name'] = '';
	$USER['user_id'] = '';
	$USER['user_email'] = '';
	$USER['shop_id'] = '';
}
//print_r($_GET);

/* 定义文件表 */
$t_shop_info = $tablePreStr."shop_info";
$t_category = $tablePreStr."category";
$t_goods = $tablePreStr."goods";
$t_areas = $tablePreStr."areas";
$t_users = $tablePreStr."users";
$t_keywords_count = $tablePreStr."keywords_count";
$t_goods_attr = $tablePreStr."goods_attr";
$t_brand = $tablePreStr."brand";
$t_brand_category = $tablePreStr."brand_category";
$t_attribute = $tablePreStr."attribute";
$t_user_rank = $tablePreStr."user_rank";
$t_tag = $tablePreStr."tag";

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();
$brand_id = intval(get_args("brand_id"));
//$brand_id=18;

$sql="select * from $t_brand where brand_id=$brand_id and is_show=1";
$brand_info=$dbo->getRow($sql);

$sql="SELECT g.pv,g.is_set_image,g.brand_id,g.transport_price,g.transport_template_price,g.goods_thumb,g.goods_id,g.cat_id,g.goods_name,g.goods_price,g.goods_intro,g.shop_id,s.shop_id,s.shop_name,s.user_id,s.shop_country,s.shop_province,s.shop_district,s.shop_city,u.user_id,u.rank_id,ur.rank_id,ur.rank_name,
		s.shop_province,s.shop_city	FROM `$t_goods` AS g,`$t_users` AS u,`$t_shop_info` AS s,`$t_user_rank` AS ur WHERE g.brand_id='$brand_id' and g.shop_id=s.shop_id and g.shop_id=u.user_id and u.rank_id=ur.rank_id";
$result = $dbo->fetch_page($sql,$SYSINFO['product_page']);

$tag_list = get_tag_list($dbo,$t_tag,15);

//print_r($result);

$areainfo = get_areas_kv($dbo,$t_areas);

$k=short_check(get_args("k"));
$cat_id = intval(get_args("cat_id"));
$min_price = intval(get_args("min_price"));
$max_price = intval(get_args("max_price"));
$country = intval(get_args("country"));
$province = intval(get_args("province"));
$city	= intval(get_args("city"));
$district = intval(get_args("district"));
$search_type = short_check(get_args("search_type"));
$search_type = !empty($search_type)?$search_type:$i_langpackage->i_goods_search;
/* 处理系统分类 */
$sql_category = "select c.* from `$t_category` as c, $t_brand_category as b where b.brand_id=$brand_id and c.cat_id=b.cat_id";
$cat_rs = $dbo->getRs($sql_category);



$header['title'] = $i_langpackage->i_brand_detail;
$header['keywords'] = $SYSINFO['sys_keywords'];
$header['description'] = $SYSINFO['sys_description'];
/* 浏览记录 */
$getcookie = get_hisgoods_cookie();
$goodshistory = array();
if($getcookie) {
	$goodshistory = get_good_shistory($dbo,$getcookie,$t_goods);
}
$sql_best = "SELECT * FROM $t_goods WHERE is_on_sale=1 AND is_best=1 and lock_flg=0 order by pv desc limit 4";
$goods_best = $dbo->getRs($sql_best);
$goods_hot = get_hot_goods($dbo,$t_goods,4);
?>