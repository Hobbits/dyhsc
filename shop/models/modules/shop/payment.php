<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require("foundation/acheck_shop_creat.php");
require("foundation/module_shop.php");
require("foundation/module_payment.php");
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
$s_langpackage=new shoplp;
//数据表定义区
$t_payment = $tablePreStr."payment";
$t_shop_payment = $tablePreStr."shop_payment";
$t_shop_info = $tablePreStr."shop_info";
$t_users = $tablePreStr."users";
//读写分离定义方法
$dbo=new dbex;
dbtarget('r',$dbServs);
/* 商铺信息处理 */
include("foundation/fshop_locked.php");
//判断用户是否锁定，锁定则不许操作
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	trigger_error($m_langpackage->m_user_locked);//非法操作
}
$payment = get_payment_info($dbo,$t_payment,1);

$info = get_shop_payment_info($dbo,$t_shop_payment,$shop_id);
?>