<?php
$userid=get_sess_user_id();
//会员退出
session_destroy();
$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
$r = new returnobj('ok','登出成功');
echo $callback . '(' . json_encode( $r ) . ')';
exit;
//unset_cookie('iweb_login');

//if($_SERVER['HTTP_REFERER']){
//	$url=$_SERVER['HTTP_REFERER'];
//	$in=strpos($url,'outuserid=');//把退出时的userid传回，如用户立刻在次登录时判断是否和退出时是同一账号
//	if($in){
//		$url=substr($url,0,$in-1);
//	}
//	//debug 测试用
//	//$url=strpos($url,"?")?$url.'&outuserid='.$userid:$url.'?outuserid='.$userid;
//	header('Location: ' .$url);
//}
//echo "<script>top.location.href='login.php?outuserid=$userid'</script>";
?>