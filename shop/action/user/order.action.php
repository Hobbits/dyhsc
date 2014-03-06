<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
require("foundation/module_order.php");
require("foundation/module_goods.php");
require("foundation/module_photo.php");

//语言包引入
$m_langpackage=new moduleslp;

//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();

//定义文件表
$t_order_info = $tablePreStr."order_info";
$t_cart = $tablePreStr."cart";
$t_groupbuy = $tablePreStr."groupbuy";
$t_groupbuy_log = $tablePreStr."groupbuy_log";
$t_goods = $tablePreStr."goods";
$t_useraddress=$tablePreStr."user_address";
$t_order_goods = $tablePreStr."order_goods";
$t_credit = $tablePreStr."credit";
$t_good_photo = $tablePreStr."good_photo";
// 处理post变量

$post['group_id'] = intval(get_args('group_id'));
$post['shop_id'] = intval(get_args('sshop_id'));
$post['user_id'] = $user_id;
//$post['goods_id'] = intval(get_args('goods_id'));
$goods_id = str_filter(get_args('goods_id'));

if (is_array($goods_id)) {
	foreach ($goods_id as $k=>$v){
		$goods_id[$k]=intval($v);
	}
}else{
	$goods_id=array(intval($goods_id));
}
$post['pay_id'] = intval(get_args('pay_id'));
$post['pay_name'] = short_check(get_args('pay_name'));
$goods_name=get_args('goods_name');
//$post['goods_price'] = floatval(get_args('goods_price'));
$goods_price = get_args(('goods_price'));
if (is_array($goods_price)) {
	foreach ($goods_price as $k=>$v){
		$goods_price[$k]=floatval($v);
	}
}else{
	$goods_price=array(floatval($goods_price));
}

$transport_type = short_check(get_args('transport_type'));
if($transport_type){
	$aa=explode(',',$transport_type);
	$post['transport_price'] = floatval($aa[0]);
	$post['transport_type'] = $aa[1];
}else
{
    $post['transport_price'] = 0;
}

$order_amount = get_args("order_amount");

if (is_array($order_amount)) {
	foreach ($order_amount as $k=>$v){
		$order_amount[$k]=floatval($v);
	}
}else{
	$order_amount=array(floatval($order_amount));
}

$order_amount_value=0;
foreach ($order_amount as $value){
	$order_amount_value+=$value;
}

$post['order_amount'] =$order_amount_value;
$post['order_value'] = $order_amount_value+floatval(get_args("transport_type"));
$order_num = get_args("order_num");
if (is_array($order_num)) {
	foreach ($order_num as $k=>$v){
		$order_num[$k]=intval($v);
	}
}else{
	$order_num =array(intval($order_num));
}
$post['consignee'] = short_check(get_args('to_user_name'));
$post['country'] = intval(get_args('country'));
$post['province'] = intval(get_args('province'));
$post['city'] = intval(get_args('city'));
$post['district'] = intval(get_args('district'));
$post['mobile'] = short_check(get_args('mobile'));
$post['email'] = short_check(get_args('email'));
$post['telphone'] = short_check(get_args('telphone'));
$post['zipcode'] = short_check(get_args('zipcode'));
$post['address'] = long_check(get_args('full_address'));
$post['message'] = long_check(get_args('message'));
$post['order_time'] = $ctime->long_time();
$rand = rand(10,99);
$post['payid'] = date("YmdHis".$rand);
$quantity = get_args('order_num');
$grouplog_id=intval(get_args('grouplog_id'));
if (is_array($quantity)) {
	foreach ($quantity as $k=>$v){
		$quantity[$k]=intval($v);
	}
}else{
	$quantity =array(intval($quantity));
}

$group_id=$post['group_id'];
if (is_array($goods_name)) {
	foreach ($goods_name as $k=>$v){
		$goods_name[$k]=short_check($v);
	}
}else{
	$goods_name =array(short_check($goods_name));
}
$str = implode(",",$goods_id);
$cat_sql = "select goods_number from `$t_cart` where user_id=$post[user_id] and goods_id IN ($str)";
$cat_rs=$dbo->getRow($cat_sql);
/** 检查商品数量 */
foreach ($goods_id as $k=>$v){
	$goods_info = get_goods_info($dbo,$t_goods,array('goods_name','goods_price','goods_number'),$v);
	if($quantity[$k]>$goods_info['goods_number']){
		action_return(0,$m_langpackage->m_num_lack,'-1');
		exit;
	}
}

//生成订单
$err_no=0;
$order_id = $dbo->createbyarr($post,$t_order_info);
if ($order_id) {
	foreach ($goods_id as $k=>$v){
		
		$sql = "insert into $t_credit(order_id,goods_id,buyer,seller) value($order_id,$v,$user_id,$post[shop_id])";
		$dbo->exeUpdate($sql);

		$info = array(
			"order_id"=>$order_id,
			"goods_id"=>$v,
			"goods_name"=>$goods_name[$k],
			"goods_price"=>$goods_price[$k],
			"order_num"=>$order_num[$k],
		    "shop_id"=>$post['shop_id'],
			"good_tran"=>$post['transport_price'],
			"add_time"=>$ctime->long_time()
		);
		if(!$dbo->createbyarr($info,$t_order_goods)){
			$err_no[]=$v;
		}else{
			$now = date("Y-m-d");
			$sql = "UPDATE `$t_groupbuy` set order_num=order_num+1  where goods_id=$v ";
			$dbo->exeUpdate($sql);
            
			if ($cat_rs){
				$sql = "delete from `$t_cart` where user_id=$user_id and goods_id=$v ";
				$dbo->exeUpdate($sql);
				if(get_session('cart')){
					$car=get_session('cart');
					if(isset($car[$v])){
						unset($car[$v]);
					}
					set_session('cart',$car);
				}
				/** 减少库存 */
				$isql = "update `$t_goods` set goods_number = `$t_goods`.goods_number - $quantity[$k] where goods_id=$v";
				$dbo->exeUpdate($isql);
			}else {
				if(isset($grouplog_id)&&$grouplog_id){//团购时
                    $isql = "update `$t_goods` set goods_number = `$t_goods`.goods_number - ".intval(get_args('quantity'))." where goods_id=$v";
				    $dbo->exeUpdate($isql);
                    /* 改变下订单状态 **/
                    $sql2="UPDATE `$t_groupbuy_log` set log_type=1  where grouplog_id=$grouplog_id";
                    $dbo->exeUpdate($sql2);
                }else{
                    $isql = "update `$t_goods` set goods_number = `$t_goods`.goods_number - $quantity[$k] where goods_id=$v";
				    $dbo->exeUpdate($isql);
                }
			}
		}
	}
}else{
	$err_no="-1";
}
if ($err_no==0) {
	action_return(1,$m_langpackage->m_order_success,'modules.php?app=user_order_success&id='.$post['payid']);
}else{
	action_return(0,$m_langpackage->m_order_fail,'-1');
}
?>
