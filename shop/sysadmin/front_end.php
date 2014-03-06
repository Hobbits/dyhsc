<?php
header("content-type:text/html;charset=utf-8");
$IWEB_SHOP_IN = true;
require("../foundation/asession.php");
require("../configuration.php");
require("includes.php");
require("../foundation/module_admin_logs.php");

/* modules 公共信息处理 */
if(isset($_SESSION['admin_id'])) {
	$admin_id = $_SESSION['admin_id'];
}
if(isset($_SESSION['admin_name'])) {
	$admin_name = $_SESSION['admin_name'];
}
/* 判断用户是否登陆 */
if(!isset($admin_id)||!$admin_id) {
	echo '<script>top.location.href="login.php";</script>';
	exit;
}

//数据表定义区
$t_admin_log = $tablePreStr."admin_log";

//引入语言包
$a_langpackage=new adminlp;
//定义读操作
dbtarget('w',$dbServs);
$dbo=new dbex;
require("atool_box.php");
//当前可访问的应用工具
$appArray=array(
);
$appArray=array_merge($appArray,$tools_box_array);
$appId=getAppId();
$apptarget=$appArray[$appId];
if(isset($apptarget)){
	/** 添加log */
	$admin_log =$a_langpackage->a_run_tool;//"运行工具";
	admin_log($dbo,$t_admin_log,$admin_log);
	require($apptarget);
}else{
	echo 'no pages!';
}
?>