<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//语言包引入
$a_langpackage=new adminlp;

//定义文件表
$t_shop_request = $tablePreStr."shop_request";

//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();

// 处理post变量
$post['company_name'] = short_check(get_args('company_name'));
$post['person_name'] = short_check(get_args('person_name'));
$post['credit_type'] = short_check(get_args('credit_type'));
$post['credit_num'] = short_check(get_args('credit_num'));
$post['company_area'] = short_check(get_args('company_area'));
$post['company_address'] = short_check(get_args('company_address'));
$post['zipcode'] = short_check(get_args('zipcode'));
$post['mobile'] = short_check(get_args('mobile'));
$post['telphone'] = short_check(get_args('telphone'));
$post['user_id'] = intval(get_args('uid'));
$request_id = intval(get_args('request_id'));
$uid=intval(get_args('uid'));
$post['add_time'] = $ctime->long_time();

// 图片上传处理
$cupload = new upload();
$cupload->set_dir("../uploadfiles/","shop/request/$uid");
$file = $cupload->execute();
if($file) {
	$post['credit_commercial'] = $file[0]['dir'].$file[0]['name'];
}

if($request_id) {
	$post['status'] = 0;
	$item_sql = get_update_item($post);
	$sql = "update `$t_shop_request` set $item_sql where request_id='$request_id'";
} else {
	$item_sql = get_insert_item($post);
	$sql = "insert `$t_shop_request` $item_sql";
}

if($dbo->exeUpdate($sql)) {
	action_return(1,$a_langpackage->a_put_suc,'m.php?app=shop_create&id='.$uid);
} else {
	action_return(0,$a_langpackage->a_put_lose,'-1');
}
?>