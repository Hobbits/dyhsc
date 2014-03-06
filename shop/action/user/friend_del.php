<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
$t_users = $tablePreStr."users";
$t_shop_info = $tablePreStr."shop_info";
$t_friends = $tablePreStr."friends";
$user_chat = $tablePreStr."chat";
//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();
$friendid = $_GET['friendid'];

if ($friendid){
	$sql = "delete from `$t_friends` where ownerid='$sessionuserid' and friendid=$friendid";
	//判断有没有未读的信息
//查看是否有未读的消息
	$nsql = "select count(*) num from `$user_chat` where fromid = $friendid and toid=$sessionuserid and isshow = 0";
	$isshow = $dbo->getRsassoc($nsql);
	if ($isshow[0]['num']){
		$r =  new returnobj('-1','您有未读的消息，不能删除好友');
		$final =  $callback . '(' . json_encode( $r ) . ')';
		print_r($final);
		exit();
	}
	if ($dbo->exeUpdate($sql)){
		//返回好友列表
	$sql1 = "select u.user_id,u.user_name from `$t_users` as u,`$t_friends` as f where u.user_id = f.friendid and f.ownerid = '$sessionuserid' " ;
	$friends = $dbo->getRsassoc($sql1);
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
		
		if ($result){
			foreach ($result as $r){
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
		
		
//		$re = new returnobj('ok','删除好友成功',$chatnums);
//		print_r($callback . '(' . json_encode( $re ) . ')');
//		exit;
	}else{
		$re = new returnobj('ok','删除好友失败');
		print_r($callback . '(' . json_encode( $re ) . ')');
		exit;
	}
}