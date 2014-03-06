<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
$t_users = $tablePreStr."users";

$t_friends = $tablePreStr."friends";
$t_shop_info = $tablePreStr."shop_info";
$user_chat = $tablePreStr."chat";
//数据库操作
dbtarget('r',$dbServs);
$dbo=new dbex();
//$sessionuserid = '15';

$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
//$sql = "select u.user_id,u.user_name,s.logo_thumb from `$t_users` as u,`$t_friends` as f ,$t_shop_info as s where u.user_id = f.friendid and f.ownerid = '$sessionuserid' and s.user_id = u.user_id" ;
$sql = "select u.user_id,u.user_name from `$t_users` as u,`$t_friends` as f where u.user_id = f.friendid and f.ownerid = '$sessionuserid' " ;
$friends = $dbo->getRsassoc($sql);
if ($friends){
	foreach ($friends as $friend){
		$userid = $friend['user_id'];$chatsql = '';$chatcount = '';$recordnums = '';
		//返回每个人的未读的信息
		$chatsql = "select count(*) num, addtime from $user_chat where fromid= $userid and toid= $sessionuserid and isshow = 0";
		$chatcount = $dbo->getRow($chatsql);
		if ($chatcount){
			$recordnums = $chatcount['num'] ;
			$addtime = $chatcount['addtime'];
		}else{
			$recordnums = '0';
			$addtime = '';
		}
		
		
		$result[$friend['user_id']]['records_num'] =$recordnums;		
		$result[$friend['user_id']]['user_id'] =$friend['user_id'];
		$result[$friend['user_id']]['user_name'] =$friend['user_name'];
		//搜好友头像
		$sql2 = "select logo_thumb from `$t_shop_info` where user_id = $userid";
		$img = $dbo->getRow($sql2);
		if ($img['logo_thumb']){
			$result[$friend['user_id']]['logo_thumb'] =$img['logo_thumb'];
		}else{
			$result[$friend['user_id']]['logo_thumb'] =$shopthumbimg;
		}
		$userid = '';
		if($addtime){
			$result[$friend['user_id']]['addtime'] =strtotime($chatcount['addtime']);
		}else{
			$result[$friend['user_id']]['addtime'] ='';
		}
	}
//	function cmp($a, $b)
//	{
//	    if ($a == $b) {
//	        return 0;
//	    }
//	    return ($a > $b) ? 1 : 0;
//	}

	
	if ($result){
		foreach ($result as $r){
			//$addtimes[] = $r['addtime'];
			$final[] = $r;
		}
	}
	$re = new returnobj('ok',$final,$chatnums);
	print_r($callback . '(' . json_encode( $re ) . ')');
	exit;
}else{
	$re = new returnobj('ok',array());
	print_r($callback . '(' . json_encode( $re ) . ')');
	exit;
}