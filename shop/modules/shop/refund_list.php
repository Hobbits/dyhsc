<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/shop/refund_list.html
 * 如果您的模型要进行修改，请修改 models/modules/shop/refund_list.php
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
if(filemtime("templates/default/modules/shop/refund_list.html") > filemtime(__file__) || (file_exists("models/modules/shop/refund_list.php") && filemtime("models/modules/shop/refund_list.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/shop/refund_list.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php

	/*
		-----------------------------------------
		文件：refund_list.php。
		功能: 商铺退款单。
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
	$refund_account = short_check(get_args('refund_account'));

	//数据表定义区
	$t_refund_list = $tablePreStr."refund_list";
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

	$sql = "select * from `$t_refund_list` where shop_id='$user_id'";
	if($refund_account)
	{
		$sql .= " and refund_account like '%$refund_account%'";
	}
	if($user_name)
	{
		$sql .= " and user_name like '%$user_name%'";
	}
	if($start_time)
	{
		$sql .= " and operator_date >= '$start_time'";
	}
	if($end_time)
	{
		$sql .= " and operator_date <= '$end_time'";
	}
	$sql .= " order by operator_date desc";
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
.search {margin:5px; height:30px;*height:80px; background:#fff; width:90%; padding-left:0px; text-align:left;}
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
<body onload="menu_style_change('shop_refund_list');changeMenu();">
<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;退款单
	</div>
    <div class="clear"></div>
    <?php  require("modules/left_menu.php");?>
    <div class="main_right">
    	<div class="right_top"></div>
        <div class="cont">
            <div class="cont_title">
            	退款单
			</div>
            <hr />
			<div class="search">
				<form action="modules.php" method="get" name="search_form" style="float:left;">
					<p>退款账号：<input class="txt" type="text" name="refund_account" value="<?php echo $refund_account;?>" />
					会员名：<input class="txt" type="text" name="user_name" value="<?php echo $user_name;?>" /></p>
					<p>操作日期：<input class="Wdate" type="text" name="start_time" id="start_time" onFocus="WdatePicker({isShowClear:false,readOnly:true})" value="<?php echo $start_time;?>" />~
					<input class="Wdate" type="text" name="end_time" id="end_time" onFocus="WdatePicker({isShowClear:false,readOnly:true})" value="<?php echo $end_time;?>" />
					<input type="hidden" value="shop_refund_list" name="app" />
					<input type="submit" name="submit" value="搜索" /></p>
				</form>
			</div>
			  <hr />
				<table width="100%" class="">
					<tr class="">
						<th width="60">订单编号</th>
						<th width="80">退款方式</th>
						<th width="200">退款账户</th>
						<th width="90">退款金额</th>
						<th width="35">会员名</th>
						<th width="50">操作日期</th>
				   </tr>
					<?php 
					if(!empty($result['result'])) {
						foreach($result['result'] as $v) {?>
					<tr class="trcolor">
						<td class="center" width="40"><?php echo  $v['order_id'];?></td>
						<td class="center"><?php echo  $v['refund_way'];?></td>
						<td class="center"><?php echo  $v['refund_account'];?></td>
						<td class="center"><?php echo  $v['refund_money'];?></td>
						<td class="center"><?php echo  $v['user_name'];?></td>
						<td class="center"><?php echo  $v['operator_date'];?></td>
					</tr>
					<?php }?>
					<tr><td colspan="6" class="page"><?php  require("modules/page.php");?></td></tr>
					<?php  } else {?>
					<tr><td colspan="6" class="center">没有退款单！</td></tr>
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