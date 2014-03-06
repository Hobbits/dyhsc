<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/shop/shipping_print.html
 * 如果您的模型要进行修改，请修改 models/modules/shop/shipping_print.php
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
if(filemtime("templates/default/modules/shop/shipping_print.html") > filemtime(__file__) || (file_exists("models/modules/shop/shipping_print.php") && filemtime("models/modules/shop/shipping_print.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/shop/shipping_print.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php

	/*
		-----------------------------------------
		文件：shipping_print.php。
		功能: 商铺发货单打印。
		日期：2010-11-24
		-----------------------------------------
	*/

	if(!$IWEB_SHOP_IN) {
		trigger_error('Hacking attempt');
	}
	
	//引入语言包
	$m_langpackage=new moduleslp;
	$i_langpackage=new indexlp;
	
	//引入文件
	require("foundation/module_order.php");
	
	//数据表定义区
	$t_shipping_list = $tablePreStr."shipping_list";
	$t_order_goods = $tablePreStr."order_goods";
	$t_users = $tablePreStr."users";
	$t_order_info = $tablePreStr."order_info";
	$t_goods = $tablePreStr."goods";
	$t_shop_info = $tablePreStr."shop_info";
	
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
	
	$order_info = get_order_info($dbo,$t_order_info,$t_order_goods,$t_goods,$t_shop_info,$info['order_id'],0,$user_id);
	
	if(!$order_info)
		trigger_error("没有该订单！");


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>发货单</title>
<style type="text/css">
#wrapper { font-size:12px; }
table { font-size:12px; margin-bottom:20px; border-collapse:collapse; border-spacing:0 }
.tab_print caption.title { font-size:18px; font-weight:bolder; }
.tab_print th, .tab_print td { font-size:12px; padding:10px 0 10px 10px; }
.tab_print th { width:70px; font-weight:normal; text-align:left }
.tab_print2 th, .tab_print2 td { padding:10px 5px; border:1px dashed #000; border-top:none; border-bottom:none; }
</style>
</head>

<body>
<div id="wrapper">
	<table class="tab_print" width="100%">
		<caption class="title">
		发货单
		</caption>
		<tr>
			<th>发货编号：</th>
			<td><?php echo $info['shipping_id'];?></td>
			<th>订单号：</th>
			<td><?php echo $info['order_id'];?></td>
			<th>支付单号：</th>
			<td><?php echo $info['pay_sn'];?></td>
		</tr>
		<tr>
			<th>物流方式：</th>
			<td><?php echo $info['shipping_type'];?></td>
			<th>物流公司：</th>
			<td><?php echo $info['shipping_company'];?></td>
			<th>快递单号：</th>
			<td><?php echo $info['shipping_no'];?></td>
		</tr>
		<tr>
			<th>收货人：</th>
			<td><?php echo $info['consignee'];?></td>
			<th>收货地址：</th>
			<td><?php echo $info['consignee_address'];?></td>
			<th>收货人电话:</th>
			<td><?php echo $info['consignee_tel'];?></td>
		</tr>
		<tr>
			<th>发货日期：</th>
			<td colspan="5"><?php echo $info['add_date'];?></td>
		</tr>
	</table>
	<table class="tab_print2" cellpadding="0" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>序号</th>
				<th>产品名称</th>
				<th>价格</th>
				<th>数量</th>
				<th>小计</th>
			</tr>
		</thead>
		<tbody>
		<?php if(!empty($order_info['order_goods'])) {
			foreach($order_info['order_goods'] as $v) {?>
			<tr>
				<td>1</td>
				<td><?php echo $v['goods_name'];?></td>
				<td><?php echo $v['goods_price'];?></td>
				<td><?php echo $v['order_num'];?></td>
				<td><?php echo number_format($v['goods_price']*$v['order_num'],2,'.','');?></td>
			</tr>
			<?php }?>
		<?php }?>

			<tr>
				<td>&nbsp;</td>
				<td></td>
				<td></td>
				<td align="right">运费：</td>
				<td><?php echo $order_info['transport_price'];?></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td align="right">订单总计：</td>
				<td><?php echo $order_info['order_amount'];?></td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="7"></td>
			</tr>
			<tr>
				<td colspan="7" align="right">打单员:<?php echo $user_name;?></td>
			</tr>
		</tfoot>
	</table>
</div>
</body>
</html>
<?php } ?>