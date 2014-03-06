<?php
	if(!$IWEB_SHOP_IN) {
		die('Hacking attempt');
	}
	/* 处理数据 */
	$id = intval(get_args('id'));
	$goods_id = short_check(get_args('goods_ids'));
	$godds_arr = explode(',',$goods_id);
	$goods = array();
	foreach($godds_arr as $value){
		if($value != $id){
			$goods[]=$value;
		}
	}
	$goods = implode(',',$goods);
	echo $goods;
?>