<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

$t_chat = $tablePreStr."chat";
$t_users = $tablePreStr."users";
$t_shop_info = $tablePreStr."shop_info";
$t_delrecord = $tablePreStr."delrecord";
$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
//当前用户
$userid = $_GET['toid'];
$last = $_GET['last'];
if ($last && $last > 0){
	$pre = ($last-1)*10;
	$next = $last*10-1;
	$sql = "select * from `$t_chat` where fromid in ($sessionuserid,$userid) and  toid in ($sessionuserid,$userid) order by addtime desc limit $pre,$next";
}else{
	$sql = "select * from `$t_chat` where fromid in ($sessionuserid,$userid) and  toid in ($sessionuserid,$userid) order by addtime desc limit 0,9";
}
//echo $last;exit;
//数据库操作
dbtarget('r',$dbServs);
$dbo=new dbex();
//查看聊天记录是否存在
$delsql = "select * from `$t_delrecord` where fromid = $sessionuserid and toid = $userid";
$delids = $dbo->getRsassoc($delsql);
	if ($delids){
		//若当前用户删除与此用户的聊天记录则返回为空
		$r =  new returnobj('ok','');
		$result =  $callback . '(' . json_encode( $r ) . ')';
		print_r($result);
		exit;
	}
	
//聊天记录小于10条，当$last>=2时不返回
$csql = "select count(*) num from `$t_chat` where fromid in ($sessionuserid,$userid) and  toid in ($sessionuserid,$userid) ";
$count = $dbo->getRow($csql);
if ($last){
	if ($last > 1 ||  $last > '1'){
		if ($count['num'] < 11 || $count['num'] < '11'){
			$contents = '';
		}else{
			$contents = $dbo->getRsassoc($sql);
		}
	}else{
		$contents = $dbo->getRsassoc($sql);
	}
}else{
	$contents = $dbo->getRsassoc($sql);
}


if ($contents){
	foreach ($contents as $c){
		
		//将消息状态都改成1
		$id = '';$s = '';$uid = '';$shopsql='';$shoplogo='';$shopsql2='';$shoplogo2='';
		if (!$c['isshow'] && $c['toid'] == $sessionuserid){
			$id = $c['id'];
			//改变会话状态
			$s = "update `$t_chat` set isshow='1' where id ='$id'";
			$dbo->exeUpdate($s);	
		}
		$return[$c['id']]['id'] = $c['id'];
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
		$uid = $c['toid'];
		//头像
//		$shopsql2 = "select logo_thumb from $t_shop_info where shop_id = $uid";
//		$shoplogo2 = $dbo->getRow($shopsql2);
//		$return[$c['id']]['toidicon'] = $shoplogo2['logo_thumb'];
		//用户名
		$nsql = "select user_name from $t_users where user_id = $uid";
		$username = $dbo->getRow($nsql);
		$return[$c['id']]['toidname'] = $username['user_name'];
		$return[$c['id']]['message'] = $c['message'];
		$return[$c['id']]['timestamp'] = strtotime($c['addtime']);
		$t = $ctime->time_stamp()-strtotime($c['addtime']);
		
		$timediff = time_long($t);
		$return[$c['id']]['timediff'] = $timediff;
	}
	$fuid = $contents[0]['fromid'];
	$shopsql = "select logo_thumb from $t_shop_info where shop_id = $fuid";
	$shoplogo = $dbo->getRow($shopsql);
	if($shoplogo['logo_thumb']){
		$icon['fromidicon'] = $shoplogo['logo_thumb'];
	}else{
		$icon['fromidicon'] = 'uploadfiles/shop/default/thumbdefault.png';
	}
	
	$uid = $contents[0]['toid'];
	$shopsql2 = "select logo_thumb from $t_shop_info where shop_id = $uid";
	$shoplogo2 = $dbo->getRow($shopsql2);
	if($shoplogo2['logo_thumb']){
		$icon['toidicon'] = $shoplogo2['logo_thumb'];
	}else{
		$icon['toidicon'] ='uploadfiles/shop/default/thumbdefault.png';
	}
	
		
	if($return){
		foreach ($return as $r){
			$back[] = $r;
		}
	}
	if ($back){
		$r =  new returnobj('ok',$back,$icon);
		$result =  $callback . '(' . json_encode( $r ) . ')';
		print_r($result);
		exit;
	}else{
		$r =  new returnobj('ok',array());
		$result =  $callback . '(' . json_encode( $r ) . ')';
		print_r($result);
		exit;
	}
}else{
	$r =  new returnobj('ok',array());
	$result =  $callback . '(' . json_encode( $r ) . ')';
	print_r($result);
	exit;
}

