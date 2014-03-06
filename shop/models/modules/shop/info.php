<?php

if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require("foundation/acheck_shop_creat.php");
require("foundation/module_areas.php");
require("foundation/module_shop.php");
require("foundation/module_users.php");
require("foundation/module_shop_category.php");
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

//数据表定义区
$t_areas = $tablePreStr."areas";
$t_shop_info = $tablePreStr."shop_info";
$t_users = $tablePreStr."users";
$t_privilege = $tablePreStr."privilege";
$t_user_rank = $tablePreStr."user_rank";
$t_shop_categories = $tablePreStr."shop_categories";

//读写分离定义方法
$dbo=new dbex;
dbtarget('r',$dbServs);

//判断用户是否锁定，锁定则不许操作
$sql ="select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if($row['locked']==1){
	session_destroy();
	trigger_error($m_langpackage->m_user_locked);//非法操作
}
$shop_info = get_shop_info($dbo,$t_shop_info,$shop_id);

$shop_rank = $shop_info['shop_categories'];

$user_id = get_sess_user_id();
$areas_info = get_areas_info($dbo,$t_areas);
$user_info = get_user_info($dbo,$t_users,$user_id);
//$s_categories_info = get_categories_info($dbo,$t_shop_categories);
$rank_info = get_userrank_info($dbo,$t_user_rank,$user_info['rank_id']);
//echo $user_info['rank_id'];exit();
//echo $rank_info['privilege'];exit();
$privilege = unserialize($rank_info['privilege']);
$shop_categories_parent = get_categories_item_parentid($dbo,$t_shop_categories,0);
$categories_parent = 0;
$categories_child = 0;
if(isset($shop_info['shop_categories'])){
	$shop_categories_info = get_categories_info_catid($dbo,$t_shop_categories,$shop_info['shop_categories']);
	if($shop_categories_info['parent_id'] == 0){
		$categories_parent = $shop_info['shop_categories'];
	} else {
		$categories_parent = $shop_categories_info['parent_id'];
		$categories_child = $shop_info['shop_categories'];
	}
}


//echo $shop_info['shop_categories'];
$flag ='0';
foreach ($privilege as $key =>$vlaue){
	if ($key =='10'){
		$flag ='1';
	}
}
$shoptemplate_arr[] = array(
	'imgurl' => 'skin/default/images/default_small.gif',
	'bigimgurl' => 'skin/default/images/default.gif',
	'tpltag' => 'default',
	'tplname' => $m_langpackage->m_default_template
);
$shoptemplate_arr[] = array(
	'imgurl' => 'skin/default/images/green_small.gif',
	'bigimgurl' => 'skin/default/images/green.gif',
	'tpltag' => 'green',
	'tplname' => $m_langpackage->m_green_template
);
$shoptemplate_arr[] = array(
	'imgurl' => 'skin/default/images/blue_small.gif',
	'bigimgurl' => 'skin/default/images/blue.gif',
	'tpltag' => 'blue',
	'tplname' => $m_langpackage->m_blue_template
);
$shoptemplate_arr[] = array(
	'imgurl' => 'skin/default/images/red_small.gif',
	'bigimgurl' => 'skin/default/images/red.gif',
	'tpltag' => 'red',
	'tplname' => $m_langpackage->m_red_template
);
$shoptemplate_arr[] = array(
	'imgurl' => 'skin/default/images/purple_small.gif',
	'bigimgurl' => 'skin/default/images/purple.gif',
	'tpltag' => 'purple',
	'tplname' => $m_langpackage->m_purple_template
);
$shoptemplate_arr[] = array(
	'imgurl' => 'skin/default/images/gray_small.gif',
	'bigimgurl' => 'skin/default/images/gray.gif',
	'tpltag' => 'gray',
	'tplname' => $m_langpackage->m_gray_template
);
?>