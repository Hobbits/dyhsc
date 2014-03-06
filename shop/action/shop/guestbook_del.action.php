<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
require("foundation/module_guestbook.php");

//语言包引入
$m_langpackage=new moduleslp;

//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();

//定义文件表
$t_shop_guestbook = $tablePreStr."shop_guestbook";

// 处理post变量
if(empty($_POST)){
	$gid = intval(get_args('id'));
}else{
	$guest=get_args('guest');
	if (!$guest){
		action_return(1,$m_langpackage->m_del_select,'modules.php?app=shop_guestbook');
	}
	$gid=implode(',',$guest);
}

$del = del_shop_guestbook($dbo,$t_shop_guestbook,$gid,$shop_id);

if($del) {
	action_return(1,$m_langpackage->m_del_success);
} else {
	action_return(0,$m_langpackage->m_del_fail,'-1');
}
exit;
?>