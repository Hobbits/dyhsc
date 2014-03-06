<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/shop/receiv_list.html
 * 如果您的模型要进行修改，请修改 models/modules/shop/receiv_list.php
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
if(filemtime("templates/default/modules/shop/receiv_list.html") > filemtime(__file__) || (file_exists("models/modules/shop/receiv_list.php") && filemtime("models/modules/shop/receiv_list.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/shop/receiv_list.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php

	/*
		-----------------------------------------
		文件：receiv_list.php。
		功能: 商铺收款单。
		日期：2010-11-23
		-----------------------------------------
	*/
	
	if(!$IWEB_SHOP_IN) {
		trigger_error('Hacking attempt');
	}

	//引入语言包
	$m_langpackage = new moduleslp;

	//获取Post数据
	$start_time = short_check(get_args('start_time'));
	$end_time = short_check(get_args('end_time'));
	$user_name = short_check(get_args('user_name'));
	$payid = short_check(get_args('payid'));

	//数据表定义区
	$t_receiv_list = $tablePreStr."receiv_list";
	$t_users = $tablePreStr."users";

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

	$sql = "select * from `$t_receiv_list` where shop_id='$user_id'";
	if($payid)
	{
		$sql .= " and payid like '%$payid%'";
	}
	if($user_name)
	{
		$sql .= " and receiver like '%$user_name%'";
	}
	if($start_time)
	{
		$sql .= " and receiv_date >= '$start_time'";
	}
	if($end_time)
	{
		$sql .= " and receiv_date <= '$end_time'";
	}
	$sql .= " order by receiv_date desc";
	$result = $dbo->fetch_page($sql,10);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo  $m_langpackage->m_u_center;?></title>
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/style.css">
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/userchangeStyle.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<script type='text/javascript' src='servtools/date/WdatePicker.js'></script>
<style type="text/css">
.edit span{background:#FFF2E6;}
.search {margin:5px; height:30px; background:#fff; width:90%; padding-left:0px; text-align:left;}
.search input {color:#444;}
td{text-align:left;}
td div.goodsname{line-height:18px;  font-weight:bold;}
td span.category{color:#FF6600;}
.txt{
	height:20px;
	border:1px solid #999;
	line-height:20px}
p{
	margin-bottom:10px;}	
</style>
</head>
<body onload="menu_style_change('shop_receiv_list');changeMenu();">
<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;收款单
	</div>
    <div class="clear"></div>
    <?php  require("modules/left_menu.php");?>
    <div class="main_right">
    	<div class="right_top"></div>
        <div class="cont">
            <div class="cont_title">
            	<span class="tr_op">
            	<a href="modules.php?app=shop_receiv_export">导出收款单</a>
				</span>收款单
			</div>
            <hr />
			<div class="search">
				<form action="modules.php" method="get" name="search_form" style="float:left;">
					<p>支付单号：<input class="txt" type="text" name="payid" value="<?php echo $payid;?>" />
					会员名：<input class="txt" type="text" name="user_name" value="<?php echo $user_name;?>" /></p>
					<p>
					支付日期：<input class="Wdate" type="text" name="start_time" id="start_time" onFocus="WdatePicker({isShowClear:false,readOnly:true})" value="<?php echo $start_time;?>" /> ~
					<input class="Wdate" type="text" name="end_time" id="end_time" onFocus="WdatePicker({isShowClear:false,readOnly:true})" value="<?php echo $end_time;?>" />
					<input type="hidden" value="shop_receiv_list" name="app" />
					<input type="submit" name="submit" value="搜索" /></p>
				</form>
			</div>
				<table width="100%" class="">
					<tr class="">
						<th width="40">订单号</th>
						<th width="100">支付单号</th>
						<th width="100">支付方式</th>
						<th width="90">支付时间</th>
						<th width="50">收款人</th>
						<th width="60">收款时间</th>
						<th width="100">收款账号</th>
						<th width="60">收款金额</th>
				   </tr>
					<?php 
					if(!empty($result['result'])) {
						foreach($result['result'] as $v) {?>
					<tr class="trcolor">
						<td class="center"><?php echo  $v['order_id'];?></td>
						<td class="center"><?php echo  $v['payid'];?></td>
						<td class="center"><?php echo  $v['payment_type'];?></td>
						<td class="center"><?php echo  $v['pay_date'];?></td>
						<td class="center"><?php echo  $v['receiver'];?></td>
						<td class="center"><?php echo  $v['receiv_date'];?></td>
						<td class="center"><?php echo  $v['receiv_account'];?></td>
						<td class="center"><?php echo  $v['receiv_money'];?></td>
					</tr>
					<?php }?>
					<tr><td colspan="8" class="page"><?php  require("modules/page.php");?></td></tr>
					<?php  } else {?>
					<tr><td colspan="8" class="center">没有收款单！</td></tr>
					<?php }?>
				</table>
		</div>
		<div class="clear"></div>
		<div class="right_bottom"></div>
		<div class="back_top"><a href="#"></a></div>
    </div>
<?php  require("shop/index_footer.php");?>
</body>
</html><?php } ?>