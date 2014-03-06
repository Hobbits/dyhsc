<?php
header("content-type:text/html;charset=utf-8");
$IWEB_SHOP_IN = true;
require("foundation/asession.php");
require("configuration.php");
require("includes.php");
require("foundation/fstring.php");
require("foundation/module_tag.php");
require("foundation/module_nav.php");
require("foundation/module_goods.php");
require("foundation/module_brand.php");
// require("foundation/fcustom_domain.php");
/* 用户信息处理 */
//require 'foundation/alogin_cookie.php';
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

//引入语言包
$i_langpackage=new indexlp;

$header['title'] = $i_langpackage->i_index." - ".$SYSINFO['sys_title'];
$header['keywords'] = $SYSINFO['sys_keywords'];
$header['description'] = $SYSINFO['sys_description'];

/* 定义文件表 */
$t_shop_info = $tablePreStr."shop_info";
$t_category = $tablePreStr."category";
$t_goods = $tablePreStr."goods";
$t_index_images = $tablePreStr."index_images";
$t_brand = $tablePreStr."brand";
$t_article = $tablePreStr."article";
$t_users = $tablePreStr."users";
$t_flink= $tablePreStr."flink";
$t_tag = $tablePreStr."tag";
$t_nav = $tablePreStr."nav";
$t_shop_request = $tablePreStr."shop_request";
/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();

/* 处理系统分类 */
$sql_category = "select * from `$t_category` order by sort_order asc,cat_id asc,sort_order asc";
$result_category = $dbo->getRs($sql_category);

$CATEGORY = array();
if($result_category) {
	foreach($result_category as $v) {
		$CATEGORY[$v['parent_id']][$v['cat_id']] = $v;

	}
}

/* 轮显图片 */
$sql_images = "select * from `$t_index_images` where `status`=1 order by id asc limit 6";
$images_info = $dbo->getRs($sql_images);

if($images_info) {
	$images_order = '""';
	$images_array = '';
	$i = 1;
	foreach($images_info as $images) {
		$images_order .= ',"'.$i.'"';
		$images_array .= "imgLink[$i] = '$images[images_link]'; \n";
		$images_array .= "imgUrl[$i] = '$images[images_url]'; \n";
		$images_array .= "imgText[$i] = '$images[name]'; \n";
		$i++;
	}

}

/* 产品处理 */
$sql_promote = "SELECT * FROM $t_goods WHERE is_on_sale=1 AND is_admin_promote=1 and lock_flg=0 order by pv desc limit 10";
$sql_notice = "select * from $t_article where cat_id=3 and is_show=1 order by short_order desc limit 8;";
$sql_maller = "select * from $t_article where cat_id=6 and is_show=1 order by add_time desc limit 3;";
$sql_seller = "select * from $t_article where cat_id=7 and is_show=1 order by add_time desc limit 3;";
$sql_flink = "select * from $t_flink where is_show=1 and brand_logo!='' ORDER BY brand_id DESC limit 10";


$goods_promote = $dbo->getRs($sql_promote);
$goods_hot = get_hot_goods($dbo,$t_goods,8);
$brand_rs = get_brand_list($dbo,$t_brand,8);
$notice = $dbo->getRs($sql_notice);
$maller = $dbo->getRs($sql_maller);
$seller = $dbo->getRs($sql_seller);
$tag_list = get_tag_list($dbo,$t_tag,20);
/* 友情链接 */
$flink_rs = $dbo->getRs($sql_flink);
/* 商家信息 */
$sql_shop = "SELECT a.*,b.user_name FROM $t_shop_info as a,$t_users as b,$t_shop_request as c  where a.user_id = b.user_id and a.user_id = c.user_id and c.status=1 and a.shop_commend=1 and a.lock_flg=0 and a.open_flg=0 order by shop_commend desc,a.shop_id desc limit 7;";
$shop_info = $dbo->getRs($sql_shop);

/*导航位置*/
$nav_selected=1;
$nav_list = get_nav_list($t_nav,$dbo);
?>