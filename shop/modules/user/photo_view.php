<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/user/photo_view.html
 * 如果您的模型要进行修改，请修改 models/modules/user/photo_view.php
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
if(filemtime("templates/default/modules/user/photo_view.html") > filemtime(__file__) || (file_exists("models/modules/user/photo_view.php") && filemtime("models/modules/user/photo_view.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/user/photo_view.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("foundation/module_photo.php");
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

$id = intval(get_args('id'));
$path = short_check(get_args('path'));
if(!$id) { trigger_error($m_langpackage->m_handle_err); }

//数据表定义区
$t_order_goods = $tablePreStr."order_goods";

$dbo=new dbex;
//读写分离定义方法
dbtarget('r',$dbServs);

$info = get_photo_info($dbo,$t_order_goods,$id);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $m_langpackage->m_u_center;?></title>
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/modules.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/layout.css">
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/style.css">
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/userchangeStyle.js"></script>
<style type="text/css">
td span { color:red; }
#reg_step { width:770px; height:29px; margin: 12px auto 20px; line-height: 29px; }
#reg_step ol li { width: 154px; float: left; padding:0 0 3px; font-size: 14px; font-weight: bold; background-color:#ececec; color:#333; text-align:center; }
#reg_step ol li span, #reg_step ol li strong { display: block; text-align:center; }
#reg_step ol li.current { background:url(skin/default/images/steps_bg.gif) left top no-repeat; padding-top:4px; margin-top:-4px; color:#FFF; }
#reg_step ol li.last_current { background-color: #F6A248; color: #fff; background-position: right -145px; }
td { text-align:left; }
</style>
</head>
<body onload="menu_style_change('<?php echo  $path;?>');changeMenu();">
<?php  require("shop/index_header.php");?>
<div class="site_map"> <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo  $m_langpackage->m_goods_photo_request;?> </div>
<div class="clear"></div>
<?php  require("modules/left_menu.php");?>
<div class="main_right">
	<div class="right_top"></div>
	<div class="cont">
		<div class="cont_title"><?php echo  $m_langpackage->m_goods_photo_request;?></div>
		<table class="form_table_02" width="100%" border="0" cellspacing="0">
			<tr>
				<th width="100px"><?php echo  $m_langpackage->m_goods_name;?>：</th>
				<td><?php echo  $info['goods_name'];?></td>
			</tr>
			<tr>
				<th><?php echo  $m_langpackage->m_goods_price;?>：</th>
				<td><?php echo  $info['goods_price'];?></td>
			</tr>
			<tr>
				<th><?php echo  $m_langpackage->m_transport_price;?>：</th>
				<td><?php echo  $info['good_tran'];?></td>
			</tr>
			<tr>
				<th><?php echo  $m_langpackage->m_order_ordertime;?>：</th>
				<td><?php echo  $info['add_time'];?></td>
			</tr>
		</table>
	</div>
	<div class="clear"></div>
	<div class="right_bottom"></div>
	<div class="back_top"><a href="#"></a></div>
</div>
<?php  require("shop/index_footer.php");?>
</body>
</html><?php } ?>