<?php
header("content-type:text/html;charset=utf-8");
$IWEB_SHOP_IN = true;
require("../foundation/asession.php");
require("../configuration.php");
require("includes.php");
//当前可访问的action动作,先列出公共部分,然后按各个模块列出
$actArray = array(
	'login'					=> array('a/login_act.php','index.php'),
	'logout'				=> array('a/logout_act.php','login.php'),
	'change_password'		=> array('a/admin/change_password.php'),
	'admin_add'				=> array('a/admin/add.php','m.php?app=admin_list'),
	'admin_del'				=> array('a/admin/del.php'),
	'group_del'				=> array('a/admin/group_del.php'),
	'tag_edit'				=> array("a/sys/tag_edit.php"),
	'tag_del'				=> array("a/sys/tag_del.php"),

	'member_info_edit'		=> array('a/member/info_edit.php'),
	'member_locked'			=> array('a/member/locked.php'),
	'member_locked_user'	=> array('a/member/locked_user.php'),
	'member_unlock'			=> array('a/member/unlock.php'),
	'member_rank_edit'		=> array('a/member/rank_edit.php'),
	'member_rank_add'		=> array('a/member/rank_add.php','m.php?app=member_rank'),
	'member_rank_del'		=> array('a/member/rank_del.php','m.php?app=member_rank'),

	'asd_position_add'		=> array('a/asd/position_add.php','m.php?app=asd_position_list'),
	'asd_position_del'		=> array('a/asd/position_del.php','m.php?app=asd_position_list'),
	'asd_position_edit'		=> array('a/asd/position_edit.php'),
	'asd_add'				=> array('a/asd/add.php','m.php?app=asd_list'),
	'asd_edit'				=> array('a/asd/edit.php'),
	'asd_del'				=> array('a/asd/del.php','m.php?app=asd_list'),
	

	'news_add'				=> array('a/news/add.php','m.php?app=news_list'),
	'news_edit'				=> array('a/news/edit.php'),
	'news_del'				=> array('a/news/del.php','m.php?app=news_list'),
	'news_catedit'			=> array('a/news/catedit.php','m.php?app=news_catlist'),
	'news_catdel'			=> array('a/news/catdel.php','m.php?app=news_catlist'),
	'news_catadd'			=> array('a/news/catadd.php','m.php?app=news_catlist'),

	'index_images_upload'	=> array('a/index/images_upload.php','m.php?app=index_images'),
	'index_images_del'		=> array('a/index/images_del.php','m.php?app=index_images'),

	'verifycode_status'		=> array('a/sys/verifycode_status.php'),
	'sys_setting_update'	=> array('a/sys/setting_update.php','m.php?app=sys_setting'),
	'searchkey_del'			=> array('a/sys/searchkey_del.php'),
	'sys_crons_del'			=> array('a/sys/crons_del.php'),
	'sys_crons_add'			=> array('a/sys/crons_add.php'),
	'sys_area_add'			=> array('a/sys/area_add.php'),
	'sys_area_del'			=> array('a/sys/area_del.php'),
	'sys_upd_integral'		=> array('a/sys/upd_integral.php'),
	'get_url_content'		=> array('a/sys/get_url_content.php'),
	'remind_upd'			=> array('a/remind/upd.php'),
	'remind_status_upd'		=> array('a/remind/status_upd.php'),
	'nav_add'				=> array("a/sys/nav_add.php"),
	'nav_edit'				=> array("a/sys/nav_edit.php"),
	'nav_del'				=> array("a/sys/nav_del.php"),
	'integral_add'			=> array("a/sys/integral_add.php"),
	'integral_del'			=> array("a/sys/integral_del.php"),
	'mailtpl_upd'			=> array('a/mailtpl/upd.php'),

	'goods_attr_edit'		=> array('a/goods/attr_edit.php'),
	'goods_attr_del'		=> array('a/goods/attr_del.php'),
	'goods_attr_extend'		=> array('a/goods/attr_extend.php'),
	'goods_brand_add'		=> array('a/goods/brand_add.php','m.php?app=goods_brand_list'),
	'brand_add'				=> array('a/goods/good_brand_add.php'),
	'goods_brand_edit'		=> array('a/goods/brand_edit.php'),
	'goods_brand_del'		=> array('a/goods/brand_del.php','m.php?app=goods_brand_list'),
	'goods_category_add'	=> array('a/goods/category_add.php','m.php?app=goods_category_list'),
	'goods_category_edit'	=> array('a/goods/category_edit.php'),
	'goods_category_del'	=> array('a/goods/category_del.php','m.php?app=goods_category_list'),
	'goods_update_keyword'	=> array('a/goods/update_keyword.php'),
	'goods_edit'			=> array('a/goods/edit.php'),
	'groupbuy_edit'			=> array('a/groupbuy/edit.php'),
	'flink_add'				=> array('a/goods/flink_add.php','m.php?app=flink_list'),
	'flink_edit'			=> array('a/goods/flink_edit.php','m.php?app=flink_list'),
	'flink_del'				=> array('a/goods/flink_del.php'),

	'complaint_type_edit'	=> array('a/complaint/type_edit.php'),
	'complaint_type_del'	=> array('a/complaint/type_del.php'),
	'complaint_del'			=> array('a/complaint/del.php'),

	'order_payment_edit'	=> array('a/order/payment_edit.php','m.php?app=order_payment'),
	'order_set_status'		=> array('a/order/set_status.php','m.php?app=order_alllist'),
	'close_protect_rights'	=> array('a/order/close_protect_rights.action.php'),
	'order_view'		=> array('a/order/view.php','m.php?app=order_alllist'),

	'shop_goodsdownsale'	=> array('a/shop/goodsdownsale.php','m.php?app=shop_list'),
	'shop_request'			=> array('a/shop/request.php','m.php?app=shop_request'),
	'lock_shop'				=> array('a/shop/lock_shop.php','m.php?app=shop_list'),
	'lock_goods'			=> array('a/goods/lock_goods.php','m.php?app=goods_list'),
	'lock_goods_user'		=> array('a/goods/lock_goods.php','m.php?app=complaint_list'),

	'unload_tool'			=> array('a/toolsbox/unload_tool.php'),
	'download_tool'			=> array('a/toolsbox/download_tool.php'),
	'shop_categories_add'   => array('a/shop/categories_add.php'),
	'shop_categories_edit'  => array('a/shop/categories_edit.php'),
	'shop_categories_del'  	=> array('a/shop/categories_del.php'),
	'categories_export'  	=> array('a/shop/categories_export.php'),
	'categories_import'  	=> array('a/shop/categories_import.php'),
	

	// ajax
	'news_isshow_toggle'	=> array('a/news/isshow_toggle.php'),
	'images_status_toggle'	=> array('a/index/status_toggle.php'),
	'goods_toggle'			=> array('a/goods/toggle.action.php'),
	'order_payment_toggle'	=> array('a/order/payment_toggle.action.php'),
	'tpl_ajax_comp'			=> array('a/sys/ajax_comp.php'),
	'group_edit'			=> array('a/admin/group_edit.php'),
	'group_update'			=> array('a/admin/group_update.php'),
	'user_check_useremail'  => array('a/member/check_useremail.php'),
	'get_cat_brand_list'	=> array('a/goods/get_cat_brand_list.php'),
	'upload_act'			=> array('a/pubtools/upload.action.php'),
    'sitemap'    			=> array('a/sys/sitemap.php'),
    'updateAjax' 			=> array('a/updateAjax.php'),
    'shopcommend' 			=> array('a/shop/shop_commend.php'),
	'asd_exits'				=> array('a/asd/asd.ajax.php'),
	'tagcommend' 			=> array('a/sys/tag_commend.php'),
	'word_add' 				=> array('a/sys/word_add.php'),
	'word_edit' 			=> array('a/sys/word_edit.php'),
	'word_del' 				=> array('a/sys/word_del.php'),
	'shop_add' 				=> array('a/shop/add.php'),
	'shop_create' 			=> array('a/shop/create.php'),
	'ajax_areas'			=> array('a/shop/areas.action.php'),
	'ajax_categori'			=> array('a/shop/shop_categories.action.php'),
	'ship_method_toggle'	=> array('a/shop/method_toggle.action.php'),
	'shop_method_add'	=> array('a/shop/method_add.php'),
	'shop_method_edit'	=> array('a/shop/method_edit.php'),
	'shop_edit'	=> array('a/shop/shop_edit.php'),
	'remind_add'	=> array('a/remind/add.php'),
	'remind_update'	=> array('a/remind/edit.php'),
	'remind_del'	=> array('a/remind/del.php'),
	'order_update'	=> array('a/order/update.php'),
);

