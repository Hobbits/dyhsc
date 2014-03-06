<?php
$IWEB_SHOP_IN = true;


/* 用户信息处理 */
if(get_sess_user_id()) {
	$USER['login'] = 1;
	$USER['user_name'] = get_sess_user_name();
	$USER['user_id'] = get_sess_user_id();
	$USER['user_email'] = get_sess_user_email();
	$USER['shop_id'] = get_sess_shop_id();
	$privilege=get_sess_privilege();
} else {
	$USER['login'] = 0;
	$USER['user_name'] = '';
	$USER['user_id'] = '';
	$USER['user_email'] = '';
	$USER['shop_id'] = '';
	$privilege='';
}

$user_privilege = '';
	if($privilege) {
		$user_privilege = unserialize($privilege);
	
	}

// 连接数据库 初始操作

$order_id = intval($_GET['order_id']);
$pay_id = intval($_GET['pay_id']);
$shop_id=intval($_GET['shop_id']);

$t_order_info = $tablePreStr."order_info";
$t_shop_payment = $tablePreStr."shop_payment";
$t_payment = $tablePreStr."payment";

$sql = "SELECT * FROM $t_shop_payment WHERE shop_id=$shop_id and pay_id=$pay_id";
$sql2= "SELECT * FROM $t_payment WHERE pay_id=$pay_id";

$shop_pay = $dbo->getRow($sql);
$pay=$dbo->getRow($sql2);
if(!$shop_pay)
{
	trigger_error("没有商铺信息");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>银行支付</title>
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/modules.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/layout.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/style.css">
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/userchangeStyle.js"></script>
</head>
<body onload="menu_style_change('user_cart');changeMenu();">
<?php  require("shop/index_header.php");?>
<div class="site_map"> <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo $m_langpackage->m_my_cart;?> </div>
<div class="clear"></div>
<?php  require("modules/left_menu.php");?>
<div class="main_right">
  <div class="cont">
  <div class="cont_title"><img height="30" src="plugins/bank/logo.gif"></div>
  <hr />
  <div class="openMain">
    <form action="do.php?act=user_pay_message" method="post">
      <table class="tab_pay" width="100%">
        <caption class="ttls">
        <?php echo $shop_pay['pay_desc']?>
        </caption>
        <tr>
          <td>支付信息：<br /><textarea class="payInput" name="pay_message" rows="7" cols="55" wrap="off"></textarea>
            <input type="hidden" name="id" value="<?php echo $order_id;?>"/></td>
        </tr>
        <tr>
          <td><input type="submit" name="name" value="提交"/></td>
        </tr>
      </table>
      <input type="hidden" name="pay_id" value="<?php echo $pay_id?>"/>
      <input type="hidden" name="pay_name" value="<?php echo $pay['pay_name']?>"/>
    </form>
  </div>
  </div>
  <div class="right_bottom"></div>
  <div class="back_top"><a href="#"></a></div>
</div>
</body>
</html>