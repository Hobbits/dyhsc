<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

if(!$user_id) {
	exit("-3");
}

/* post 数据处理 */
$shop_id = intval(get_args('id'));

if(!$shop_id) {
	exit();
}

//数据表定义区
$t_user_favorite = $tablePreStr."user_favorite";
//$t_goods = $tablePreStr."goods";
$t_shop_info = $tablePreStr."shop_info";

//定义写操作
dbtarget('r',$dbServs);
$dbo=new dbex;
$sql = "select * from `$t_user_favorite` where shop_id='$shop_id' and user_id='$user_id'";
$row = $dbo->getRow($sql);
if($row) {
	exit('-1');
}

$sql = "select * from `$t_shop_info` where shop_id='$shop_id'";
$row = $dbo->getRow($sql);
if(!$row) {
	exit('-2');
}

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

$add_time = $ctime->long_time();

$sql = "insert into `$t_user_favorite` (user_id,shop_id,add_time) values ('$user_id','$shop_id','$add_time');";
if($dbo->exeUpdate($sql)) {
//	$dbo->exeUpdate("update `$t_goods` set favpv=favpv+1 where goods_id='$goods_id'");
	echo "1";
}
?>