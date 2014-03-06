<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;
//
//if(!isset($user_privilege[1])) {
//	set_sess_err_msg($m_langpackage->m_error_createshop);
//	echo '<script language="JavaScript">location.href="modules.php?app=message"</script>';
//	exit;
//}

require("foundation/module_areas.php");
require("foundation/module_shop_category.php");

//数据表定义区
$t_areas = $tablePreStr."areas";
$t_shop_categories = $tablePreStr."shop_categories";

//读写分离定义方法
$dbo=new dbex;
dbtarget('r',$dbServs);

/* 初始化shopinfo */
$shop_info = array(
	'shop_name'		=> '',
	'shop_country'	=> 1,
	'shop_province'	=> 0,
	'shop_city'		=> 0,
	'shop_district'	=> 0,
	'shop_address'	=> '',
	'shop_images'	=> '',
	'shop_template'	=> 'default',
	'shop_intro'	=> '',
	'shop_management' => ''
);
$shop_categories_parent = get_categories_item_parentid($dbo,$t_shop_categories,0);
$areas_info = get_areas_info($dbo,$t_areas);

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