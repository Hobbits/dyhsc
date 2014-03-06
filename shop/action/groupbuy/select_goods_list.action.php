<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
/* post 数据处理 */
$shop_category = intval(get_args('shop_category'));
$goodsselect_name = short_check(get_args('goodsselect_name'));

//数据表定义区
$t_goods = $tablePreStr."goods";
$t_shop_category = $tablePreStr."shop_category";
$t_groupbuy = $tablePreStr."groupbuy";

//定义写操作
dbtarget('r',$dbServs);
$dbo=new dbex;

if($shop_category!=""){
	$sql="select * from $t_shop_category where parent_id=$shop_category";
	$category_list= $dbo->getRs($sql);
	foreach($category_list as $key=>$val){
		$str_catrgory[$key]=$val['shop_cat_id'];
		$shop_category=implode(",",$str_catrgory);
	}
}
$sql="select goods_id from $t_groupbuy where shop_id=$shop_id and group_condition ='0' and examine = '1'";
$a_goods_id= $dbo->getRs($sql);
foreach($a_goods_id as $key=>$val){
	$goods_id[$key]=$val[0];
}
if(isset($a_goods_id)&&$a_goods_id){
	$a_goods_id=implode(',',$goods_id);
}else{
	$a_goods_id="";
}

$sql="select * from $t_goods where shop_id=$shop_id  and lock_flg !=1 and is_on_sale = 1";

if($a_goods_id!=""){
	$sql.=" and goods_id not in($a_goods_id) ";
}
if($goodsselect_name!=""){
	$sql.=" and goods_name like '%$goodsselect_name%' ";
}
if($shop_category!=""){
	$sql.=" and ucat_id in($shop_category) ";
}

$goods_list= $dbo->getRs($sql);
$str= "";
foreach($goods_list as $val){
	//$str.= "<option ondblclick=\"select_goods_id(this)\" value='".$val['goods_id']."'>".$val['goods_name']."</option>";
	$str.= "<option value='".$val['goods_id']."'>".$val['goods_name']."</option>";
}
echo $str;

?>