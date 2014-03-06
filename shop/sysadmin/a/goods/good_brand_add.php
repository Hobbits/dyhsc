<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require_once("../foundation/module_category.php");
//语言包引入
$a_langpackage=new adminlp;
$t_category = $tablePreStr."category";

$cat_name  = short_check(get_args('ucat_input'));
$parent_id  = intval(get_args('id'));

//定义操作
dbtarget('w',$dbServs);
$dbo=new dbex;
$sql = "insert into $t_category (cat_name,parent_id) value ('$cat_name',$parent_id)";

if($dbo->exeUpdate($sql)) {
		echo mysql_insert_id();
	} else {
		echo "0";
	}
?>