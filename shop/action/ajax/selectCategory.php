<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//种类的连动菜单
require("foundation/module_category.php");
$cat_id=intval(get_args("cat_id"));
$num=intval(get_args("num"));

$t_category=$tablePreStr."category";
$dbo=new dbex;
dbtarget('r',$dbServs);

$catearr=get_sub_category($dbo,$t_category,$cat_id);
if(empty($catearr)){
	echo 0;
}else{
	$option="<option value='0'>---请选择---</option>";
	foreach ($catearr as $v){
		$option.="<option value='".$v['cat_id']."'>".$v['cat_name']."</option>";
	}
	echo $option;
}
exit;

?>