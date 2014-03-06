<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/user/order_adress.html
 * 如果您的模型要进行修改，请修改 models/modules/user/order_adress.php
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
if(filemtime("templates/default/modules/user/order_adress.html") > filemtime(__file__) || (file_exists("models/modules/user/order_adress.php") && filemtime("models/modules/user/order_adress.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/user/order_adress.html",1);
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
$s_langpackage=new shoplp;

$gid = get_args('gid');
$goods_id = str_filter($gid);
$order_num = str_filter(get_args('v'));
$address_id = intval(get_args('address_id'));
if(!$goods_id) { trigger_error("非法操作"); }
if(!$order_num) { trigger_error("非法操作"); }
if(!is_array($goods_id)){
	$goods_id=array(intval($goods_id));
}
if(!is_array($order_num)){
	$order_num=array(intval($order_num));
}
$url_param ="";
for($i=0; $i< sizeof($goods_id);$i++)
{
	$url_param.="&gid[]=".$goods_id[$i]."&v[]=".$order_num[$i];
}
 

//数据表定义区
$t_users = $tablePreStr."users";
$t_goods = $tablePreStr."goods";
$t_shop_info	=	$tablePreStr."shop_info";
$t_transport_template = $tablePreStr."goods_transport";
$t_user_info = $tablePreStr."user_info";
$t_areas = $tablePreStr."areas";
$t_shop_payment = $tablePreStr."shop_payment";
$t_payment = $tablePreStr."payment";
$t_user_address = $tablePreStr."user_address";
$t_cart = $tablePreStr."cart";

$dbo=new dbex;
//读写分离定义方法
dbtarget('r',$dbServs);

//判断是否该商品的网店已被锁定
$lock_flg	=	get_shop_lock_flag($dbo,$t_goods,$t_shop_info,$goods_id[0]);
if($lock_flg=='1')
	trigger_error($m_langpackage->m_goods_shop_locked);
/* 产品信息获取 */
$as=implode(",",$goods_id);
$sql = "select * from `$t_goods` where goods_id in ($as) and is_on_sale=1";

$goodsinfo = $dbo->getRow($sql);
if($goodsinfo['goods_number']==0) { trigger_error($s_langpackage->s_kucun_0); }
if($goodsinfo['lock_flg']) { trigger_error($s_langpackage->s_goods_locked); }
if(!$goodsinfo) { trigger_error($s_langpackage->s_goods_error); }
//判断该商品是否有价格，如果为0，则是询价，不能进入订单。
$sql1="select goods_price from $t_goods where goods_id=$goods_id[0]";
$resule=$dbo->getRow($sql1);
if($resule['goods_price']=='0.00'){
	echo "<script language='JavaScript'>location.href='inquiry.php?gid=$goods_id[0]'</script>";
}


$sql="select * from $t_user_address where user_id=$user_id";
$address_rs=$dbo->getRs($sql);

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

if($address_id && $address_rs){
	foreach($address_rs as $value) {
		if($address_id == $value['address_id']) {
			$user_info = $value;
		}
	}
} elseif ($address_rs) {
	$user_info = $address_rs[0];
	$address_id = $address_rs[0]['address_id'];
}
$tablestyle="none";
if(!$address_rs){
	$tablestyle="block";
}

// 用户所选国家， 如果没选默认为1（中国）
$user_info['user_country'] = $user_info['user_country'] ? $user_info['user_country'] : 1;

$shop_id=get_sess_shop_id();
if(is_array($goods_id)){
	$goods_info = get_goods_info($dbo,$t_goods,"*",$goods_id[0]);
}else{
	$goods_info = get_goods_info($dbo,$t_goods,"*",$goods_id);
}
if($shop_id == $goods_info['shop_id']) {
	set_sess_err_msg($m_langpackage->m_dontbuy_youself);
	echo '<script language="JavaScript">location.href="modules.php?app=message"</script>';
	exit();
}
if(!$goods_info) { trigger_error("非法操作"); }

//$user_info = get_user_info($dbo,$t_user_info,$user_id);
$user_info['user_id'] = $user_id;
// 用户所选国家， 如果没选默认为1（中国）
$user_info['user_country'] = $user_info['user_country'] ? $user_info['user_country'] : 1;
$areas_info = get_areas_info($dbo,$t_areas);
$sql = "select * from `$t_shop_payment` where shop_id='$goods_info[shop_id]'";
$payment_info = $dbo->getRow($sql);
$payment = get_payment_info($dbo,$t_payment);
//$transport_type =0;
////取得配送方式
//if ($goods_info['is_transport_template']&&$goods_info['transport_template_id']) {
//	$transport_template_info = $dbo->getRow("SELECT content FROM $t_transport_template WHERE id='{$goods_info['transport_template_id']}'");
//	$transport = unserialize($transport_template_info['content']);
//	foreach ($transport as $key=>$value){
//		if ($key=="ems") {
//			$name="EMS";
//		}
//		if ($key=="ex") {
//			$name="快递";
//		}
//		if ($key=="pst") {
//			$name="平邮";
//		}
//		$transport[$key]['name']=$name;
//	}
//	if (isset($transport['ems'])) {
//		$transport_type='ems';
//	}
//	if (isset($transport['pst'])) {
//		$transport_type='pst';
//	}
//	if (isset($transport['ex'])) {
//		$transport_type='ex';
//	}
//}
$newaddress="";
if(!empty($address_rs)){
	$newaddress="display:none";
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo  $m_langpackage->m_u_center;?></title>
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/modules.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/layout.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo  $SYSINFO['templates'];?>/css/style.css">
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/userchangeStyle.js"></script>
<script language="JavaScript" type="text/javascript" src="servtools/NewDialog/Dialog.js"></script>
<link href="servtools/NewDialog/skin/default.css" rel="stylesheet" />
<style type="text/css">
th{background:#EFEFEF}
td span{color:red;}
</style>
</head>
<body onload="menu_style_change('user_my_order');changeMenu();">
<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo  $m_langpackage->m_my_order;?>
	</div>
    <div class="clear"></div>
	<?php  require("modules/left_menu.php");?>

		<div class="main_right">
  <div class="cont">
  
            <div class="title_uc"><h3><?php echo  $m_langpackage->m_my_order;?></h3></div>
            <hr />
             <div id="stepTip" class="clearfix">
     <ul class="list_step1 clearfix">
     <li class="now"><?php echo $m_langpackage->m_u_first;?>:<br /><?php echo $m_langpackage->m_ordernow_add;?></li>
     <li><?php echo $m_langpackage->m_u_secound;?>:<br /><?php echo $m_langpackage->m_sure_ordernow;?></li>
     <li style="padding-right:0"><?php echo $m_langpackage->m_u_third;?>:<br /><?php echo $m_langpackage->m_accomplish;?></li>
     </ul>
     </div>
     
		<form action="modules.php?app=user_order&gid=<?php echo implode(',',$goods_id);?>&v=<?php echo implode(',',$order_num);?>" method="post" name="for<?php echo  $m_langpackage->m_profile;?>" onsubmit="return checkform();">


		<table width="100%" class="form_table">
			<tr class="center"><th colspan="7"><?php echo $m_langpackage->m_getgoods_addresslist;?></th></tr>
			<?php if(empty($address_rs)){?>
				<tr><td class="center" colspan="7"><?php echo $m_langpackage->m_dontsave_getgoods_addresslist;?></td></tr>
			<?php }?>
			<?php foreach($address_rs as $val){?>
			<tr>
				<td class="center"><input type="radio" name="address_id" value="<?php echo $val['address_id'];?>" onclick="changeurl(<?php echo $val['address_id'];?>);" <?php if($val['address_id']==$address_id){?> checked <?php }?> /></td>
				<td class="center"><?php echo $val['to_user_name'];?></td>
				<td><?php echo $areas_info[0][$val['user_country']]['area_name'];?> <?php echo $areas_info[1][$val['user_province']]['area_name'];?> <?php echo $areas_info[2][$val['user_city']]['area_name'];?> <?php echo $areas_info[3][$val['user_district']]['area_name'];?></td>
				<td><?php echo $val['full_address'];?></td><td class="center"><?php echo $val['zipcode'];?></td>
				<td class="center"><?php echo $val['mobile'];?>/<?php echo $val['telphone'];?></td>
				<td class="center"><?php echo $val['email'];?></td>
			</tr>
			<?php }?>
			<tr>
			    <td class="center"><input type="radio" name="address_id" value="" onclick="newAddress();" <?php if(empty($address_rs)){?> checked <?php }?>/></td>
			    <td class="left" colspan="4"><?php echo $m_langpackage->m_userother_address;?></td><td></td><td class="center"></td>
			</tr>
		</table>

       <table id="newAddress" width="100%" border="0" cellspacing="0">
					<tr>
						<th align="left" width="30%">&nbsp;&nbsp;<?php echo  $m_langpackage->m_order_getsting;?></th><th width="70%"><span></span></th>
					</tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_contact;?>：</td>
						<td align="left"><input type="text" name="to_user_name" value="<?php echo  $user_info['to_user_name'];?>" maxlength="12" /></td></tr>
					<tr>
						<td class="textright"><?php echo  $m_langpackage->m_stayarea;?>：</td>
						<td>
							<span id="user_country"><select name="country" onchange="areachanged(this.value,0);">
								<option value='0'><?php echo  $m_langpackage->m_select_country;?></option>
							<?php  foreach($areas_info[0] as $v){?>
								<option value="<?php echo  $v['area_id'];?>"
									<?php  if($v['area_id']==$user_info['user_country']){echo 'selected';}?>><?php echo  $v['area_name'];?></option>
							<?php }?>
							</select></span>
							<span id="user_province"><?php if($user_info['user_country']) {?>
							<select name="province" id="province" onchange="areachanged(this.value,1);">
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
					<tr><td class="textright"><?php echo  $m_langpackage->m_address;?>：</td>
					<td><input type="text" name="full_address" value="<?php echo  $user_info['full_address'];?>" style="width:250px;" maxlength="200" /></td></tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_zipcode;?>：</td>
					<td><input type="text" name="zipcode" value="<?php echo  $user_info['zipcode'];?>" maxlength="6" /></td></tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_mobile;?>：</td>
						<td><input type="text" name="mobile" value="<?php echo  $user_info['mobile'];?>" maxlength="20" /></td></tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_telphone;?>：</td>
						<td><input type="text" name="telphone" value="<?php echo  $user_info['telphone'];?>" maxlength="20" /></td></tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_email;?>：</td>
						<td><input type="text" name="email" value="<?php echo $user_info['email'];?>" maxlength="20" /></td></tr>
						
						<tr><td class="textright"></td><td align="left"><input type="checkbox" name="issave" value="1" /><?php echo  $m_langpackage->m_add_list;?></td></tr>
					<tr><td></td><td><span><?php echo  $m_langpackage->m_sureaddress_rcgoods;?></span><input type=hidden name="newadd" id="newadd" value="0" /></td></tr>
					<tr><td></td><td><span><input type="submit" name="submit" value="<?php echo  $m_langpackage->m_post_order;?>" /></span></td></tr>
				</table>

		</form>
        </div>
        </div>
    </div>
<div class="clear"></div>
<?php  require("shop/index_footer.php");?>
<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
function newAddress(){
	document.getElementById("newadd").value='1';
	clearaddress();
}

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
			var obj = document.getElementsByName('transporttype');
			for(i=0;i<obj.length;i++){
				if(obj[i].checked){
					var transporttype_value=obj[i].value;
				}
			}
			//getallpay(transporttype_value);
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
function getallpay(type){
	var area_id = document.getElementById('province').value;
	var goods_id = <?php echo $goods_info['goods_id'];?>;
	var goods_num = <?php echo $order_num;?>;
	ajax("do.php?act=gettransportprice","POST","area_id="+area_id+"&goods_id="+goods_id+"&goods_num="+goods_num+"&type="+type,function(data){
		document.getElementById("order_amount").value=parseInt(parseInt(<?php echo $goods_info['goods_price'];?>)*goods_num+parseInt(data));
		document.getElementById("allpay").innerHTML=document.getElementById("order_amount").value;
		document.getElementById("transportprice").innerHTML=data;
		document.getElementById("transport_price").value=data;
	});
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
	var user_email_reg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
	if(!email.value=='' && !user_email_reg.test(email.value)){
		alert('<?php echo $m_langpackage->m_email_type_notine;?>');
		return false;
	}

	var user_mobile = document.getElementsByName('mobile')[0];
	var reg = /^\d+(\.d+)?$/;

	var user_telphone = document.getElementsByName('telphone')[0];
	var tel_reg=/^([0-9]|[-])+$/g ;

	if(user_mobile.value=='' && user_telphone.value=='') {
		alert('<?php echo $m_langpackage->m_sorry_p_mselectone;?>');
		return false;
	} else if(!user_mobile.value=='' && !reg.test(user_mobile.value)) {
		alert('<?php echo $m_langpackage->m_sorry_mobiletype;?>');
		return false;
	} else if(!user_telphone.value=='' && !tel_reg.test(user_telphone.value)) {
		alert('<?php echo $m_langpackage->m_sorry_phonetype;?>');
		return false;
	}else {
		return true;
	}
}

function changeurl(v){
	var re = /&address_id=[0-9]+/g;
	var url = location.href.replace(re,"")+"&address_id="+v+"<?php echo $url_param;?>";
	location.href = url;
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
	var address_id = document.getElementsByName('address_id')[0];
	address_id.value="";
}
//-->
</script>
</body>
</html><?php } ?>