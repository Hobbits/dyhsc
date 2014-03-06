<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}
error_reporting(0);
require("foundation/module_article.php");
//引入语言包
$s_langpackage=new shoplp;

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();
/* 定义文件表 */

$t_integral = $tablePreStr."integral";

$t_article_cat = $tablePreStr."article_cat";

$sql = "SELECT * FROM `$t_article_cat` order by sort_order ";
$article_cat = $dbo->getRs($sql);
if(!$article_cat) {
	trigger_error($s_langpackage->s_no_category,E_USER_ERROR);
}

foreach ($article_cat as $val){
	if($val['cat_id']==2){
		$cat_name=$val['cat_name'];
	}
}

$sql = "SELECT * FROM `$t_integral` order by int_grade";
$integral = $dbo->getRs($sql);

$header=array('title'=>'商铺信用等级','keywords'=>'商铺信用等级','description'=>'商铺信用等级');

?>