<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入公共方法

function insert_goods_info (&$dbo,$table,$insert_items){
	$item_sql = get_insert_item($insert_items);
	$sql = "insert `$table` $item_sql";
	if($dbo->exeUpdate($sql)) {
		return mysql_insert_id();
	} else {
		return false;
	}
}

function update_goods_info(&$dbo,$table,$update_items,$goods_id,$shop_id) {
	$item_sql = get_update_item($update_items);
	$sql = "update `$table` set $item_sql where goods_id='$goods_id' and shop_id='$shop_id'";
	return $dbo->exeUpdate($sql);
}

function get_goods_info(&$dbo,$table,$select_items,$goods_id,$shop_id=0) {
	$item_sql = get_select_item($select_items);
	if($shop_id) {
		$sql = "select $item_sql from `$table` where goods_id='$goods_id' and shop_id='$shop_id'";
	} else {
		$sql = "select $item_sql from `$table` where goods_id='$goods_id'";
	}

	return $dbo->getRow($sql);
}

function get_goods_num(&$dbo,$table,$shop_id=0) {
	if($shop_id) {
		$sql = "select count(*) from `$table` where shop_id='$shop_id'";
	} else {
		$sql = "select count(*) from `$table`";
	}
	$count = $dbo->getRow($sql);
	return $count[0];
}

function get_goods_openflg(&$dbo,$table,$ship_id) {
	$sql="select open_flg from `$table` where shop_id=$ship_id";
	$count = $dbo->getRow($sql);
	return $count[0];
}

function get_goods_isname_num(&$dbo,$table,$shop_id=0,$isname) {
	//	if($shop_id) {
	$sql = "select count(*) from `$table` where shop_id='$shop_id' and is_".$isname."=1";
	//		echo $sql;
	//	} else {
	//		$sql = "select count(*) from `$table`";
	//	}
	$count = $dbo->getRow($sql);
	return $count[0];
}

function delete_goods(&$dbo,$table,$goods_id,$shop_id) {
	$sql = "delete from `$table` where goods_id='$goods_id' and shop_id='$shop_id'";
	return $dbo->exeUpdate($sql);
}

function delete_onegoods(&$dbo,$table,$goods_id) {
	$sql = "delete from `$table` where goods_id='$goods_id'";
	return $dbo->exeUpdate($sql);
}

function get_goods_attr(&$dbo,$table,$goods_id) {
	$sql = "select * from `$table` where goods_id='$goods_id'";
	return $dbo->getRs($sql);
}

function get_isname_num(&$dbo,$table,$shop_id) {
	$sql = "select goods_id,is_best,is_new,is_hot,is_promote from `$table` where shop_id='$shop_id'";
	return $dbo->getRs($sql);
}

function update_goods_attr(&$dbo,$table,$array,$goods_id) {
	if(empty($array)) {
		return false;
	}
	$i = 0;
	foreach($array as $key=>$value) {
		if(is_array($value)) {
			$value = implode("\n",$value);
		}
		$sql = "update `$table` set attr_values='$value' where goods_id='$goods_id' and attr_id='$key'";
		//echo $sql;
		if($dbo->exeUpdate($sql)){
			$i++;
		}
	}
	return $i;
}

function insert_goods_attr(&$dbo,$table,$array,$goods_id) {
	if(empty($array)) {
		return false;
	}
	$dot = '';
	$sql = "insert into `$table` (goods_id,attr_id,attr_values) values";
	foreach($array as $key=>$value) {
		if($value) {
			if(is_array($value)) {
				$value = implode("\n",$value);
				$sql .= $dot . " ('$goods_id','$key','$value')";
				$dot = ',';
			} else {
				$sql .= $dot . " ('$goods_id','$key','$value')";
				$dot = ',';
			}
		}
	}
	return $dbo->exeUpdate($sql);
}

