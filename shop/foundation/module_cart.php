<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
/* 我的购物车 */
function get_cart_info(&$dbo,$t_cart,$t_goods,$t_shop_info,$user_id,$page){
	$sql = "SELECT c.user_id,a.goods_id,a.cart_id,a.add_time,a.goods_number,b.shop_id,b.goods_name,b.goods_thumb,b.goods_price,b.favpv,c.shop_name,c.shop_id,c.lock_flg,c.open_flg FROM `$t_cart` AS a, `$t_goods` AS b, `$t_shop_info` as c WHERE a.goods_id=b.goods_id AND b.shop_id=c.shop_id AND a.user_id='$user_id'";
	$sql .= " order by c.shop_id desc,a.add_time desc";
	return $dbo->fetch_page($sql,$page);
}
/* 用户不存在时购物车 */
function get_cart_session(&$dbo,$t_goods,$t_shop_info,$goods_ids,$page){
	$sql = "SELECT c.user_id,b.shop_id,b.goods_id,b.goods_name,b.goods_thumb,b.goods_price,b.favpv,c.shop_name,c.shop_id,c.lock_flg,c.open_flg FROM `$t_goods` AS b, `$t_shop_info` as c WHERE b.shop_id=c.shop_id AND b.goods_id IN $goods_ids";
	$sql .= " order by b.goods_id desc";
	return $dbo->fetch_page($sql,$page);
}

?>