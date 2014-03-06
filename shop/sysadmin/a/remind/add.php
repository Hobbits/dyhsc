<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require_once("../foundation/module_news.php");
require_once("../foundation/module_admin_logs.php");
//语言包引入
$a_langpackage=new adminlp;

//权限管理
$right=check_rights("remind_add");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}
/* post 数据处理 */
$nowtime = $ctime->long_time();
$post['remind_info'] = short_check(get_args('remind_info'));
$post['user_id'] = '0';
$post['isread'] = '2';
$post['remind_time'] = $nowtime;

//数据表定义区
$t_remind_info = $tablePreStr."remind_info";
//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

$article_id = insert_news_info($dbo,$t_remind_info,$post);

if($article_id) {
	action_return(1,$a_langpackage->a_add_suc,"m.php?app=message_list");
} else {
	action_return(0,$a_langpackage->a_add_lose,'-1');
}
?>