<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("../foundation/module_shop_category.php");
require_once("../foundation/module_admin_logs.php");
//语言包引入
$a_langpackage=new adminlp;

//权限管理
$right=check_rights("cat_update");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}
/* post 数据处理 */
$post['cat_name'] = short_check(get_args('cat_name'));
$post['parent_id'] = intval(get_args('parent_id'));
$post['sort_order'] = intval(get_args('sort_order'));

if(empty($post['cat_name'])) {
	action_return(0,$a_langpackage->a_class_null,'-1');
	exit;
}

$cat_id = intval(get_args('cat_id'));
if(!$cat_id) {trigger_error($a_langpackage->a_error);}

//数据表定义区
$t_shop_categories = $tablePreStr."shop_categories";
$t_admin_log = $tablePreStr."admin_log";

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

if(update_category_info($dbo,$t_shop_categories,$post,$cat_id)) {
	admin_log($dbo,$t_admin_log,$a_langpackage->a_edit_category."：$cat_id");
	action_return(1,$a_langpackage->a_amend_suc,'m.php?app=shop_categories_edit&id='.$cat_id);
} else {
	action_return(0,$a_langpackage->a_amend_lose,'-1');
}
?>