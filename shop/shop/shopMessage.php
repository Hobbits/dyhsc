<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/shop/shopMessage.html
 * 如果您的模型要进行修改，请修改 models/shop/shopMessage.php
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
if(filemtime("templates/default/shop/shopMessage.html") > filemtime(__file__) || (file_exists("models/shop/shopMessage.php") && filemtime("models/shop/shopMessage.php") > filemtime(__file__)) ) {
	tpl_engine("default","shop/shopMessage.html",1);
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

$status=get_args('status');
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
.message {font-size:14px; line-height:100px; width:580px; float:left; font-weight:bold;}
</style>
</head>
<body onload="changeMenu();">
	<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo  $m_langpackage->m_messageshow;?>
	</div>
    <div class="clear"></div>
    <?php  require("modules/left_menu.php");?>
      <div class="main_right">
        	<div class="right_top"></div>
            <div class="cont">
                <div class="cont_title"><?php echo  $m_langpackage->m_messageshow;?></div>
                <hr />
                <?php  if($status=='1'){?>
	                <div id="stepTip">
				     <ul class="list_step clearfix">
				     <li><?php echo $m_langpackage->m_u_first;?>:<br /><?php echo $m_langpackage->m_a_info;?></li>
				     <li><?php echo $m_langpackage->m_u_secound;?>:<br /><?php echo $m_langpackage->m_a_shop_info;?></li>
				     <li><?php echo $m_langpackage->m_u_third;?>:<br /><?php echo $m_langpackage->m_a_manager_info;?></li>
				     <li class="now" style="padding-right:0"><?php echo $m_langpackage->m_u_fore;?>:<br /><?php echo $m_langpackage->m_accomplish;?></li>
				     </ul>
				     </div>
					<div style="padding:20px;">
						
						<div class="message">&nbsp;&nbsp;<img src="skin/default/images/right.gif"/><?php echo $m_langpackage->m_a_past_auccess;?><a href="do.php?act=refresh_shop"><font color="blue"><?php echo $m_langpackage->m_a_this;?></font></a></div>
						<div class="clear"></div>
					</div>
				<?php  }else {?>
					 <?php  if($status=='2'){?>
						<div style="padding:20px;">
							<div class="message">&nbsp;&nbsp;<img src="skin/default/images/prompt.gif"/><?php echo $m_langpackage->m_a_no_request;?></div>
							<div class="clear"></div>
						</div>
					<?php  }else {?>
						<div id="stepTip">
					     <ul class="list_step clearfix">
					     <li><?php echo $m_langpackage->m_u_first;?>:<br /><?php echo $m_langpackage->m_a_info;?></li>
					     <li><?php echo $m_langpackage->m_u_secound;?>:<br /><?php echo $m_langpackage->m_a_shop_info;?></li>
					     <li class="now"><?php echo $m_langpackage->m_u_third;?>:<br /><?php echo $m_langpackage->m_a_manager_info;?></li>
					     <li style="padding-right:0"><?php echo $m_langpackage->m_u_fore;?>:<br /><?php echo $m_langpackage->m_accomplish;?></li>
					     </ul>
					     </div>
						<div style="padding:20px;">
							
							<div class="message">&nbsp;&nbsp;<img src="skin/default/images/prompt.gif"/><?php echo $m_langpackage->m_a_commit_auccess;?></div>
							<div class="clear"></div>
						</div>
					<?php }?>
				<?php }?>
        	</div>
        	<div class="clear"></div>
			<div class="right_bottom"></div>
			<div class="back_top"><a href="#"></a></div>
   	 </div>
<?php  require("shop/index_footer.php");?>
</body>
</html><?php } ?>