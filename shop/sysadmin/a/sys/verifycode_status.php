<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require_once("../foundation/module_admin_logs.php");
require_once("../foundation/asystem_info.php");

//	语言包引入
$a_langpackage=new adminlp;

$verifycode =  unserialize($SYSINFO['verifycode']);

$v = short_check(get_args('v'));
$id = short_check(get_args('id'));

//数据表定义区
$t_settings = $tablePreStr."settings";
$t_admin_log = $tablePreStr."admin_log";

$verifycode[$id] = $v;
$verifycode_str = serialize($verifycode);

//定义读操作
dbtarget('w',$dbServs);
$dbo=new dbex;

$sql="update `$t_settings` set value='$verifycode_str' where variable = 'verifycode'";
$status = $dbo->exeUpdate($sql);
//echo $sql;
if($status){
	/** 添加log */
	$admin_log =$a_langpackage->a_verifycode_status_update;//"更新提醒设置状态";
	admin_log($dbo,$t_admin_log,$admin_log);
	$SYSINFO['verifycode'] = $verifycode_str ;
	put_file($SYSINFO);

	echo 1;
}

function put_file($sysinfo) {
	$content = '<'.'?php'."\n";
	$content .= "if(!".'$'."IWEB_SHOP_IN) {die('Hacking attempt');} \n";
	foreach($sysinfo as $k=>$v) {
		$v = str_replace('\"','"',$v);
		$content .= '$'."SYSINFO['$k'] = '$v'; \n";
	}
	$content .= '?'.'>';
	file_put_contents("../cache/setting.php",$content);
}
?>