<?php
//获取首页图片
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//定义文件表
$t_index_images = $tablePreStr."index_images";
 /* 数据库操作 */
	dbtarget('r',$dbServs);
	$dbo=new dbex();

/* 轮显图片 */
$sql_images = "select id,images_url,images_link from `$t_index_images` where `status`=1 order by id asc limit 6";
$images_info = $dbo->getRs($sql_images);
$callback = isset( $_GET[ 'callback' ] ) ? $_GET[ 'callback' ] : 'callback';
$name = array('id','images_url','images_link');

if($images_info) {
	foreach ($images_info as $image){
		foreach ($name as $a) {
			if($a == 'images_url'){
				$return[$image['id']][$a] = str_replace('./',' ',$image[$a]);
			}else{
				$return[$image['id']][$a] = $image[$a];
			}
		}
	}
	if ($return){
		foreach ($return as $value){
			$result[] = $value;
		}
	}
	if ($result){
		$re = new returnobj('ok',$result);
		$r =  $callback . '(' . json_encode( $re ) . ')';
		print_r($r);
	}

}else{
	$re = new returnobj('ok','');
	$r =  $callback . '(' . json_encode( $re ) . ')';
	print_r($r);	
}
?>