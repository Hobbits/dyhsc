<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
$t_users = $tablePreStr."users";
$t_shop_info = $tablePreStr."shop_info";

//数据库操作
dbtarget('r',$dbServs);
$dbo=new dbex();

$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';

$name = $_GET['searchname'];
if ($name){
	//$sql = "select u.user_id,u.user_name,s.logo_thumb from `$t_users` AS u ,`$t_shop_info` AS s where  u.user_name like '%$name%' and u.user_id = s.user_id and u.user_id <> $sessionuserid ";
	$sql = "select u.user_id,u.user_name from `$t_users` AS u  where  u.user_name like '%$name%' and u.user_id <> $sessionuserid ";
	$lists = $dbo->getRsassoc($sql);
	if ($lists){
		foreach ($lists as $list){
			$uid = $list['user_id'];
			$result[$list['user_id']]['user_id'] = $list['user_id'];
			$result[$list['user_id']]['user_name'] = $list['user_name'];
			//搜图片
			$sql2 = "select logo_thumb from `$t_shop_info` where user_id = $uid";
			$img = $dbo->getRow($sql2);
			if($img['logo_thumb']){
				$result[$list['user_id']]['logo_thumb'] = $img['logo_thumb'];
			}else{
				$result[$list['user_id']]['logo_thumb'] = $shopthumbimg;
			}
		}
		if ($result){
			foreach ($result as $r){
				$final[] = $r;
			}
		}
		$re = new returnobj('ok',$final,$chatnums);
		print_r($callback . '(' . json_encode( $re ) . ')');
		exit;
	}else{
		$re = new returnobj('ok','',$chatnums);
		print_r($callback . '(' . json_encode( $re ) . ')');
		exit;
	}
}