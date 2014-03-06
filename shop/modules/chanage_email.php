<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/chanage_email.html
 * 如果您的模型要进行修改，请修改 models/modules/chanage_email.php
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
if(filemtime("templates/default/modules/chanage_email.html") > filemtime(__file__) || (file_exists("models/modules/chanage_email.php") && filemtime("models/modules/chanage_email.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/chanage_email.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
	/*
	***********************************************
	*$ID:
	*$NAME:
	*$AUTHOR:E.T.Wei
	*DATE:Mon May 24 15:10:41 CST 2010
	***********************************************
	*/
	if(!$IWEB_SHOP_IN) {
		trigger_error('Hacking attempt');
	}
	$user_id = intval(get_args("user_id"));
	//文件引入
	require("foundation/module_users.php");
	require("foundation/csmtp.class.php");
	require("foundation/asystem_info.php");
	//引入语言包
	$m_langpackage=new moduleslp;
	$i_langpackage=new indexlp;

	if(get_sess_user_id()) {
		$USER['login'] = 1;
		$USER['user_name'] = get_sess_user_name();
		$USER['user_id'] = get_sess_user_id();
		$USER['user_email'] = get_sess_user_email();
		$USER['shop_id'] = get_sess_shop_id();
	} else {
		$USER['login'] = 0;
		$USER['user_name'] = '';
		$USER['user_id'] = '';
		$USER['user_email'] = '';
		$USER['shop_id'] = '';
	}

	//数据表定义区
	$t_users = $tablePreStr."users";
	$t_user_info = $tablePreStr."user_info";
	$t_mailtpl = $tablePreStr."mailtpl";
	//读写分类定义方法
	$dbo = new dbex;
	dbtarget("r",$dbServs);
	$sql =  "SELECT `user_name`,`user_email`,`locked`,`email_check`,`email_check_code` FROM `$t_users` WHERE user_id='$user_id'";
	$user_info = $dbo->getRow($sql);
	if($user_info['locked']||$user_info['email_check']){
		 echo"<script language=javascript>
			alert(\"".$m_langpackage->m_changeemail_error."！\");
			location.href = \"index.php\"
			</script>";
	}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo  $m_langpackage->m_change_mail;?></title>
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/modules.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/layout.css">
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/index.css" rel="stylesheet" type="text/css" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>

</head>
<body>
<div id="wrapper">
<?php  require("shop/index_header.php");?>
    <div class="clear"></div>
    <div id="contents" class="clearfix"  >
		<h3 class="ttlm_login"><?php echo $m_langpackage->m_change_email;?></h3>
		<div class="findpsw">
			<form action="" method="post" name="form1" >
				<table class="tab_findpsw" >
					<tr align="center"><td width="100px;"><?php echo $m_langpackage->m_register_username;?>：</td><td><input type="text" name="user_name" value="" /></td></tr>
					<tr><td><?php echo $m_langpackage->m_register_password;?>：</td><td><input type="password" name="user_password" value="" /></td></tr>
					<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $m_langpackage->m_new_email;?>：</td><td><input type="text" name="user_email" value="" /></td></tr>
					<tr><td>&nbsp;&nbsp;<?php echo $m_langpackage->m_fill_code;?>：</td><td><input type="text" name="veriCode" id="veriCode" style="width:100px" maxlength="4" /> 
          	<img border="0" hight="10px" align="absmiddle" src="servtools/veriCodes.php" id="verCodePic"><a href="javascript:;" onclick="return getVerCode();"><?php echo $i_langpackage->i_change_img;?></a><SPAN id="veriCode_message"></SPAN></td>
              </tr>
					<input type="hidden" name="user_id" value="<?php echo $user_id;?>" />
					<tr><td></td><td align="center"><input type="button" name="asd" value="<?php echo  $m_langpackage->m_send;?>" class="btn_02" onclick="chanage_mail();"/></td></tr>
				</table>
			</form>
		</div>
    </div>
</div>
<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
<!--
// 检测邮箱
function chanage_mail(){
	var user_email = document.getElementsByName('user_email')[0];
	var user_email_reg = /^[0-9a-zA-Z_\-\.]+@[0-9a-zA-Z_\-]+(\.[0-9a-zA-Z_\-]+)*$/;

	if(user_email.value=='') {
		alert('<?php echo $m_langpackage->m_fill_email;?>');
		return false;
	} else if(!user_email.value.match(user_email_reg)) {
		alert('<?php echo $m_langpackage->m_fill_right;?>!');
		return false;
	}

	var cvalue=document.getElementById("veriCode").value;
	var veriCode = document.getElementsByName('veriCode')[0];
	var veriCode_message = document.getElementById('veriCode_message');
	if(cvalue==''){
		veriCode_message.style.color = 'red';
		veriCode.className = 'txt_230 ipt_focus';
		veriCode_message.innerHTML = '<?php echo  $i_langpackage->i_rmsgvf_input;?>';
		return false;
	}else{
	ajax('do.php?act=checkcode','POST','checkcode='+cvalue,function(data){
		if(data==1){
			veriCode_message.innerHTML = '';
			document.form1.action="do.php?act=chanage_email";
			document.form1.submit();
		}else{
			veriCode_message.style.color = 'red';
			veriCode.className = 'txt_230 ipt_focus'; 
			veriCode_message.innerHTML = '<?php echo  $i_langpackage->i_checkcode_error;?>';
            return false;
		}
	});
	}
}
function getVerCode() {
	document.getElementById("verCodePic").src="servtools/veriCodes.php?vc="+Math.random();
	return false;
}
//-->
</script>

<div class="clear"></div>
<?php  require("shop/index_footer.php");?>
</body>
</html><?php } ?>