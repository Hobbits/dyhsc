<?php
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
?>