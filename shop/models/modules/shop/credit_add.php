<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}
require("foundation/module_goods.php");
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
$s_langpackage=new shoplp;

//数据表定义区
$t_order_goods = $tablePreStr."order_goods";
$t_order_info = $tablePreStr."order_info";
$t_users = $tablePreStr."users";
$t_goods = $tablePreStr."goods";
$oid=intval(get_args('id'));
$t=short_check(get_args('t'));

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);
//$user_id = get_sess_user_id();
//判断商品是否锁定，锁定则不许操作
$sql="select b.goods_id,a.transport_type from $t_order_info as a join $t_order_goods as b on a.order_id=b.order_id where a.order_id=$oid";
$row1=$dbo->getRow($sql);
if($row1){
	$goods_id=$row1['goods_id'];
}
include("foundation/fgoods_locked.php");
//判断用户是否锁定，锁定则不许操作
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	trigger_error($m_langpackage->m_user_locked);//非法操作
}

$credit=array(
		"1"=>$m_langpackage->m_credit_goods,
		"0"=>$m_langpackage->m_credit_middle,
		"-1"=>$m_langpackage->m_credit_bad,
	);
if($t=='buyer'){
	$sql="select order_status,buyer_reply from $t_order_info where order_id=$oid and user_id=$user_id";
	$row=$dbo->getRow($sql);
	if(!$row){
		trigger_error('您没有购买该商品，您不能评价！');
	}else{
		if($row['order_status']!=3){
			trigger_error('您还没有完成购买，您不能评价！');
		}
		if($row['buyer_reply']==1){
			trigger_error('您已评价过，您不能重复评价！');
		}
	}
}

	$sql="select c.goods_name,c.goods_id,b.user_name,b.user_id from $t_order_info as a,$t_users as b,$t_order_goods as c where a.order_id=$oid and b.user_id=a.user_id and a.order_id=c.order_id";

$result = $dbo->getRow($sql);

?>