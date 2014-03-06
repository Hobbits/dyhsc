<?php
header("content-type:text/html;charset=utf-8");
$IWEB_SHOP_IN = true;

require("foundation/asession.php");
require("configuration.php");
require("includes.php");
require_once("foundation/fstring.php");

require_once("foundation/module_areas.php");

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

//引入语言包
$i_langpackage=new indexlp;

/* 定义文件表 */
$t_shop_info = $tablePreStr."shop_info";
$t_users = $tablePreStr."users";
$t_goods = $tablePreStr."goods";
$t_areas = $tablePreStr."areas";
$t_user_rank = $tablePreStr."user_rank";
$t_shop_categories = $tablePreStr."shop_categories";

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();

/* 处理商铺分类 */
$sql_category = "select * from `$t_shop_categories` order by sort_order asc,cat_id asc";
$result_category = $dbo->getRs($sql_category);

$CATEGORY = array();
if($result_category) {
	foreach($result_category as $v) {
		$CATEGORY[$v['parent_id']][$v['cat_id']] = $v;

	}
}

/* 地区信息 */
$areainfo = get_areas_kv($dbo,$t_areas);
/* 获得省级地址 */
$area_arr = "select area_id,area_name from `$t_areas` where area_type='1'";
$area_list = $dbo->getRs($area_arr);
$area_id = intval(get_args('areaid'));

/* 列表处理 */
$k = short_check(get_args('k'));

$sql = "SELECT * FROM `$t_shop_info` as a, `$t_users` as b ,$t_user_rank as c WHERE a.user_id=b.user_id and open_flg=0 and b.rank_id=c.rank_id ";

if($k) {
	$sql .= " and a.shop_name LIKE '%$k%' ";
}
if ($area_id){
	$sql .= " and a.shop_province = '$area_id'";
}

$sql .= " ORDER BY shop_creat_time DESC";
$result = $dbo->fetch_page($sql,$SYSINFO['seller_page']);

$header['title'] = $i_langpackage->i_s_company." - ".$SYSINFO['sys_title'];
$header['keywords'] = $i_langpackage->i_s_company.','.$SYSINFO['sys_keywords'];
$header['description'] = $SYSINFO['sys_description'];
?>