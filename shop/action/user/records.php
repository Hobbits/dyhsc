<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
$t_users = $tablePreStr."users";
$t_chat = $tablePreStr."chat";
$t_shop_info = $tablePreStr."shop_info";
$t_delrecord = $tablePreStr."delrecord";
$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
//数据库操作
dbtarget('r',$dbServs);
$dbo=new dbex();
//当前用户
$delsql = "select toid from `$t_delrecord` where fromid = $sessionuserid ";
$delids = $dbo->getRsassoc($delsql);
if ($delids){
	foreach ($delids as $delid){
		$deluserids[] = $delid['toid'];
	}
}
//print_r($deluserids);exit;
// $sessionuserid = '20';
$sql = "select distinct fromid,toid from $t_chat where fromid = $sessionuserid or toid = $sessionuserid";
$result = $dbo->getRsassoc($sql);
if ($result){
	$str_id = '';
	foreach ($result as $value){
		if ($value['fromid']!=$sessionuserid ){
			$str_id .= $value['fromid'].',';
		}
		if ($value['toid'] != $sessionuserid){
			$str_id .= $value['toid'].',';
		}
	}
	if ($str_id){
		$str = substr($str_id, 0,strlen($str_id)-1);
		$ids = split(',', $str);
		$toids = array_unique($ids);
		if ($toids){
			foreach ($toids as $toid){
				if(!in_array($toid, $deluserids)){
				$tosql = '';$notshowsql='';$nsql='';$username = '';$num_all = '';$notshownum='';$lastsql='';$chatcontent = '';
				$shopsql = '';$shoplogo='';$chatsql = '';$chatcount='';
				$return[$toid]['userid_chat'] = $toid;
				//获取用户名
				$nsql = "select user_name from $t_users where user_id = $toid";
				$username = $dbo->getRow($nsql);
				$return[$toid]['name_chat'] = $username['user_name'];
				//获取店铺头像
				$shopsql = "select logo_thumb from $t_shop_info where shop_id = $toid";
				$shoplogo = $dbo->getRow($shopsql);
				if ($shoplogo['logo_thumb']){
					$return[$toid]['icon'] = $shoplogo['logo_thumb'];
				}else{
					$return[$toid]['icon'] = $shopthumbimg;
				}
				//搜索聊天记录
				//$tosql = "select count(*) num from $t_chat where fromid in ($sessionuserid,$toid) and  toid in ($sessionuserid,$toid) order by addtime asc ";
				//$num_all = $dbo->getRow($tosql);
				//$return[$toid]['num_all'] = $num_all['num'];
				//$notshowsql ="select count(*) num from $t_chat where toid = $sessionuserid and fromid = $toid and isshow = 0 ";
				//$notshownum = $dbo->getRow($notshowsql);
				//$return[$toid]['num_notshow'] = $notshownum['num'];
				$lastsql = "select message,addtime from $t_chat where fromid in ($sessionuserid,$toid) and  toid in ($sessionuserid,$toid) order by addtime desc limit 1";
				$chatcontent = $dbo->getRow($lastsql);
				$return[$toid]['last_dialogue'] = $chatcontent['message'];
			//返回每个人的未读的信息
				$chatsql = "select count(*) num, addtime from $t_chat where fromid= $toid and toid= $sessionuserid and isshow = 0";
				$chatcount = $dbo->getRow($chatsql);
				if ($chatcount){
					$recordnums = $chatcount['num'] ;
				}else{
					$recordnums = '0';
				}
				//$return[$toid]['last_addtime'] = date('y-n-j',strtotime($chatcontent['addtime']));
				$return[$toid]['last_timestamp'] = strtotime($chatcontent['addtime']);
				$return[$toid]['records_num'] = $recordnums;
			}
			}
			if ($return){
				foreach ($return as $chat){
					$back[] = $chat;
				}
				$r =  new returnobj('ok',$back,$chatnums);
				$final =  $callback . '(' . json_encode( $r ) . ')';
				print_r($final);
			}
		}
	}else{
		//没聊天记录
		$r =  new returnobj('ok','',$chatnums);
		$final =  $callback . '(' . json_encode( $r ) . ')';
		print_r($final);
	}
}