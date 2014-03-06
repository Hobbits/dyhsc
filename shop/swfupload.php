<?php

	$IWEB_SHOP_IN = true;
	if (isset($_POST["ps"])) {
		session_id($_POST["ps"]);
	}
	session_start();

    if(!isset($_SERVER["HTTP_ACCEPT_LANGUAGE"])){
    	$_SERVER["HTTP_ACCEPT_LANGUAGE"]="zh-cn";
    }
	require('configuration.php');
	require('includes.php');
	/* do 公共信息处理 */
	require 'foundation/alogin_cookie.php';
	$user_id = get_sess_user_id();
	$user_name = get_sess_user_name();
	$shop_id = get_sess_shop_id();
	$privilege=get_sess_privilege();
	if($privilege) {
		$user_privilege = unserialize($privilege);
	}

	/* 判断用户是否登陆 */
	if(!$user_id) { exit('请先登陆！'); }
	/* 判断用户相关操作是否合法 */
	if(isset($_POST['user_id']) && $_POST['user_id'] != $user_id) { exit('非法操作002！请重新登陆！'); }
	/* 判断商铺相关操作是否合法 */
	if($shop_id>0 && isset($_POST['shop_id']) && $_POST['shop_id'] != $shop_id) { exit('非法操作001！请重新登陆！'); }
	
	if(!isset($_POST["gcv"])){
		HandleError("非法操作");
		exit; 
	}
	
	if(!get_session("goodsvercode")||get_session("goodsvercode")!=$_POST["gcv"]){
		HandleError("非法操作");
		exit; 
	}
	
	
	function HandleError($message) {
		echo "ERROR:".$message;
	}
	if(get_args("act")&&get_args("act")=='csvtaobao'){
		require("action/goods/csv_taobao_img.php");
	}else{
		require("action/pubtools/swfupload.action.php");
	}
	
	?>