function delete_goods_attr(&$dbo,$table,$array,$goods_id) {
	if(empty($array)) {
		return false;
	}
	$attr_id = $dot = '';
	foreach($array as $k=>$v) {
		$attr_id .= $dot.$k;
		$dot = ',';
	}
	$sql = "delete from `$table` where attr_id in ($attr_id) and goods_id='$goods_id'";
	return $dbo->exeUpdate($sql);
}
function get_transport_template_list(&$dbo,$table,$shop_id=''){
	if (empty($shop_id)) {
		$shop_id = get_sess_shop_id();
	}

	$sql = "SELECT * FROM `$table` WHERE shop_id = '$shop_id' ORDER BY id DESC";
	return $dbo->getRs($sql);
}
function  update_default_transportprice(&$dbo,$goods_table,$transport_table,$goods_id){
	$sql="SELECT transport_template_id,is_transport_template,transport_price FROM `$goods_table` WHERE goods_id='$goods_id'";
	$goods_info = $dbo->getRow($sql);
	$default_price=0;
	if ($goods_info['is_transport_template']) {
		$sql="SELECT content FROM $transport_table WHERE id='{$goods_info['transport_template_id']}'";
		$transport_info = $dbo->getRow($sql);
		$transport_content = $transport_info['content'];
		$transport_arr = unserialize($transport_content);
		if (isset($transport_arr['ems'])) {
			$default_price = $transport_arr['ems']['frist'];
		}
		if (isset($transport_arr['pst'])) {
			$default_price = $transport_arr['pst']['frist'];
		}
		if (isset($transport_arr['ex'])) {
			$default_price = $transport_arr['ex']['frist'];
		}
	}else{
		$default_price=$goods_info['transport_price'];
	}
	$sql="UPDATE $goods_table SET transport_template_price='$default_price' WHERE goods_id='$goods_id'";
	return $dbo->exeUpdate($sql);
}
function get_shop_payment(&$dbo,$t_shop_payment,$t_payment,$shop_id){
	$sql = "SELECT b.pay_id,b.pay_code FROM $t_shop_payment AS a, $t_payment AS b WHERE a.pay_id=b.pay_id AND a.shop_id=$shop_id AND a.enabled=1";
	return $dbo->getRs($sql);
}
function export_csv_info(&$dbo,$table,$shop_id){
	$sql = "SELECT goods_id,goods_name FROM $table WHERE shop_id='$shop_id' ORDER BY goods_id DESC";
	return $dbo->getRs($sql);
}
function  get_goods_transport_price(&$dbo,$table,$area_id,$template_id,$arr_list,$goods_num=1){
	$sql = "SELECT content FROM $table WHERE id='$template_id'";
	$arr = $dbo->getRow($sql);
	$content = unserialize($arr['content']);
	foreach($arr_list as $v){
		$transport_price[$v['tranid']]=0;
	}
	if ($goods_num>1) {
		foreach ($arr_list as $val){
			if($content[$val['tranid']]['frist']!=0){
				if(empty($content[$val['tranid']][$area_id]['frist'])){
					$transport_price[$val['tranid']] = $content[$val['tranid']]['frist']+$content[$val['tranid']]['second']*($goods_num-1);
				}else{
					$transport_price[$val['tranid']] = $content[$val['tranid']][$area_id]['frist']+$content[$val['tranid']][$area_id]['second']*($goods_num-1);
				}
			}
		}
	}else{
		foreach ($arr_list as $val){
			if($content[$val['tranid']]['frist']!=0){
				if(empty($content[$val['tranid']][$area_id]['frist'])){
					$transport_price[$val['tranid']] = $content[$val['tranid']]['frist'];
				}else{
					$transport_price[$val['tranid']] = $content[$val['tranid']][$area_id]['frist'];
				}
			}
		}
	}
	return $transport_price;
}
/* 推荐商品 */
function get_hot_goods(&$dbo,$table,$limit){
	$sql = "SELECT * FROM $table WHERE is_on_sale=1 AND is_hot=1 and lock_flg=0 order by pv desc limit $limit";
	return $dbo->getRs($sql);
}
/* 浏览记录 */
function get_good_shistory(&$dbo,$getcookie,$table){
	arsort($getcookie);
	$getcookie = array_keys($getcookie);
	$gethisgoodsid = implode(",",array_slice($getcookie, 0, 4));
	$sql = "select is_set_image,goods_id,goods_name,goods_thumb,goods_price from $table where goods_id in ($gethisgoodsid)";
	return $dbo->getRs($sql);
}
/* 查看该商品的网店是否为锁定 */
function get_shop_lock_flag(&$dbo,$t_goods,$t_shop_info,$good_id){
	$sql = "select b.lock_flg from $t_goods as a,$t_shop_info as b where a.shop_id=b.shop_id and a.goods_id=$good_id";
	$result= $dbo->getRow($sql);
	if(isset($result))
	return $result[0];
	else
	return -1;
}
//获取商品的所有图片
function get_goods_pics(&$dbo,$t_goods_attachment,$good_id){
	$sql = "SELECT * FROM $t_goods_attachment WHERE goods_id=$good_id AND is_delete=1 ";
	return $dbo->getRs($sql);
}
//添加商品图片
function insert_goods_imgs(&$dbo,$table,$insert_items){
	$item_sql = get_insert_item($insert_items);
	$sql = "insert `$table` $item_sql";
	if($dbo->exeUpdate($sql)) {
		return mysql_insert_id();
	} else {
		return false;
	}
}
//商品主图
function is_goods_imgs(&$dbo,$table,$goodid){
	if ($goodid){
		$sql = "select * from $table  where goods_id=$goodid and main_img=1 and is_delete = 1";
		$result= $dbo->getRow($sql);
		if($result) {
			return $result;
		} else {
			return false;
		}
	}
}
//删除图片
function delimg(&$dbo,$table,$imgid){
	$sql = "delete from `$table` where aid='$imgid'";
	return $dbo->exeUpdate($sql);
}
//设置商品主图
function goodmakemain(&$dbo,$table,$goods_id,$imgid){
	$sql="UPDATE $table SET main_img='1' WHERE goods_id='$goods_id' and aid='$imgid' ";
	return $dbo->exeUpdate($sql);
}
//删除主图
function goodmovemain(&$dbo,$table,$goods_id,$imgid){
	$sql="UPDATE $table SET main_img='0' WHERE goods_id='$goods_id' and aid='$imgid' ";
	return $dbo->exeUpdate($sql);
}
?>