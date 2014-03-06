<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require_once("../foundation/module_admin_logs.php");
//语言包引入
$a_langpackage=new adminlp;

//权限管理
$right=check_rights("categories_del");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}


/* get */
$id = intval(get_args('id'));

if(!$id) {
	action_return(0,$a_langpackage->a_error,'-1');
}

//数据表定义区
$t_shop_categories = $tablePreStr."shop_categories";
$t_admin_log = $tablePreStr."admin_log";
//读写分离定义方法
$dbo = new dbex;
dbtarget('r',$dbServs);

/* 处理系统分类 */
$sql_category = "select * from `$t_shop_categories` where parent_id='$id'";
$result_category = $dbo->getRs($sql_category);
$ids = $id;
if($result_category) {
	foreach($result_category as $v) {
		$ids .= ",".$v['cat_id'];
	}
}

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

$sql = "delete from `$t_shop_categories` where cat_id in ($ids)";

if($dbo->exeUpdate($sql)) {
	admin_log($dbo,$t_admin_log,$a_langpackage->a_del_category."：$ids");
	action_return(1,$a_langpackage->a_del_suc,'m.php?app=shop_categories_list');
} else {
	action_return(0,$a_langpackage->a_del_lose,'-1');
}
?>