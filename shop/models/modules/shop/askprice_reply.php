<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}


//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

//数据表定义区
$t_shop_inquiry = $tablePreStr."shop_inquiry";

$gid=intval(get_args('id'));

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

$sql = "select * from `$t_shop_inquiry` where iid='$gid'";

$sql .= " order by add_time desc";
//echo $sql;/
$result = $dbo->getRow($sql);
$sql="update $t_shop_inquiry set read_status =1 where iid='$gid' ";
$dbo->exeUpdate($sql);
//print_r($result);
?>