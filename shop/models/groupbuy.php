<?php
header("content-type:text/html;charset=utf-8");
$IWEB_SHOP_IN = true;

require("foundation/asession.php");
require("configuration.php");
require("includes.php");
require_once("foundation/fstring.php");
require("foundation/flefttime.php");
require("foundation/module_tag.php");
require("foundation/module_nav.php");

/* 用户信息处理 */
require 'foundation/alogin_cookie.php';
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
$i_langpackage = new indexlp;
$s_langpackage=new shoplp;

/* 定义文件表 */
$t_shop_info = $tablePreStr."shop_info";
$t_user_info = $tablePreStr."user_info";
$t_users = $tablePreStr."users";
$t_shop_category = $tablePreStr."shop_category";
$t_goods = $tablePreStr."goods";
$t_groupbuy = $tablePreStr."groupbuy";
$t_areas = $tablePreStr."areas";
$t_tag = $tablePreStr."tag";
$t_nav = $tablePreStr."nav";
$t_category = $tablePreStr."category";

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();

/* 产品处理 */
$sql_best = "SELECT * FROM $t_goods WHERE is_on_sale=1 AND is_best=1 and lock_flg=0 order by pv desc limit 4";
$sql_hot = "SELECT * FROM $t_goods WHERE is_on_sale=1 AND is_hot=1 and lock_flg=0 order by pv desc limit 10";
$goods_best = $dbo->getRs($sql_best);
$goods_hot = $dbo->getRs($sql_hot);

/* 浏览记录 */
$getcookie = get_hisgoods_cookie();
$goodshistory = array();
if($getcookie) {
	arsort($getcookie);
	$getcookie = array_keys($getcookie);
	$gethisgoodsid = implode(",",array_slice($getcookie, 0, 4));
	$sql = "select is_set_image,goods_id,goods_name,goods_thumb,goods_price from $t_goods where goods_id in ($gethisgoodsid)";
	$goodshistory = $dbo->getRs($sql);
}

$header['title'] = $i_langpackage->i_lay_out." - ".$SYSINFO['sys_title'];
$header['keywords'] = $i_langpackage->i_lay_out.','.$SYSINFO['sys_keywords'];
$header['description'] = $SYSINFO['sys_description'];

/* 时间处理 */
$now_time = new time_class();
$now_time = $now_time -> short_time();

$group_id=array();
$sql="select group_id from $t_groupbuy where group_condition ='-1' and examine='1'";
$groups_id = $dbo->getRs($sql);
foreach($groups_id as $key=>$val){
	$group_id[$key]=$val[0];
}
$group_id=implode(',',$group_id);

$sql="update $t_groupbuy set group_condition ='0' where  start_time <= '$now_time' and '$now_time' <= end_time ";
if($group_id){
	$sql.=" and group_id in($group_id)";
}
$dbo->exeUpdate($sql);

$group_id=array();
$sql="select group_id from $t_groupbuy where group_condition ='0' and examine='1'";
$groups_id = $dbo->getRs($sql);
foreach($groups_id as $key=>$val){
	$group_id[$key]=$val[0];
}
$group_id=implode(',',$group_id);

$sql="update $t_groupbuy set group_condition ='1' where '$now_time' >= end_time ";
if($group_id){
	$sql.=" and group_id in($group_id)";
}
$dbo->exeUpdate($sql);


$sql = "SELECT b.*,g.* FROM `$t_groupbuy` b left join `$t_goods` g on b.goods_id = g.goods_id";
$sql .= " WHERE b.recommended = 0 and g.lock_flg =0 and b.group_condition ='0' and b.examine = '1'";
//$sql .= " and b.start_time <= '$now_time' and '$now_time' <= b.end_time";
$result = $dbo->fetch_page($sql,$SYSINFO['product_page']);
$tag_list = get_tag_list($dbo,$t_tag,15);


$nav_selected =6;
$nav_list = get_nav_list($t_nav,$dbo);

	/* 处理系统分类 */
$sql_category = "select * from `$t_category` order by sort_order asc,cat_id asc,sort_order asc";
$result_category = $dbo->getRs($sql_category);

$CATEGORY = array();
if($result_category) {
	foreach($result_category as $v) {
		$CATEGORY[$v['parent_id']][$v['cat_id']] = $v;

	}
}
?>