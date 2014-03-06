<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/shop/order_view.html
 * 如果您的模型要进行修改，请修改 models/modules/shop/order_view.php
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
if(filemtime("templates/default/modules/shop/order_view.html") > filemtime(__file__) || (file_exists("models/modules/shop/order_view.php") && filemtime("models/modules/shop/order_view.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/shop/order_view.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}
require("foundation/acheck_shop_creat.php");
require("foundation/module_areas.php");
require("foundation/module_order.php");
require("foundation/module_payment.php");

//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

$order_id = intval(get_args('order_id'));
if(!$order_id) { trigger_error($m_langpackage->m_handle_err); }

//数据表定义区
$t_order_info = $tablePreStr."order_info";
$t_areas = $tablePreStr."areas";
$t_order_goods = $tablePreStr."order_goods";
$t_goods = $tablePreStr."goods";
$t_shop_info = $tablePreStr."shop_info";
$t_payment = $tablePreStr."payment";

$dbo=new dbex;
//读写分离定义方法
dbtarget('r',$dbServs);

$info = get_order_info($dbo,$t_order_info,$t_order_goods,$t_goods,$t_shop_info,$order_id,0,$shop_id);
if(!$info)
	trigger_error($m_langpackage->m_no_order);
$areas = get_areas_kv($dbo,$t_areas);
$payment_info = get_payment_info($dbo,$t_payment);
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
td span { color:red; }
#reg_step { width:770px; height:29px; margin: 12px auto; line-height: 29px; }
#reg_step ol li { width: 154px; float: left; padding:0 0 3px; font-size: 14px; font-weight: bold; background-color:#ececec; color:#333; text-align:center; }
#reg_step ol li span, #reg_step ol li strong { display: block; text-align:center; }
#reg_step ol li.current { background:url(skin/default/images/steps_bg.gif) left top no-repeat; padding-top:4px; margin-top:-4px; color:#FFF; }
#reg_step ol li.last_current { background-color: #F6A248; color: #fff; background-position: right -145px; }
td { text-align:left; }
</style>
</head>
<body onload="menu_style_change('shop_my_order');changeMenu();">
<?php  require("shop/index_header.php");?>
<div class="site_map"> <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo  $m_langpackage->m_order_info;?> </div>
<div class="clear"></div>
<?php  require("modules/left_menu.php");?>
<div class="main_right">
	<div class="right_top"></div>
	<div class="cont">
		<div class="title_uc">
			<h3><span class="tr_op"><a href="modules.php?app=shop_my_order" ><?php echo  $m_langpackage->m_recver_order;?></a>&nbsp;&nbsp;</span><?php echo  $m_langpackage->m_order_info;?></h3>
			<hr />
		</div>
		<div id="reg_step">
			<ol>
				<?php  if($info['order_status']==0) {?>
				<li class="current"><strong>1、<?php echo $m_langpackage->m_buy_mk_order;?></strong></li>
				<li class=""><span>2、<?php echo $m_langpackage->m_buyer_pay;?></span></li>
				<li class=""><span>3、<?php echo $m_langpackage->m_check_put_goods;?></span></li>
				<li class=""><span>4、<?php echo $m_langpackage->m_buyer_checkget_goods;?></span></li>
				<li class=""><span>5、<?php echo $m_langpackage->m_thisorder_cancel;?></span></li>
				<?php  } elseif($info['order_status']==3) {?>
				<li class=""><strong class="first">1、<?php echo $m_langpackage->m_buy_mk_order;?></strong></li>
				<li class=""><span>2、<?php echo $m_langpackage->m_buyer_pay;?></span></li>
				<li class=""><span>3、<?php echo $m_langpackage->m_check_put_goods;?></span></li>
				<li class=""><span>4、<?php echo $m_langpackage->m_buyer_checkget_goods;?></span></li>
				<li class="current"><span>5、<?php echo $m_langpackage->m_com_deal;?></span></li>
				<?php  } elseif($info['transport_status']==1) {?>
				<li class=""><strong class="first">1、<?php echo $m_langpackage->m_buy_mk_order;?></strong></li>
				<li class=""><span>2、<?php echo $m_langpackage->m_buyer_pay;?></span></li>
				<li class="current"><span>3、<?php echo $m_langpackage->m_check_put_goods;?></span></li>
				<li class=""><span>4、<?php echo $m_langpackage->m_buyer_checkget_goods;?></span></li>
				<li class=""><span>5、<?php echo $m_langpackage->m_com_deal;?></span></li>
				<?php  } elseif($info['pay_status']==1) {?>
				<li class=""><strong class="first">1、<?php echo $m_langpackage->m_buy_mk_order;?></strong></li>
				<li class="current"><span>2、<?php echo $m_langpackage->m_buyer_pay;?></span></li>
				<li class=""><span>3、<?php echo $m_langpackage->m_check_put_goods;?></span></li>
				<li class=""><span>4、<?php echo $m_langpackage->m_buyer_checkget_goods;?></span></li>
				<li class=""><span>5、<?php echo $m_langpackage->m_com_deal;?></span></li>
				<?php  } else  {?>
				<li class="current"><strong class="first">1、<?php echo $m_langpackage->m_buy_mk_order;?></strong></li>
				<li class=""><span>2、<?php echo $m_langpackage->m_buyer_pay;?></span></li>
				<li class=""><span>3、<?php echo $m_langpackage->m_check_put_goods;?></span></li>
				<li class=""><span>4、<?php echo $m_langpackage->m_buyer_checkget_goods;?></span></li>
				<li class=""><span>5、<?php echo $m_langpackage->m_com_deal;?></span></li>
				<?php }?>
			</ol>
		</div>
		<table width="100%" border="0" cellspacing="0">
			<!--	<tr>
				<th style="background:#FFF2E6; color:#F67A06;" colspan="4">&nbsp;&nbsp;<?php echo  $m_langpackage->m_goods_info;?></th>
			</tr>-->
			<tr>
				<th  width="320"><?php echo  $m_langpackage->m_goods_name;?></th>
				<th width="115"><?php echo  $m_langpackage->m_goods_price;?></th>
				<th width="90"><?php echo  $m_langpackage->m_buy_num;?></th>
				<th width="100"><?php echo  $m_langpackage->m_transport_price;?></th>
			</tr>
			<?php $num =count($info['order_goods']); foreach($info['order_goods'] as $k=>$v){?>
			<tr>
				<td><a href="goods.php?id=<?php echo  $v['goods_id'];?>" target="_blank" ><?php echo  $v['goods_name'];?></a></td>
				<td style="text-align:center;"><?php echo  $v['goods_price'];?><?php echo  $m_langpackage->m_yuan;?></td>
				<td style="text-align:center;"><?php echo  $v['order_num'];?></td>
				<?php if($k==0){?>
				<td class="border_l " style="text-align:center;"  rowspan="<?php echo $num;?>"><?php echo  $info['transport_price'];?><?php echo  $m_langpackage->m_yuan;?></td>
				<?php }?> </tr>
			<?php }?>
			<tr>
				<td class="border_l" colspan="4">&nbsp;&nbsp;<?php echo  $m_langpackage->m_order_thisbuyprice;?>:<span><?php echo  $info['order_value'];?></span><?php echo  $m_langpackage->m_yuan;?>
					<?php if($info['order_status']==1 && $info['pay_status']==0) {?>
					<form action="do.php?act=shop_order_priceedit" method="post" onsubmit="return checkForm();">
						&nbsp;&nbsp;<?php echo  $m_langpackage->m_order_editprice;?><input id="price" name="price" value="<?php echo  $info['order_value'];?>" style="width:70px;" /> <input type="hidden" name="order_id" value="<?php echo  $order_id;?>" /> <input type="submit" name="btn" value="<?php echo  $m_langpackage->m_order_editprice;?>" />
					</form>
					<?php }?> </td>
			</tr>
		</table>
		<h3 class="ttlm_02"><?php echo  $m_langpackage->m_order_getsting;?></h3>
		<table  class="form_table_02" width="100%" border="0" cellspacing="0">
			
			<tr>
				<th  width="100px"><?php echo  $m_langpackage->m_contact;?>:</th>
				<td><?php echo  $info['consignee'];?></td>
			</tr>
			<tr>
				<th><?php echo  $m_langpackage->m_address;?>: </th>
				<td> <?php echo  $info['mobile'];?> , <?php echo  $info['telphone'];?>  , <?php echo  $areas[$info['province']];?> <?php echo  $areas[$info['city']];?> <?php echo  $areas[$info['district']];?> , <?php echo  $info['address'];?> , <?php echo  $info['zipcode'];?></td>
			</tr>
			<tr>
				<th><?php echo  $m_langpackage->m_mobile;?>:</th>
				<td><?php echo  $info['mobile'];?></td>
			</tr>
			<tr>
				<th><?php echo  $m_langpackage->m_telphone;?>:</th>
				<td><?php echo  $info['telphone'];?></td>
			</tr>
			<tr>
				<th><?php echo  $m_langpackage->m_email;?>:</th>
				<td><?php echo  $info['email'];?></td>
			</tr>
			<tr>
				<th><?php echo  $m_langpackage->m_stayarea;?>:</th>
				<td><?php echo  $areas[$info['province']];?> <?php echo  $areas[$info['city']];?> <?php echo  $areas[$info['district']];?></td>
			</tr>
			<tr>
				<th><?php echo  $m_langpackage->m_address;?>:</th>
				<td><?php echo  $info['address'];?></td>
			</tr>
			<tr>
				<th><?php echo  $m_langpackage->m_zipcode;?>:</th>
				<td><?php echo  $info['zipcode'];?></td>
			</tr>
		</table>
		<h3 class="ttlm_02"><?php echo  $m_langpackage->m_order_info;?></h3>
		<table  class="form_table_02" width="100%" border="0" cellspacing="0">
			<tr>
				<th><?php echo  $m_langpackage->m_order_message;?>:</th>
				<td><?php echo  $info['message'];?></td>
			</tr>
			<tr>
				<th><?php echo  $m_langpackage->m_payment_message;?>:</th>
				<td><?php echo  $info['pay_message'];?></td>
			</tr>
			<tr>
				<th><?php echo  $m_langpackage->m_alipay_tradeno;?>:</th>
				<td><?php echo  $info['trade_no'];?></td>
			</tr>
			<tr>
				<th><?php echo  $m_langpackage->m_order_time;?>:</th>
				<td><?php echo  $info['order_time'];?></td>
			</tr>
			<tr>
				<th><?php echo  $m_langpackage->m_pay_time;?>:</th>
				<td><?php echo  $info['pay_time'];?></td>
			</tr>
			<tr>
				<th><?php echo  $m_langpackage->m_receive_time;?>:</th>
				<td><?php echo  $info['receive_time'];?></td>
			</tr>
		</table>
		<h3 class="ttlm_02"><?php echo  $m_langpackage->m_order_poststing;?></h3>
		<table  class="form_table_02" width="100%" border="0" cellspacing="0">
			<tr>
				<th><?php echo  $m_langpackage->m_shipping_name;?>:</th>
				<td><?php echo  $info['shipping_name'];?></td>
			</tr>
			<tr>
				<th><?php echo  $m_langpackage->m_shipping_no;?>:</th>
				<td><?php echo  $info['shipping_no'];?></td>
			</tr>
			<tr>
				<th><?php echo  $m_langpackage->m_shipping_type;?>:</th>
				<td><?php echo  $info['shipping_type'];?></td>
			</tr>
			<tr>
				<th><?php echo  $m_langpackage->m_shipping_time;?>:</th>
				<td><?php echo  $info['shipping_time'];?></td>
			</tr><tr>
				<th>操作：</th>
				<td><span class="tr_op">
					<?php  if($info['order_status']==1 && $info['pay_status']==0) {?>
							<a href="do.php?act=shop_order_del&id=<?php echo  $info['order_id'];?>" onclick="return confirm('<?php echo  $m_langpackage->m_sure_thisorder;?>');"><?php echo  $m_langpackage->m_cancelorder;?></a>
					<?php }?>
					<?php  if($info['transport_status']==0 && $info['order_status']==1 && $info['pay_status']==1) {?>
						<?php  if($payment_info[$info['pay_id']]['pay_code']=='alipay') {?>
							<a href="plugins/alipay/comput.php?id=<?php echo  $info['order_id'];?>" target="_blank"><?php echo  $m_langpackage->m_sure_shippingnow;?></a>
						<?php  } else {?>
							<a href="modules.php?app=shop_delivery_add&order_id=<?php echo  $info['order_id'];?>" onclick="javascript:if(confirm('<?php echo  $m_langpackage->m_clicksure_s;?>')){return true;} else {return false;}"><?php echo  $m_langpackage->m_sure_shippingnow;?></a>
						<?php }?>
					<?php }?>
					<?php  if($info['transport_status']==0 && $info['order_status']==1 && $info['pay_status']==2) {?>
						<a href="modules.php?app=shop_back_money&order_id=<?php echo  $info['order_id'];?>">退款</a>
					<?php }?>
					<?php  if($info['protect_status']==1 || $info['protect_status']==2) {?>
						<a href="modules.php?app=shop_protect_rights&id=<?php echo  $info['order_id'];?>"><font color='red'>查看维权</font></a>
					<?php }?>
					<a href="modules.php?app=shop_order_view&order_id=<?php echo  $info['order_id'];?>" title="<?php echo  $m_langpackage->m_view_orderinfo;?>">
					<?php echo  $m_langpackage->m_view_orderinfo2;?></a>
					<!-- 订单评价 开始 -->
					<?php  if($info['transport_status']==1 && $info['order_status']==3 && $info['seller_reply']==0) {?>
						<a href="modules.php?app=shop_credit_add&id=<?php echo  $info['order_id'];?>&t=seller" ><?php echo  $m_langpackage->m_evaluate;?></a>
					<?php }else if($info['transport_status']==1 && $info['order_status']==3 && $info['seller_reply']==1){?>
						<?php echo $m_langpackage->m_already_valuation;?>
					<?php }?>
					<!-- 订单评价 结束 -->
					</span>
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="clear"></div>
<?php  require("shop/index_footer.php");?>
<script>
function checkForm() {
	var price = document.getElementsByName("price")[0];
	var re=/^(\d+)$/;
	if(!re.test(price.value)){
		alert("<?php echo  $m_langpackage->m_price_error;?>");
		return false;
	}
	return true;
}
</script>
</body>
</html><?php } ?>