<?php
header("content-type:text/html;charset=utf-8");
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//引入模块公共方法文件
include("foundation/module_users.php");
// 数据表定义区
$t_users = $tablePreStr."users";
$t_user_info = $tablePreStr."user_info";
//$t_mailtpl = $tablePreStr."mailtpl";
$t_user_rank = $tablePreStr."user_rank";
$t_user_open = $tablePreStr."openuser";

dbtarget('w',$dbServs);
$dbo=new dbex();


if ($_GET['cat']){
	//判断用户是否已注册过
	//echo get_session('random');exit;
	if ($_GET['nick']){
		$post1['user_name'] =urldecode($_GET['nick']);
	}elseif ($_GET['name']){
		$post1['user_name'] =urldecode($_GET['name']);
	}
	$post1['reg_time'] = $ctime->long_time();
	
	if($_GET['openid']){
		$tencent['user_key'] = urldecode($_GET['openid']);
		$tencent['category'] = 'tencent';
	}elseif ($_GET['uid']){
		$tencent['user_key'] =urldecode($_GET['uid']);
		$tencent['category'] = 'sina';
	}
	if (get_session('random')){
		$tencent['random'] = get_session('random');
	}else{
		$tencent['random'] = $_GET['sess'];
	}
	if ($_GET['openid']){
		$openid = $_GET['openid'];
	}elseif (urldecode($_GET['uid'])){
		$openid = urldecode($_GET['uid']);
	}
	if ($_GET['profile']){
		$post1['user_ico'] = urldecode($_GET['profile']) ;
	}
    $opensql = "select * from `$t_user_open` where user_key = '$openid' ";
    $o = $dbo->getRow($opensql);
    if ($o){
    	$rand = $tencent['random'];
    	$upsql = "update `$t_user_open` set random = $rand where user_key = '$openid' ";
    	$dbo->exeUpdate($upsql);
    	echo '1';
    	exit;
    }else {
    	 $user_id = insert_user_info($dbo,$t_users,$post1);
    	// echo $user_id;
    	if ($user_id){
	    	 $tencent['user_id'] = $user_id;
	    	 $is = insert_user_info($dbo,$t_user_open,$tencent);
//	    	 if ($_GET['nick']){
		    	 if ($is){
					 echo '1';
		    	 }else{
		    	 	echo '-1';
		    	 }
//	    	 }
//	    	 elseif ($_GET['name']){
//	    	 	$USER['userid'] = $user_id;
//	    	 	$USER['username'] = $post1['user_name'];
//	    	 	$b = new returnobj('ok',$USER,$chatnums);
//				print_r($callback . '(' . json_encode( $b ) . ')');
//				exit;
//	    	 }
    	}else{
    		echo '-1';
    	}
    }
}else{

$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
$post['user_name'] = short_check(get_args('name'),1);
$post['user_passwd'] = md5(short_check(get_args('psw'),1));

dbtarget('r',$dbServs);
$dbo=new dbex();
$sql = "select user_id from `$t_users` where user_name='$post[user_name]'";
$row = $dbo->getRow($sql);

if($row) {
	$result = '2';
	echo $callback . '(' . json_encode( $result ) . ')';
	exit;
}

$post['reg_time'] = $ctime->long_time();
//$post['email_check_code'] = md5($post['user_name'].$ctime->time_stamp());

///* 设置用户rank_id */
$user_rank = get_userrank_info($dbo,$t_user_rank,2);
///*  */
	$user_id = insert_user_info($dbo,$t_users,$post);
	if ($user_id){
		$USER['userid'] = $user_id;
		$USER['username'] = $post['user_name'];
		$USER['password'] = short_check(get_args('psw'),1);
		echo $callback . '(' . json_encode( $USER ) . ')';
		exit;
	}else{
		$result='-1';
		echo $callback . '(' . json_encode( $result ) . ')';
		exit;
	
	}
}
?>
