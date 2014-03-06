<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

//引入语言包
$i_langpackage=new indexlp;



/* 定义文件表 */
$t_shop_info=$tablePreStr."shop_info";
$t_user_info = $tablePreStr."user_info";
$t_goods = $tablePreStr."goods";

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();
if(empty($USER['user_id'])){
	echo '<script language="JavaScript">location.href="/login.php"</script>';
	exit;
}
/* 产品信息获取 */
$sql = "select * from `$t_goods` as a,`$t_shop_info` as b where a.goods_id=$goods_id and a.shop_id=b.shop_id";
$info = $dbo->getRow($sql);
if(!$info) { trigger_error($i_langpackage->i_goods_error); }//没有此商品

if($USER['user_id']) {
	$sql = "SELECT * FROM `$t_user_info` WHERE user_id='".$USER['user_id']."'";
	$user_info = $dbo->getRow($sql);
	$user_info['user_email'] = $USER['user_email'];
}

$nav_selected='1';
?>