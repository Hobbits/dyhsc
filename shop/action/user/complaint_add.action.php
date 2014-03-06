<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
require 'foundation/module_complaint.php';

//语言包引入
$m_langpackage=new moduleslp;

//定义文件表
$t_complaints = $tablePreStr."complaints";
$t_order_info = $tablePreStr."order_info";
$t_users = $tablePreStr."users";
if(strtolower(short_check(get_args('veriCode'))) != strtolower(get_session('verifyCode'))) {
	action_return(0, $m_langpackage->m_verifycode_error,'-1');
	
}

// 清空验证码值
set_session('verifyCode','');

// 处理post变量
$post['user_id'] = $user_id;
$post['usered_id'] = intval(get_args('shopid'));
$post['goods_id'] = intval(get_args('goods_id'));
$post['usered_name'] = short_check(get_args('shop_name'));
$post['goods_name'] = short_check(get_args('goods_name'));
$post['complaints_title'] = short_check(get_args('complaints_title'));
$post['complaints_content'] = long_check(get_args('complaints_content'));
$post['order_id'] = intval(get_args('order_id'));
$order=$post['order_id'];

//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();
//判断用户是否锁定，锁定则不许操作
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	trigger_error($m_langpackage->m_user_locked);//非法操作
}
$insert_id=insert_complaint($dbo,$t_complaints,$post);


//echo $insert_id;
if($insert_id) {
	$sql = "update `$t_order_info` set complaint=1 where order_id='$order' and user_id='$user_id'";
	$dbo->exeUpdate($sql);
	action_return(1,$m_langpackage->m_add_success,'modules.php?app=user_my_order');
} else {
	action_return(0,$m_langpackage->m_add_fail,'-1');
}
exit;
?>