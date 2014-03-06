<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/reg/register.html
 * 如果您的模型要进行修改，请修改 models/modules/reg/register.php
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
if(filemtime("templates/default/modules/reg/register.html") > filemtime(__file__) || (file_exists("models/modules/reg/register.php") && filemtime("models/modules/reg/register.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/reg/register.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}
//引入语言包
$i_langpackage=new indexlp;
require_once("foundation/asystem_info.php");

$header['keywords'] = $SYSINFO['sys_keywords'];
$header['description'] = $SYSINFO['sys_description'];
$verifycode = unserialize($SYSINFO['verifycode']);
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
$nav_selected = '1';

$rmail=get_args("rmail")?get_args("rmail"):"";
$ruser=get_args("ruser")?get_args("ruser"):"";
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo  $header['keywords'];?>" />
<meta name="description" content="<?php echo  $header['description'];?>" />
<title><?php echo  $i_langpackage->i_user_register;?></title>
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/index.css" rel="stylesheet" type="text/css" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/area.js"></script>
</head>
<body>
<div id="wrapper">
<?php  include("shop/index_header.php");?>

<div id="contents" class="clearfix" >
<h3 class="ttlm_login"><?php echo  $i_langpackage->i_u_register;?></h3>

     <form action="do.php?act=register" name="reg_form" method="post">
     <div id="login_leftColumn" class="w_395">
     	<p class="mg12b"><?php echo  $i_langpackage->i_reg_email;?>：</p>
          <p class="mg12b">
          	<input type="text" class="txt_230 ipt_nomal" name="user_email" autocomplete="off"  value="<?php echo $rmail;?>"/><span id="user_email_message" class="hint"></span>
          </p>
          <p class="tip mg12b"><?php echo  $i_langpackage->i_re_your_password;?></p>
          <p class="mg12b"><?php echo  $i_langpackage->i_reg_username;?>：</p>
          <p class="mg12b">
          	<input type="text" class="txt_230 ipt_nomal" name="user_name" id="user_name" onblur="checkname();" autocomplete="off" value="<?php echo $ruser;?>" /><span id="user_name_message" class="hint"></span>
          </p>

          <p class="tip mg12b"><?php echo  $i_langpackage->i_reg_unameinfo;?></p>
          <p class="mg12b"><?php echo  $i_langpackage->i_reg_passwd;?>：</p>
          <p class="mg12b">
          	<input class="txt_230 ipt_nomal" type="password" name="user_password" id="user_password" autocomplete="off" /><span id="user_password_message" class="hint"></span>
          </p>
          <p class="tip mg12b"><?php echo  $i_langpackage->i_reg_passwdinfo;?></p>
          <p class="mg12b"><?php echo  $i_langpackage->i_reg_repasswd;?>：</p>
          <p class="mg12b">
          	<input class="txt_230 ipt_nomal" type="password" name="user_repassword" id="user_repassword" /><span id="user_repassword_message" class="hint"></span>
          </p>
          <p class="tip mg12b"><?php echo  $i_langpackage->i_reg_repasswd1;?></p>
		  <?php if($verifycode['2']==1){?>
          <p class="mg12b"><?php echo  $i_langpackage->i_verifycode;?>：</p>
          <p class="vali mg12b">
          	<input type="text" class="txt_230" name="veriCode" id="veriCode" style="width:100px" maxlength="4" /> 
          	<img border="0" src="servtools/veriCodes.php" align="absmiddle" id="verCodePic"><a href="javascript:;" onclick="return getVerCode();"><?php echo $i_langpackage->i_change_img;?></a>
          	<SPAN id="veriCode_message"></SPAN>
          </p>
		   <p class="tip mg12b"><?php echo  $i_langpackage->i_reg_inputvf;?></p>
		  <?php }?>
         
		  <div class="login_submit">
				<input class="btn_02" type="button" value="<?php echo  $i_langpackage->i_register_now;?>" name="regcheckbtn" onclick="checkcode();"/>
		  </div>
      </div>
      </form>

     <div id="login_rightColumn" class="w_443"></div>
</div>

<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
function rlength(v){
	return v.replace(/[^\x00-\xff]/g, 'xx').length; 
}

function getVerCode() {
	document.getElementById("verCodePic").src="servtools/veriCodes.php?vc="+Math.random();
	return false;
}

// 检测会员用户名
var user_name = document.getElementsByName('user_name')[0];
var user_name_message = document.getElementById('user_name_message');
var user_name_status = false;
var user_name_reg = /^(\w|[\u0391-\uFFE5])*$/;
user_name.onmouseover = function()
{
	user_name.className = 'txt_230 ipt_focus';
};
user_name.onmouseout = function()
{
	user_name.className = 'txt_230 ipt_nomal';
}; 

 function checkname(){
	 var user_name = document.getElementsByName('user_name')[0];
	if(user_name.value=='') {
		user_name_message.style.color = 'red';
		user_name_message.innerHTML = '* <?php echo  $i_langpackage->i_rmsg_inputuname;?>';
		user_name_status = false;
	} else if(!user_name.value.match(user_name_reg)) {
		user_name_message.style.color = 'red';
		user_name.className = 'txt_230 ipt_error';
		user_name.onmouseout= 'txt_230 ipt_error'; 
		user_name_message.innerHTML = '* <?php echo  $i_langpackage->i_rmsg_formatname;?>';
		user_name_status = false;
	}else if(rlength(user_name.value)<4||rlength(user_name.value)>16){
		user_name_message.style.color = 'red';
		user_name.className = 'txt_230 ipt_error';
		user_name.onmouseout= 'txt_230 ipt_error'; 
		user_name_message.innerHTML = '* <?php echo  $i_langpackage->i_rmsg_formatname;?>';
		user_name_status = false;
	}else {
		user_name_message.style.color = 'red';
		user_name.className = 'txt_230 ipt_error';
		user_name.onmouseout= 'txt_230 ipt_error'; 
		user_name_message.innerHTML = '* <?php echo  $i_langpackage->i_rmsgname_checknow;?>';
		ajax("do.php?act=user_check_username","POST","v="+user_name.value,function(data){
			if(data==1) {
				user_name_message.style.color = 'green';
				user_name_message.innerHTML = '<?php echo  $i_langpackage->i_rmsgname_isok;?>';
				user_name_status = true;
			} else {
				user_name_message.style.color = 'red';
				user_name_message.innerHTML = '* <?php echo  $i_langpackage->i_rmsgname_used;?>';
				user_name_status = false;
			}
		});
	}
};

// 检测邮箱
var user_email = document.getElementsByName('user_email')[0];
var user_email_message = document.getElementById('user_email_message');
var user_email_status = false;
var user_email_reg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
user_email.onmouseover = function(){user_email.className = 'txt_230 ipt_focus'};
user_email.onmouseout = function(){user_email.className = 'txt_230 ipt_nomal'}; 
user_email.onblur = function(){
	if(user_email.value=='') {
		user_email_message.style.color = 'red';
		user_email_message.innerHTML = '* <?php echo  $i_langpackage->i_rmsgmail_input;?>';
		user_email_status = false;
	} else if(!user_email.value.match(user_email_reg)) {
		user_email_message.style.color = 'red';
		 user_email.className = 'txt_230 ipt_error';
		 user_email.onmouseout = 'txt_230 ipt_error'; 		
		 user_email_message.innerHTML = '* <?php echo  $i_langpackage->i_rmsgmail_format;?>';
		user_email_status = false;
	} else {
		user_email_message.style.color = 'red';
		 user_email.className = 'txt_230 ipt_error';
		 user_email.onmouseout = 'txt_230 ipt_error'; 		
		user_email_message.innerHTML = '* <?php echo  $i_langpackage->i_rmsgmail_checknow;?>';
		ajax("do.php?act=user_check_useremail","POST","v="+user_email.value,function(data){
			if(data==1) {
				user_email_message.style.color = 'green';
				user_email_message.innerHTML = '<?php echo  $i_langpackage->i_rmsgmail_isok;?>';
				user_email_status = true;
			} else {
				user_email_message.style.color = 'red';
				user_email_message.innerHTML = '* <?php echo  $i_langpackage->i_rmsgmail_used;?>';
				user_email_status = false;
			}
		});
	}
};

// 检测密码
var user_password = document.getElementsByName('user_password')[0];
var user_password_message = document.getElementById('user_password_message');
var user_password_status = false;
user_password.onmouseover = function(){user_password.className = 'txt_230 ipt_focus'};
user_password.onmouseout = function(){user_password.className = 'txt_230 ipt_nomal'}; 
user_password.onblur = function(){
	if(user_password.value=='') {
		user_password_message.style.color = 'red';
		user_password_message.innerHTML = '* <?php echo  $i_langpackage->i_rmsgpwd_input;?>';
		user_password_status = false;
	} else if(user_password.value.length<6 || user_password.value.length>16) {
		user_password_message.style.color = 'red';
		 user_password.className = 'txt_230 ipt_error';
		user_password.onmouseout='txt_230 ipt_error';
		user_password_message.innerHTML = '* <?php echo  $i_langpackage->i_rmsgpwd_format;?>';
		user_password_status = false;
	} else {
		user_password_message.style.color = 'green';
		user_password_message.innerHTML = '<?php echo  $i_langpackage->i_rmsgpwd_right;?>';
		user_password_status = true;
	}
};

// 检测确认密码
var user_repassword = document.getElementsByName('user_repassword')[0];
var user_repassword_message = document.getElementById('user_repassword_message');
var user_repassword_status = false;
user_repassword.onmouseover = function(){user_repassword.className = 'txt_230 ipt_focus'};
user_repassword.onmouseout = function(){user_repassword.className = 'txt_230 ipt_nomal'}; 
user_repassword.onblur = function(){
	if(user_repassword.value=='') {
		user_repassword_message.style.color = 'red';
		user_repassword_message.innerHTML = '* <?php echo  $i_langpackage->i_rmsgrepwd_input;?>';
		user_repassword_status = false;
	} else if(user_repassword.value!=user_password.value) {
		user_repassword_message.style.color = 'red';
		 user_repassword.className = 'txt_230 ipt_error';
		 user_repassword.onmouseout='txt_230 ipt_error'; 		
		 user_repassword_message.innerHTML = '* <?php echo  $i_langpackage->i_rmsgpwd_notfaf;?>';
		user_repassword_status = false;
	} else {
		user_repassword_message.style.color = 'green';
		user_repassword_message.innerHTML = '<?php echo  $i_langpackage->i_rmsgrepwd_format;?>';
		user_repassword_status = true;
	}
};



function checkcode(){
	<?php if($verifycode['2']==1) {?>
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
	<?php if($verifycode['2']==1) {?>
	var veriCode = document.getElementsByName('veriCode')[0];
	var veriCode_message = document.getElementById('veriCode_message');
	if(veriCode.value=='') {
		veriCode_message.style.color = 'red';
		veriCode.className = 'txt_230 ipt_focus'; 
		veriCode_message.innerHTML = '<?php echo  $i_langpackage->i_rmsgvf_input;?>';
		return false;
	}
	<?php }?>
	if(user_name_status && user_email_status && user_password_status && user_repassword_status) {
		return true;
	} else {
		user_name.onblur();
		user_email.onblur();
		user_password.onblur();
		user_repassword.onblur();
		if(user_name_status && user_email_status && user_password_status && user_repassword_status) {
			return true;
		}
		return false;
	}
}
var $ = function (id) {
	return "string" == typeof id ? document.getElementById(id) : id;
}


</script>
<!-- main end -->
<!--main right end-->
<?php  require("shop/index_footer.php");?>
<!--footer end-->
</div>
</body>
</html>
<?php } ?>