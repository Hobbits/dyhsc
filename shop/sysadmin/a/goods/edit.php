<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require_once("../foundation/module_goods.php");
require_once("../foundation/module_remind.php");
//语言包引入
$a_langpackage=new adminlp;

//权限管理
$right=check_rights("goods_edit");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}

$post['lock_flg'] = intval(get_args('lock_flg'));
$post['goods_name'] = short_check(get_args('goods_name'));
$post['goods_intro'] = big_check(get_args('goods_intro'));

$goods_id = intval(get_args('good_id'));
$shop_id = intval(get_args('shop_id'));

//数据表定义
$t_remind_info = $tablePreStr."remind_info";
$t_goods = $tablePreStr."goods";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

//查询出原来的商品数据，与提交获得的对比
$array = array("lock_flg","goods_name","goods_intro","shop_id");
$info = get_goods_info($dbo,$t_goods,$array,$goods_id,$shop_id);
if($info){
	$nowtime = $ctime->long_time();
	if(intval(get_args('lock_flg'))){
		if($info['lock_flg']!=intval(get_args('lock_flg'))){
			$lock = $a_langpackage->a_good_lock;
			if(intval(get_args('lock_flg'))==0){
				$lock = $a_langpackage->a_good_delock;
			}
			$array = array(
				'user_id' => $shop_id,
				'remind_info' => $a_langpackage->a_zai.$nowtime."，".$post['goods_name'].$lock,
				'remind_time' => $nowtime,
			);
			insert_remind_info($dbo,$t_remind_info,$array);
		}
	}
	if($post['goods_name']){
		if($info['goods_name']!=short_check(get_args('goods_name'))){
			$array = array(
				'user_id' => $shop_id,
				'remind_info' => $a_langpackage->a_zai.$nowtime."，".$info['goods_name'].$a_langpackage->a_good_chang,
				'remind_time' => $nowtime,
			);
			insert_remind_info($dbo,$t_remind_info,$array);
		}
	}
	if($post['goods_intro']){
		if($info['goods_intro']!=short_check(get_args('goods_intro'))){
			$array = array(
				'user_id' => $shop_id,
				'remind_info' => $a_langpackage->a_zai.$nowtime."，".$info['goods_name'].$a_langpackage->a_intro_chang,
				'remind_time' => $nowtime,
			);
			insert_remind_info($dbo,$t_remind_info,$array);
		}
	}
}

if(update_goods_info($dbo,$t_goods,$post,$goods_id,$shop_id)) {
	action_return(1,$a_langpackage->a_amend_suc,'m.php?app=goods_edit&goods_id='.$goods_id);
} else {
	action_return(0,$a_langpackage->a_amend_lose,'-1');
}
?>