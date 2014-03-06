<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

// require("../foundation/module_areas.php");
require_once("../foundation/module_admin_logs.php");
//语言包引入
$a_langpackage=new adminlp;

/* post 数据处理 */

$int_id = short_check(get_args('id'));
$POST['int_grade'] = short_check(get_args('credit_grade'));
$POST['int_min'] = short_check(get_args('credit_min'));
$POST['int_max'] = short_check(get_args('credit_max'));
$POST['int_img'] = short_check(get_args('credit_img_old'));

//数据表定义区
$t_integral = $tablePreStr."integral";
$t_admin_log = $tablePreStr."admin_log";
//权限管理
$credit_update=check_rights("credit_update");
if(!$credit_update){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}
//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

$sql = "select * from $t_integral where int_grade={$POST['int_grade']}";
$row = $dbo->getRow($sql);
if($row){
	action_return(0,$a_langpackage->a_dengji,'-1');
}
$cupload = new upload('jpg|gif|png',2048,'credit_img');
$cupload->set_dir("../uploadfiles/credit/","{y}/{m}/{d}");
$file = $cupload->execute();
if($file) {
	$file[0]['dir'] = str_replace("../","./",$file[0]['dir']);
	$POST['int_img'] = $file[0]['dir'].$file[0]['name'];
}
		
if(get_args('id')){
	$sql = "update `$t_integral` set int_grade = {$POST['int_grade']},int_min = '{$POST['int_min']}',int_max = '{$POST['int_max']}',int_img = '{$POST['int_img']}' where int_id= $int_id ";

	$upd_suc=$dbo->exeUpdate($sql);
	if($upd_suc) {
		/** 添加log */
		$admin_log =$a_langpackage->a_integral_edit_log;
		admin_log($dbo,$t_admin_log,$admin_log);
		action_return(1,$a_langpackage->a_upd_suc,'m.php?app=sys_integral');
	}else {
		action_return(0,$a_langpackage->a_upd_lose,'-1');
	}

}else{

	$sql = "insert into `$t_integral` (int_grade,int_min,int_max,int_img)values({$POST['int_grade']},'{$POST['int_min']}','{$POST['int_max']}','{$POST['int_img']}')";

	$ins_suc=$dbo->exeUpdate($sql);

	if($ins_suc) {
		/** 添加log */
		$admin_log =$a_langpackage->a_integral_add_log;
		admin_log($dbo,$t_admin_log,$admin_log);

		action_return(1,$a_langpackage->a_upd_suc,'m.php?app=sys_integral');
	} else {
		action_return(0,$a_langpackage->a_upd_lose,'-1');
	}
}

		
	
?>