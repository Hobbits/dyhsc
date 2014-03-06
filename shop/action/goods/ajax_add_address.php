<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
require("foundation/module_goods.php");
require 'foundation/module_users.php';
//语言包引入
$m_langpackage=new moduleslp;

//定义文件表
$t_areas = $tablePreStr."areas";
$t_user_address = $tablePreStr."user_address";
$t_user_info = $tablePreStr."user_info";

//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();

$post['user_id']=intval(get_args("user_id"));
if (!$post['user_id']) {
	exit(0);
}
$post['to_user_name'] = short_check(get_args('to_user_name'));
$post['mobile'] = short_check(get_args('mobile'));
$post['telphone'] = short_check(get_args('telphone'));
$post['full_address'] = short_check(get_args('full_address'));
$post['zipcode'] = short_check(get_args('zipcode'));
$post['user_country'] = intval(get_args('country'));
$post['user_province'] = intval(get_args('province'));
if (!$post['user_province']) {
	exit(0);
}
$post['user_city'] = intval(get_args('city'));
$post['user_district'] = intval(get_args('district'));
$post['email'] = short_check(get_args('email'));
$insert_id=insert_user_address($dbo,$t_user_address,$post);
if ($insert_id) {
	echo $insert_id;
}else{
	echo 0;
}
?>