$actId=getActId();
$acttarget=$actArray[$actId];

/* ajax请求时判断处理 */
$ajaxCheckArray = array('news_isshow_toggle','category_update_goodsnum','goods_toggle','get_url_content');
if(in_array($actId,$ajaxCheckArray)) {
	if(strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
		echo "<script>window.location='login.php'</script>";
		exit;
	}
}

$notCheckLoginArray = array('login','logout');
if(!in_array($actId,$notCheckLoginArray)) {
	/* do 公共信息处理 */
	$admin_id = $_SESSION['admin_id'];
	$admin_name = $_SESSION["admin_name"];

	/* 判断用户是否登陆 */
	if(!$admin_id) { echo("<script>window.location='login.php'</script>");exit; }
}

//action动作成功控制函数
function action_return($success=1,$return_mess="",$activeUrl=""){
 include("messagebox.php");
	global $acttarget;
	echo "<script language='javascript'>";
	$setUrl = '';
	if($activeUrl!=''){
		$setUrl = $activeUrl;
	} else {
		$setUrl = $acttarget[1];
	}
	if(trim($return_mess)!=''){
		echo "ShowMessageBox('$return_mess','$setUrl');";
	}else{
		echo "location.href='$setUrl'";
	}
	echo "</script>";
	exit();
}

if(isset($acttarget)) {
	require($acttarget[0]);
} else {
	trigger_error('no pages!');
}

?>