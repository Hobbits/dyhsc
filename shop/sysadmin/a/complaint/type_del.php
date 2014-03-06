<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require_once("../foundation/module_complaint.php");
//语言包引入
$a_langpackage=new adminlp;

//权限管理
$right=check_rights("del_complaint_title");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}
/* post 数据处理 */
$type_id=get_args('type_id');
if($type_id){
	if(!is_array($type_id)){
			$type_id=array(intval($type_id));
		}
	$type_id=implode(",", $type_id);
}else{
	$type_id = intval(get_args('id'));
}
if(!$type_id) {
	action_return(0,$a_langpackage->a_error,'-1');
}

//数据表定义区
$t_complaint_type = $tablePreStr."complaint_type";

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

	$sql = "delete from $t_complaint_type where type_id in($type_id)";

	if($dbo->exeUpdate($sql)) {
		action_return(1,$a_langpackage->a_del_suc,'m.php?app=complaint_type');
	} else {
		action_return(0,$a_langpackage->a_del_lose,'-1');
	}

?>