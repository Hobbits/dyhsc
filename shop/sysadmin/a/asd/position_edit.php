<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//语言包引入
$a_langpackage=new adminlp;

require_once("../foundation/module_asd.php");
require_once("../foundation/module_admin_logs.php");
//权限管理
$right=check_rights("adv_postion_update");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');	
}
/* post */
$post = array(
	'position_name'	=> short_check(get_args('position_name')),
	'asd_width'		=> intval(get_args('asd_width')),
	'asd_height'	=> intval(get_args('asd_height')),
	'position_desc'	=> long_check(get_args('position_desc')),
);
$position_id = intval(get_args('position_id'));

if(!$position_id) {
	action_return(0,$a_langpackage->a_error,'-1');
}
if(!$post['position_name']) {
	action_return(0,$a_langpackage->a_asdposition_null,'-1');
}

//数据表定义区
$t_asd_content = $tablePreStr."asd_content";
$t_asd_position = $tablePreStr."asd_position";
$t_admin_log = $tablePreStr."admin_log";
//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

if(update_asd_position_info($dbo,$t_asd_position,$post,$position_id)) {
	update_asd_position_file($dbo,$t_asd_content,$t_asd_position);
	admin_log($dbo,$t_admin_log,$a_langpackage->a_edit_adLocation."：$position_id");
	action_return(1,$a_langpackage->a_amend_suc,"m.php?app=asd_position_edit&id=".$position_id);
} else {
	action_return(0,$a_langpackage->a_edit_lose_repeat,'-1');
}
?>