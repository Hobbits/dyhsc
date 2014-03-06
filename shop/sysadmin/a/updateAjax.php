<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require_once("../foundation/module_admin_logs.php");
require_once ("../foundation/module_asd.php");
$tablename=$tablePreStr.short_check(get_args("tablename"));
$colname=short_check(get_args("colname"));
$colvalue=short_check(get_args("colvalue"));
$idname=short_check(get_args("idname"));
$idvalue=short_check(get_args("idvalue"));
$logcontent=short_check(get_args("logcontent"));

$t_admin_log = $tablePreStr."admin_log";
$t_asd_content = $tablePreStr."asd_content";
$t_asd_position = $tablePreStr."asd_position";

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

$sql="update $tablename set $colname='$colvalue' where $idname=$idvalue";
$re=$dbo->exeUpdate($sql);
if($re){
	if($tablename==$t_asd_content){
		update_asd_position_file($dbo,$t_asd_content,$t_asd_position,$idvalue);
	}
	if($tablename==$t_asd_position){
		update_asd_position_file($dbo,$t_asd_content,$t_asd_position);
	}
	admin_log($dbo,$t_admin_log,$logcontent.$idvalue);
	echo "1";
}else{
	echo "0";
}
?>