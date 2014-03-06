<?php

/**
 * 错误处理函数
 * @param  $errno 错误码
 * @param  $errstr　错误提示
 */
 function throw_errors($errno, $errstr)
 {
	global $baseUrl;
	$beforeurl = '';
	if(isset($_SERVER['HTTP_REFERER']))
		$beforeurl=@$_SERVER['HTTP_REFERER'];
	if(!$beforeurl){
	 	$beforeurl="";
	 }
	$errstr=$errstr.'-'.$beforeurl;
	$errstr=urlencode($errstr);
	if(!headers_sent())
	{
	    header('Location:'.$baseUrl.'error.php?errstr='.$errstr);
	}
	else
	{
	    echo '<meta http-equiv="Refresh" content="0;URL='.$baseUrl.'error.php?errstr='.$errstr.'" />';
	}
	exit(1);
 }
 function throw_succes($success, $errstr,$return_url=''){
	global $baseUrl;
	$beforeurl = '';
	
	$phpname = "error.php";
	if($success){
		$phpname = "succes.php";
	}
	if(isset($_SERVER['HTTP_REFERER']))
		$beforeurl=@$_SERVER['HTTP_REFERER'];
		
 	if($return_url!='')
		$beforeurl = $return_url;
	
 	if(!$beforeurl){
 		$beforeurl="";
 	}
 	$errstr=$errstr."-".$beforeurl;
 	$errstr=urlencode($errstr);
 	
	if($return_url=='0'){
	 	$errstr = $errstr.'&paths=2';
	}
	if(!headers_sent()){
	    header('Location:'.$baseUrl.$phpname.'?errstr='.$errstr);
	}else{
	   echo '<meta http-equiv="Refresh" content="0;URL='.$baseUrl.$phpname.'?errstr='.$errstr.'" />';
	}
	exit(1);
 }
 //设定为默认的错误处理方式
 set_error_handler("throw_errors");

?>