<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入公共方法
function  get_tag_info(&$dbo,$tag_table,$goods_table,$tag_id){
	$info=array();
	$sql="SELECT t.*,g.goods_id,g.goods_name FROM $tag_table AS t,$goods_table AS g WHERE t.tag_id='$tag_id' AND t.goods_id=g.goods_id";
	$info = $dbo->getRow($sql);
	return $info;
}
function  get_tag_list(&$dbo,$tag_table,$limit='',$goods_id=''){
	$sql="SELECT * FROM $tag_table ";
	if ($goods_id) {
		$sql.="WHERE goods_id='$goods_id'";
	}else{
		$sql.="WHERE is_recommend=1";
	}
	$sql.=" group by tag_name ";
	$sql.=" ORDER BY short_order ASC,tag_num DESC";
	if($limit){
		$sql.=" limit $limit";
	}
	$list = array();
	$list = $dbo->getRs($sql);
	foreach ($list as $k=>$v){
		$list[$k]['url']="search.php?k=".urlencode($v['tag_name']);
		$tag_num_sql = "select count(tag_name) as num from `$tag_table` where tag_name='$v[tag_name]'";
		$tag_num = $dbo->getRs($tag_num_sql);
		$list[$k]['tag_num'] = $tag_num;
	}
	return $list;
}
function insert_tag_info(&$dbo,$table,$t_tag_user,$insert_items,$user_id){
	$item_sql = get_insert_item($insert_items);
	$sql = "insert `$table` $item_sql";
	if($dbo->exeUpdate($sql)) {
		$tagid = mysql_insert_id();
		if ($tagid){
			$time = new time_class();
			$add_time = $time->long_time();
			$post_tag_user = array(
				'tag_id' => $tagid,
				'user_id' => $user_id,
				'add_time' => $add_time,
			);
			return insert_tag_user_info($dbo,$t_tag_user,$post_tag_user);
		}
	} else {
		return false;
	}
}
function insert_tag_user_info(&$dbo,$table,$insert_items){
	$item_sql = get_insert_item($insert_items);
	$sql = "insert `$table` $item_sql";
	if($dbo->exeUpdate($sql)) {
		return mysql_insert_id();
	} else {
		return false;
	}
}
function update_tag_info(&$dbo,$table,$update_items,$tag_id){
	$item_sql = get_update_item($update_items);
	$sql = "update `$table` set $item_sql where tag_id='$tag_id'";
	return $dbo->exeUpdate($sql);
}

?>