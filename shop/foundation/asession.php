<?php 
if(!$IWEB_SHOP_IN){
	die('Hacking attempt');
}
/*
	第三个参数写域名。比如：.jooyea.com
*/
session_set_cookie_params(0,'/',"");
session_start();

if (isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP']!='unknown') {   
         $ip = $_SERVER['HTTP_CLIENT_IP'];   
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']!='unknown') {   
         $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];   
    } else {   
         $ip = $_SERVER['REMOTE_ADDR'];   
    }   


// if (isset($_SESSION['HTTP_USER_AGENT'])){
    // if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT'].$ip)){
      // exit;
    // }
  // }else{
  	// session_regenerate_id();
    // $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT'].$ip);
// }

?>