<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("foundation/module_guestbook.php");

//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

//数据表定义区
$t_shop_guestbook = $tablePreStr."shop_guestbook";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);
$result = get_guestbook_info($dbo,$t_shop_guestbook,$user_id,13);
?>