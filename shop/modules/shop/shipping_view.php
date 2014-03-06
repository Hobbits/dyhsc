<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/shop/shipping_view.html
 * 如果您的模型要进行修改，请修改 models/modules/shop/shipping_view.php
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
if(filemtime("templates/default/modules/shop/shipping_view.html") > filemtime(__file__) || (file_exists("models/modules/shop/shipping_view.php") && filemtime("models/modules/shop/shipping_view.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/shop/shipping_view.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php

	/*
		-----------------------------------------
		文件：shipping_view.php。
		功能: 商铺发货单查看。
		日期：2010-11-23
		-----------------------------------------
	*/

	if(!$IWEB_SHOP_IN) {
		trigger_error('Hacking attempt');
	}
	
	//引入语言包
	$m_langpackage=new moduleslp;
	$i_langpackage=new indexlp;

	//数据表定义区
	$t_shipping_list = $tablePreStr."shipping_list";
	$t_users = $tablePreStr."users";
	
	//获取Post数据
	$shipping_id = intval(get_args('shipping_id'));

	//读写分离定义方法
	$dbo = new dbex;
	dbtarget('r',$dbServs);

	//判断用户是否锁定，锁定则不许操作
	$sql ="select locked from $t_users where user_id=$user_id";
	$row = $dbo->getRow($sql);
	if($row['locked']==1){
		session_destroy();
		trigger_error($m_langpackage->m_user_locked);//非法操作
	}
	
	$sql = "select * from `$t_shipping_list` where shipping_id='$shipping_id'";
	$info = $dbo->getRow($sql);
	
	if(!$info)
		trigger_error("发货单不存在！");



?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo  $m_langpackage->m_u_center;?></title>
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/style.css">
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/userchangeStyle.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<style type="text/css">
.red { color:red; }
.templageimg span { float:left; display:block; text-align:left; margin-left:5px; }
.templageimg img { border:2px solid #eee; cursor:pointer; }
</style>
</head>
<body onload="menu_style_change('shop_shipping_list');changeMenu();" >
<?php  require("shop/index_header.php");?>
<div class="site_map"> <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;查看发货单 </div>
<div class="clear"></div>
<?php  require("modules/left_menu.php");?>
<div class="main_right">
	<div class="right_top"></div>
	<div class="cont">
		<div class="cont_title">查看发货单</div>
		<hr />
		<table width="100%"  class="form_table_02">
			<tr>
				<th  width="15%">订单编号:</th>
				<td><?php echo $info['order_id'];?></td>
			</tr>
			<tr>
				<th >支付单编号:</th>
				<td><?php echo $info['pay_sn'];?></td>
			</tr>
			<tr>
				<th >物流方式:</th>
				<td><?php echo $info['shipping_type'];?></td>
			</tr>
			<tr>
				<th>物流公司:</th>
				<td><?php echo $info['shipping_company'];?></td>
			</tr>
			<tr>
				<th>快递单号:</th>
				<td><?php echo $info['shipping_no'];?></td>
			</tr>
			<tr>
				<th>发货日期:</th>
				<td><?php echo $info['add_date'];?></td>
			</tr>
			<tr>
				<th>收货人:</th>
				<td><?php echo $info['consignee'];?></td>
			</tr>
			<tr>
				<th>收货地址:</th>
				<td><?php echo $info['consignee_address'];?></td>
			</tr>
			<tr>
				<th>收货人电话:</th>
				<td><?php echo $info['consignee_tel'];?></td>
			</tr>
			<tr>
				<th>操作员:</th>
				<td><?php echo $info['operator'];?></td>
			</tr>
		</table>
	</div>
	<div class="clear"></div>
	<div class="right_bottom"></div>
	<div class="back_top"><a href="#"></a></div>
</div>
<?php  require("shop/index_footer.php");?>
</div>
</body>
</html><?php } ?>