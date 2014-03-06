<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}


$t_users = $tablePreStr."users";
$t_chat = $tablePreStr."chat";
$t_shop_info = $tablePreStr."shop_info";
$t_delrecord = $tablePreStr."delrecord";
//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();
$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
$fromid = $sessionuserid;
$toid = $_GET['toid'];
$message = $_GET['message'];
$addtime = $ctime->long_time();
//$fromid = '20';
//$toid = '15';
//$message = '你好asss';
$sql = "insert $t_chat (fromid,toid,message,addtime) values ('$fromid','$toid','$message','$addtime') ";
//echo $sql;exit;
if ($toid){
$r = $dbo->exeUpdate($sql);
}
if ($r){
	//查看是否在删除列表
	//$delsql = "select toid from `$t_delrecord` where fromid = $sessionuserid ";
	$delsql = "select * from `$t_delrecord` where fromid in ($sessionuserid,$toid) and toid in ($sessionuserid,$toid)  ";
	$dels = $dbo->getRsassoc($delsql);
	if ($dels){
		foreach ($dels as $del){
			$delid = $del['id'];
			$addsql = "delete from `$t_delrecord` where id = $delid";
			$dbo->exeUpdate($addsql);
		}
//		if (in_array($toid, $delids)){
//			//将删除表中的用户id去掉
//			$addsql = "delete from `$t_delrecord` where toid=$toid and fromid=$sessionuserid";
//			$dbo->exeUpdate($addsql);
//		}
	}
	
	$selectsql = "select * from $t_chat order by addtime desc limit 1 ";
	$return = $dbo->getRsassoc($selectsql);
	if ($return[0]){

		$return[0]['timestamp'] = strtotime($return[0]['addtime']);
		$t = $ctime->time_stamp()-strtotime($return[0]['addtime']);

		$timediff = time_long($t);
		$return[0]['timediff'] = $timediff;
		//用户名
		$uid = $return[0]['toid'];

		//头像
		$shopsql = "select logo_thumb from $t_shop_info where shop_id = $uid";
		$shoplogo = $dbo->getRow($shopsql);
		$return[0]['icon'] = $shoplogo['logo_thumb'];
				
		$back =  new returnobj('ok',$return[0],$chatnums);
		$res =  $callback . '(' . json_encode( $back ) . ')';
		print_r($res);
		exit;
	}
}
?>