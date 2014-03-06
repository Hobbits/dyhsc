<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

function insert_order_info(&$dbo,$table,$insert_items) {
	$item_sql = get_insert_item($insert_items);
	$sql = "insert into `$table` $item_sql ";
	//echo $sql;
	return $dbo->exeUpdate($sql);
	//exit;
	//echo mysql_insert_id();
	//return mysql_insert_id();
}

function get_order_info(&$dbo,$table,$t_order_goods,$t_goods,$t_shop_info,$order_id,$user_id=0,$shop_id=0) {
	$sql="select * from `$table` where order_id='$order_id' ";
	if($user_id) {
		$sql .= " and user_id='$user_id'";
	}
	if($shop_id) {
		$sql .= " and shop_id='$shop_id'";
	}
	$v = $dbo->getRow($sql);
	if(!$v){
		return false;
	}
	$sql = "select og.goods_id,og.goods_price,og.order_num,og.goods_name,og.id,
		b.goods_thumb,c.user_id,c.shop_name from `$t_goods` as b,
		`$t_shop_info` as c,`$t_order_goods` AS og where og.goods_id=b.goods_id AND og.order_id='{$v['order_id']}'AND c.shop_id='{$v['shop_id']}'";
	$list = $dbo->getRs($sql);
	$v['order_goods']=$list;
	return $v;
}

function get_order_info_bypayid(&$dbo,$table,$payid) {
	$sql="select * from `$table` where payid='$payid' ";
//	if($user_id) {
//		$sql .= " and user_id='$user_id'";
//	}
//	echo $sql;
	return $dbo->getRow($sql);
}

function get_order_info_by_order_id(&$dbo,$table,$order_id) {
	$sql="select * from `$table` where order_id='$order_id' ";
	return $dbo->getRow($sql);
}

function get_order_info_orderstatus(&$dbo,$table) {
	$sql="select * from `$table` where order_status='1'";
//	echo $sql;
	return $dbo->getRow($sql);
}

function get_order_info_list(&$dbo,$table){
	$sql = "select * from $table";
//	echo $sql;
	return $dbo->getRs($sql);
}

function upd_order_info(&$dbo,$table,$update_items,$order_id) {
	$item_sql = get_update_item($update_items);
	$sql = "update `$table` set $item_sql where order_id='$order_id'";
//	echo $sql;
	return $dbo->exeUpdate($sql);
}
/* 收到的订单 */
function get_myoder_list(&$dbo,$t_order_info,$t_order_goods,$t_goods,$t_shop_info,$id,$page,$type,$state,$t_users){
	$list=array();
	if ($type =='shop'){
		$str="";
		if(!empty($state)){
			switch ($state){
				case 1:
					$str.=" and order_status=1 ";break;
				case 2:
					$str.=" and order_status=2 ";break;
				case 3:
					$str.=" and pay_status=0 ";break;
				case 4:
					$str.=" and pay_status=1 ";break;
				case 5:
					$str.=" and transport_status=0 ";break;
				case 6:
					$str.=" and transport_status=1 ";break;
				case 7:
					$str.=" and order_status=3 ";break;
				case 8:
					$str.=" and transport_status=0 and pay_status=1 ";break;
				case 9:
					$str.=" and order_status=3 and seller_reply='0' ";break;
			}
		}
		$sql="SELECT * FROM $t_order_info WHERE shop_id='$id' ".$str." ORDER BY order_time DESC"; 
		$list = $dbo->fetch_page($sql,$page);
		foreach ($list['result'] as $k=>$v){
			$sql = "select og.order_id,og.goods_id,b.goods_thumb,og.id,b.lock_flg,c.user_id,c.shop_name,b.goods_name,c.shop_id from  `$t_goods` as b, `$t_shop_info` as c,`$t_order_goods` AS og where og.order_id='{$v['order_id']}' and og.goods_id=b.goods_id and c.shop_id='{$v['shop_id']}'";
			$rs = $dbo->getRs($sql);
			$list['result'][$k]['order_goods']=$rs;
			$sql = "SELECT user_name FROM  $t_users   WHERE user_id='{$v['user_id']}'";

			$rs = $dbo->getRs($sql);
			$list['result'][$k]['dname']=$rs[0];
		}
	}else if($type == 'groupbuy') {
		$sql="SELECT * FROM $t_order_info WHERE group_id='$id'  ORDER BY order_time DESC";
		$list = $dbo->fetch_page($sql,$page);
		foreach ($list['result'] as $k=>$v){
			$sql = "select og.order_id,og.goods_id,b.goods_thumb,og.id,b.lock_flg,c.user_id,c.shop_name,b.goods_name,c.shop_id from `$t_order_goods` as og, `$t_goods` as b, `$t_shop_info` as c where og.order_id='{$v['order_id']}' and og.goods_id=b.goods_id and c.shop_id='{$v['shop_id']}'";
			$rs = $dbo->getRs($sql);
			$list['result'][$k]['order_goods']=$rs;
			$sql = "SELECT user_name FROM  $t_users   WHERE user_id='{$v['user_id']}'";
			$rs = $dbo->getRs($sql);
			$list['result'][$k]['dname']=$rs[0];
		}
	}
	return $list;
}

?>