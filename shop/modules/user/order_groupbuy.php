<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/user/order_groupbuy.html
 * 如果您的模型要进行修改，请修改 models/modules/user/order_groupbuy.php
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
if(filemtime("templates/default/modules/user/order_groupbuy.html") > filemtime(__file__) || (file_exists("models/modules/user/order_groupbuy.php") && filemtime("models/modules/user/order_groupbuy.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/user/order_groupbuy.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("foundation/module_users.php");
require("foundation/module_areas.php");
require("foundation/module_goods.php");
require("foundation/module_payment.php");
//require_once("foundation/asession.php");
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

$group_id = intval(get_args('gid'));
$newadd=intval(get_args('newadd'));
if(!$group_id) { exit($m_langpackage->m_handle_err); }
//数据表定义区
$t_users = $tablePreStr."users";
$t_goods = $tablePreStr."goods";
$t_user_info = $tablePreStr."user_info";
$t_areas = $tablePreStr."areas";
$t_shop_payment = $tablePreStr."shop_payment";
$t_payment = $tablePreStr."payment";
$t_user_address = $tablePreStr."user_address";
$t_shop_groupbuy = $tablePreStr."groupbuy";
$t_shop_groupbuy_log = $tablePreStr."groupbuy_log";

$dbo=new dbex;
//读写分离定义方法
dbtarget('r',$dbServs);
$sql = "select * from $t_shop_groupbuy where group_id = $group_id";
$groupbuyinfo = $dbo->getRow($sql);



$user_info=array(
	'user_country'=>'',
	'user_id'=>'',
	'user_province'=>'',
	'user_city'=>'',
	'to_user_name'=>'',
	'user_district'=>'',
	'full_address'=>'',
	'zipcode'=>'',
	'mobile'=>'',
	'telphone'=>'',
	'email'=>'',

);
if(isset($newadd)&&$newadd=='1'){
	$user_info['user_country']=intval(get_args('country'));
	$user_info['user_province']=intval(get_args('province'));
	$user_info['user_city']=intval(get_args('city'));
	$user_info['user_district']=intval(get_args('district'));
	$user_info['full_address']=short_check(get_args('full_address'));
	$user_info['zipcode']=short_check(get_args('zipcode'));
	$user_info['mobile']=short_check(get_args('mobile'));
	$user_info['telphone']=short_check(get_args('telphone'));
	$user_info['email']=short_check(get_args('email'));
	$user_info['to_user_name']=short_check(get_args('to_user_name'));
/** 保存地址 */
	if(isset($_POST['issave'])&&$_POST['issave']=='1'){
		$sql2="insert into $t_user_address (user_id,to_user_name,full_address,zipcode,telphone,mobile".
		      ",user_country,user_province,user_city,user_district,email) values ('".$user_id."',".
		      "'".$user_info['to_user_name']."','".$user_info['full_address']."','".$user_info['zipcode']."','".$user_info['telphone']."','".$user_info['mobile'] .
		      "','".$user_info['user_country']."','".$user_info['user_province']."','".$user_info['user_city']."','".$user_info['user_district']."','".$user_info['email']."')";
		$dbo->exeUpdate($sql2);
	}
}else{
	$sql="select * from $t_user_address where user_id=$user_id";
	$address_rs=$dbo->getRs($sql);
	if ($address_rs) {
		$user_info = $address_rs[0];
		$address_id = $address_rs[0]['address_id'];
	}
}
// 用户所选国家， 如果没选默认为1（中国）
$user_info['user_country'] = $user_info['user_country'] ? $user_info['user_country'] : 1;
$shop_id=get_sess_shop_id();

$sql = "select g.*,l.*,t.transport_price,t.goods_name from $t_shop_groupbuy g left join $t_shop_groupbuy_log l on g.group_id = l.group_id left join $t_goods t on g.goods_id = t.goods_id where g.group_id = $group_id";
$goods_info = $dbo->getRow($sql);
if(!$goods_info) { exit($m_langpackage->m_handle_err); }

$user_info['user_id'] = $user_id;
// 用户所选国家， 如果没选默认为1（中国）
$user_info['user_country'] = $user_info['user_country'] ? $user_info['user_country'] : 1;
$areas_info = get_areas_info($dbo,$t_areas);
/*
foreach($areas_info[1] as $v)
{
	echo $v['area_id'];
}

exit();*/
$sql = "select * from `$t_shop_payment` where shop_id='$goods_info[shop_id]'";
$payment_info = $dbo->getRow($sql);

$payment = get_payment_info($dbo,$t_payment);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo  $m_langpackage->m_u_center;?></title>
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/modules.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/layout.css">
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/style.css">
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/userchangeStyle.js"></script>
<style type="text/css">
th{background:#EFEFEF}
td span{color:red;}
</style>
</head>
<body onload="menu_style_change('user_my_order');changeMenu();">
<?php  require("shop/index_header.php");?>

	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo  $m_langpackage->m_my_group_buy_orders;?>
	</div>
    <div class="clear"></div>
    <?php  require("modules/left_menu.php");?>
    <div class="main_right">
		<div class="right_top"></div>
		<div class="cont">
			<div class="cont_title">
				<?php echo  $m_langpackage->m_my_group_buy_orders;?>
			</div>
			<hr />
			 <div id="stepTip" class="clearfix">
     <ul class="list_step1 clearfix">
     <li><?php echo  $m_langpackage->m_u_first;?>:<br /><?php echo  $m_langpackage->m_ordernow_add;?></li>
     <li class="now"><?php echo  $m_langpackage->m_u_secound;?>:<br /><?php echo  $m_langpackage->m_sure_ordernow;?></li>
     <li style="padding-right:0"><?php echo  $m_langpackage->m_u_third;?>:<br /><?php echo  $m_langpackage->m_accomplish;?></li>
     </ul>
     </div>
			<form action="do.php?act=user_order" method="post" name="for<?php echo  $m_langpackage->m_profile;?>" onsubmit="return checkform();">
				<table  width="100%" border="0" cellspacing="0">
					<tr>
						<th><?php echo  $m_langpackage->m_group_name;?></th>
						<th><?php echo  $m_langpackage->m_group_price;?></th>
						<th><?php echo  $m_langpackage->m_buy_num;?></th>
						<th><?php echo  $m_langpackage->m_transport_price;?></th>
					</tr>
					<tr>
						<td align="center"><?php echo  $goods_info['group_name'];?></td>
						<td align="center"><?php echo  $goods_info['spec_price'];?><?php echo  $m_langpackage->m_yuan;?></td>
						<td align="center"><?php echo  $goods_info['quantity'];?></td>
						<td align="center"><?php echo  $goods_info['transport_price'];?><?php echo  $m_langpackage->m_yuan;?></td>
					</tr>
					<input type="hidden" value="<?php echo  $goods_info['shop_id'];?>" name="sshop_id" />
					<input type="hidden" value="<?php echo  $goods_info['goods_id'];?>" name="goods_id" />
					<input type="hidden" value="<?php echo  $goods_info['goods_name'];?>" name="goods_name" />
					<input type="hidden" value="<?php echo  $goods_info['group_id'];?>" name="group_id" />
					<input type="hidden" value="<?php echo  $goods_info['grouplog_id'];?>" name="grouplog_id" />
					<input type="hidden" value="<?php echo  $goods_info['spec_price'];?>" name="goods_price" />
					<input type="hidden" value="<?php echo  $goods_info['transport_price'];?>" name="transport_price" />
					<input type="hidden" value="<?php echo  $goods_info['quantity'];?>" name="quantity" />
					<input type="hidden" value="<?php echo  $goods_info['spec_price'] * $goods_info['quantity'] + $goods_info['quantity'] * $goods_info['transport_price'];?>" name="order_amount" />
					<tr><td colspan="4"><?php echo  $m_langpackage->m_order_thisbuyprice;?>:<span><?php echo  $goods_info['spec_price'] * $goods_info['quantity'] + $goods_info['quantity'] * $goods_info['transport_price'];?></span><?php echo  $m_langpackage->m_yuan;?></td></tr>
				</table>
							  <table  width="100%" border="0" cellspacing="0">
					<tr>
						<th colspan="2">&nbsp;&nbsp;<?php echo  $m_langpackage->m_order_getsting;?></th>
					</tr>
					<tr><td class="textright" align="left"><?php echo  $m_langpackage->m_contact;?>:</td>
						<td><?php echo  $user_info['to_user_name'];?></td></tr>
					<tr>
						<td class="textright"><?php echo  $m_langpackage->m_stayarea;?>:</td>
						<td>
							
							<?php  foreach($areas_info[0] as $v){?>
									<?php  if($v['area_id']==$user_info['user_country']){?><?php echo  $v['area_name'];?><?php }?>
							<?php }?>
							&nbsp;
							<?php if($user_info['user_country']) {?>
							
							<?php  foreach($areas_info[1] as $v) {
									if($v['parent_id'] == $user_info['user_country']) {?>
								
								<?php  if($v['area_id']==$user_info['user_province']){?><?php echo  $v['area_name'];?><?php }?>
							<?php }?>
							<?php }?>
							<?php }?>&nbsp;
							<?php  if($user_info['user_province']) {?>
						
							<?php  foreach($areas_info[2] as $v) {
									if($v['parent_id'] == $user_info['user_province']){?>
							
								<?php  if($v['area_id']==$user_info['user_city']){?><?php echo  $v['area_name'];?><?php }?>
							<?php }?>
							<?php }?>
							<?php }?>&nbsp;
							<?php   if($user_info['user_city']) {?>
							
								
							<?php  foreach($areas_info[3] as $v) {
									if($v['parent_id'] == $user_info['user_city']) {?>
								
								<?php  if($v['area_id']==$user_info['user_district']){?><?php echo  $v['area_name'];?><?php }?>
							<?php }?>
							<?php }?>
							<?php }?>
						</td>
					</tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_address;?>:</td>
					<td><?php echo  $user_info['full_address'];?></td></tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_zipcode;?>:</td>
					<td><?php echo  $user_info['zipcode'];?></td></tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_mobile;?>:</td>
						<td><?php echo  $user_info['mobile'];?></td></tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_telphone;?>:</td>
						<td><?php echo  $user_info['telphone'];?></td></tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_email;?>:</td>
						<td><?php echo $user_info['email'];?></td></tr>
					<tr><td colspan="2">&nbsp;&nbsp;<span><?php echo  $m_langpackage->m_sureaddress_rcgoods;?></span></td></tr>
				</table>
				<table  width="100%" border="0" cellspacing="0" style="display:none">
					<tr>
						<th colspan="2">&nbsp;&nbsp;<?php echo  $m_langpackage->m_order_getsting;?></th>
					</tr>
					<tr><td class="textright" align="left"><?php echo  $m_langpackage->m_contact;?>:</td>
						<td><input type="text" name="to_user_name" value="<?php echo  $goods_info['linkman'];?>" maxlength="12" /></td></tr>
					<tr>
						<td class="textright"><?php echo  $m_langpackage->m_stayarea;?>:</td>
						<td>
							<span id="user_country"><select name="country" onchange="areachanged(this.value,0);">
								<option value='0'><?php echo  $m_langpackage->m_select_country;?></option>
							<?php  foreach($areas_info[0] as $v){?>
								<option value="<?php echo  $v['area_id'];?>"
									<?php  if($v['area_id']==$user_info['user_country']){echo 'selected';}?>><?php echo  $v['area_name'];?></option>
							<?php }?>
							</select></span>
							<span id="user_province"><?php if($user_info['user_country']) {?>
							<select name="province" onchange="areachanged(this.value,1);">
								<option value='0'><?php echo  $m_langpackage->m_select_province;?></option>
							<?php  foreach($areas_info[1] as $v) {
									if($v['parent_id'] == $user_info['user_country']) {?>
								<option value="<?php echo  $v['area_id'];?>"
								<?php  if($v['area_id']==$user_info['user_province']){echo 'selected';}?>><?php echo  $v['area_name'];?></option>
							<?php }?>
							<?php }?>
							</select>
							<?php }?></span>
							<span id="user_city"><?php  if($user_info['user_province']) {?>
							<select name="city" onchange="areachanged(this.value,2);">
								<option value='0'><?php echo  $m_langpackage->m_select_city;?></option>
							<?php  foreach($areas_info[2] as $v) {
									if($v['parent_id'] == $user_info['user_province']){?>
								<option value="<?php echo  $v['area_id'];?>"
								<?php  if($v['area_id']==$user_info['user_city']){echo 'selected';}?>><?php echo  $v['area_name'];?></option>
							<?php }?>
							<?php }?></select>
							<?php }?></span>
							<span id="user_district"><?php   if($user_info['user_city']) {?>
							<select name="district">
								<option value='0'><?php echo  $m_langpackage->m_select_district;?></option>
							<?php  foreach($areas_info[3] as $v) {
									if($v['parent_id'] == $user_info['user_city']) {?>
								<option value="<?php echo  $v['area_id'];?>"
								<?php  if($v['area_id']==$user_info['user_district']){echo 'selected';}?>><?php echo  $v['area_name'];?></option>
							<?php }?>
							<?php }?></select>
							<?php }?></span>
						</td>
					</tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_address;?>:</td>
					<td><input type="text" name="full_address" value="<?php echo  $user_info['full_address'];?>" style="width:250px;" maxlength="200" /></td></tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_zipcode;?>:</td>
					<td><input type="text" name="zipcode" value="<?php echo  $user_info['zipcode'];?>" maxlength="6" /></td></tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_mobile;?>:</td>
						<td><input type="text" name="mobile" value="<?php echo  $user_info['mobile'];?>" maxlength="20" /></td></tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_telphone;?>:</td>
						<td><input type="text" name="telphone" value="<?php echo  $user_info['telphone'];?>" maxlength="20" /></td></tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_email;?>:</td>
						<td><input type="text" name="email" value="<?php echo $user_info['email'];?>" maxlength="20" /></td></tr>
					<tr><td colspan="2">&nbsp;&nbsp;<span><?php echo  $m_langpackage->m_sureaddress_rcgoods;?></span></td></tr>
				</table>
				<table  width="100%" border="0" cellspacing="0">
					<tr>
						<th colspan="2">&nbsp;&nbsp;<?php echo  $m_langpackage->m_sure_postorder;?></th>
					</tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_order_message;?>:</td><td><textarea name="message" style="width:280px;height:60px"></textarea></td></tr>
					<tr><td colspan="2" align="center">
					<input type="hidden" name="user_id" value="<?php echo  $user_info['user_id'];?>" />
					<input type="hidden" name="pay_id" value="<?php echo  $payment_info['pay_id'];?>" />
					<input type="hidden" name="pay_name" value="<?php echo  $payment[$payment_info['pay_id']]['pay_name'];?>" />
					<input type="submit" class="submit" name="submit" value="<?php echo  $m_langpackage->m_post_order;?>" /></td></tr>
				</table>
			</form>
        </div>
    </div>
<div class="clear"></div>
<?php  require("shop/index_footer.php");?>
<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
<!--
function areachanged(value,type){
	if(value > 0) {
		ajax("do.php?act=ajax_areas","POST","value="+value+"&type="+type,function(return_text){
			var return_text = return_text.replace(/[\n\r]/g,"");
			if(return_text==""){
				alert("");
			} else {
				if(type==0) {
					document.getElementById("user_province").innerHTML = return_text;
					show("user_province");
					hide("user_city");
					hide("user_district");
				} else if(type==1) {
					document.getElementById("user_city").innerHTML = return_text;
					show("user_city");
					hide("user_district");
				} else if(type==2) {
					document.getElementById("user_district").innerHTML = return_text;
					show("user_district");
				}
			}
		});
	} else {
		if(type==2) {
			hide("user_district");
		} else if(type==1) {
			hide("user_district");
			hide("user_city");
		} else if(type==0) {
			hide("user_district");
			hide("user_city");
			hide("user_province");
		}
	}
}

function hide(id) {
	document.getElementById(id).style.display = 'none';
}

function show(id) {
	document.getElementById(id).style.display = '';
}


function checkform(){
	var to_user_name = document.getElementsByName('to_user_name')[0];
	if(to_user_name.value==''){
		alert('<?php echo $m_langpackage->m_pl_getgoods_name;?>');
		return false;
	}

	var province = document.getElementsByName('province')[0];
	if(province.value==0){
		alert('<?php echo $m_langpackage->m_pl_getgoods_province;?>');
		return false;
	}

	var city = document.getElementsByName('city')[0];
	if(city.value==0){
		alert('<?php echo $m_langpackage->m_pl_getgoods_city;?>');
		return false;
	}

	var district = document.getElementsByName('district')[0];
	if(district.value==0){
		alert('<?php echo $m_langpackage->m_pl_getgoods_district;?>');
		return false;
	}

	var full_address = document.getElementsByName('full_address')[0];
	if(full_address.value==''){
		alert('<?php echo $m_langpackage->m_pl_getgoods_address;?>');
		return false;
	}

	var zipcode = document.getElementsByName('zipcode')[0];
	if(zipcode.value==''){
		alert('<?php echo $m_langpackage->m_pl_getgoods_zipcode;?>');
		return false;
	}

	var email = document.getElementsByName('email')[0];
	var user_email_reg = /^[0-9a-zA-Z_\-\.]+@[0-9a-zA-Z_\-]+(\.[0-9a-zA-Z_\-]+)*$/;
	if(!email.value=='' && !user_email_reg.test(email.value)){
		alert('<?php echo $m_langpackage->m_email_type_notine;?>');
		return false;
	}

	var user_mobile = document.getElementsByName('mobile')[0];
	var user_mobile_reg = new RegExp("[0-9-]{5,15}");

	var user_telphone = document.getElementsByName('telphone')[0];
	var user_telphone_reg = new RegExp("[0-9-]{5,15}");

	if(user_mobile.value=='' && user_telphone.value=='') {
		alert('<?php echo $m_langpackage->m_sorry_p_mselectone;?>');
		return false;
	} else if(!user_mobile.value=='' && !user_mobile_reg.test(user_mobile.value)) {
		alert('<?php echo $m_langpackage->m_sorry_mobiletype;?>');
		return false;
	} else if(!user_telphone.value=='' && !user_telphone_reg.test(user_telphone.value)) {
		alert('<?php echo $m_langpackage->m_sorry_phonetype;?>');
		return false;
	}else {
		return true;
	}

}

function changeurl(v){
	var re = /&address_id=[0-9]+/g;
	location.href = location.href.replace(re,'')+'&address_id='+v;
}

function clearaddress() {
	areachanged(1,0);
	var to_user_name = document.getElementsByName('to_user_name')[0];
	to_user_name.value="";
	var full_address = document.getElementsByName('full_address')[0];
	full_address.value="";
	var zipcode = document.getElementsByName('zipcode')[0];
	zipcode.value="";
	var mobile = document.getElementsByName('mobile')[0];
	mobile.value="";
	var telphone = document.getElementsByName('telphone')[0];
	telphone.value="";
	var email = document.getElementsByName('email')[0];
	email.value="";
}
//-->
</script>
</body>
</html><?php } ?>