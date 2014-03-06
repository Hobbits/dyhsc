<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
require("../foundation/module_shop.php");
require("../foundation/module_admin_logs.php");
require("../foundation/module_remind.php");
//语言包引入
$a_langpackage=new adminlp;

//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();
//定义文件表
$t_shop_info = $tablePreStr."shop_info";
$t_word= $tablePreStr."word";
$t_remind_info = $tablePreStr."remind_info";
$t_admin_log = $tablePreStr."admin_log";
// 处理post变量
$shop_id = intval(get_args('shop_id'));

//查询出shop_info的内容
$info = get_shop_info($dbo,$t_shop_info,$shop_id);
//判断是否有敏感词
$sql="select * from $t_word";
$row = $dbo->getRs($sql);
$nowtime = $ctime->long_time();
$post['shop_name'] = short_check1(get_args('shop_name'));
if($post['shop_name'] != $info['shop_name']){
	$array = array(
		'user_id' => $info['user_id'],
		'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_shop_name.$a_langpackage->a_be_modified,
		'remind_time' => $nowtime,
	);
	insert_remind_info($dbo,$t_remind_info,$array);//发送站内信
}
$post['shop_address'] = long_check(get_args('shop_address'));
if($post['shop_address'] != $info['shop_address']){
	$array = array(
		'user_id' => $info['user_id'],
		'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_shop_address.$a_langpackage->a_be_modified,
		'remind_time' => $nowtime,
	);
	insert_remind_info($dbo,$t_remind_info,$array);
}
$post['shop_template'] = short_check(get_args('shop_template'));
if($post['shop_template'] != $info['shop_template']){
	$array = array(
		'user_id' => $info['user_id'],
		'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_shop_mode.$a_langpackage->a_be_modified,
		'remind_time' => $nowtime,
	);
	insert_remind_info($dbo,$t_remind_info,$array);
}
$post['shop_country'] = intval(get_args('country'));
if($post['shop_country'] != $info['shop_country']){
	$array = array(
		'user_id' => $info['user_id'],
		'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_shopcountry.$a_langpackage->a_be_modified,
		'remind_time' => $nowtime,
	);
	insert_remind_info($dbo,$t_remind_info,$array);
}
$post['shop_province'] = intval(get_args('province'));
if($post['shop_province'] != $info['shop_province']){
	$array = array(
		'user_id' => $info['user_id'],
		'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_shop_province.$a_langpackage->a_be_modified,
		'remind_time' => $nowtime,
	);
	insert_remind_info($dbo,$t_remind_info,$array);
}
$post['shop_city'] = intval(get_args('city'));
if($post['shop_city'] != $info['shop_city']){
	$array = array(
		'user_id' => $info['user_id'],
		'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_shop_city.$a_langpackage->a_be_modified,
		'remind_time' => $nowtime,
	);
	insert_remind_info($dbo,$t_remind_info,$array);
}
$post['shop_district'] = intval(get_args('district'));
if($post['shop_district'] != $info['shop_district']){
	$array = array(
		'user_id' => $info['user_id'],
		'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_shop_district.$a_langpackage->a_be_modified,
		'remind_time' => $nowtime,
	);
	insert_remind_info($dbo,$t_remind_info,$array);
}
$post['shop_intro'] = big_check(get_args('shop_intro'));
if($post['shop_intro'] != $info['shop_intro']){
	$array = array(
		'user_id' => $info['user_id'],
		'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_shop_intro.$a_langpackage->a_be_modified,
		'remind_time' => $nowtime,
	);
	insert_remind_info($dbo,$t_remind_info,$array);
}
if($row){
	foreach ($row as $v){
		if(stristr($post['shop_name'],$v['word_name'])){
			action_return(0, $a_langpackage->a_shop_no.$v['word_name'],'-1');
		}
		if(stristr($post['shop_intro'],$v['word_name'])){
			action_return(0, $a_langpackage->a_shop_intro_no.$v['word_name'].$a_langpackage->a_shop_intro_back1,'-1');
		}
	}
}
$post['shop_management'] = short_check(get_args('shop_management'));
if($post['shop_management'] != $info['shop_management']){
	$array = array(
		'user_id' => $info['user_id'],
		'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_shop_range.$a_langpackage->a_be_modified,
		'remind_time' => $nowtime,
	);
	insert_remind_info($dbo,$t_remind_info,$array);
}
$post['shop_creat_time'] = $ctime->long_time();
$post['shop_categories'] =short_check(get_args('categories'));
if($post['shop_categories']==0)
	$post['shop_categories'] =short_check(get_args('categories_parent'));
if($post['shop_categories'] != $info['shop_categories']){
	$array = array(
		'user_id' => $info['user_id'],
		'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_categories_parent.$a_langpackage->a_be_modified,
		'remind_time' => $nowtime,
	);
	insert_remind_info($dbo,$t_remind_info,$array);
}
if(update_shop_info($dbo,$t_shop_info,$post,$shop_id)) {
	admin_log($dbo,$t_admin_log,"店铺内容被修改");//'修改店铺内容');
	action_return(1,$a_langpackage->a_put_suc,'m.php?app=shop_list');
} else {
	action_return(0,$a_langpackage->a_put_lose,'-1');
}
exit;
?>