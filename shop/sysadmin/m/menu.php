<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//引入语言包
$t_plugin_url = $tablePreStr."plugin_url";
$a_langpackage=new adminlp;
$right_array=array(
    "site_set_browse"    =>"0",
    "image_browse"    =>   "0",
    "programme_browse"    =>   "0",
    "area_browse"    =>   "0",
    "pay_browse"    =>   "0",
    "keyword_browse"    =>   "0",
    "credit_browse"    =>   "0",
    "remind"    =>   "0",
    "email_browse"    =>   "0",
    "flink_list"    =>   "0",
    "flink_add"    =>   "0",
    'tag_list'=>'0',
    'tag_add'=>'0',
    'tag_eidt'=>'0',
    'tag_del'=>'0',
    "user_browse"    =>   "0",
    "user_rank_browse"    =>   "0",
    "add_user_rank_browse"    =>   "0",
    "audit_company"    =>   "0",

    "shop_browse"    =>   "0",

    "order_list_browse"    =>   "0",
    "pay_order_list_browse"    =>   "0",
    "complaint_list"       => "0",
    "complaint_title"      => "0",

    "goods_list_browse"    =>   "0",
    "cat_add"    =>   "0",
    "cat_list"    =>   "0",
    "brand_add"    =>   "0",
    "brand_show"    =>   "0",
    "attr_manager"    =>   "0",
    "groupbuy_list"    =>   "0",

    "nav_list"    =>   "0",
    "nav_edit"    =>   "0",
	"protect_rights"	=>"0",
    "adv_position_list"    =>   "0",
    "adv_add"    =>   "0",
    "adv_list"    =>   "0",
    "adver_add"    =>   "0",

    "news_catlist"    =>   "0",
    "news_list"    =>   "0",
    "add_news_cat"    =>   "0",
    "add_news"    =>   "0",

    "template_mana"    =>   "0",

    "tools_list"    =>   "0",
    "tools_download"    =>   "0",
    "tools_mana"    =>   "0",

    "database"    =>   "0",
    "database_recover"    =>   "0",

    "admin_list"    =>   "0",
    "admin_group"    =>   "0",
    "admin_add"    =>   "0",
    "pass_browse"    =>   "0",
    "plugin"       => "",
    "shop_categories" => "0",
    "sys_sitemap"=> "0",

	"sensi_words"=> "0",
	"word_add"=> "0",
	"word_edit"=> "0",
	"word_del"=> "0",

	"shop_add"=> "0",

	"sys_navigate"=> "0",

	"shop_method"=>"0",
	"error_set"=>"0",
	"goods_edit"=>"0",
	"shop_edit"=>"0",
	"remind_info"=>"0",
	"verifycode"=> "a:4:{i:1;i:1;i:2;i:0;i:3;i:0;i:4;i:0;}",
);
foreach($right_array as $key => $value){
	$right_array[$key]=check_rights($key);
}

