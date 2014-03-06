<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require_once("../foundation/module_news.php");
require_once("../foundation/module_admin_logs.php");
//语言包引入
$a_langpackage=new adminlp;

//权限管理
$right=check_rights("word_edit");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}
$ctime = new time_class;

/* post 数据处理 */
$word_id = intval(get_args('word_id'));
$word_name = short_check(get_args('word_name'));
$content= big_check(get_args('content'));

//数据表定义区
$t_word = $tablePreStr."word";

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

$sql="update $t_word set word_name='$word_name',content='$content' where word_id=$word_id";

if($dbo->exeUpdate($sql)) {
	action_return(1,$a_langpackage->a_amend_suc,'m.php?app=word_edit&id='.$word_id);
} else {
	action_return(0,$a_langpackage->a_amend_lose,'-1');
}
?>