<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}
error_reporting(0);
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

$sql = "SELECT * FROM `$t_article_cat` order by sort_order ";
$article_cat = $dbo->getRs($sql);
if(!$article_cat) {
	trigger_error($s_langpackage->s_no_category,E_USER_ERROR);
}
$article_info = get_article_info($dbo,$t_article,$article_id);
if(!$article_info) {
	trigger_error($s_langpackage->s_no_news,E_USER_ERROR);
}

foreach ($article_cat as $val){
	if($val['cat_id']==$article_info['cat_id']){
		$cat_name=$val['cat_name'];
	}
}
$up_article = get_flip_info($dbo,$t_article,$article_id,'up');
$down_article = get_flip_info($dbo,$t_article,$article_id,'down');

if($article_info['is_link'] && $article_info['link_url']) {
	echo "<script>location.href = '".$article_info['link_url']."'</script>";
	exit;
}

$header = get_header_info($article_info);

$sql = "SELECT article_id,title FROM $t_article WHERE  cat_id='8'";
$left_article_list =$dbo->getRs($sql);
?>