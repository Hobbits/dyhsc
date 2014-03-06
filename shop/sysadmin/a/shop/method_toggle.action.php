<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

/* post 数据处理 */
$id = intval(get_args('id'));
$v = intval(get_args('v'));

if(!$id) {
	exit();
}

//数据表定义区
$t_transport = $tablePreStr."transport";
//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

$sql = "update `$t_transport` set ifopen='$v' where tranid='$id'";
//语言包引入
$a_langpackage=new adminlp;

if($dbo->exeUpdate($sql)) {
	echo "1";
} else {
	echo "-1";
}
exit;
?>