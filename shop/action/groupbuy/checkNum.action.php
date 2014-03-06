<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
require 'foundation/module_groupbuy.php';

//数据库操作
dbtarget('r',$dbServs);
$dbo=new dbex();

$goods_id=intval(get_args("goods_id"));
$num=intval(get_args("num"));

//定义文件表
$t_goods = $tablePreStr."goods";
$sql="select goods_number from $t_goods where goods_id=$goods_id";
$goodsnum=$dbo->getRow($sql);

if($num>$goodsnum[0]){
	echo '0';
}else{
	echo '1';
}
exit;
?>