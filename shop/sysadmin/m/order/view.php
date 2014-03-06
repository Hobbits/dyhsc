<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require("../foundation/module_payment.php");
require("../foundation/module_areas.php");
require("../foundation/module_order.php");
require("../foundation/module_shop.php");

//引入语言包
$a_langpackage=new adminlp;
//权限管理
$right=check_rights("order_browse");
if(!$right){
	header('location:m.php?app=error');
}
$order_id = intval(get_args('id'));
if(!$order_id) { trigger_error($a_langpackage->a_error); }

//定义读操作
dbtarget('r',$dbServs);
$dbo=new dbex;

//数据表定义区
$t_shop_payment = $tablePreStr."shop_payment";
$t_order_info = $tablePreStr."order_info";
$t_shop_info = $tablePreStr."shop_info";
$t_areas = $tablePreStr."areas";
$t_order_goods = $tablePreStr."order_goods";
$t_goods = $tablePreStr."goods";
$t_good_photo = $tablePreStr."good_photo";

$user_id="";
$info = get_order_info($dbo,$t_order_info,$t_order_goods,$t_goods,$t_shop_info,$order_id,$user_id);
$areas = get_areas_kv($dbo,$t_areas);
$shop_payment = get_shop_payment_info($dbo,$t_shop_payment,$info['shop_id']);
$shop_info = get_shop_info($dbo,$t_shop_info,$info['shop_id']);
$info['shop_name'] = $shop_info['shop_name'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/admin.css">
<link rel="stylesheet" type="text/css" href="skin/css/main.css">
<style>
td span {color:red;}
.right{font-weight:bold;}
</style>
</head>
<body>
<div id="maincontent">
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_m_order_mengament;?>&gt;&gt;<?php echo $a_langpackage->a_order;?><?php echo $a_langpackage->a_look;?></div>
        <hr />
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_order;?><?php echo $a_langpackage->a_look;?></span><span class="right" style="margin-right:15px;"><a href="m.php?app=order_alllist" style="float: right;"><?php echo $a_langpackage->a_alllist_back; ?></a></span></h3>
    <div class="content2">
	<span style="text-align:center;" align="middle">
				<?php if($info['order_status']==1 && $info['pay_status']==0){?>
				<a class="btn_ava"  onclick="window.location='a.php?act=order_view&order_id=<?php echo $info['order_id'];?>&state=1'"><span>取消订单</span></a>
				<?php }else{?>
				<a class="btn_unava"><span>取消订单</span></a>
				<?php }?>
				<?php if($info['pay_status']==0 && ($info['order_status']==1 || $info['order_status']==2)){?>
				<a class="btn_ava"  onclick="window.location='a.php?act=order_view&order_id=<?php echo $info['order_id'];?>&state=2'"><span>付&nbsp;&nbsp;款</span></a>
				<?php }else{?>
				<a class="btn_unava"><span>付款</span></a>
				<?php }?>
				<?php if($info['transport_status']==0 && $info['order_status']==2){?>
				<a class="btn_ava"  onclick="window.location='a.php?act=order_view&order_id=<?php echo $info['order_id'];?>&state=3'"><span>商家发货</span></a>
				<?php }else{?>
				<a class="btn_unava"><span>商家发货</span></a>
				<?php }?>
				<?php if($info['transport_status']==1 && $info['pay_status']==1 && ($info['order_status']==1 || $info['order_status']==2)){?>
				<a class="btn_ava"  onclick="window.location='a.php?act=order_view&order_id=<?php echo $info['order_id'];?>&state=4'"><span>确认收货</span></a>
				<?php }else{?>
				<a class="btn_unava"><span>确认收货</span></a>
				<?php }?>
	</span>
    	
		<form action="a.php?act=order_payment_edit" method="post" onsubmit="return checkform();" enctype="multipart/form-data">
		<table class="list_table">
			<thead>
			<tr>
				<th colspan="4">&nbsp;&nbsp;<?php echo $a_langpackage->a_order_info;?></th>
			</tr>
			</thead>
			<tbody>
				<tr style="text-align:center;">
                	<td align="left" width="270px">&nbsp;&nbsp;<?php echo $a_langpackage->a_goods_name;?></td>
                    <td width="100px"><?php echo $a_langpackage->a_goods_price;?></td>
                    <td width="80px"><?php echo $a_langpackage->a_order_num;?></td>
                    <td width="" align="left"><?php echo $a_langpackage->a_trans_price;?></td>
                </tr>
                <?php
                	foreach ($info['order_goods'] as $k=>$v){
                ?>
				<tr style="text-align:center;">
					<td align="left">&nbsp;&nbsp;<?php echo $v['goods_name'];?></a></td>
					<td><?php echo $v['goods_price'];?><?php echo $a_langpackage->a_yuan;?></td>
					<td><?php echo $v['order_num'];?></td>
					<td align="left"><?php echo $info['transport_price'];?><?php echo $a_langpackage->a_yuan;?></td>
				</tr>
				<?php
                	}
				?>
				<tr><td align="left" colspan="4">&nbsp;&nbsp;<?php echo $a_langpackage->a_fact_pay; ?>：<?php echo $info['order_amount'];?></span><?php echo $a_langpackage->a_yuan;?>&nbsp;&nbsp;<?php echo $a_langpackage->a_should_pay; ?>：<?php echo $info['order_value'];?><?php echo $a_langpackage->a_yuan;?></td></tr>
			</tbody>
		</table>
		<table class="list_table">
			<thead>
				<tr>
					<th colspan="2">&nbsp;&nbsp;<?php echo $a_langpackage->a_mana_center;?></th>
				</tr>
			</thead>
			<tbody>
				<tr><td width="80px">&nbsp;&nbsp;<?php echo $a_langpackage->a_linker;?>：</td><td><?php echo $info['consignee'];?></td></tr>
				<tr><td>&nbsp;&nbsp;<?php echo $a_langpackage->a_mobile;?>：</td><td><?php echo $info['mobile'];?></td></tr>
				<tr><td>&nbsp;&nbsp;<?php echo $a_langpackage->a_tel;?>：</td><td><?php echo $info['telphone'];?></td></tr>
				<tr><td>&nbsp;&nbsp;<?php echo $a_langpackage->a_email;?>：</td><td><?php echo $info['email'];?></td></tr>
				<tr><td>&nbsp;&nbsp;<?php echo $a_langpackage->a_shop_area;?>：</td><td><?php echo $areas[$info['province']];?> <?php echo $areas[$info['city']];?> <?php echo $areas[$info['district']];?></td></tr>
				<tr><td>&nbsp;&nbsp;<?php echo $a_langpackage->a_address;?>：</td><td><?php echo $info['address'];?></td></tr>
				<tr><td>&nbsp;&nbsp;<?php echo $a_langpackage->a_post;?>：</td><td><?php echo $info['zipcode'];?></td></tr>
			</tbody>
		</table>
		<table class="list_table">
			<thead>
				<tr>
					<th colspan="2">&nbsp;&nbsp;<?php echo $a_langpackage->a_trans_info;?></th>
				</tr>
			</thead>
			<tbody>
				<tr><td width="100">&nbsp;&nbsp;<?php echo $a_langpackage->a_shop_name2;?>：</td><td><?php echo $info['shop_name'];?></td></tr>
				<tr><td>&nbsp;&nbsp;<?php echo $a_langpackage->a_trans_company_name;?>：</td><td><?php echo $info['shipping_name'];?></td></tr>
				<tr><td>&nbsp;&nbsp;<?php echo $a_langpackage->a_trans_ID;?>：</td><td><?php echo $info['shipping_no'];?></td></tr>
				<tr><td>&nbsp;&nbsp;<?php echo $a_langpackage->a_trans_type;?>：</td><td><?php echo $info['shipping_type'];?></td></tr>
				<tr><td>&nbsp;&nbsp;<?php echo $a_langpackage->a_trans_time;?>：</td><td><?php echo $info['shipping_time'];?></td></tr>
			</tbody>
		</table>
		<table class="list_table">
			<thead>
				<tr>
					<th colspan="2">&nbsp;&nbsp;<?php echo $a_langpackage->a_order_infomation;?></th>
				</tr>
			</thead>
			<tbody>
				<tr><td width="100">&nbsp;&nbsp;<?php echo $a_langpackage->a_orderID;?>：</td><td><?php echo $info['payid'];?></td></tr>
				<tr><td>&nbsp;&nbsp;<?php echo $a_langpackage->a_shop_gather_mode;?>：</td><td><?php echo $info['pay_name'];?></td></tr>
				
				<tr><td>&nbsp;&nbsp;<?php echo $a_langpackage->a_order_ps;?>：</td><td><?php echo $info['message'];?></td></tr>
				<tr><td>&nbsp;&nbsp;<?php echo $a_langpackage->a_make_order_time;?>：</td><td><?php echo $info['order_time'];?></td></tr>
				<tr><td>&nbsp;&nbsp;<?php echo $a_langpackage->a_pay_time;?>：</td><td><?php echo $info['pay_time'];?></td></tr>
				<tr><td>&nbsp;&nbsp;<?php echo $a_langpackage->a_get_goods_time;?>：</td><td><?php echo $info['receive_time'];?></td></tr>
			</tbody>
		</table>
		</form>
		</div>
	  </div>
	</div>
</div>
</body>
</html>