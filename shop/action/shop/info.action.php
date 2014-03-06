<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
require("foundation/module_shop.php");
require_once("foundation/asystem_info.php");
//语言包引入
$m_langpackage=new moduleslp;
//print_r($_POST);
//exit;
//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();

//定义文件表
$t_shop_info = $tablePreStr."shop_info";
$t_users = $tablePreStr."users";
$t_user_rank = $tablePreStr."user_rank";
$t_word= $tablePreStr."word";
$t_shop_categories = $tablePreStr."shop_categories";
$user_id = get_sess_user_id();
// 处理post变量

$post['shop_name'] = short_check1(get_args('shop_name'));
//判断商铺名称是否重复
$sql = "select * from $t_shop_info where shop_name='{$post['shop_name']}' and user_id<>'$user_id'";
$array = $dbo->getRs($sql);
if($array){
	action_return(0, $m_langpackage->m_shop_yes,'-1');
}
$post['shop_address'] = long_check(get_args('shop_address'));
$post['shop_template'] = short_check(get_args('shop_template'));
$post['shop_country'] = intval(get_args('country'));
$post['shop_province'] = intval(get_args('province'));
$post['shop_city'] = intval(get_args('city'));
$post['shop_district'] = intval(get_args('district'));
$post['shop_intro'] = big_check(get_args('shop_intro'));
//判断是否有敏感词
$sql="select * from $t_word";
$row = $dbo->getRs($sql);
if($row){
	foreach ($row as $v){
		if(stristr($post['shop_name'],$v['word_name'])){
			action_return(0, $m_langpackage->m_shop_no.$v['word_name'],'-1');
		}
		if(stristr($post['shop_intro'],$v['word_name'])){
			action_return(0, $m_langpackage->m_shop_intro_no.$v['word_name'].",".$m_langpackage->m_shop_intro_back1,'-1');
		}
	}
}
$post['shop_management'] = short_check(get_args('shop_management'));
$post['map_x'] = short_check(get_args('now_x'));
$post['map_y'] = short_check(get_args('now_y'));
$post['map_zoom'] = short_check(get_args('now_zoom'));
$shop_id = intval(get_args('shop_id'));

$post['shop_categories'] =short_check(get_args('categories'));
if($post['shop_categories']==0)
	$post['shop_categories'] =short_check(get_args('categories_parent'));

//$post['shop_categories'] = short_check(get_args('categories'));

if($SYSINFO['sys_domain']==1){
	$user_id = get_sess_user_id();
	$sql = "select ur.privilege from $t_users as u join $t_user_rank as ur on u.rank_id = ur.rank_id where u.user_id = '$user_id'";
	$user_rank = $dbo->getRow($sql);
	$privilege = unserialize($user_rank['privilege']);
	$flag ='0';
	foreach ($privilege as $key =>$vlaue){
		if ($key =='10'){
			$flag ='1';
		}
	}
	if($flag=='1'){
		$post['shop_domain'] = short_check(get_args('shop_domain'));
		if(isset($post['shop_domain']) ){
			if($post['shop_domain']=='www'){
				action_return(0,'该域名格式不正确!','-1');
			}
			
			$is_shop_domain = check_shop_domain($dbo,$t_shop_info,$shop_id,$post['shop_domain']);
			if($is_shop_domain[0] > 0){
				action_return(0,'该域名已存在，请重新输入！','-1');
			}
		}
	}
}


$rank = intval(get_args('rank'));

if ($rank){
	$rank1 = intval(get_args('rank1'));
	if ($rank1){
		$rank2 = intval(get_args('rank2'));
		if ($rank2){
			$rank3 = intval(get_args('rank3'));
			if ($rank3){
				$rank4 = intval(get_args('rank4'));
				if ($rank4){
					$post['shop_categories'] = $rank4;
				}else {
					$post['shop_categories'] = $rank3;
				}
			}else {
				$post['shop_categories'] = $rank2;
			}
		}else {
			$post['shop_categories'] = $rank1;
		}
	}else {
		$post['shop_categories'] = $rank;
	}
}



$upload_1 = new upload('jpg|gif|png',1024,'attach_images');
$upload_1->set_dir("uploadfiles/","shop/{y}/{m}/{d}");
$file_1 = $upload_1->execute();
if($file_1 && $file_1[0]['flag']==1) {
	$post['shop_images'] = $file_1[0]['dir'].$file_1[0]['name'];
}

$upload_2 = new upload('jpg|gif|png',1024,'attach_logo');
$upload_2->set_dir("uploadfiles/","shop/{y}/{m}/{d}");
$file_2 = $upload_2->execute();
if($file_2 && $file_2[0]['flag']==1) {
	$post['shop_logo'] = $file_2[0]['dir'].$file_2[0]['name'];
}

$upload_3 = new upload('jpg|gif|png',1024,'attach_template');
$upload_3->set_dir("uploadfiles/","shop/{y}/{m}/{d}");
$file_3 = $upload_3->execute();
if($file_3 && $file_3[0]['flag']==1) {
	$post['shop_template_img'] = $file_3[0]['dir'].$file_3[0]['name'];
}

if(update_shop_info($dbo,$t_shop_info,$post,$shop_id)) {
	$sql = "update $t_shop_categories set shops_num=shops_num+1 where cat_id={$post['shop_categories']}";
	$dbo->exeUpdate($sql);
	action_return(1,$m_langpackage->m_edit_success);
} else {
	action_return(0,$m_langpackage->m_edit_fail,'-1');
}
exit;
?>