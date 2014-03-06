<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

/* 公共信息处理 header, left, footer */
require("foundation/module_shop.php");
require("foundation/module_users.php");
require("foundation/flefttime.php");
require("foundation/module_shop_category.php");
$t_shop_categories = $tablePreStr."shop_categories";
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
$t_groupbuy = $tablePreStr."groupbuy";

/* 商铺信息处理 */
$SHOP = get_shop_info($dbo,$t_shop_info,$shop_id);
//商铺分类
$shop_rank = $SHOP['shop_categories'];
$shop_rank_arr = get_categories_rank($shop_rank,$dbo,$t_shop_categories);
if ($shop_rank_arr){
	$num = count($shop_rank_arr) - 1;
}

if(!$SHOP) { trigger_error($s_langpackage->s_shop_error);}
$sql = "select rank_id,user_name,last_login_time from $t_users where user_id='".$SHOP['user_id']."'";
$ranks = $dbo->getRow($sql);
$SHOP['rank_id'] = $ranks[0];
/* 获取文章头部 */
$header = get_shop_header($s_langpackage->s_group_buy,$SHOP);
/* 时间处理 */
$now_time = new time_class();
$now_time = $now_time -> short_time();
$sql = "SELECT b.*,g.* FROM `$t_groupbuy` b left join `$t_goods` g on b.goods_id = g.goods_id";
$sql .= " WHERE b.shop_id='$shop_id' and b.recommended = 0 and g.lock_flg =0 and b.group_condition ='0' and b.examine = '1'";
$sql .= " and b.start_time <= '$now_time' and '$now_time' <= b.end_time";

$result = $dbo->fetch_page($sql,$SYSINFO['product_page']);
$nav_selected=3;
?>