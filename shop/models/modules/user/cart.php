<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//引入文件
require_once("foundation/fsqlitem_set.php");
require_once("foundation/module_goods.php");
require_once("foundation/module_cart.php");
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
$s_langpackage=new shoplp;

$k = short_check(get_args('k'));
$cat = intval(get_args('cat'));

//数据表定义区
$t_cart = $tablePreStr."cart";
$t_goods = $tablePreStr."goods";
$t_shop_info = $tablePreStr."shop_info";
$user_id = get_sess_user_id();
//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);
$sql="SELECT goods_id FROM $t_cart WHERE user_id='$user_id'";
$rs = $dbo->getRs($sql);
$arr = array();
foreach ($rs as $k=>$v){
	$arr[]=$v['goods_id'];
}
$goods_ids="";
$dbo = new dbex;
dbtarget('w',$dbServs);
if (get_session('cart')) {
	$car=get_session('cart');
	foreach ($car as $key=>$value){
		if ($user_id) {
			if (!in_array($key,$arr)) {
				$insert_array = array(
					'user_id' => $user_id,
					'goods_id' => $key,
					'goods_number' => $car[$key]['num'],
					'add_time' => $ctime->long_time(),
				);
				$goods_info = get_goods_info($dbo,$t_goods,array('goods_name','goods_price','goods_number'),$key);
				$item_sql = get_insert_item($insert_array);
				$sql = "insert into `$t_cart` $item_sql ";
				if($dbo->exeUpdate($sql)) {
					$new_goods_num = $goods_info['goods_number'] - $car[$key]['num'];
					$sql = "update `$t_goods` set goods_number='$new_goods_num' where goods_id='$key'";
					$dbo->exeUpdate($sql);
				}
			}
		}
		$goods_ids.="($key,";
	}
	set_session('cart',$car);
}
$goods_ids = substr($goods_ids,0,-1);
$goods_ids.=")";
//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);
if ($user_id) {
	$result = get_cart_info($dbo,$t_cart,$t_goods,$t_shop_info,$user_id,10);
}else{
	$result = get_cart_session($dbo,$t_goods,$t_shop_info,$goods_ids,10);
	$car=get_session('cart');
	foreach ($result['result'] as $k=>$v){
		$result['result'][$k]['add_time']=$car[$v['goods_id']]['add_time'];
		$result['result'][$k]['goods_number']=$car[$v['goods_id']]['num'];
		$result['result'][$k]['cart_id']=0;
	}
	set_session('cart',$car);
}
$sql="SELECT sum(a.goods_number*b.goods_price) as sumvalue FROM $t_cart AS a, $t_goods AS b, $t_shop_info as c WHERE a.goods_id=b.goods_id AND b.shop_id=c.shop_id AND a.user_id=$user_id order by c.shop_id desc,a.add_time desc";
$row=$dbo->getRow($sql);

$shoparray=array();
if(!empty($result['result'])){
	foreach ($result['result'] as $k=>$v){
		foreach ($v as $ke=>$va){
			if($ke=="shop_id"){
				$shoparray[$k]=$va['shop_id'];
			}
		}

	}
}
//print_r($result);
//exit;
$shoparray=array_unique($shoparray);
?>