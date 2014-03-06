<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
require("foundation/module_goods.php");
require("foundation/module_shop.php");

//语言包引入
$m_langpackage=new moduleslp;

//定义文件表
$t_goods = $tablePreStr."goods";
$t_users = $tablePreStr."users";
$t_shop_info=$tablePreStr."shop_info";
$t_goods_gallery = $tablePreStr."goods_gallery";
$t_img_size=$tablePreStr."img_size";

$id = intval(get_args('id'));
//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();
//判断用户是否锁定，锁定则不许操作
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	trigger_error($m_langpackage->m_user_locked);//非法操作
}

//判断sessionid和userid是不是同一个，如果不是则不需删除
$sql = "select shop_id from $t_goods where goods_id='$id'";
$rs = $dbo->getRow($sql);
if($rs['shop_id'] != get_sess_user_id()){
	action_return(1,$m_langpackage->m_not_del,'-1');
}

//删除img_size和goods_gallery中的数据
$sql = "select * from $t_goods_gallery where goods_id=$id ";
$row = $dbo->getRs($sql);
$count_imgsize='';
foreach($row as $v){
	if($v['goods_id']==$id){
		$img_size_id = $v['img_size_id'];
		$sql = "select * from $t_img_size where id='$img_size_id' ";
		$rs = $dbo->getRow($sql);
		$count_imgsize.=$rs['img_size'];
		$sql = "delete from `$t_img_size` where id='$img_size_id'";
		if($dbo->exeUpdate($sql)){
			//删除图片
			@unlink($v['img_url']);
			@unlink($v['thumb_url']);
			@unlink($v['img_original']);
		}
	}
	$img_id = $v['img_id'];
	$sql = "delete from `$t_goods_gallery` where img_id='$img_id'";
	$dbo->exeUpdate($sql);
}
//将shop-info表中的数据更新
$row=get_shop_info($dbo,$t_shop_info,$shop_id);
$goods_num=$row['goods_num']-1;
$count_imgsize = $row['count_imgsize'] - $count_imgsize;
$sql="update $t_shop_info set goods_num=$goods_num ,count_imgsize=$count_imgsize where shop_id=$shop_id";
$dbo->exeUpdate($sql);
//最后删除goods表中的数据
if(delete_goods($dbo,$t_goods,$id,$shop_id)) {
	action_return(1,$m_langpackage->m_delgoods_success);
} else {
	action_return(0,$m_langpackage->m_delgoods_fail,'-1');
}
exit;
?>