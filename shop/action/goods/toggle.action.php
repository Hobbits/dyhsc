<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//引入语言包
$m_langpackage=new moduleslp;
require("foundation/module_goods.php");

$name_array = array('on_sale','hot','new','best','promote');
/* post 数据处理 */
$goods_id = intval(get_args('id'));
$s = intval(get_args('s'));
$name = short_check(get_args('name'));

if(!$goods_id) {
	exit();
}

if(!in_array($name,$name_array)) {
	exit();
}
//数据表定义区
$t_goods = $tablePreStr."goods";
$t_shop = $tablePreStr."shop_info";
$t_users = $tablePreStr."users";
//定义写操作
dbtarget('r',$dbServs);
$dbo=new dbex;
//判断商品是否锁定
$goods = get_goods_info($dbo,$t_goods,'lock_flg',$goods_id);
if($goods['lock_flg']==1) { 
	echo -3;
		exit;
}
//判断用户是否锁定，锁定则不许操作
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	echo -4;
		exit;
}
if($s==1 && $name!='on_sale'){
	
	
	
	$is_num=get_goods_isname_num($dbo,$t_goods,$shop_id,$name);
	if($name=='best'){
		$actId=4;
	}elseif($name=='promote'){
		$actId=5;
	}elseif($name=='new'){
		$actId=6;
	}elseif($name=='hot'){
		$actId=7;
	}
	if(!isset($user_privilege[$actId])) {
		$user_privilege[$actId] = 0;
	}
	if($is_num>=$user_privilege[$actId]){
		echo -1;
		exit;
	}
}

//$sql="select * from $t_goods "

$s_open=get_goods_openflg($dbo,$t_shop,$shop_id);
if($s_open&&$s_open[0]==1){
	echo '-2';
	exit;
}
//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

$sql = "update `$t_goods` set is_".$name."='$s' where goods_id='$goods_id' and shop_id='$shop_id'";

if($dbo->exeUpdate($sql)) {
	echo $s ? 'yes' : 'no';
}
?>