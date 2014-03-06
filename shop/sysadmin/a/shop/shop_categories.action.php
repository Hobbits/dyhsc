<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//语言包引入
$a_langpackage=new adminlp;

/* post 数据处理 */
$parent_id = intval(get_args('value'));
$child_value = intval(get_args('child_value'));
if(!$parent_id) {
	exit();
}
if(!$child_value) {
	$child_value=0;
}
require("../foundation/module_shop_category.php");
//数据表定义区
$t_shop_categories=$tablePreStr."shop_categories";
//定义读操作
dbtarget('r',$dbServs);
$dbo=new dbex;

$shop_categories = get_categories_item_parentid($dbo,$t_shop_categories,$parent_id);
if(!$shop_categories) {
	exit();
}

$select = '<select name="categories" >';

foreach($shop_categories as $v) {
	if($v['cat_id']==$child_value)
	 	$select .= '<option value="' . $v['cat_id'] . '" selected >' . $v['cat_name'] . '</option>';
	else
	 	$select .= '<option value="' . $v['cat_id'] . '">' . $v['cat_name'] . '</option>';
}
$select .= '</select>';
echo $select;
?>