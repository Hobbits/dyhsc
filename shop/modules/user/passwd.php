<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/user/passwd.html
 * 如果您的模型要进行修改，请修改 models/modules/user/passwd.php
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
if(filemtime("templates/default/modules/user/passwd.html") > filemtime(__file__) || (file_exists("models/modules/user/passwd.php") && filemtime("models/modules/user/passwd.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/user/passwd.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

$t_users = $tablePreStr."users";

//定义读操作
dbtarget('r',$dbServs);
$dbo=new dbex;
//判断用户是否锁定，锁定则不许操作
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	trigger_error($m_langpackage->m_user_locked);//非法操作
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo  $m_langpackage->m_u_center;?></title>
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/modules.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/layout.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/style.css">
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/userchangeStyle.js"></script>

<style type="text/css">
td{text-align:left;}
</style>
</head>
<body onload="menu_style_change('user_passwd');changeMenu();">
	<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo  $m_langpackage->m_edit_password;?>
	</div>
    <div class="clear"></div>
    	<?php  require("modules/left_menu.php");?>
        <div class="main_right">
        	<div class="right_top"></div>
            <div class="cont">
                <div class="cont_title"><?php echo  $m_langpackage->m_edit_password;?></div>
                <hr />
				<form action="do.php?act=user_passwd" method="post" name="form_passwd" onsubmit="return checkForm();">
					<table width="100%" style="border:0" cellspacing="0">
						<tr class="trcolor">
							<td width="40%" class="textright"><?php echo  $m_langpackage->m_old_password;?>:</td>
							<td><input type="password" name="user_passwd" value="" maxlength="20" /></td>
							<td><?php echo  $i_langpackage->i_reg_passwdinfo;?></td>
							
						</tr>
						<tr class="trcolor">
							<td class="textright"><?php echo  $m_langpackage->m_new_password;?>:</td>
							<td><input type="password" name="user_new_passwd" value="" maxlength="20" /></td>
							<td ><?php echo  $i_langpackage->i_reg_passwdinfo;?></td>
						</tr>
						<tr class="trcolor">
							<td class="textright"><?php echo  $m_langpackage->m_re_password;?>:</td>
							<td><input type="password" name="user_verify_passwd" value="" maxlength="20" /></td>
							<td><?php echo  $i_langpackage->i_reg_repasswd1;?></td>
						</tr>
						<tr class="trcolor">
							<td></td><td><input type="hidden" name="user_id" value="<?php echo  $user_id;?>" />
							<input class="submit" type="submit" name="submit" value="<?php echo  $m_langpackage->m_edit_password;?>" /></td>
						</tr>
					</table>
				</form>
            </div>
            <div class="clear"></div>
			<div class="right_bottom"></div>
			<div class="back_top"><a href="#"></a></div>
        </div>
    <?php  require("shop/index_footer.php");?>
<script language="JavaScript">
<!--
function checkForm() {
	var user_passwd = document.getElementsByName("user_passwd")[0];
	var user_new_passwd = document.getElementsByName("user_new_passwd")[0];
	var user_verify_passwd = document.getElementsByName("user_verify_passwd")[0];
	if(user_passwd.value=='') {
		alert("<?php echo  $m_langpackage->m_oldpassword_notnone;?>");
		user_passwd.focus();
		return false;
	} else if(user_new_passwd.value=='') {
		alert("<?php echo  $m_langpackage->m_password_notnone;?>");
		user_new_passwd.focus();
		return false;
	} else if(user_new_passwd.value.length<6 || user_new_passwd.value.length>16) {
		alert("<?php echo  $i_langpackage->i_rmsgpwd_format;?>");
		user_new_passwd.focus();
		return false;
	}else if(user_verify_passwd.value!=user_new_passwd.value) {
		alert("<?php echo  $m_langpackage->m_password_notsame;?>");
		user_verify_passwd.value = '';
		user_verify_passwd.focus();
		return false;
	} else if(user_passwd.value==user_new_passwd.value) {
		alert("<?php echo  $m_langpackage->m_password_same;?>");
		user_new_passwd.focus();
		user_new_passwd.value = '';
		user_verify_passwd.value = '';
		return false;
	}

	return true;
}
//-->
</script>
</body>
</html><?php } ?>