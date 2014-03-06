<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}
require("foundation/acheck_shop_creat.php");
require("foundation/module_askprice.php");
require("foundation/module_shop.php");
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
$s_langpackage=new shoplp;
//数据表定义区
$t_shop_inquiry = $tablePreStr."shop_inquiry";
$t_shop_info = $tablePreStr."shop_info";
$t_users = $tablePreStr."users";
//读写分离定义方法
$dbo = new dbex;
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
/* 收到的询价 */
$result = get_shop_askprice_list($dbo,$t_shop_inquiry,$shop_id,13);
?>