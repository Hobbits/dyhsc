<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/groupbuy/login.html
 * 如果您的模型要进行修改，请修改 models/modules/groupbuy/login.php
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
if(filemtime("templates/default/modules/groupbuy/login.html") > filemtime(__file__) || (file_exists("models/modules/groupbuy/login.php") && filemtime("models/modules/groupbuy/login.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/groupbuy/login.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require("foundation/module_groupbuy.php");

//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

$group_id = intval(get_args('id'));

//数据表定义区
$t_groupbuy = $tablePreStr."groupbuy";
$t_groupbuy_log = $tablePreStr."groupbuy_log";


//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

$group_row=get_groupbuy_info($dbo,"*",$t_groupbuy,$group_id);

$login_rs=get_groupbuylog_list($dbo,"*",$t_groupbuy_log,$group_id)

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo  $m_langpackage->m_u_center;?></title>
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/modules.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/layout.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/style.css">
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/userchangeStyle.js"></script>

</head>
<body onload="menu_style_change('groupbuy_list');changeMenu();">
<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo  $m_langpackage->m_order_status;?>
	</div>
    <div class="clear"></div>
	<?php  require("modules/left_menu.php");?>
    <div class="main_right">
    	<div class="right_top"></div>
        <div class="cont">
			<div class="title_uc"><h3><?php echo  $m_langpackage->m_order_status;?></h3><hr /></div>
			<form action="do.php?act=goods_list" method="post" onsubmit="return submitform();">
				<table width="100%" class="form_table">
				<tr><td colspan="4" style="font-weight:bold; color:#F67A06;">&nbsp;&nbsp;<?php echo $m_langpackage->m_event_title;?> - <?php echo $group_row['group_name'];?></td></tr>
				<tr class="center">
						<th width="100"><?php echo $m_langpackage->m_group_user_name;?></th>
						<th width="100"><?php echo $m_langpackage->m_group_contact;?></th>
						<th width="100"><?php echo $m_langpackage->m_group_tel;?></th>
						<th width="100"><?php echo $m_langpackage->m_group_quantity;?></th>
				 </tr>
					<?php if(!empty($login_rs)){
					foreach($login_rs as $v) {?>
					<tr>
						<td class="center"><?php echo $v['user_name'];?></td>
						<td class="center"><?php echo $v['linkman'];?></td>
						<td class="center"><?php echo $v['tel'];?></td>
						<td class="center"><?php echo $v['quantity'];?></td>
					</tr>
					<?php }?>
					<?php  } else {?>
					<tr><td colspan="4" class="center"><?php echo $m_langpackage->m_nolist_record;?>！</td></tr>
					<?php }?>
				</table>
			</form>
        </div>
    </div>
<div class="clear"></div>
<?php  require("shop/index_footer.php");?>
</body>
</html><?php } ?>