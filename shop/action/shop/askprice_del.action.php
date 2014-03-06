<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
require("foundation/module_askprice.php");

//语言包引入
$m_langpackage=new moduleslp;

//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();

//定义文件表
$t_shop_inquiry = $tablePreStr."shop_inquiry";

// 处理post变量
if(empty($_POST)){
	$iid = intval(get_args('id'));
}else{
	$iid=get_args('iid');
	if (!$iid){
		action_return(1,$m_langpackage->m_del_select,'modules.php?app=shop_askprice');
	}
	$iid=implode(',',$iid);
}

$del = del_shop_askprice($dbo,$t_shop_inquiry,$iid,$shop_id);

if($del) {
	action_return(1,$m_langpackage->m_del_success);
} else {
	action_return(0,$m_langpackage->m_del_fail,'-1');
}
exit;
?>