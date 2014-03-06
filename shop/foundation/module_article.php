<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
/* 文章信息 */
function get_article_info(&$dbo,$table,$article_id){
	$sql = "SELECT * FROM `$table` WHERE is_show=1 and article_id='$article_id'";
	return $dbo->getRow($sql);
}
/* 文章信息翻页 */
function get_flip_info(&$dbo,$table,$article_id,$type){
	if ($type == 'up'){
		$sql="SELECT * FROM $table WHERE article_id < $article_id ORDER BY article_id DESC LIMIT 1";
		return $dbo->getRow($sql);
	}else if($type == 'down'){
		$sql="SELECT * FROM $table WHERE article_id > $article_id ORDER BY article_id ASC LIMIT 1";
		return $dbo->getRow($sql);
	}
}
/* header信息 */
function get_header_info($header_info){
	$header = array();
	if (is_array($header_info)){
		$header['title'] = $header_info['title'];
		$header['keywords'] = $header_info['title'];
		$header['description'] = sub_str(strip_tags($header_info['content']),100);
	}else {
		$header['title'] = $header_info;
		$header['keywords'] = $header_info;
		$header['description'] = sub_str(strip_tags($header_info),100);
	}
	return $header;
}
/* 文章信息列表 */
function get_article_list(&$dbo,$table,$cat_id,$page){
	$sql = "SELECT * FROM `$table` WHERE is_show=1 and cat_id='$cat_id' order by add_time desc ";
	return $dbo->fetch_page($sql,$page);
}
?>