<?php
	/*
	***********************************************
	*$ID:get_url_content
	*$NAME:get_url_content
	*$AUTHOR:E.T.Wei
	*DATE:Sat Jun 19 15:40:00 CST 2010
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		die('Hacking attempt');
	}
	//文件引入
	require('../foundation/module_goods.php');
	require('../foundation/module_category.php');
	//引入语言包
	//语言包引入
   $a_langpackage=new adminlp;
	
	//数据表定义区
	$t_article_cat = $tablePreStr."article_cat";
	$t_category = $tablePreStr."category";
	$t_brand = $tablePreStr."brand";
	//读写分类定义方法
	$dbo = new dbex;
	dbtarget("r",$dbServs);
	$type = intval(get_args("type"));
	if (empty($type)||$type<1) {
		exit($a_langpackage->a_error_operate."！");
	}
	$str ="<select id='nav_select' onchange='change(this.value)' >";
	switch ($type){
		case 1:
			$sql="SELECT cat_id,cat_name FROM $t_category ORDER BY cat_id ASC";
			$arr = $dbo->getRs($sql);
			foreach ($arr as $value){
				$str.="<option value='category.php?id=".$value['cat_id']."'>".$value['cat_name']."</option>";
			}
			break;
		case 2:
			$sql="SELECT brand_id,brand_name FROM $t_brand ORDER BY brand_id ASC ";
			$arr = $dbo->getRs($sql);
			foreach ($arr as $value){
				$str.="<option value='brand.php?brand_id=".$value['brand_id']."'>".$value['brand_name']."</option>";
			}
			break;
		case 3:
			$sql="SELECT cat_id,cat_name FROM  $t_article_cat ORDER BY cat_id DESC";
			$arr = $dbo->getRs($sql);
			foreach ($arr as $value){
				$str.="<option value='article_list.php?id=".$value['cat_id']."'>".$value['cat_name']."</option>";
			}
			break;
		default:
			exit(0);
	}
	$str.="</select>";
	echo $str;
	
?>