$id = short_check(get_args('value'));
$ltype=short_check(get_args("ltype"));
if(!$ltype){
	$ltype="0";
}
/***插件 */
$sql="select * from $t_plugin_url where layout_id='index_admin'";
$dbo = new dbex;
dbtarget('r',$dbServs);
$plugin=$dbo->getRs($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/admin.css"><script
	type='text/javascript' src="skin/js/jy.js"></script>
<style>
</style>

</head>
<body onload="showlink('<?php echo $ltype;?>')">
<input type="hidden" id="hid" value="menuid" />
<div id="jybody" style="margin-top: 0px;">
<div id="leftmenu"><?php if ($id == 'index' or $id == ''){?>
<ul class="submenu" id="index">
	<li id="separator" class="separator"></li>
	<li id="main" class="active" onclick="changeMenu(this);"><a
		href="m.php?app=main" target="main-frame"><?php echo $a_langpackage->a_manager_index; ?></a></li>
	<!-- 管理首頁 -->
		<?php if($right_array["site_set_browse"]){?>
	<li id="site_set_browse" class="" onclick="changeMenu(this);"><a
		href="m.php?app=sys_setting" target="main-frame"><?php echo $a_langpackage->a_syssite_setting; ?></a></li>
	<!-- 基本设置 -->
		<?php }?>

		<?php if($right_array["area_browse"]){?>
	<li id="area_browse" class="" onclick="changeMenu(this);"><a
		href="m.php?app=sys_area" target="main-frame"><?php echo $a_langpackage->a_sys_area; ?></a></li>
	<!-- 地域管理 -->
		<?php }?>
		<?php if($right_array["pay_browse"]){?>
	<!-- <li id="pay_browse" class="" onclick="changeMenu(this);"><a
		href="m.php?app=order_payment" target="main-frame"><?php //echo $a_langpackage->a_m_order_payment; ?></a></li>  -->
	<!-- 支付 -->
		<?php }?>

		<?php if($right_array["remind"]){?>
	<!--   <li id="remind" class="" onclick="changeMenu(this);"><a
		href="m.php?app=remind_set" target="main-frame"><?php //echo $a_langpackage->a_m_remind_set; ?></a></li> -->
	<!-- 提醒设置 -->
		<?php }?>
		<?php if($right_array["email_browse"]){?>
	<!--  <li id="email_browse" class="" onclick="changeMenu(this);"><a
		href="m.php?app=mailtpl_set" target="main-frame"><?php //echo $a_langpackage->a_m_mailtpl_set; ?></a></li>  -->
	<!-- 邮件模板 -->
		<?php }?>
		<?php if($right_array["database"]){?>
	<!--  <li id="database" class="" onclick="changeMenu(this);"><a
		href="m.php?app=db_save" target="main-frame"><?php //echo $a_langpackage->a_m_dbs_backup; ?></a></li> -->
	<!-- 数据库备份 -->
		<?php }?>
		<?php if($right_array["database_recover"]){?>
	<li id="database_recover" class="" onclick="changeMenu(this);"><a
		href="m.php?app=db_recover" target="main-frame"><?php echo $a_langpackage->a_m_dbs_recover; ?></a></li>
	<!-- 数据库恢复 -->
		<?php }?>
		<?php if($right_array["programme_browse"]){?>
	<!--  <li id="programme_browse" class="" onclick="changeMenu(this);"><a
		href="m.php?app=sys_crons" target="main-frame"><?php //echo $a_langpackage->a_sys_cron; ?></a></li> -->
	<!-- 计划任务 -->
		<?php }?>
		<?php if($right_array["verifycode"]){?>
	<!--  <li id="programme_browse" class="" onclick="changeMenu(this);"><a
		href="m.php?app=verifycode" target="main-frame"><?php //echo $a_langpackage->a_sys_verifycode; ?></a></li>  -->
	<!-- 验证管理 -->
		<?php }?>
		<?php if($right_array["nav_list"]){?>
	<!-- <li id="nav_list" class="" onclick="changeMenu(this);"><a
		href="m.php?app=nav_list" target="main-frame"><?php //echo $a_langpackage->a_custom_navigation; ?></a></li>  -->
	<!-- 自定义导航 -->
		<?php }?>
</ul>
<?php }?> <?php if ($id == 'shops'){?><!-- 商铺 -->
<ul class="submenu" id="index">
	<li id="separator" class="separator"></li>
	<?php if($right_array["shop_browse"]){?>
	<li id="shop_browse" class="active" onclick="changeMenu(this);"><a
		href="m.php?app=shop_list" target="main-frame"><?php echo $a_langpackage->a_shop_list; ?></a></li>
	<!-- 商铺列表 -->
		<?php }?>
		<?php if($right_array["audit_company"]){?>
	<!-- <li id="audit_company" class="" onclick="changeMenu(this);"><a
		href="m.php?app=shop_request" target="main-frame"><?php echo $a_langpackage->a_m_check_commember; ?></a></li>  -->
		<?php }?>
		<?php if($right_array["shop_categories"]){?>
	<li id="shop_categories" class="" onclick="changeMenu(this);"><a
		href="m.php?app=shop_categories_list" target="main-frame"><?php echo $a_langpackage->a_shop_category; ?></a></li>
	<!-- 商铺分类 -->
		<?php }?>
		<?php if($right_array["credit_browse"]){?>
	<li id="credit_browse" class="" onclick="changeMenu(this);"><a
		href="m.php?app=sys_integral" target="main-frame"><?php echo $a_langpackage->a_m_sys_integral; ?></a></li>
	<!-- 信用等级 -->
		<?php }?>
</ul>
<?php }?> <?php if ($id == 'application'){?><!-- 应用 -->
<ul class="submenu" id="index">
	<li id="separator" class="separator"></li>
	<?php if($right_array["template_mana"]){?>
	<li id="template_mana" class="active" onclick="changeMenu(this);"><a
		href="m.php?app=manage_template" target="main-frame"><?php echo $a_langpackage->a_m_template_management; ?></a></li>
		<?php }?>
		<?php if($right_array["plugin"]){?>
	<li id="plugin" class="" onclick="changeMenu(this);"><a
		href="m.php?app=plugin_list" target="main-frame"><?php echo $a_langpackage->a_m_plugin_management; ?></a></li>
		<?php }?>
		<?php if($right_array["tools_list"]){?>
	<li id="tools_list" class="" onclick="changeMenu(this);"><a
		href="m.php?app=tool_list" target="main-frame"><?php echo $a_langpackage->a_m_tool_list; ?></a></li>
		<?php }?>
		<?php if($right_array["tools_mana"]){?>
	<li id="tools_mana" class="" onclick="changeMenu(this);"><a
		href="m.php?app=m_tool" target="main-frame"><?php echo $a_langpackage->a_m_tools_management; ?></a></li>
		<?php }?>

	<!-- 
				<li class="" onclick="changeMenu(this);"><a href="<?php // echo isset($plugin[0]['url'])?"../".$plugin[0]['url']."?method=newsList":'';?>" target="main-frame">新闻管理</a></li>
				 -->
</ul>
<?php }?> <?php if ($id == 'member'){?><!-- 会员 -->
<ul class="submenu" id="index">
	<li id="separator" class="separator"></li>
	<?php if($right_array["user_browse"]){?>
	<li id="user_browse" class="active" onclick="changeMenu(this);"><a
		href="m.php?app=member_list" target="main-frame"><?php echo $a_langpackage->a_memeber_list; ?></a></li>
		<?php }?>
		<?php if($right_array["user_rank_browse"]){?>
	<li id="user_rank_browse" class="" onclick="changeMenu(this);"><a
		href="m.php?app=member_rank" target="main-frame"><?php echo $a_langpackage->a_m_member_level_set; ?></a></li>
		<?php }?>

		<?php if($right_array["admin_list"]){?>
	<li id="admin_list" class="" onclick="changeMenu(this);"><a
		href="m.php?app=admin_list" target="main-frame"><?php echo $a_langpackage->a_admin_list; ?></a></li>
		<?php }?>
		<?php if($right_array["admin_group"]){?>
	<li id="admin_group" class="" onclick="changeMenu(this);"><a
		href="m.php?app=admin_group" target="main-frame"><?php echo $a_langpackage->a_m_admingroup_set; ?></a></li>
		<?php }?>
		<?php if($right_array["pass_browse"]){?>
	<li id="pass_browse" class="" onclick="changeMenu(this);"><a
		href="m.php?app=change_password" target="main-frame"><?php echo $a_langpackage->a_edit_admin_psd; ?></a></li>
		<?php }?>
</ul>
<?php }?> <?php if ($id == 'order'){?><!-- 订单 -->
<ul class="submenu" id="index">
	<li id="separator" class="separator"></li>
	<?php if($right_array["order_list_browse"]){?>
	<li id="order_list_browse" class="active" onclick="changeMenu(this);"><a
		href="m.php?app=order_alllist" target="main-frame"><?php echo $a_langpackage->a_alllist; ?></a></li>
		<?php }?>
		<?php if($right_array["pay_order_list_browse"]){?>
	<li id="pay_order_list_browse" class="" onclick="changeMenu(this);"><a
		href="m.php?app=order_alllist&pay_status=1" target="main-frame"><?php echo $a_langpackage->a_m_opayedrder_list; ?></a></li>
		<?php }?>
		<?php if($right_array["complaint_list"]){?>
	<li id="complaint_list" class="" onclick="changeMenu(this);"><a
		href="m.php?app=complaint_list" target="main-frame"><?php echo $a_langpackage->a_complaints_list; ?></a></li>
		<?php }?>
		<?php if($right_array["complaint_title"]){?>
	<li id="complaint_title" class="" onclick="changeMenu(this);"><a
		href="m.php?app=complaint_type" target="main-frame"><?php echo $a_langpackage->a_complaints_title_adm; ?></a></li>
		<?php }?>
		<?php if($right_array["shop_method"]){?>
	<li id="nav_list" class="" onclick="changeMenu(this);"><a
		href="m.php?app=shop_method" target="main-frame"><?php echo $a_langpackage->a_ship_method; ?></a></li>
	<!-- 自定义导航 -->
		<?php }?>
		<?php if($right_array["protect_rights"]){?>
	<li id="protect_rights" class="" onclick="changeMenu(this);"><a
		href="m.php?app=protect_rights" target="main-frame"><?php echo $a_langpackage->a_protect_rights; ?></a></li>
	<!-- 自定义导航 -->
		<?php }?>
</ul>
<?php }?> <?php if ($id == 'commodity'){?><!-- 商品 -->
<ul class="submenu" id="index">
	<li id="separator" class="separator"></li>
	<?php if($right_array["goods_list_browse"]){?>
	<li id="goods_list_browse" class="active" onclick="changeMenu(this);"><a
		href="m.php?app=goods_list" target="main-frame"><?php echo $a_langpackage->a_goods_list; ?></a></li>
		<?php }?>
		<?php if($right_array["brand_show"]){?>
	<li id="brand_show" class="" onclick="changeMenu(this);"><a
		href="m.php?app=goods_brand_list" target="main-frame"><?php echo $a_langpackage->a_brand_list; ?></a></li>
		<?php }?>
		<?php if($right_array["cat_list"]){?>
	<li id="cat_list" class="" onclick="changeMenu(this);"><a
		href="m.php?app=goods_category_list" target="main-frame"><?php echo $a_langpackage->a_category_list; ?></a></li>
		<?php }?>
		<?php if($right_array["attr_manager"]){?>
	<li id="attr_manager" class="" onclick="changeMenu(this);"><a
		href="m.php?app=goods_attr_manage" target="main-frame"><?php echo $a_langpackage->a_m_attr_management; ?></a></li>
		<?php }?>

		<?php if($right_array["groupbuy_list"]){?>
	<!--  <li id="groupbuy_list" class="" onclick="changeMenu(this);"><a
		href="m.php?app=groupbuy_list" target="main-frame"><?php echo $a_langpackage->a_groupbuy_list; ?></a></li>  -->
		<?php }?>
		<?php if($right_array["keyword_browse"]){?>
	<!--  <li id="keyword_browse" class="" onclick="changeMenu(this);"><a
		href="m.php?app=searchkey_admin" target="main-frame"><?php echo $a_langpackage->a_m_search_k; ?></a></li> -->
	<!-- 关键字管理 -->
		<?php }?>
		<?php if($right_array["tag_list"]){?>
	<!--  <li id="tag_list" class="" onclick="changeMenu(this);"><a
		href="m.php?app=tag_list" target="main-frame"><?php echo $a_langpackage->a_tags_manage; ?></a></li> -->
	<!-- 标签集管理 -->
		<?php }?>
</ul>
<?php }?> <?php if ($id == 'promotions'){?><!-- 网站 -->
<ul class="submenu" id="index">
	<li id="separator" class="separator"></li>
	<?php if($right_array["news_list"]){?>
	<li id="news_list" class="active" onclick="changeMenu(this);"><a
		href="m.php?app=news_list" target="main-frame"><?php echo $a_langpackage->a_news_list; ?></a></li>
		<?php }?>
		<?php if($right_array["news_catlist"]){?>
	<li id="news_catlist" class="" onclick="changeMenu(this);"><a
		href="m.php?app=news_catlist" target="main-frame"><?php echo $a_langpackage->a_news_category; ?></a></li>
		<?php }?>
		<?php if($right_array["adv_position_list"]){?>
	<li id="adv_position_list" class="" onclick="changeMenu(this);"><a
		href="m.php?app=asd_position_list" target="main-frame"><?php echo $a_langpackage->a_asdposition_list; ?></a></li>
		<?php }?>
		<?php if($right_array["adv_list"]){?>
	<li id="adv_list" class="" onclick="changeMenu(this);"><a
		href="m.php?app=asd_list" target="main-frame"><?php echo $a_langpackage->a_asd_list; ?></a></li>
		<?php }?>

		<?php if($right_array["image_browse"]){?>
	<li id="image_browse" class="" onclick="changeMenu(this);"><a
		href="m.php?app=index_images" target="main-frame"><?php echo $a_langpackage->a_index_image; ?></a></li>
		<?php }?>
		<?php if($right_array["flink_list"]){?>
	<li id="flink_list" class="" onclick="changeMenu(this);"><a
		href="m.php?app=flink_list" target="main-frame"><?php echo $a_langpackage->a_flink_list; ?></a></li>
		<?php }?>
		<?php if($right_array["sys_sitemap"]){?>
	<li id="sys_sitemap" class="" onclick="changeMenu(this);"><a
		href="m.php?app=sys_sitemap" target="main-frame"><?php echo $a_langpackage->a_m_sitemap; ?></a></li>
	<!-- 网站地图 -->
		<?php }?>
		<?php if($right_array["sensi_words"]){?>
	<li id="sensi_words" class="" onclick="changeMenu(this);"><a
		href="m.php?app=word_list" target="main-frame"><?php echo $a_langpackage->a_sensi_words; ?></a></li>
		<?php }?>
		<?php if($right_array["error_set"]){?>
	<li id="error_set" class="" onclick="changeMenu(this);"><a
		href="m.php?app=error_change&tmp_path=default/404.html"
		target="main-frame"><?php echo $a_langpackage->a_error_set; ?></a></li>
	<!-- 标签集管理 -->
		<?php }?>
		<?php if($right_array["remind_info"]){?>
	<li id="error_set" class="" onclick="changeMenu(this);"><a
		href="m.php?app=message_list" target="main-frame"><?php echo $a_langpackage->a_set_message; ?></a></li>
	<!-- 站内消息管理 -->
		<?php }?>
	<ul>
	<?php }?>

</div>
</div>
<script language="JavaScript">
<!--
function showlink(ltype) {
	var eli = document.getElementsByTagName("li");
	if(ltype!="0"){
        for(i=1;i<eli.length;i++){
    		if(eli[i].className.indexOf('active')>=0){
    			eli[i].className = '';
    		}
    	}
        document.getElementById(''+ltype).className="active";
	}else{
		for(var i=0; i<eli.length; i++) {
			if(eli[i].className=='active') {
				parent.frames[2].location = eli[i].children[0].href;
				parent.document.getElementById('frame-body').cols = '180,*';
				break;
			}
		}
	}
}

document.getElementById('separator').onclick = function (){
	if(document.body.className == 'folden') {
		document.body.className = '';
		parent.document.getElementById('frame-body').cols = '180,*';
	} else {
		document.body.className = 'folden';
		parent.document.getElementById('frame-body').cols = '50,*';
	}
}
//-->
</script>
</body>
</html>
