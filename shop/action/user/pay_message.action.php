<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件11
require 'foundation/module_order.php';

//语言包引入
$m_langpackage=new moduleslp;

//定义文件表
$t_order_info = $tablePreStr."order_info";

// 处理post变量
$nowtime = $ctime->long_time();
$order_id = intval(get_args('id'));
$post['pay_message'] = short_check(get_args('pay_message'));
$post['pay_id'] = intval(get_args('pay_id'));
$post['pay_name'] = short_check(get_args('pay_name'));
$post['pay_status']=1;
$post['pay_time']=$nowtime;

//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();

//判断sessionid和userid是不是同一个，如果不是则不需删除
$sql = "select user_id from $t_order_info where order_id=$order_id";
$rs = $dbo->getRow($sql);
if($rs['user_id'] != get_sess_user_id()){
	action_return(1,$m_langpackage->m_not_del,'-1');
}

//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();
$update=upd_order_info($dbo,$t_order_info,$post,$order_id);
if($update) {
	action_return(1,$m_langpackage->m_adm_suc,'modules.php?app=user_my_order');
} else {
	action_return(0,$m_langpackage->m_adm_lose,'modules.php?app=user_my_order');
}
exit;
?>