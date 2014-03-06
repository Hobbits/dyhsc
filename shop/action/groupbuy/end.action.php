<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
require 'foundation/module_groupbuy.php';

//语言包引入
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();

//定义文件表
$t_groupbuy = $tablePreStr."groupbuy";

/* post 数据处理 */
$group_id = intval(get_args('id'));
$post['recommended']='1';

//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();

$sql = "select examine from $t_groupbuy where group_id = $group_id";
$row = $dbo->getRow($sql);
if($row['examine']==0)
	action_return(0,$i_langpackage->i_groupbuy_lock,'-1');

$suc=update_groupbuy_release($dbo,$t_groupbuy,$post,$group_id);

if($suc) {
	action_return(1,$m_langpackage->m_edit_success,'-1');
} else {
	action_return(0,$m_langpackage->m_edit_fail,'-1');
}

exit;
?>