<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

$t_chat = $tablePreStr."chat";
$t_users = $tablePreStr."users";
$t_shop_info = $tablePreStr."shop_info";
//数据库操作
dbtarget('r',$dbServs);
$dbo=new dbex();
$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
$toid  = $sessionuserid;
//$toid = '3';
$fromid  = $_GET['opposite_userid'];

$sql = "select * from `$t_chat` where toid = $toid and fromid = $fromid  and isshow = 0 ";
$content = $dbo->getRsassoc($sql);
if ($content){
	foreach ($content as $c){
		$t='';$ct='';$uid = '';$fromsql='';$nsql='';$shopsql='';$shoplogo='';$shopsql2='';$shoplogo2='';
		$return[$c['id']]['id'] = $c['id'];	$fromusername='';$username='';
		$return[$c['id']]['fromid'] = $c['fromid'];
		
		$fuid = $c['fromid'];
		
		//头像
//		$shopsql = "select logo_thumb from $t_shop_info where shop_id = $fuid";
//		$shoplogo = $dbo->getRow($shopsql);
//		$return[$c['id']]['fromidicon'] = $shoplogo['logo_thumb'];
		
		$fromsql = "select user_name from $t_users where user_id = $fuid";
		$fromusername = $dbo->getRow($fromsql);
		$return[$c['id']]['fromidname'] = $fromusername['user_name'];
		
		$return[$c['id']]['toid'] = $c['toid'];
		//用户名
		$uid = $c['toid'];
		//头像
//		$shopsql2 = "select logo_thumb from $t_shop_info where shop_id = $uid";
//		$shoplogo2 = $dbo->getRow($shopsql2);
//		$return[$c['id']]['toidicon'] = $shoplogo2['logo_thumb'];
		
		$nsql = "select user_name from $t_users where user_id = $uid";
		$username = $dbo->getRow($nsql);
		$return[$c['id']]['toidname'] = $username['user_name'];
		
		$return[$c['id']]['message'] = $c['message'];
		$return[$c['id']]['timestamp'] = strtotime($c['addtime']);
		$t = $ctime->time_stamp()-strtotime($c['addtime']);
		$timediff = time_long($t);
		$return[$c['id']]['timediff'] = $timediff;
//		$ct = floor($t/60);
//		if ($ct < 1){
//			$return[$c['id']]['timediff'] = '刚刚';
//		}else{
//			$return[$c['id']]['timediff'] = $ct.'分钟前';
//		}
	}
	if($return){
		foreach ($return as $n){
			$id = '';$s='';
			$final[] = $n;
			$id = $n['id'];
		//改变会话状态
			$s = "update `$t_chat` set isshow='1' where id ='$id'";
			$dbo->exeUpdate($s);
		}
		$back =  new returnobj('ok',$final,$chatnums);
		$res =  $callback . '(' . json_encode( $back ) . ')';
		
		print_r($res);
	}
	
}
