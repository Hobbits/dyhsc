<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}
/* 公共信息处理 header, left, footer */
require("foundation/module_shop.php");
require("foundation/module_goods.php");
require("foundation/module_users.php");
require("foundation/module_shop_category.php");


//引入语言包
$s_langpackage=new shoplp;
$i_langpackage=new indexlp;

/* 定义文件表 */
$t_shop_info = $tablePreStr."shop_info";
$t_user_info = $tablePreStr."user_info";
$t_users = $tablePreStr."users";
$t_shop_category = $tablePreStr."shop_category";
$t_goods = $tablePreStr."goods";
$t_shop_categories = $tablePreStr."shop_categories";

$s = short_check(get_args('s'));
$k = urldecode(get_args('k'));

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();
/* 用户分类信息获取 */
$sql = "select * from `$t_shop_category` where shop_cat_id='$shop_cat_id'";
$catinfo = $dbo->getRow($sql);
if(!$catinfo && $s) {
	$catinfo['shop_id'] = $s;
	$catinfo['shop_cat_name'] =$s_langpackage->s_search;
}

$ids = $shop_cat_id;
$sql = "select shop_cat_id from `$t_shop_category` where parent_id='$shop_cat_id'";
$rows = $dbo->getRs($sql);
if($rows) {
	foreach($rows as $v){
		$ids .= ','.$v['shop_cat_id'];
	}
}

$goods_sql = "";
$ks = explode(' ', $k);
$n_conditions = array();
$k_conditions = array();
foreach($ks as $key)
{
    if (!empty($key))
    {
       $n_conditions[] = "goods_name like '%$key%'";
        $k_conditions[] = "keyword like '%$key%'";
    }
}
if (!empty($n_conditions) && !empty($k_conditions))
{
    $filter = '('.implode(' OR ', $n_conditions).')';
    $goods_sql = "and $filter";
    $filter = '('.implode(' OR ', $k_conditions).')';
   $goods_sql .= ' OR ' . $filter;
}
$goods_sql .= " order by sort_order asc,goods_id desc";

if($shop_cat_id){
	$goods_sql = "select goods_id,goods_name,goods_price,goods_thumb,is_set_image from $t_goods where shop_id={$catinfo['shop_id']} and ucat_id=$shop_cat_id " . $goods_sql;
}else{
	$goods_sql = "select goods_id,goods_name,goods_price,goods_thumb,is_set_image from $t_goods where shop_id=$s " . $goods_sql;
}
$result = $dbo->fetch_page($goods_sql,20);

/* 商铺信息处理 */
$shop_id = $catinfo['shop_id'];
$SHOP = get_shop_info($dbo,$t_shop_info,$shop_id);
if(!$SHOP) { trigger_error($s_langpackage->s_shop_error);}
//商铺分类
$shop_rank = $SHOP['shop_categories'];
$shop_rank_arr = get_categories_rank($shop_rank,$dbo,$t_shop_categories);
if ($shop_rank_arr){
	$num = count($shop_rank_arr) - 1;
}
$sql = "select rank_id,user_name,last_login_time from $t_users where user_id='".$SHOP['user_id']."'";
$ranks = $dbo->getRow($sql);
$SHOP['rank_id'] = $ranks['rank_id'];
$SHOP['user_name'] = $ranks['user_name'];

$header['title'] = $catinfo['shop_cat_name']." - ".$SHOP['shop_name'];
$header['keywords'] = $catinfo['shop_cat_name'].','.$SHOP['shop_name'];
$header['description'] = $SHOP['shop_name'].$catinfo['shop_cat_name'];

$nav_selected=3;
?>