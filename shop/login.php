<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/login.html
 * 如果您的模型要进行修改，请修改 models/login.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
/*
 * 此段代码由debug模式下生成运行，请勿改动！
 * 如果debug模式下出错不能再次自动编译时，请进入后台手动编译！
 */
/* debug模式运行生成代码 开始 */
if(!function_exists("tpl_engine")) {
	require("foundation/ftpl_compile.php");
}
if(filemtime("templates/default/login.html") > filemtime(__file__) || (file_exists("models/login.php") && filemtime("models/login.php") > filemtime(__file__)) ) {
	tpl_engine("default","login.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
header("content-type:text/html;charset=utf-8");
$IWEB_SHOP_IN = true;

require("foundation/asession.php");
require("configuration.php");
require("includes.php");
require_once("foundation/asystem_info.php");

//引入语言包
$i_langpackage=new indexlp;
$verifycode = unserialize($SYSINFO['verifycode']);
/* 用户信息处理 */
if(get_sess_user_id()) {
	$USER['login'] = 1;
	$USER['user_name'] = get_sess_user_name();
	$USER['user_id'] = get_sess_user_id();
	$USER['user_email'] = get_sess_user_email();
	$USER['shop_id'] = get_sess_shop_id();
	header('Location: modules.php');
} else {
	$USER['login'] = 0;
	$USER['user_name'] = '';
	$USER['user_id'] = '';
	$USER['user_email'] = '';
	$USER['shop_id'] = '';
}
$url = get_args('url');
if($url){
	$_SERVER['HTTP_REFERER']=urldecode($url);
}
$iweb_shop=get_cookie('iweb_login');
$outuserid=get_args('outuserid')?get_args('outuserid'):'0';
/*导航位置*/
$nav_selected=1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $i_langpackage->i_member_login;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<base href="<?php echo  $baseUrl;?>" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/index.css" rel="stylesheet" type="text/css" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/area.js"></script>

</head>
<body>
<div id="wrapper">
<?php  include("shop/index_header.php");?>

  <div id="contents" class="clearfix" >
    <h3 class="ttlm_login"><?php echo  $i_langpackage->i_u_login;?></h3>
	 <form action="do.php?act=login" method="post" name="reg_form">
		<input type="hidden" name="url" value="<?php echo isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'index.php';?>">
		<input type="hidden" name="outuserid" value="<?php echo $outuserid;?>">
	     <div id="login_leftColumn" class="w_480">
	     	<p class="mg12b"><?php echo  $i_langpackage->i_login_email;?>：</p>
	      	<p class="mg12b"><input name="user_email" class="txt_230" type="text" value="<?php echo $iweb_shop;?>" maxlength="200" /></p>
	      	<p class="tip mg12b"><?php echo  $i_langpackage->i_enter_username_email;?></p>
	      	<p class="mg12b"><?php echo  $i_langpackage->i_login_password;?>：</p>
	      	<p class="mg12b"><input name="user_passwd" class="txt_230" type="password" value="" maxlength="50" /></p>
	      	<p class="tip mg12b"><?php echo  $i_langpackage->i_reg_unameinfo;?></p>
		<?php if($verifycode['1']==1){?>
          <p class="mg12b"><?php echo  $i_langpackage->i_verifycode;?>：</p>
          <p class="vali mg12b">
          	<input type="text" class="txt_230" name="veriCode" id="veriCode" style="width:100px" maxlength="4" /> 
          	<img border="0" src="servtools/veriCodes.php" align="absmiddle" id="verCodePic"><a href="javascript:;" onclick="return getVerCode();"><?php echo $i_langpackage->i_change_img;?></a>
          	<SPAN id="veriCode_message"></SPAN>
          </p>
		   <p class="tip mg12b"><?php echo  $i_langpackage->i_reg_inputvf;?></p>
		<?php }?>
	      	<div class="login_submit">
		        <INPUT class="btn_02" type="button" value="<?php echo $i_langpackage->i_login;?>" name=<?php echo $i_langpackage->i_login;?> onclick='checkcode()'>				
		      	<span class="go_register" ><a href="modules.php?app=forgot"><?php echo  $i_langpackage->i_getback_pw;?>？</a></span>
		    </div>
	     </div>

     </form>
     <div id="login_rightColumn" class="w_475">
      	<div class="right_inner">
     		<p class="ttlms_tip"><img src="skin/<?php echo  $SYSINFO['templates'];?>/images/login_tip.gif" alt="<?php echo $i_langpackage->i_login_info;?>" /></p>
      		<p>1.<?php echo $i_langpackage->i_login_info_first;?></p>
		    <p>2.<?php echo $i_langpackage->i_login_info_sec;?></p>
		    <p>3.<?php echo $i_langpackage->i_login_info_the;?></p>
		    <!--<p>4.<?php echo $i_langpackage->i_login_info_foru;?></p>-->
		    <div class="login_submit">
		        <INPUT class="btn_02" type="button" value="<?php echo  $i_langpackage->i_register_now;?>" name=<?php echo $i_langpackage->i_login;?> onclick="javascript:window.location.href='modules.php?app=reg'"/>				
		    </div>
      	</div>
     </div>
    <!-- /contents -->
  </div>
  <script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
<!--
function reg(){
	
}
function getVerCode() {
	document.getElementById("verCodePic").src="servtools/veriCodes.php?vc="+Math.random();
}

function checkcode(){
	<?php if($verifycode['1']==1) {?>
	var cvalue=document.getElementById("veriCode").value;
	var veriCode = document.getElementsByName('veriCode')[0];
	var veriCode_message = document.getElementById('veriCode_message');
	if(cvalue==''){
		veriCode_message.style.color = 'red';
		veriCode.className = 'txt_230 ipt_focus'; 
		veriCode_message.innerHTML = '<?php echo  $i_langpackage->i_rmsgvf_input;?>';
		return false;
	}
	ajax('do.php?act=checkcode','POST','checkcode='+cvalue,function(data){
		if(data==1){
			veriCode_message.innerHTML = '';
			if(checkForm()){
            	document.reg_form.submit();
			}
		}else{
			veriCode_message.style.color = 'red';
			veriCode.className = 'txt_230 ipt_focus'; 
			veriCode_message.innerHTML = '<?php echo  $i_langpackage->i_checkcode_error;?>';
            return false;
		}
		
	});
	<?php  } else {?>
		if(checkForm()){
            document.reg_form.submit();
		}
	<?php }?>
}

function checkForm() {
	var user_email = document.getElementsByName("user_email")[0];
	if(user_email.value=='') {
		alert('<?php echo  $i_langpackage->i_email_notnone;?>');
		user_email.focus();
		return false;
	}
	//var user_passwd = document.getElementsByName("user_passwd")[0];
	//if(user_passwd.value=='') {
		//alert('<?php echo  $i_langpackage->i_password_notnone;?>');
		//user_passwd.focus();
		//return false;
	//} 
	
	return true;
}
//-->
</script>
<!-- main end -->
<!--main right end-->
<?php  require("shop/index_footer.php");?>
<!--footer end-->
</div>
</body>
</html>
<?php } ?>