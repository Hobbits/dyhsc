<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//语言包引入
$m_langpackage=new moduleslp;

/* post 数据处理 */
$parent_id = intval(get_args('value'));
$rank = intval(get_args('rank'));

if(!$parent_id) {
	exit();
}

//数据表定义区
$t_shop_categories = $tablePreStr."shop_categories";
//定义读操作
dbtarget('r',$dbServs);
$dbo=new dbex;

$sql ="select cat_id,cat_name,parent_id from `$t_shop_categories` where parent_id ='$parent_id'";
$categories_info = $dbo->getRs($sql);

if(!$categories_info) {
	exit();
}

$select = "";

if ($rank == 0){
	$select .= '<select name="rank1" onchange="v_change(this.value,1);">';
	$select .= '<option value="0">'.$m_langpackage->m_select_cateogry.'</option>';
}else if($rank == 1){
	$select .= '<select name="rank2" onchange="v_change(this.value,2);">';
	$select .= '<option value="0">'.$m_langpackage->m_select_cateogry.'</option>';
}else if($rank == 2){
	$select .= '<select name="rank3" onchange="v_change(this.value,3);">';
	$select .= '<option value="0">'.$m_langpackage->m_select_cateogry.'</option>';
}else if($rank == 3){
	$select .= '<select name="rank4" onchange="v_change(this.value,4);">';
	$select .= '<option value="0">'.$m_langpackage->m_select_cateogry.'</option>';
}

foreach($categories_info as $v) {
	$select .= '<option value="' . $v['cat_id'] . '">' . $v['cat_name'] . '</option>';
}

$select .= '</select>';
echo $select;

?>