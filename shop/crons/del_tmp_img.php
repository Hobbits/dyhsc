<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//数据表定义区
$t_tmp_img = $tablePreStr."tmp_img";

$years=date("Y");
$months=date("m");
$days=date("d");
$day=date("Y-m-d",mktime(0,0,0,$months,$days-2,$years));

$sql="delete from $t_tmp_img where add_time<'$day'";

//定义操作
dbtarget('r',$dbServs);
$dbo = new dbex;

$dbo->exeUpdate($sql);


?>