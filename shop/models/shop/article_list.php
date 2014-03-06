<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require("foundation/module_shop.php");
require("foundation/module_users.php");
require("foundation/module_article.php");

//引入语言包
$s_langpackage=new shoplp;

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();

/* 定义文件表 */
$t_shop_info = $tablePreStr."shop_info";
$t_user_info = $tablePreStr."user_info";
$t_users = $tablePreStr."users";
$t_shop_category = $tablePreStr."shop_category";
$t_goods = $tablePreStr."goods";
$t_article = $tablePreStr."article";
$t_article_cat = $tablePreStr."article_cat";

$cat_id = intval(get_args('id'));

$sql = "SELECT * FROM `$t_article_cat` order by sort_order asc";
$article_cat = $dbo->getRs($sql);
if(!$article_cat) {
	trigger_error($s_langpackage->s_no_category);
}

foreach ($article_cat as $val){
	if($val['cat_id']==$cat_id){
		$cat_name=$val['cat_name'];
	}
}
$result = get_article_list($dbo,$t_article,$cat_id,$SYSINFO['article_page']);

if(!$result) {
	trigger_error($s_langpackage->s_no_message);
}

$header = get_header_info($cat_name);

/*导航位置*/
$nav_selected=5;
?>