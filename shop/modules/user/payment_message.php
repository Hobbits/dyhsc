<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/user/payment_message.html
 * 如果您的模型要进行修改，请修改 models/modules/user/payment_message.php
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
if(filemtime("templates/default/modules/user/payment_message.html") > filemtime(__file__) || (file_exists("models/modules/user/payment_message.php") && filemtime("models/modules/user/payment_message.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/user/payment_message.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("foundation/module_order.php");
require("foundation/module_payment.php");
require("foundation/module_goods.php");
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
$s_langpackage=new shoplp;
$order_id = intval(get_args('id'));
if(!$order_id) { trigger_error($m_langpackage->m_handle_err); }

//数据表定义区
$t_order_info = $tablePreStr."order_info";
$t_shop_payment = $tablePreStr."shop_payment";
$t_payment = $tablePreStr."payment";
$t_order_goods = $tablePreStr."order_goods";
$t_goods = $tablePreStr."goods";
$t_shop_info = $tablePreStr."shop_info";
$t_users = $tablePreStr."users";
$dbo=new dbex;
//读写分离定义方法
dbtarget('r',$dbServs);
//判断商品是否锁定，锁定则不许操作
$sql="select b.goods_id from $t_order_info as a join $t_order_goods as b on a.order_id=b.order_id where a.order_id=$order_id";
$row=$dbo->getRow($sql);
if($row){
	$goods_id=$row['goods_id'];
}
include("foundation/fgoods_locked.php");
//判断用户是否锁定，锁定则不许操作
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	trigger_error($m_langpackage->m_user_locked);//非法操作
}
$order_info = get_order_info($dbo,$t_order_info,$t_order_goods,$t_goods,$t_shop_info,$order_id,$user_id);
if(!$order_info){
	trigger_error('订单不存在');
}
if($order_info['order_status']=='0'||$order_info['order_status']=='3'||$order_info['pay_status']=='1'){
	trigger_error($m_langpackage->m_handle_err);
}

$payment_shop_info = get_shop_payment_info($dbo,$t_shop_payment,$order_info['shop_id'],1);
$payment_info = get_payment_info($dbo,$t_payment,1);

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
.red {color:red;}
</style>
</head>
<body onload="menu_style_change('user_my_order');changeMenu();">
<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo  $m_langpackage->m_iwant_pay;?>
	</div>
    <div class="clear"></div>
	<?php  require("modules/left_menu.php");?>

    <div class="main_right">
		<div class="right_top"></div>
		 <div class="cont">
            <div class="cont_title"><?php echo  $m_langpackage->m_iwant_pay;?></div>
			<hr />
			<form action="do.php?act=user_order" method="post" name="form_profile">
				<table width="100%" style="border:0" cellspacing="0">
					<tr><td class="textright"><?php echo  $m_langpackage->m_your_payid;?>：</td><td class="textleft"><?php echo  $order_info['payid'];?></td></tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_order_amount;?>：</td><td class="textleft"><?php echo $m_langpackage->m_money_sign;?><?php echo  $order_info['order_value'];?><?php echo  $m_langpackage->m_yuan;?></td></tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_payment_cho;?>：</td><td class="textleft">
					<?php foreach($payment_shop_info as $value){?>
						<?php if(isset($payment_info[$value['pay_id']])){?>
					<a href="pay.php?order_id=<?php echo  $order_info['order_id'];?>&pay_id=<?php echo $value['pay_id'];?>&shop_id=<?php echo $order_info['shop_id'];?>"><?php echo $payment_info[$value['pay_id']]['pay_name'];?>
					<img src="plugins/<?php echo $payment_info[$value['pay_id']]['pay_code'];?>/logo.gif" height="30" onerror="this.src='skin/default/images/nopic.gif'"/></a> <br /><br />
						<?php }?>
					<?php }?>
					</td></tr>
				</table>
			</form>
        	</div>
        <div class="clear"></div>
        <div class="right_bottom"></div>
        <div class="back_top"><a href="#"></a></div>
    </div>
<?php  require("shop/index_footer.php");?>
</body>
</html><?php } ?>