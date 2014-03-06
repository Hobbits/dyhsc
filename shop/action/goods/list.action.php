<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
require("foundation/module_goods.php");
require("foundation/module_gallery.php");

//语言包引入
$m_langpackage=new moduleslp;

$dbo=new dbex();
dbtarget('w',$dbServs);

//定义文件表
$t_goods = $tablePreStr."goods";
$t_shop = $tablePreStr."shop_info";

$s_open=get_goods_openflg($dbo,$t_shop,$shop_id);

$goods_ids = implode(",",get_args('checkbox'));

if($s_open&&$s_open[0]==1){
	action_return(0,'店铺关闭，操作失败','-1');
	exit;
}

if(short_check(get_args('down'))) {
	$sql = "update `$t_goods` set is_on_sale=0 where goods_id in ($goods_ids) and shop_id='$shop_id'";
	$dbo->exeUpdate($sql);
} elseif(short_check(get_args('up'))) {
	$sql = "update `$t_goods` set is_on_sale=1 where goods_id in ($goods_ids) and shop_id='$shop_id'";
	$dbo->exeUpdate($sql);
}

action_return();
?>