<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//定义数据表
$t_shop_info = $tablePreStr."shop_info";
$t_shop_request = $tablePreStr."shop_request";

$shopid = intval(get_args('shopid'));
$shopcommend = intval(get_args('shopcommend'));

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;
//判断是否能推荐
if($shopcommend)
{
	$sql = "SELECT c.status,a.lock_flg,a.open_flg FROM $t_shop_info as a left join $t_shop_request as c on a.user_id = c.user_id where a.shop_id=$shopid";
	$row = $dbo->getRow($sql);
	if($row)
	{
		if($row['status']!="" && $row['status']!="1")
		{
			echo "no.0.1";
			exit;
		}
		if($row['lock_flg']!="" && $row['lock_flg']!="0")
		{
			echo "no.0.2";
			exit;
		}
		if($row['open_flg']!="" && $row['open_flg']!="0")
		{
			echo "no.0.3";
			exit;
		}
	}
	else
	{
		echo "no.0.1";
		exit;
	}
}

$sql = "update $t_shop_info set shop_commend=$shopcommend where shop_id=$shopid";

$val="";
if($dbo->exeUpdate($sql)){
	if($shopcommend){
		$val= 'yes';
	}else{
		$val= 'no';
	}
}else{
if($shopcommend){
		$val= 'no';
	}else{
		$val= 'yes';
	}
}
$sql="select count(*) from $t_shop_info where shop_commend='1'";
$row=$dbo->getRow($sql);
echo $val.".".$row[0];
exit;
?>