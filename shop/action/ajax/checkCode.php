<?php
/**
 * 检测验证码
 */
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

$checkcode=get_args("checkcode");
if(get_session("verifyCode")&&strtolower(get_session('verifyCode'))==strtolower($checkcode)){
	echo 1;
}else{
	echo 0;
}
exit;
?>