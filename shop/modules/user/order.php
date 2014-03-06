<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/user/order.html
 * 如果您的模型要进行修改，请修改 models/modules/user/order.php
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
if(filemtime("templates/default/modules/user/order.html") > filemtime(__file__) || (file_exists("models/modules/user/order.php") && filemtime("models/modules/user/order.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/user/order.html",1);
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

if(!get_sess_user_id()){
	exit('请先<a href="login.php">登陆</a>！');
}

//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
$s_langpackage=new shoplp;

$address_id = intval(get_args('address_id'));
$goods_id = get_args("gid");
$goods_id=explode(",",$goods_id);

if(is_array($goods_id)){
	foreach ($goods_id as $k=>$v){
		$goods_id[$k]=intval($v);
	}
}else{
	$goods_id=array(intval($goods_id));
}
$order_num = get_args("v");
$order_num = explode(",",$order_num);

if(is_array($order_num)){
	foreach ($order_num as $k=>$v){
		$order_num[$k]=intval($v);
	}
}else{
	$order_num=array(intval($order_num));
}
foreach ($goods_id as $k=>$v){
	$buy_goods[$v]=$order_num[$k];
}

if(!$goods_id) { exit($m_langpackage->m_handle_err); }
if(!$order_num) { exit($m_langpackage->m_handle_err); }

//数据表定义区
$t_users = $tablePreStr."users";
$t_goods = $tablePreStr."goods";
$t_goods_transport= $tablePreStr."goods_transport";
$t_user_info = $tablePreStr."user_info";
$t_areas = $tablePreStr."areas";
$t_shop_payment = $tablePreStr."shop_payment";
$t_payment = $tablePreStr."payment";
$t_user_address = $tablePreStr."user_address";
$t_cart = $tablePreStr."cart";
$t_transport = $tablePreStr."transport";

$dbo=new dbex;
//读写分离定义方法
dbtarget('r',$dbServs);

$sql="select * from $t_user_address where user_id=$user_id";
$address_rs=$dbo->getRs($sql);
$ntablestyle="display:none";
if(!$address_rs){
    $ntablestyle="display:block";
}
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

  foreach($_POST as $k=>$v){
		$user_info[$k]=short_check(get_args($k));
		$user_info['user_country']=short_check(get_args('country'));
		$user_info['user_province']=short_check(get_args('province'));
		$user_info['user_city']=short_check(get_args('city'));
		$user_info['user_district']=short_check(get_args('district'));
	}
	/** 保存地址 */
	if(isset($_POST['issave'])&&$_POST['issave']=='1'){
		$sql2="insert into $t_user_address (user_id,to_user_name,full_address,zipcode,telphone,mobile".
		      ",user_country,user_province,user_city,user_district,email) values ('".$user_id."',".
		      "'".$user_info['to_user_name']."','".$user_info['full_address']."','".$user_info['zipcode']."','".$user_info['telphone']."','".$user_info['mobile'] .
		      "','".$user_info['user_country']."','".$user_info['user_province']."','".$user_info['user_city']."','".$user_info['user_district']."','".$user_info['email']."')";
		$dbo->exeUpdate($sql2);
	}
// 用户所选国家， 如果没选默认为1（中国）
$user_info['user_country'] = !empty($user_info['user_country']) ? $user_info['user_country'] : 1;
//查询商品库存
$goods_info = array();
$wherestr = implode(",",$goods_id);
$num_sql = "SELECT goods_id,goods_number FROM $t_goods WHERE goods_id IN ($wherestr)";
$rs = $dbo->getRs($num_sql);
$arr=array();

foreach ($rs as $k=>$v){
	$arr[$v['goods_id']]=$v['goods_number'];
}

foreach ($buy_goods as $k=>$v){
	if ($arr[$k]>=$v) {
		$goods_info[]=get_goods_info($dbo,$t_goods,"*",$k);
	}
}
if(!$goods_info) { exit($m_langpackage->m_handle_err); }
$shop_id=get_sess_shop_id();
if($shop_id == $goods_info[0]['shop_id']) {
	set_sess_err_msg($m_langpackage->m_dontbuy_youself);
	echo '<script language="JavaScript">location.href="modules.php?app=message"</script>';
	exit();
}
$user_info['user_id'] = $user_id;
$areas_info = get_areas_info($dbo,$t_areas);
//print_r($user_info);
$sql = "select * from `$t_shop_payment` where shop_id='".$goods_info[0]['shop_id']."'";
$payment_info = $dbo->getRow($sql);
$payment = get_payment_info($dbo,$t_payment);
$transport_type =0;
//查询开启的配送方式
$sql="select * from $t_transport where ifopen=1";
$arr_list=$dbo->getRs($sql);
foreach($arr_list as $v){
	$transport_price[$v['tranid']]=0;
}
//$transport_price=array('ex_price'=>0,'pst_price'=>0,'ems_price'=>0);
//取得配送方式,计算总体运费
foreach ($goods_info as $k=>$v){
	if ($v['is_transport_template']&&$v['transport_template_id']>0) {
		$transport_pirce_goods = get_goods_transport_price($dbo,$t_goods_transport,$user_info['user_province'],$v['transport_template_id'],$arr_list,$buy_goods[$v['goods_id']]);
		foreach($arr_list as $value){
			$transport_price[$value['tranid']]+=$transport_pirce_goods[$value['tranid']];
		}
	}else{
		foreach($arr_list as $value){
			$transport_price[$value['tranid']]+=$v['transport_price'];
		}
	}
}

//查询开启的配送方式
$sql="select * from $t_transport where ifopen=1";
$arr_list=$dbo->getRs($sql);
$transport_type_str="<select name='transport_type' onchange='change_transport(this.value)'>";
//循环出所有可用的配送方式
foreach ($arr_list as $value){
$tranid=$value['tranid'];
	foreach ($transport_price as $k=>$v){
		if ($tranid==$k && intval($v)>0) {
			$transport_type_str.="<option value='$v,$tranid'>".$value['tran_name'].$v."元</option>";
		}
	}
}

$transport_type_str.="</select>";
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
<body>
<?php  require("shop/index_header.php");?>
	<div class="site_map">
	  <?php echo $m_langpackage->m_current_position;?><A href="index.php"><?php echo $SYSINFO['sys_name'];?></A>/<a href="modules.php"><?php echo $m_langpackage->m_u_center;?></a>/&nbsp;&nbsp;<?php echo  $m_langpackage->m_my_order;?>
	</div>
    <div class="clear"></div>
	<?php  require("modules/left_menu.php");?>
    <div class="main_right">
		<div class="right_top"></div>
		<div class="cont">
            <div class="title_uc"><h3><?php echo  $m_langpackage->m_my_order;?></h3></div><hr />
             <div id="stepTip" class="clearfix">
			     <ul class="list_step1 clearfix">
			     <li><?php echo  $m_langpackage->m_u_first;?>:<br /><?php echo  $m_langpackage->m_ordernow_add;?></li>
			     <li class="now"><?php echo  $m_langpackage->m_u_secound;?>:<br /><?php echo  $m_langpackage->m_sure_ordernow;?></li>
			     <li style="padding-right:0"><?php echo  $m_langpackage->m_u_third;?>:<br /><?php echo  $m_langpackage->m_accomplish;?></li>
			     </ul>
             </div>
			<form action="do.php?act=user_order" method="post" name="for<?php echo  $m_langpackage->m_profile;?>" onsubmit="return checkform();">
				<table width="100%" border="0" cellspacing="0">
					<input type="hidden" value="<?php echo  $goods_info[0]['shop_id'];?>" name="sshop_id" />
					<tr><th colspan="2"><?php echo  $m_langpackage->m_goods_name;?></th><th><?php echo  $m_langpackage->m_goods_price;?></th><th><?php echo  $m_langpackage->m_buy_num;?></th></tr>
					<?php foreach($goods_info as $k=>$v){?>
					<tr><td class="name" colspan="2"><a href="<?php echo  goods_url($v['goods_id']);?>" target="_blank"><?php echo  $v['goods_name'];?></a></td>
					<td align="center"><?php echo  $v['goods_price'];?><?php echo  $m_langpackage->m_yuan;?></td>
					<td align="center" ><?php echo  $buy_goods[$v['goods_id']];?></td>
					<input type="hidden" value="<?php echo  $v['goods_id'];?>" name="goods_id[]" />
					<input type="hidden" value="<?php echo  $v['goods_name'];?>" name="goods_name[]" />
					<input type="hidden" value="<?php echo  $v['goods_price'];?>" name="goods_price[]" />
					<input type="hidden" value="<?php echo  $buy_goods[$v['goods_id']];?>" name="order_num[]" />
					<input type="hidden" value="<?php echo  $v['goods_price'] *$buy_goods[$v['goods_id']] ;?>" id="order_amount" name="order_amount[]" />
					</tr>
					<?php }?>
				</table>
				<table id="transport_type" width="100%" border="0" cellspacing="0">
					<tr>
						<tr class="center"><th colspan="7" align="left"><?php echo $m_langpackage->m_transport_price;?></th></tr>
					</tr>
					<tr>
						<td colspan="7">
							<div id="transport_box">
								<?php echo $transport_type_str;?>
							</div>
						</td>
					</tr>
				</table>
				
				<table id="oldAddress" width="100%" border="0" cellspacing="0">
					<tr>
						<th align="left" width="200">&nbsp;&nbsp;<?php echo  $m_langpackage->m_order_getsting;?></th><th align="right"><span onclick="clearaddress();"></span></th>
					</tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_contact;?>：</td>
						<td align="left"><?php echo  $user_info['to_user_name'];?></td></tr>
					<tr>
						<td class="textright"><?php echo  $m_langpackage->m_stayarea;?>：</td>
						<td>
							  <?php echo $areas_info[0][$user_info['user_country']]['area_name'];?>
                              <?php echo $areas_info[1][$user_info['user_province']]['area_name'];?>
                              <?php echo $areas_info[2][$user_info['user_city']]['area_name'];?>
                              <?php echo $areas_info[3][$user_info['user_district']]['area_name'];?>
						</td>
					</tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_address;?>：</td>
					<td><?php echo  $user_info['full_address'];?></td></tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_zipcode;?>：</td>
					<td><?php echo  $user_info['zipcode'];?></td></tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_mobile;?>：</td>
						<td><?php echo  $user_info['mobile'];?></td></tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_telphone;?>：</td>
						<td><?php echo  $user_info['telphone'];?></td></tr>
					<tr><td class="textright"><?php echo  $m_langpackage->m_email;?>：</td>
						<td><?php echo $user_info['email'];?></td></tr>
					<tr><td></td><td><span><?php echo  $m_langpackage->m_sureaddress_rcgoods;?></span></td></tr>
				</table>
				

				<table width="100%" border="0" cellspacing="0">
					<tr>
						<th width="200" align="left">&nbsp;&nbsp;<?php echo  $m_langpackage->m_sure_postorder;?></th><th></th>
					</tr>
					<tr><td class="textright" valign="top"><?php echo  $m_langpackage->m_order_message;?>：</td><td><textarea name="message" style="width:280px;height:60px" id="textareac" onkeyup="this.value=this.value.slice(0,300);"></textarea></td></tr>
					<tr><td colspan="2" align="center">
					<input type="hidden" name="to_user_name" value="<?php echo  $user_info['to_user_name'];?>" />
					<input type="hidden" name="full_address" value="<?php echo  $user_info['full_address'];?>" />
					<input type="hidden" name="zipcode" value="<?php echo  $user_info['zipcode'];?>" />
					<input type="hidden" name="mobile" value="<?php echo  $user_info['mobile'];?>" />
					<input type="hidden" name="telphone" value="<?php echo  $user_info['telphone'];?>" />
					<input type="hidden" name="email" value="<?php echo  $user_info['email'];?>" />
					<input type="hidden" name="country" value="<?php echo $user_info['user_country'];?>" />
					<input type="hidden" name="province" value="<?php echo $user_info['user_province'];?>" />
					<input type="hidden" name="city" value="<?php echo $user_info['user_city'];?>" />
					<input type="hidden" name="district" value="<?php echo $user_info['user_district'];?>" />
					<input type="hidden" name="pay_id" value="<?php echo  $payment_info['pay_id'];?>" />
					<input type="hidden" name="pay_name" value="<?php echo  $payment[$payment_info['pay_id']]['pay_name'];?>" />
					<input type="hidden" name="real_transport_money" id="real_transport_money" value="0" />
					<input type="button" onclick="javacript:history.go(-1);" name="submit" class="submit" value="<?php echo $m_langpackage->m_change_address;?>" />
					<input type="submit" name="submit" class="submit" onclick="do_transports()" value="<?php echo  $m_langpackage->m_post_order;?>" /></td></tr>
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
//				alert("");
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
//			getallpay(transporttype_value);
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

	var textareac = document.getElementById("textareac");
	if(textareac.value.length>300){
		alert("<?php echo $s_langpackage->s_work_count_error;?>");
		textareac.focus();
		return false;
	}
	return true;

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
function do_transports(){
	var transports = document.getElementsByName('transport_type')[0];
	for(i=0;i<transports.length;i++){
		if(transports[i].selected){
			var val=transports[i].value;
		}
	}
	change_transport(val);
	return true;
}
function changeurl(v){
	var re = /&address_id=[0-9]+/g;
	location.href = location.href.replace(re,'')+'&address_id='+v;
}

function clearaddress() {
//	areachanged(1,0);
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
	var user_country = document.getElementsByName('country')[0];
	for(i=0;i<user_country.length;i++){
		if(user_country[i].value==0){
			user_country[i].selected=true;
		}
	}
	hide("user_province");
	hide("user_city");
	hide("user_district");
}
function change_transport(val){
	document.getElementById('real_transport_money').value=val;
}
//-->
</script>
</body>
</html><?php } ?>