<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require("../foundation/module_areas.php");
require("../foundation/module_admin_logs.php");
//语言包引入
$a_langpackage=new adminlp;
//权限管理
$right=check_rights("area_del");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}
/* post 数据处理 */
$id = short_check(get_args('id'));
//$POST['area_type'] = short_check(get_args('area_type'));
//if(get_args('name')){
//	$POST['area_name'] = short_check(get_args('name'));
//}elseif(get_args('area_name')){
//	$POST['area_name'] = short_check(get_args('area_name'));
//}

//数据表定义区
$t_areas = $tablePreStr."areas";
$t_admin_log = $tablePreStr."admin_log";

$dbo=new dbex;
dbtarget('r',$dbServs);
$areas_info = get_all_areas($dbo,$t_areas);
$del_id = $id.getalldelid($id);

//定义写操作
dbtarget('w',$dbServs);
$ins_suc=del_area($dbo,$t_areas,$del_id);
if($ins_suc) {
	/** 添加log */
	$admin_log =$a_langpackage->a_area_directory_del;//"删除地域管理目录";
	admin_log($dbo,$t_admin_log,$admin_log);

	action_return(1,$a_langpackage->a_del_suc,'-1');
} else {
	action_return(0,$a_langpackage->a_del_lose,'-1');
}

function getalldelid($id) {
	global $areas_info;
	$str = '';
	foreach($areas_info as $v) {
		if($v['parent_id']==$id) {
			$str .= ','.$v['area_id'];
			$str .= getalldelid($v['area_id']);
		}
	}
	return $str;
}
?>