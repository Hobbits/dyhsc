<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require("foundation/acheck_shop_creat.php");
require("foundation/module_goods.php");
require("foundation/module_gallery.php");

//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
$s_langpackage=new shoplp;
//数据表定义区
$t_goods = $tablePreStr."goods";
$t_goods_gallery = $tablePreStr."goods_gallery";
$t_users = $tablePreStr."users";
$goods_id = intval(get_args('id'));
if(!$goods_id) {
	trigger_error($m_langpackage->m_handle_err);
}

//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);
//判断商品是否锁定
include("foundation/fgoods_locked.php");
//判断用户是否锁定，锁定则不许操作
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	trigger_error($m_langpackage->m_user_locked);//非法操作
}
// 判断用户操作的是自己店铺下的商品。
$goods_info = get_goods_info($dbo,$t_goods,'is_set_image',$goods_id,$shop_id);
if(empty($goods_info)) { trigger_error($m_langpackage->m_handle_err);}

$gallery_list = get_gallery_list($dbo,$t_goods_gallery,$goods_id);

?>