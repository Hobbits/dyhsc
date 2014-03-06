<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/user/forgot.html
 * 如果您的模型要进行修改，请修改 models/modules/user/forgot.php
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
if(filemtime("templates/default/modules/user/forgot.html") > filemtime(__file__) || (file_exists("models/modules/user/forgot.php") && filemtime("models/modules/user/forgot.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/user/forgot.html",1);
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

/* POST */
$userpwd_id = intval(get_args('uid'));
$code = short_check(get_args('ucode'));

if(!$userpwd_id || !$code) {
	echo '<script language="JavaScript">alert("'.$m_langpackage->m_forgot_info.'"); location.href="modules.php"</script>';
	exit;
}

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();

/* 定义文件表 */
$t_users = $tablePreStr."users";

$sql = "select * from `$t_users` where user_id='$userpwd_id'";
$row = $dbo->getRow($sql);
if($row['forgot_check_code'] != $code) {
	echo '<script language="JavaScript">alert('.$m_langpackage->m_forgot_info.'); location.href="modules.php"</script>';
	exit;
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo  $m_langpackage->m_u_center;?></title>
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/modules.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/layout.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/style.css">
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/userchangeStyle.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>

</head>
<body>
<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo  $m_langpackage->m_find_password;?>
	</div>
    <div class="clear"></div>
 	<?php  require("modules/left_menu.php");?>
    <div class="main_right">
    	<div class="right_top"></div>
        <div class="cont">
			<div class="title_uc"><h3><?php echo  $m_langpackage->m_find_password;?></h3><hr /></div>
				<form action="do.php?act=forgot" method="post" name="form_passwd" onsubmit="return checkForm();">
					<table width="100%" border="0" cellspacing="0">
						<tr><th class="textright"><?php echo  $m_langpackage->m_new_password;?>：</td>
							<th class="textleft"><input type="password" name="user_new_passwd" value="" maxlength="20" /></td>
						</tr>
						<tr><th class="textright"><?php echo  $m_langpackage->m_re_password;?>：</td>
							<th class="textleft"><input type="password" name="user_verify_passwd" value="" maxlength="20" /></td>
						</tr>
						<tr><td colspan="2" align="center"><input type="hidden" name="user_id" value="<?php echo  $userpwd_id;?>" />
						<input type="hidden" name="code" value="<?php echo  $code;?>" /><input type="submit" class="submit " name="submit" value="<?php echo  $m_langpackage->m_edit;?>" /></td></tr>
					</table>
				</form>
	        </div>
    	</div>
    </div>
    <div class="clear"></div>
    <?php  require("shop/index_footer.php");?>
<script language="JavaScript">
<!--
function checkForm() {
	var user_new_passwd = document.getElementsByName("user_new_passwd")[0];
	var user_verify_passwd = document.getElementsByName("user_verify_passwd")[0];
	if(user_new_passwd.value=='') {
		alert("<?php echo  $m_langpackage->m_password_notnone;?>");
		user_new_passwd.focus();
		return false;
	} else if(user_verify_passwd.value!=user_new_passwd.value) {
		alert("<?php echo  $m_langpackage->m_password_notsame;?>");
		user_verify_passwd.value = '';
		user_verify_passwd.focus();
		return false;
	}
	return true;
}
//-->
</script>
</body>
</html><?php } ?>