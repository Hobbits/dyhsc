<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
require("foundation/module_goods.php");
require("foundation/module_tag.php");
//语言包引入
$m_langpackage=new moduleslp;

//定义文件表
$t_tag = $tablePreStr."tag";
$t_tag_user = $tablePreStr."tag_user";
$t_goods = $tablePreStr."goods";
$verifycode = unserialize($SYSINFO['verifycode']);
if($verifycode['4']==1){
	if(strtolower(short_check(get_args('veriCode'))) != strtolower(get_session('verifyCode'))) {
		action_return(0, $m_langpackage->m_verifycode_error,'-1');
		
	}
}

// 清空验证码值
set_session('verifyCode','');

$post_tag = array(
	'tag_name'	=> short_check(get_args('tag')),
	'goods_id'	=> intval(get_args('goods_id')),
	'is_recommend' =>0
);

$tag_userid = intval(get_args('tag_userid'));

if (!$post_tag['goods_id'] or !$tag_userid){
	exit($m_langpackage->m_illegal);
}
//数据库操作
$dbo=new dbex();
dbtarget('r',$dbServs);

$shop_id = get_goods_info($dbo,$t_goods,array('shop_id'),$post_tag['goods_id']);
$post_tag['shop_id'] = $shop_id['shop_id'];
if (!$post_tag['shop_id']){
	exit($m_langpackage->m_illegal);
}
//数据库操作
dbtarget('w',$dbServs);
$tag_id = insert_tag_info($dbo,$t_tag,$t_tag_user,$post_tag,$tag_userid);

if($tag_id) {
	action_return(1,$m_langpackage->m_add_lable,'goods.php?id='.$post_tag['goods_id']);
} else {
	action_return(0,$m_langpackage->m_add_lable_fail,'-1');
}
exit;
?>