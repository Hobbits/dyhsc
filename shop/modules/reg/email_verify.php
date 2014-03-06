<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/reg/email_verify.html
 * 如果您的模型要进行修改，请修改 models/modules/reg/email_verify.php
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
if(filemtime("templates/default/modules/reg/email_verify.html") > filemtime(__file__) || (file_exists("models/modules/reg/email_verify.php") && filemtime("models/modules/reg/email_verify.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/reg/email_verify.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

/* 用户信息处理 */
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
$user_id = intval(get_args("user_id"));
$t_users = $tablePreStr."users";

$header['keywords'] = $SYSINFO['sys_keywords'];
$header['description'] = $SYSINFO['sys_description'];

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();
$sql="SELECT user_email FROM $t_users WHERE user_id='$user_id'";
$user_info = $dbo->getRow($sql);
$nav_selected = '1';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo  $header['keywords'];?>" />
<meta name="description" content="<?php echo  $header['description'];?>" />
<title><?php echo  $m_langpackage->m_email_ver;?></title>
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/index.css" rel="stylesheet" type="text/css" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/area.js"></script>
<style>
	.forgotleft {float:left; width:330px;}
	.forgotright {float:left; width:600px; border:1px solid #eee; line-height:24px; padding-left:10px;}
	.forgotleft div {margin-top:10px;}
	hr{border:0 #ccc solid;border-top-width:1px;clear:both;height:0}
	.reginbox{width:518px; margin:40px auto 50px}
	.regbox h3{color:#E38016;font-size:16px;height:35px;line-height:35px;margin:0 40px 20px;padding-left:70px;}
	.regbox p{color:#333333;font-size:14px;line-height:180%;padding:5px 5px 0 35px;}
	.rsend h4{font-size:14px; margin:10px 0;}
	.rsend ul {padding:5px 0 5px 25px;}
	.rsend ul li {list-style-position:inside;list-style-type:square; text-align:left; padding:5px 0}
	.rsend ul li a{color:red;}
</style>
</head>
<body>
<div id="wrapper">
<?php  include("shop/index_header.php");?>
<!--search end -->
<div id="contents" class="clearfix"  >
	<h3 class="ttlm_login"><?php echo $m_langpackage->m_member_register;?></h3>
	<div class="regbox">
		<div class="reginbox">
	        <h3><?php echo $m_langpackage->m_think_register;?>，<?php echo $i_langpackage->i_email_complete_registration;?></h3>
	        <div style="min-height: 100px;">
	             <p><?php echo $m_langpackage->m_we;?><span style="color:red;"><?php echo $user_info['user_email'];?></span><?php echo $m_langpackage->m_send_email;?></p>
	             <p><?php echo $m_langpackage->m_confirm_prompt;?></p>
	        </div>
	        <hr />
	        <div class="rsend">
	            <h4><?php echo $m_langpackage->m_receive_email;?></h4>
	            <ul>
	                <li><?php echo $m_langpackage->m_register_prompt;?><a href="javascript:;" onclick="return showspan()"><?php echo $m_langpackage->m_register_prompt1;?></a>
	                <span id="codespan" style="display: none"><input type="text" class="" name="veriCode" id="veriCode" style="width:100px" maxlength="4" /> 
          	        <img height="30" src="servtools/veriCodes.php" align="absmiddle"  id="verCodePic" onclick="getVerCode(this)"><input type="button" value="确定" /></span></li>
	                <li><?php echo $m_langpackage->m_register_prompt2;?><?php echo $user_info['user_email'];?> (<a href="modules.php?app=chanage_email&user_id=<?php echo $user_id;?>"><?php echo $m_langpackage->m_register_prompt3;?></a>)</li>
	            </ul>
	         </div>
	     </div>
	</div>
</div>
<!-- main end -->
<!--main right end-->
<?php  require("shop/index_footer.php");?>
<!--footer end-->
</body>
</html>
<<script type="text/javascript">
<!--
function getVerCode(obj) {
	obj.src="servtools/veriCodes.php";
}
function sendemail(){
	var vc=document.getElementById("veriCode").value;
	window.location.href="do.php?act=send_email&user_id=<?php echo $user_id;?>&code="+vc;
}

function showspan(){
	document.getElementById("codespan").style.display="";
	return false;
}
//-->
</script>
<?php } ?>