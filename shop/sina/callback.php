<?php
//session_start();
header("content-type:text/html;charset=utf-8");
include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );

if (isset($_REQUEST['code'])) {
	$keys = array();
	$keys['code'] = $_REQUEST['code'];
	$keys['redirect_uri'] = WB_CALLBACK_URL;
	try {
		$token = $o->getAccessToken( 'code', $keys ) ;
	} catch (OAuthException $e) {
	}
}

if ($token) {
	
	$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $token['access_token']);
    $uid = $token['uid'];
	$user_message = $c->show_user_by_id($uid);
	
	$sinaid = base64_encode($user_message['id']);
	$sinaname = base64_encode($user_message['screen_name']);
	
	header("location: ../appdo.php?act=appregister&name=".$sinaname."&uid=".$sinaid."&cat=open");
	
} else {
?>
授权失败。
<?php
}
?>