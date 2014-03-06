<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//引入语言包
$a_langpackage=new adminlp;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/admin.css">
<script type='text/javascript' src="skin/js/jy.js"></script>
<style>
.cfff a:link, .cfff a:hover, .cfff a:visited {
	color:#fff;
}
</style>
</head>
<body onload="nTabs()">
<input type="hidden" id="hid" value="topid" />
<div id="jywrap">
<div id="jyhead">
<div class="logo"></div>
<div class="nav">
	<ul class="menu">
		<li id="index" class="active"><a href="m.php?app=menu&value=index" target="menu-frame" hidefocus="true"><?php echo $a_langpackage->a_global_settings; ?></a></li>
		<li id="shops"><a href="m.php?app=menu&value=shops" target="menu-frame" hidefocus="true"><?php echo $a_langpackage->a_m_shop_mengament; ?></a></li>
		<li id="member"><a href="m.php?app=menu&value=member" target="menu-frame" hidefocus="true"><?php echo $a_langpackage->a_m_member_oprate; ?></a></li>
		<li id="commodity"><a href="m.php?app=menu&value=commodity" target="menu-frame" hidefocus="true"><?php echo $a_langpackage->a_m_aboutgoods_management; ?></a></li>
		<li id="order"><a href="m.php?app=menu&value=order" target="menu-frame" hidefocus="true"><?php echo $a_langpackage->a_m_order_mengament; ?></a></li>
		<li id="promotions"><a href="m.php?app=menu&value=promotions" target="menu-frame" hidefocus="true"><?php echo $a_langpackage->a_promotion_manage; ?></a></li>
		<li id="application"><a href="m.php?app=menu&value=application" target="menu-frame" hidefocus="true"><?php echo $a_langpackage->a_application_management; ?></a></li>
	</ul>
</div>
<div class="uinfo">
	<div align="right"> 
	<div class="cfff" style="background-color:#FFF;color:#F67A06"><a class="c_F67" style="color:#F67A06" href="../" target="_blank"><?php echo $a_langpackage->a_site_index; ?></a>|<a class="c_F67" style="color:#F67A06" href="m.php?app=change_password" target="main-frame"><?php echo $a_langpackage->a_password_edit; ?></a>|<a class="c_F67" style="color:#F67A06" href="m.php?app=navigate" target="main-frame">功能导航</a></div>
	<p style="margin-top:10px;"><?php echo $a_langpackage->a_hello; ?><em><?php echo $_SESSION['admin_name']; ?></em> <a href="a.php?act=logout" target="main-frame" style="width:30px; display:inline-block;text-align: left;"><?php echo $a_langpackage->a_admin_logout; ?></a></p>
		
		<!-- <div class="uinfo">
		<?php echo $a_langpackage->a_hello; ?><em><?php echo $_SESSION['admin_name']; ?></em>  <br />
		<?php echo $a_langpackage->a_right_v; ?>：<?php echo $_SESSION['group_name']; ?> | <a href="../" target="_blank"><?php echo $a_langpackage->a_site_index; ?></a> | <a href="m.php?app=main" target="main-frame"><?php echo $a_langpackage->a_sysadmin_index; ?></a> | <a href="m.php?app=change_password" target="main-frame"><?php echo $a_langpackage->a_password_edit; ?></a> | <a href="a.php?act=logout" target="main-frame"><?php echo $a_langpackage->a_logout; ?></a>
		</div>-->
	</div>
	<div>&nbsp;</div>
</div>
</body>
</html>