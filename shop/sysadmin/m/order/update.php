<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require("../foundation/module_payment.php");
require("../foundation/module_order.php");
require("../foundation/module_shop.php");
require("../foundation/module_areas.php");
require("../foundation/module_shop_category.php");

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
$t_payment = $tablePreStr."payment";
$t_shop_categories = $tablePreStr."shop_categories";
$t_areas = $tablePreStr."areas";


$user_id="";
$info = get_order_info($dbo,$t_order_info,$t_order_goods,$t_goods,$t_shop_info,$order_id,$user_id);
$areas = get_areas_kv($dbo,$t_areas);
$shop_payment = get_shop_payment_info($dbo,$t_shop_payment,$info['shop_id']);
$shop_info = get_shop_info($dbo,$t_shop_info,$info['shop_id']);
$info['shop_name'] = $shop_info['shop_name'];

$sql = "select * from $t_payment where enabled=1";
$payarr = $dbo->getRs($sql);
$shop_categories_parent = get_categories_item_parentid($dbo,$t_shop_categories,0);
$areas_info = get_areas_info($dbo,$t_areas);

$categories_parent = 0;
$categories_child = 0;
if(isset($shop_info['shop_categories'])){
	$shop_categories_info = get_categories_info_catid($dbo,$t_shop_categories,$shop_info['shop_categories']);
	if($shop_categories_info['parent_id'] == 0){
		$categories_parent = $shop_info['shop_categories'];
	} else {
		$categories_parent = $shop_categories_info['parent_id'];
		$categories_child = $shop_info['shop_categories'];
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/admin.css">
<link rel="stylesheet" type="text/css" href="skin/css/main.css">
<style>
td span { color:red; }
.right { font-weight:bold; }
</style>
</head>
<body>
<div id="maincontent">
	<div class="wrap">
		<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_m_order_mengament;?>&gt;&gt;<?php echo $a_langpackage->a_order;?><?php echo $a_langpackage->a_look;?></div>
		<hr />
		<div class="infobox">
			<h3><span class="left"><?php echo $a_langpackage->a_order;?><?php echo $a_langpackage->a_look;?></span><span class="right" style="margin-right:15px;"><a href="m.php?app=order_alllist" style="float: right;"><?php echo $a_langpackage->a_alllist_back; ?></a></span></h3>
			<div class="content2"> <span style="text-align:center;" align="middle">
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
				<form action="a.php?act=order_update" method="post" onsubmit="return check();">
					<table class="list_table" >
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
							<tr>
								<td align="left" colspan="4">&nbsp;&nbsp;<?php echo $a_langpackage->a_order_goal; ?>：<input type="text" name="order_value" value="<?php echo $info['order_value'];?>"/><?php echo $a_langpackage->a_yuan;?>&nbsp;&nbsp;<?php echo $a_langpackage->a_fact_pay; ?>：<?php echo $info['order_actual'];?><?php echo $a_langpackage->a_yuan;?></td>
							</tr>
						</tbody>
					</table>
					<table class="list_table" style="float:left; width:32%; margin-right:2%">
						<thead>
							<tr>
								<th colspan="2">&nbsp;&nbsp;<?php echo $a_langpackage->a_mana_center;?></th>
							</tr>
						</thead>
						<tbody>
							<tr><input type="hidden" name="order_id" value="<?php echo $info['order_id'];?>"/>
								<td width="80px">&nbsp;&nbsp;<?php echo $a_langpackage->a_linker;?>：</td>
								<td><input type="text" name="consignee" value="<?php echo $info['consignee'];?>"/></td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;<?php echo $a_langpackage->a_mobile;?>：</td>
								<td><input type="text" name="mobile" value="<?php echo $info['mobile'];?>"/></td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;<?php echo $a_langpackage->a_tel;?>：</td>
								<td><input type="text" name="telphone" value="<?php echo $info['telphone'];?>"/></td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;<?php echo $a_langpackage->a_email;?>：</td>
								<td><input type="text" name="email" value="<?php echo $info['email'];?>"/></td>
							</tr>
							<tr>
								<td><?php echo $a_langpackage->a_shop_country; ?>：</td>
								<td><span id="shop_country">
									<select name="country"	onchange="areachanged(this.value,0);">
										<option value='0'><?php echo $a_langpackage->a_selectcount; ?></option>
										<?php 
								foreach ($areas_info[0] as $v){
								?>
										<option value="<?php echo $v['area_id']; ?>"<?php if($v['area_id']==$shop_info['shop_country']){echo 'selected';}?>> <?php echo $v['area_name']; ?></option>
										<?php
								}
								?>
									</select>
									</span> <span id="shop_province">
									<?php 
							if($info['province']){
								?>
									<select name="province" onchange="areachanged(this.value,1);">
										<option value='0'><?php echo $a_langpackage->a_select_province; ?></option>
										<?php 
									foreach ($areas_info[1] as $v){
									?>
										<option value="<?php echo $v['area_id']; ?>"<?php if($v['area_id']==$shop_info['shop_province']){echo 'selected';}?>> <?php echo $v['area_name']; ?></option>
										<?php
									}
									?>
									</select>
									<?php 
							}
							?>
									</span> <span id="shop_city">
									<?php 
							if($info['city']){
								?>
									<select name="city" onchange="areachanged(this.value,2);">
										<option value='0'><?php echo $a_langpackage->a_select_city; ?></option>
										<?php 
									foreach ($areas_info[2] as $v){
										if($v['parent_id'] == $shop_info['shop_province']){
									?>
										<option value="<?php echo $v['area_id']; ?>"<?php if($v['area_id']==$shop_info['shop_city']){echo 'selected';}?>> <?php echo $v['area_name']; ?></option>
										<?php
										}
									}
									?>
									</select>
									<?php 
							}
								?>
									</span> <span id="shop_district">
									<?php 
							if($info['district']){
								?>
									<select name="district">
										<option value='0'><?php echo $a_langpackage->a_select_dir; ?></option>
										<?php 
									foreach($areas_info[3] as $v){
										if($v['parent_id'] == $shop_info['shop_city']){
											?>
										<option value="<?php echo $v['area_id']; ?>"<?php if($v['area_id']==$shop_info['shop_district']){echo 'selected';}?>> <?php echo $v['area_name']; ?></option>
										<?php 
										}
									}
									?>
									</select>
									<?php
							}
							?>
							</span>
								</td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;<?php echo $a_langpackage->a_address;?>：</td>
								<td><input type="text" name="address" value="<?php echo $info['address'];?>"/></td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;<?php echo $a_langpackage->a_post;?>：</td>
								<td><input type="text" name="zipcode" value="<?php echo $info['zipcode'];?>"/></td>
							</tr>
						</tbody>
					</table>
					<table class="list_table" style="float:left; width:32%; margin-right:2%">
						<thead>
							<tr>
								<th colspan="2">&nbsp;&nbsp;<?php echo $a_langpackage->a_trans_info;?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td width="100">&nbsp;&nbsp;<?php echo $a_langpackage->a_shop_name2;?>：</td>
								<td><?php echo $info['shop_name'];?></td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;<?php echo $a_langpackage->a_trans_company_name;?>：</td>
								<td><input type="text" name="shipping_name" value="<?php echo $info['shipping_name'];?>"/></td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;<?php echo $a_langpackage->a_trans_ID;?>：</td>
								<td><input type="text" name="shipping_no" value="<?php echo $info['shipping_no'];?>"/></td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;<?php echo $a_langpackage->a_trans_type;?>：</td>
								<td><input type="text" name="shipping_type" value="<?php echo $info['shipping_type'];?>"/></td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;<?php echo $a_langpackage->a_trans_time;?>：</td>
								<td><?php echo $info['shipping_time'];?></td>
							</tr>
						</tbody>
					</table>
					<table class="list_table" style="float:left; width:32%;" >
						<thead>
							<tr>
								<th colspan="2">&nbsp;&nbsp;<?php echo $a_langpackage->a_order_infomation;?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td width="100">&nbsp;&nbsp;<?php echo $a_langpackage->a_orderID;?>：</td>
								<td><?php echo $info['payid'];?></td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;<?php echo $a_langpackage->a_shop_gather_mode;?>：</td>
								<td><select name="pay_name">
									<?php foreach ($payarr as $val){
										?><option <?php if($val['pay_name'] === $info['pay_name']){ echo "selected";}?>><?php echo $val['pay_name'];?></option><?php
									}?>
								</select></td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;<?php echo $a_langpackage->a_order_ps;?>：</td>
								<td><?php echo $info['message'];?></td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;<?php echo $a_langpackage->a_make_order_time;?>：</td>
								<td><?php echo $info['order_time'];?></td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;<?php echo $a_langpackage->a_pay_time;?>：</td>
								<td><?php echo $info['pay_time'];?></td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;<?php echo $a_langpackage->a_get_goods_time;?>：</td>
								<td><?php echo $info['receive_time'];?></td>
							</tr>
						</tbody>
					</table>
					<div class="clear"></div>
					<div><input type="submit" name="submit" value="确定"/></div>
				</form>
			</div>
		</div>
	</div>
</div>
<script language="JavaScript" src="../servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
<!--
var utype = '';
function areachanged(value,type){
	utype = type;
	if(value > 0) {
		ajax("a.php?act=ajax_areas","POST","value="+value+"&type="+type);
	} else {
		if(type==2) {
			hide("shop_district");
		} else if(type==1) {
			hide("shop_district");
			hide("shop_city");
		} else if(type==0) {
			hide("shop_district");
			hide("shop_city");
			hide("shop_province");
		}
	}
}

function check() {
	var order_value = document.getElementsByName("order_value")[0];
	if(order_value.value=='') {
		alert("<?php echo $a_langpackage->a_order_goal.$a_langpackage->a_null; ?>");
		order_value.focus();
		return false;
	}
	var consignee = document.getElementsByName("consignee")[0];
	if(consignee.value=='') {
		alert("<?php echo $a_langpackage->a_linker.$a_langpackage->a_null; ?>");
		consignee.focus();
		return false;
	}
	var mobile = document.getElementsByName("mobile")[0];
	var telphone = document.getElementsByName("telphone")[0];
	if(mobile.value=='' && telphone.value=='') {
		alert("<?php echo $a_langpackage->a_mobil_telpho; ?>");
		mobile.focus();
		return false;
	}
	var email = document.getElementsByName("email")[0];
	var user_email_reg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
	if(!email.value=='' && !user_email_reg.test(email.value)){
		alert("<?php echo $a_langpackage->a_email_null_not; ?>");
		email.focus();
	}
	var province = document.getElementsByName('province')[0];
	if(province.value==0){
		alert("<?php echo $a_langpackage->a_province; ?>");
		return false;
	}

	var city = document.getElementsByName('city')[0];
	if(city.value==0){
		alert("<?php echo $a_langpackage->a_city; ?>");
		return false;
	}

	var district = document.getElementsByName('district')[0];
	if(district.value==0){
		alert("<?php echo $a_langpackage->a_district; ?>");
		return false;
	}
	
	var address = document.getElementsByName('address')[0];
	if(address.value==''){
		alert("<?php echo $a_langpackage->a_address_notnone; ?>");
		return false;
	}

	var shipping_name = document.getElementsByName('shipping_name')[0];
	if(shipping_name.value==''){
		alert("<?php echo $a_langpackage->a_trans_company_name.$a_langpackage->a_null; ?>");
		return false;
	}

	var shipping_no = document.getElementsByName('shipping_no')[0];
	if(shipping_no.value==''){
		alert("<?php echo $a_langpackage->a_trans_ID.$a_langpackage->a_null; ?>");
		return false;
	}
	return true;
}

function ajaxCallback (return_text){
	return_text = return_text.replace(/[\n\r]/g,"");
	if(return_text==""){
		alert("<?php echo $a_langpackage->a_select_again; ?>");
	} else {
		if(utype==0) {
			document.getElementById("shop_province").innerHTML = return_text;
			show("shop_province");
			hide("shop_city");
			hide("shop_district");
		} else if(utype==1) {
			document.getElementById("shop_city").innerHTML = return_text;
			show("shop_city");
			hide("shop_district");
		} else if(utype==2) {
			show("shop_district");
			document.getElementById("shop_district").innerHTML = return_text;
			
		}
	}
}

function hide(id) {
	document.getElementById(id).style.display = 'none';
}
function show(id) {
	document.getElementById(id).style.display = '';
}

function imgmover(obj) {
	obj.style.border = '2px solid #E38016';
}

function imgmout(obj) {
	obj.style.border = '2px solid #eee';
}

function wshowimg(v) {
	var width = document.body.clientWidth;
	var showimg = document.getElementById("showimg");
	var imgsrc = document.getElementById("imgsrc");

	var left = "100";
	if(width) {
		left = (width-400)/2;
	}
	showimg.style.left = left+"px";
	showimg.style.display = '';
	imgsrc.src = v;
	document.getElementById("hiddeninput").focus();
}

function whideimg() {
	var showimg = document.getElementById("showimg");
	showimg.style.display = 'none';
}
//-->
</script>
</body>
</html>