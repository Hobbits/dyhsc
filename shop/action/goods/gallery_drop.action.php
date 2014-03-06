<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require("foundation/module_goods.php");
require("foundation/module_gallery.php");

/* post 数据处理 */
$id = intval(get_args('id'));
$gid = intval(get_args('gid'));
$unset_image = intval(get_args('s'));

if(!$id || !$gid) {
	exit();
}

//数据表定义区
$t_goods = $tablePreStr."goods";
$t_goods_gallery = $tablePreStr."goods_gallery";
$t_shop_info=$tablePreStr."shop_info";
$t_img_size=$tablePreStr."img_size";

//定义写操作
dbtarget('r',$dbServs);
$dbo=new dbex;

$gallery_info = get_gallery_info($dbo,$t_goods_gallery,$gid,$id);
if(empty($gallery_info)) { exit(); }

$goods_info = get_goods_info($dbo,$t_goods,'is_set_image',$gid,$shop_id);
if(empty($goods_info)) { exit(); }

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;
//删除img_size表中的数据，先查询出
$sql = "select * from `$t_goods_gallery` where goods_id=$gid and img_id=$id";
$row = $dbo->getRow($sql);
$img_size = '';
if($row){
	$img_size_id = $row['img_size_id'];
	$sql = "select * from `$t_img_size` where id=$img_size_id";
	$rs = $dbo->getRow($sql);
	$count_imgsize = $rs['img_size'];
	$sql = "delete from `$t_img_size` where id='$img_size_id'";
	if($dbo->exeUpdate($sql)){
		//删除图片
		@unlink($row['img_url']);
		@unlink($row['thumb_url']);
		@unlink($row['img_original']);
	}
	//删除goods_gallery表中的数据
	$img_id = $row['img_id'];
	$sql = "delete from `$t_goods_gallery` where img_id='$img_id'";
	$dbo->exeUpdate($sql);
	
	//修改shop_info中的数据
	$sql="update $t_shop_info set count_imgsize=count_imgsize - $count_imgsize where shop_id=$shop_id";
	$dbo->exeUpdate($sql);
	if($unset_image==1) {
		update_goods_info($dbo,$t_goods,array('is_set_image'=>0,'goods_thumb'=>''),$gid,$shop_id);
	}
	echo '1';
}else{
	echo '0';
}
?>