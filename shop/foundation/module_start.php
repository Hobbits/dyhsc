<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
/* 我的订单 */
function get_myorder_info(&$dbo,$t_order_info,$t_shop_info,$t_goods,$t_order_goods,$user_id,$state,$page) {
	$str="";
	if(!empty($state)){
			switch ($state){
				case 1:
					$str.=" and o.order_status=1 ";break;
				case 2:
					$str.=" and o.order_status=2 ";break;
				case 3:
					$str.=" and o.pay_status=0 ";break;
				case 4:
					$str.=" and o.pay_status=1 ";break;
				case 5:
					$str.=" and o.transport_status=0 ";break;
				case 6:
					$str.=" and o.transport_status=1 ";break;
				case 7:
					$str.=" and o.order_status=3 ";break;
				case 8:
					$str.=" and o.transport_status=1 and o.order_status<>3 ";break;
				case 9:
					$str.=" and o.buyer_reply='0' and o.order_status=3 ";break;
			}
		}
	$sql = "SELECT o.*,s.shop_name,s.shop_id,s.open_flg,s.lock_flg FROM $t_order_info AS o,$t_shop_info AS s WHERE o.user_id=$user_id AND o.order_status>0 AND o.shop_id=s.shop_id";
	$sql = $sql.$str." ORDER BY order_time DESC";
	$list =  $dbo->fetch_page($sql,$page);
	foreach ($list['result'] as $k=>$v){
		$sql = "select og.goods_id,og.goods_name,og.id,
		b.goods_thumb,c.user_id,c.shop_name,b.lock_flg from `$t_goods` as b,
		`$t_shop_info` as c,`$t_order_goods` AS og where og.goods_id=b.goods_id AND c.shop_id=og.shop_id AND og.order_id='{$v['order_id']}'AND c.shop_id='{$v['shop_id']}'";
		$goods_list = $dbo->getRs($sql);
		$list['result'][$k]['order_goods']=$goods_list;
	}
	return $list;
}
/* 我的收藏 */
function get_myfavorite_info(&$dbo,$t_user_favorite,$t_goods,$t_shop_info,$user_id,$page){
	$sql = "SELECT c.user_id,a.goods_id,a.favorite_id,a.add_time,b.shop_id,b.goods_name,b.goods_thumb,b.goods_price,b.favpv,c.shop_name,c.shop_id,c.lock_flg,c.open_flg FROM `$t_user_favorite` AS a, `$t_goods` AS b, `$t_shop_info` as c WHERE a.goods_id=b.goods_id AND b.shop_id=c.shop_id AND a.user_id='$user_id'";
	$sql .= " order by a.add_time desc";
	return $dbo->fetch_page($sql,$page);
}
/* 店铺收藏 */
function get_shop_favorite(&$dbo,$t_user_favorite,$t_shop_info,$user_id,$page){
	$sql = "select s.shop_id,s.shop_name,s.shop_logo,s.user_id,s.shop_intro,s.lock_flg,f.favorite_id,s.open_flg,s.lock_flg from $t_user_favorite as f left join $t_shop_info as s on f.shop_id = s.shop_id where f.user_id = '$user_id' and f.shop_id <> 0 ";
	return $dbo->fetch_page($sql,$page);
}
?>