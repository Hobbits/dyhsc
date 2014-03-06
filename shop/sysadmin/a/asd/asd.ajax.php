<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

$id = intval(get_args('id'));

//数据表定义区
$t_asd_content = $tablePreStr."asd_content";;

//if(!$id) {
	//exit();
//}
//定义写操作
dbtarget('w',$dbServs);
$dbo = new dbex;

$sql="select count(*) from $t_asd_content where position_id=$id";
$row=$dbo->getRow($sql);
echo $row[0];
?>