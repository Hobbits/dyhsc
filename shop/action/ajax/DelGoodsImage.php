<?php
/** 删除商品简介图片 */

if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

$id=intval(get_args("iid"));
$path=short_check(get_args("path"));

$t_img_size=$tablePreStr."img_size";
$t_shop_info=$tablePreStr."shop_info";
$t_goods_gallery = $tablePreStr."goods_gallery";


//定义操作
dbtarget('w',$dbServs);
$dbo=new dbex;
//查询出img_size表中该图片的大小
$sql1 = "select img_size,img_url from `$t_img_size` where id=$id and uid=$user_id";
$row = $dbo->getRow($sql1);
if($row){
	$size = $row['img_size'];
	$name = $row['img_url'];
	//根据$t_img_size 的id查询出$t_goods_gallery表中的数据
	$sql = "select * from `$t_goods_gallery` where img_size_id=$id";
	$rs = $dbo->getRow($sql);
	if($rs){
	
		//删除$t_img_size和$t_goods_gallery表中的数据
		$img_id = $rs['img_id'];
		$sqla="delete from `$t_goods_gallery` where img_id=$img_id";
		$dbo->exeUpdate($sqla);
		
		//删除图片
		@unlink($rs['img_url']);
		@unlink($rs['thumb_url']);
		@unlink($rs['img_original']);
		
	}
	//然后更新将shop_info表中的总图片大小更新
	$sql2 = "update `$t_shop_info` set count_imgsize=(count_imgsize-$size) where user_id=$user_id";
	$dbo->exeUpdate($sql2);
	//删除$t_img_size表中的数据
	$sqls="delete from `$t_img_size` where id=$id";
	$update = $dbo->exeUpdate($sqls);
	if($update && file_exists($name)){
		@unlink($name); 
	}
	if($update){
		echo "1";
	}else{
		echo "0";
	}
}else{
	echo "0";
}
exit;
?>