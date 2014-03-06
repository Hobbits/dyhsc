<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/start.html
 * 如果您的模型要进行修改，请修改 models/modules/start.php
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
if(filemtime("templates/default/modules/start.html") > filemtime(__file__) || (file_exists("models/modules/start.php") && filemtime("models/modules/start.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/start.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
require('foundation/module_start.php');
require('foundation/module_users.php');
require('foundation/module_shop.php');

$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
$t_user_favorite = $tablePreStr."user_favorite";
$t_users = $tablePreStr."users";
$t_cart = $tablePreStr."cart";
$t_goods = $tablePreStr."goods";
$t_shop_info = $tablePreStr."shop_info";
$t_remind_info = $tablePreStr."remind_info";
$t_order_info = $tablePreStr."order_info";
$t_groupbuy_log = $tablePreStr."groupbuy_log";
$t_groupbuy = $tablePreStr."groupbuy";
$t_order_goods = $tablePreStr."order_goods";
$t_shop_guestbook = $tablePreStr."shop_guestbook";
//读写分离定义方法
$dbo=new dbex;
dbtarget('r',$dbServs);

$sql = "SELECT COUNT(favorite_id) FROM `$t_user_favorite` WHERE user_id='$user_id'";
$row = $dbo->getRow($sql);
$my_favorite_num = $row[0];

$sql = "SELECT COUNT(cart_id) FROM `$t_cart` WHERE user_id='$user_id'";
$row = $dbo->getRow($sql);
$my_cart_num = $row[0];

$sql = "select goods_id,is_best,is_new,is_promote,is_hot,goods_number from `$t_goods` where shop_id='$shop_id'";
$rs = $dbo->getRs($sql);
$countgoods = 0;
$hot_num = 0;
$best_num = 0;
$new_num = 0;
$promote_num = 0;
$kucun_num = 0;
foreach($rs as $value) {
	if($value['is_best']) { $best_num++; }
	if($value['is_hot']) { $hot_num++; }
	if($value['is_new']) { $new_num++; }
	if($value['is_promote']) { $promote_num++; }
	if($value['goods_number']<5) { $kucun_num++; }
	$countgoods++;
}
//我的订单
//$result = get_myorder_info($dbo,$t_order_info,$t_shop_info,$t_goods,$t_order_goods,$user_id,10);
//$order_rs = $result;
//我的收藏
//$result = get_myfavorite_info($dbo,$t_user_favorite,$t_goods,$t_shop_info,$user_id,10);
//$favorite_rs = $result;
//判断商铺是否关闭
$rs = get_shop_info_item($dbo,array('open_flg'),$t_shop_info,$shop_id);
set_session('shop_open',$rs['open_flg']);
//判断商铺是否锁定
$rs = get_shop_info_item($dbo,array('lock_flg'),$t_shop_info,$shop_id);
set_session('shop_lock',$rs['lock_flg']);
//获取用户信息
$user_info = get_user_info_item($dbo,array('last_login_time','last_ip'),$t_users,$user_id);
//获取未读站内信
$sql="SELECT COUNT(rinfo_id) FROM $t_remind_info WHERE user_id='$user_id' AND isread='0'";
$row = $dbo->getRow($sql);
$remind_num = $row[0];
//获得未付款订单数
$sql="SELECT COUNT(order_id) FROM $t_order_info WHERE user_id='$user_id' AND pay_status='0' AND transport_status='0' AND order_status <>'0' AND order_status<>'3'";
$row = $dbo->getRow($sql);
$order_num_need_pay=$row[0];
//获得已发货订单数
$sql="SELECT COUNT(order_id) FROM $t_order_info WHERE user_id='$user_id' AND pay_status='1' AND transport_status='1' AND order_status<>0 AND order_status<>'3'";
$row = $dbo->getRow($sql);
$order_num_send=$row[0];
//获得已完成订单数
$sql="SELECT COUNT(order_id) FROM $t_order_info WHERE user_id='$user_id' AND pay_status='1' AND transport_status='1' AND order_status='3' AND buyer_reply='0' ";
$row = $dbo->getRow($sql);
$order_num=$row[0];
//获得参加的团购活动数量
$sql="SELECT group_id FROM $t_groupbuy_log WHERE user_id='$user_id' ";
$row = $dbo->getRs($sql);
$str='0,';
foreach ($row as $value){
	$str.=$value['group_id'].",";
}
$str = substr($str,0,-1);
$group_buy_num="";

$sql="SELECT COUNT(group_id) FROM $t_groupbuy WHERE group_id IN ($str) AND recommended=1";
$row=$dbo->getRow($sql);
$group_buy_num = $row[0];

//卖家提醒
//未确认订单
$sql="SELECT COUNT(order_id) FROM $t_order_info WHERE shop_id='$shop_id' and order_status=1 ORDER BY order_time DESC";
$row = $dbo->getRow($sql);
$order_sale_no_pay=$row[0];
//未发货订单
$sql="SELECT COUNT(order_id) FROM $t_order_info WHERE shop_id='$shop_id' and transport_status=0 and pay_status=1 ORDER BY order_time DESC";
$row = $dbo->getRow($sql);
$order_sale_no_huo=$row[0];
//未评价订单
$sql="SELECT COUNT(order_id) FROM $t_order_info WHERE shop_id='$shop_id' and order_status=3 and seller_reply='0' ORDER BY order_time DESC";
$row = $dbo->getRow($sql);
$order_sale_no_ping=$row[0];
//未读的留言
$sql="select COUNT(gid) from $t_shop_guestbook where shop_id='$shop_id' and shop_del_status=1 and read_status=0 order by add_time desc";
$row = $dbo->getRow($sql);
$order_sale_no_liu=$row[0];
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $m_langpackage->m_u_center;?></title>
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/layout.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/style.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/common.css">
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/userchangeStyle.js"></script>

<style type="text/css">

</style>
</head>
<body>
<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo $m_langpackage->m_page_first;?>
	</div>
    <div class="clear"></div>
	<?php  require("modules/left_menu.php");?>
    <div class="main_right">
		  <div class="cont">
			  <div class="index_top">
				  <div class="welcom_img"></div>
					<?php echo  $m_langpackage->m_last_login;?>: <?php echo $user_info['last_login_time'];?>
				  <br/>
					<?php echo $m_langpackage->m_last_ip;?>: <?php echo $user_info['last_ip'];?>
				  <br/>
					<?php echo $m_langpackage->m_you_have;?> <font color="#FF0000"><?php echo $remind_num;?></font> <?php echo $m_langpackage->m_site_rem;?>，<a href="modules.php?app=user_remind_info" class="highlight bold"><?php echo $m_langpackage->m_click_view;?></a>
				  <br/>
				  <div class="q_nav">
				  <?php if(get_sess_shop_id()>0){?>
				  <?php  } else {?>
				  <a id="qn_1" href="modules.php?app=shop_request" title="<?php echo $m_langpackage->m_i_mk_store;?>"><?php echo $m_langpackage->m_i_mk_store;?></a>
				  <?php }?>
					  <a id="qn_2" href="modules.php?app=shop_rate&t=buyer" title="<?php echo $m_langpackage->m_buy_pingjia;?>"><?php echo $m_langpackage->m_buy_pingjia;?></a>
					  <a id="qn_3" href="modules.php?app=user_my_order" title="<?php echo $m_langpackage->m_order_inquiry;?>"><?php echo $m_langpackage->m_order_inquiry;?></a>
					  <a id="qn_4" href="modules.php?app=user_favorite" title="<?php echo $m_langpackage->m_my_favorite;?>"><?php echo $m_langpackage->m_my_favorite;?></a>
					  <a id="qn_5" href="modules.php?app=user_profile" title="<?php echo $m_langpackage->m_base_setting;?>"><?php echo $m_langpackage->m_base_setting;?></a>
				  </div>
			  </div>
		  </div>

		  <div class="index_tab">
			  
			  <div class="tab_box">
				  <b><?php echo $m_langpackage->m_buy_prompt;?></b>
				  <hr />
					<?php echo $m_langpackage->m_you_have;?> <span><?php echo $order_num_need_pay;?></span> <?php echo $m_langpackage->m_pending_payment_order;?>“<b><a href="modules.php?app=user_my_order&state=3" class="highlight bold"><?php echo $m_langpackage->m_payment_orders_be;?></a></b>”<?php echo $m_langpackage->m_in_payment;?>
				  <br/>
					<?php echo $m_langpackage->m_you_have;?> <span><?php echo $order_num_send;?></span> <?php echo $m_langpackage->m_seller_shipped_orders;?>“<b><a href="modules.php?app=user_my_order&state=8" class="highlight bold"><?php echo $m_langpackage->m_yes_no;?></a></b>”
				  <br/>
					<?php echo $m_langpackage->m_you_have;?> <span><?php echo $order_num;?></span> <?php echo $m_langpackage->m_order_not_evaluated;?>“<b><a href="modules.php?app=user_my_order&state=9" class="highlight bold"><?php echo $m_langpackage->m_yes_pingjia;?></a></b>”<?php echo $m_langpackage->m_confirmed;?>
				  <br/>
                  
			  </div>
			  
	      </div>
	      <div class="index_tab">
			  
			  <div class="tab_box">
				 <b><?php echo $m_langpackage->m_sell_prompt;?></b>
				  <hr />
					<?php echo $m_langpackage->m_you_have;?> <span><?php echo $order_sale_no_pay;?></span> <?php echo $m_langpackage->m_payment_no;?><?php echo $m_langpackage->m_payment_no_to;?>“<b><a href="modules.php?app=shop_my_order&state=1" class="highlight bold"><?php echo $m_langpackage->m_payment_no;?></a></b>”<?php echo $m_langpackage->m_confirmed;?>
				  <br/>
					<?php echo $m_langpackage->m_you_have;?> <span><?php echo $order_sale_no_huo;?></span> <?php echo $m_langpackage->m_order_notransported_no;?><?php echo $m_langpackage->m_payment_no_to;?>“<b><a href="modules.php?app=shop_my_order&state=8" class="highlight bold"><?php echo $m_langpackage->m_order_notransported_to;?></a></b>”<?php echo $m_langpackage->m_confirmed;?>
				  <br/>
					<?php echo $m_langpackage->m_you_have;?> <span><?php echo $order_sale_no_ping;?></span> <?php echo $m_langpackage->m_order_not_evaluated;?>“<b><a href="modules.php?app=shop_my_order&state=9" class="highlight bold"><?php echo $m_langpackage->m_completed_orders;?></a></b>”<?php echo $m_langpackage->m_confirmed;?>
				  <br/>
				  	<?php echo $m_langpackage->m_you_have;?> <span><?php echo $order_sale_no_liu;?></span> <?php echo $m_langpackage->m_unread_no;?><?php echo $m_langpackage->m_payment_no_to;?>“<b><a href="modules.php?app=shop_guestbook&state=1" class="highlight bold"><?php echo $m_langpackage->m_unread_no;?></a></b>”<?php echo $m_langpackage->m_unread_kan;?>
				  <br/>
                  
			  </div>
			  
	      </div>
	      <div class="clear"></div>
	  	  <div class="back_top"><a href="#"></a></div>
    </div>
<?php  require("shop/index_footer.php");?>
</body>
<script language="JavaScript">
<!--
function change_style(flag) {
	if (flag =='style1'){
		document.getElementById('style1').className="current";
		document.getElementById('style2').className="";
		document.getElementById('display_order').style.display="block";
		document.getElementById('display_favorite').style.display="none";

	}
	if (flag =='style2'){
		document.getElementById('style1').className="";
		document.getElementById('style2').className="current";
		document.getElementById('display_order').style.display="none";
		document.getElementById('display_favorite').style.display="block";
	}
}

//-->
</script>
</html><?php } ?>