<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
$t_users = $tablePreStr."users";

$t_friends = $tablePreStr."friends";
//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();

$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
//$sessionuserid = '20';
$friendid = $_GET['friendid'];
//$friendid = '15';
if ($friendid){
	if ($friendid != $sessionuserid){
		//判断好友是否已添加
		$isaddsql = "select * from `$t_friends` where ownerid = $sessionuserid and friendid =$friendid ";
		$isfriend = $dbo->getRow($isaddsql);
		if ($isfriend['friendid']){
			$re = new returnobj('ok','此用户已是您的好友');
			print_r($callback . '(' . json_encode( $re ) . ')');
			exit;
		}else{
			$add_time = $ctime->long_time();
			$sql = "insert into `$t_friends` (ownerid,friendid,addtime) values ('$sessionuserid','$friendid','$add_time');";	
			if($dbo->exeUpdate($sql)) {
				$re = new returnobj('ok','好友添加成功',$chatnums);
				print_r($callback . '(' . json_encode( $re ) . ')');
				exit;
			}
		}
	}else{
		$re = new returnobj('ok','不能添加自己为好友');
		print_r($callback . '(' . json_encode( $re ) . ')');
		exit;
	}
}

