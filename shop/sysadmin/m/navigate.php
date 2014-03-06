<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//引入语言包
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

	"sys_navigate"=> "0",
);
foreach($right_array as $key => $value){
	$right_array[$key]=check_rights($key);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>iWebShop1.0</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="skin/css/admin.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="../servtools/jquery-1.3.2.min.js"></script>
<script type="text/javascript">

function showpage(locationUrl,menuUrl,toptype,ltype){
	window.parent.frames["menu-frame"].location=menuUrl+"&ltype="+ltype;
	$(window.parent.frames["header-frame"].document).find(".active").removeClass("active");
	$(window.parent.frames["header-frame"].document).find("#"+toptype).addClass("active");
	window.location.href=locationUrl;
	return false;
}
</script>
</head>
<body>
<div id="maincontent">
<div class="wrap">
<div id="siteNavi" class="clearfix">
	<ul>
		<li>
			<div class="mg12b clearfix">
				<h3 id="title_01" class="ttlm"><a href="m.php?app=menu&value=index" target="menu-frame"><?php echo $a_langpackage->a_global_settings; ?></a></h3>
				<div class="listPan">
					<ul class="clearfix">
						<li><a href="#" onclick="return showpage('m.php?app=main','m.php?app=menu&value=index','index','');" target="main-frame"><?php echo $a_langpackage->a_manager_index; ?></a></li>
						<?php if($right_array["site_set_browse"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=sys_setting','m.php?app=menu&value=index','index','site_set_browse');" target="main-frame"><?php echo $a_langpackage->a_syssite_setting; ?></a></li>
						<?php }?>
						<?php if($right_array["area_browse"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=sys_area','m.php?app=menu&value=index','index','area_browse');" target="main-frame"><?php echo $a_langpackage->a_sys_area; ?></a></li>
						<?php }?>
						<?php if($right_array["pay_browse"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=order_payment','m.php?app=menu&value=index','index','pay_browse');" target="main-frame"><?php echo $a_langpackage->a_m_order_payment; ?></a></li>
						<?php }?>
						<?php if($right_array["remind"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=remind_set','m.php?app=menu&value=index','index','remind');" target="main-frame"><?php echo $a_langpackage->a_m_remind_set; ?></a></li>
						<?php }?>
						<?php if($right_array["email_browse"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=mailtpl_set','m.php?app=menu&value=index','index','email_browse');" target="main-frame"><?php echo $a_langpackage->a_m_mailtpl_set; ?></a></li>
						<?php }?>
						<?php if($right_array["database"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=db_save','m.php?app=menu&value=index','index','database');" target="main-frame"><?php echo $a_langpackage->a_m_dbs_backup; ?></a></li>
						<?php }?>
						<?php if($right_array["database_recover"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=db_recover','m.php?app=menu&value=index','index','database_recover');" target="main-frame"><?php echo $a_langpackage->a_m_dbs_recover; ?></a></li>
						<?php }?>
						<?php if($right_array["programme_browse"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=sys_crons','m.php?app=menu&value=index','index','programme_browse');" target="main-frame"><?php echo $a_langpackage->a_sys_cron; ?></a></li>
					    <?php }?>
					</ul>
				</div>
			</div>
		</li>
		<li class="clearfix">
			<div class="mg12b clearfix">
				<h3 id="title_02" class="ttlm"><a href="m.php?app=menu&value=shops" target="menu-frame"><?php echo $a_langpackage->a_m_shop_mengament; ?></a></h3>
				<div class="listPan">
					<ul class="clearfix">
						<?php if($right_array["shop_browse"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=shop_list','m.php?app=menu&value=shops','shops','');" target="main-frame"><?php echo $a_langpackage->a_shop_list; ?></a></li>
						<?php }?>
						<?php if($right_array["audit_company"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=shop_request','m.php?app=menu&value=shops','shops','audit_company');" target="main-frame"><?php echo $a_langpackage->a_m_check_commember; ?></a></li>
						<?php }?>
						<?php if($right_array["shop_categories"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=shop_categories_list','m.php?app=menu&value=shops','shops','shop_categories');" target="main-frame"><?php echo $a_langpackage->a_shop_category; ?></a></li>
						<?php }?>
						<?php if($right_array["credit_browse"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=sys_integral','m.php?app=menu&value=shops','shops','credit_browse');" target="main-frame"><?php echo $a_langpackage->a_m_sys_integral; ?></a></li>
					    <?php }?>
					</ul>
				</div>
			</div>
		</li>

		<li class="clearfix">
			<div class="mg12b clearfix">
				<h3 id="title_03" class="ttlm"><a href="m.php?app=menu&value=member" target="menu-frame"><?php echo $a_langpackage->a_m_member_oprate; ?></a></h3>
				<div class="listPan">
					<ul class="clearfix">
						<?php if($right_array["user_browse"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=member_list','m.php?app=menu&value=member','member','user_browse');" target="main-frame"><?php echo $a_langpackage->a_memeber_list; ?></a></li>
						<?php }?>
						<?php if($right_array["user_rank_browse"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=member_rank','m.php?app=menu&value=member','member','user_rank_browse');" target="main-frame"><?php echo $a_langpackage->a_m_member_level_set; ?></a></li>
						<?php }?>
						<?php if($right_array["admin_list"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=admin_list','m.php?app=menu&value=member','member','admin_list');" target="main-frame"><?php echo $a_langpackage->a_admin_list; ?></a></li>
						<?php }?>
						<?php if($right_array["admin_group"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=admin_group','m.php?app=menu&value=member','member','admin_group');" target="main-frame"><?php echo $a_langpackage->a_m_admingroup_set; ?></a></li>
						<?php }?>
						<?php if($right_array["pass_browse"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=change_password','m.php?app=menu&value=member','member','pass_browse');" target="main-frame"><?php echo $a_langpackage->a_edit_admin_psd; ?></a></li>
					    <?php }?>
					</ul>
				</div>
			</div>
		</li>

		<li class="clearfix">
			<div class="mg12b clearfix">
				<h3 id="title_04" class="ttlm"><a href="m.php?app=menu&value=commodity" target="menu-frame"><?php echo $a_langpackage->a_m_aboutgoods_management; ?></a></h3>
				<div class="listPan">
					<ul class="clearfix">
						<?php if($right_array["goods_list_browse"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=goods_list','m.php?app=menu&value=commodity','commodity','goods_list_browse');" target="main-frame"><?php echo $a_langpackage->a_goods_list; ?></a></li>
						<?php }?>
						<?php if($right_array["brand_show"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=goods_brand_list','m.php?app=menu&value=commodity','commodity','brand_show');" target="main-frame"><?php echo $a_langpackage->a_brand_list; ?></a></li>
						<?php }?>
						<?php if($right_array["cat_list"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=goods_category_list','m.php?app=menu&value=commodity','commodity','cat_list');" target="main-frame"><?php echo $a_langpackage->a_category_list; ?></a></li>
						<?php }?>
						<?php if($right_array["attr_manager"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=goods_attr_manage','m.php?app=menu&value=commodity','commodity','attr_manager');" target="main-frame"><?php echo $a_langpackage->a_m_attr_management; ?></a></li>
						<?php }?>
						<?php if($right_array["groupbuy_list"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=groupbuy_list','m.php?app=menu&value=commodity','commodity','groupbuy_list');" target="main-frame"><?php echo $a_langpackage->a_groupbuy_list; ?></a></li>
						<?php }?>
						<?php if($right_array["keyword_browse"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=searchkey_admin','m.php?app=menu&value=commodity','commodity','keyword_browse');" target="main-frame"><?php echo $a_langpackage->a_m_search_k; ?></a></li>
						<?php }?>
						<?php if($right_array["tag_list"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=tag_list','m.php?app=menu&value=commodity','commodity','tag_list');" target="main-frame"><?php echo $a_langpackage->a_tags_manage; ?></a></li>
					    <?php }?>
					</ul>
				</div>
			</div>
		</li>
		<li class="clearfix">
			<div class="mg12b clearfix">
				<h3 id="title_05" class="ttlm"><a href="m.php?app=menu&value=order" target="menu-frame"><?php echo $a_langpackage->a_m_order_mengament; ?></a></h3>
				<div class="listPan">
					<ul class="clearfix">
						<?php if($right_array["order_list_browse"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=order_alllist','m.php?app=menu&value=order','order','order_list_browse');" target="main-frame"><?php echo $a_langpackage->a_alllist; ?></a></li>
						<?php }?>
						<?php if($right_array["pay_order_list_browse"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=order_alllist&pay_status=1','m.php?app=menu&value=order','order','pay_order_list_browse');" target="main-frame"><?php echo $a_langpackage->a_m_opayedrder_list; ?></a></li>
						<?php }?>
						<?php if($right_array["complaint_list"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=complaint_list','m.php?app=menu&value=order','order','complaint_list');" target="main-frame"><?php echo $a_langpackage->a_complaints_list; ?></a></li>
						<?php }?>
						<?php if($right_array["complaint_title"]){?>
						<li><a href="#" onclick="return showpage('m.php?app=complaint_type','m.php?app=menu&value=order','order','complaint_title');" target="main-frame"><?php echo $a_langpackage->a_complaints_title_adm; ?></a></li>
					    <?php }?>
					</ul>
				</div>
			</div>
		</li>
		<li class="clearfix">
			<div class="mg12b clearfix">
				<h3 id="title_06" class="ttlm"><a href="m.php?app=menu&value=promotions" target="menu-frame"><?php echo $a_langpackage->a_promotion_manage; ?></a></h3>
				<div class="listPan">
					<ul class="clearfix">
							<?php if($right_array["news_list"]){?>
							<li><a href="#" onclick="return showpage('m.php?app=news_list','m.php?app=menu&value=promotions','promotions','news_list');" target="main-frame"><?php echo $a_langpackage->a_news_list; ?></a></li>
							<?php }?>
							<?php if($right_array["news_catlist"]){?>
							<li><a href="#" onclick="return showpage('m.php?app=news_catlist','m.php?app=menu&value=promotions','promotions','news_catlist');" target="main-frame"><?php echo $a_langpackage->a_news_category; ?></a></li>
							<?php }?>
							<?php if($right_array["adv_position_list"]){?>
							<li><a href="#" onclick="return showpage('m.php?app=asd_position_list','m.php?app=menu&value=promotions','promotions','adv_position_list');" target="main-frame"><?php echo $a_langpackage->a_asdposition_list; ?></a></li>
							<?php }?>
							<?php if($right_array["adv_list"]){?>
							<li><a href="#" onclick="return showpage('m.php?app=asd_list','m.php?app=menu&value=promotions','promotions','adv_list');" target="main-frame"><?php echo $a_langpackage->a_asd_list; ?></a></li>
							<?php }?>
							<?php if($right_array["nav_list"]){?>
							<li><a href="#" onclick="return showpage('m.php?app=nav_list','m.php?app=menu&value=promotions','promotions','nav_list');" target="main-frame"><?php echo $a_langpackage->a_custom_navigation; ?></a></li>
							<?php }?>
							<?php if($right_array["image_browse"]){?>
							<li><a href="#" onclick="return showpage('m.php?app=index_images','m.php?app=menu&value=promotions','promotions','image_browse');" target="main-frame"><?php echo $a_langpackage->a_index_image; ?></a></li>
							<?php }?>
							<?php if($right_array["flink_list"]){?>
							<li><a href="#" onclick="return showpage('m.php?app=flink_list','m.php?app=menu&value=promotions','promotions','flink_list');" target="main-frame"><?php echo $a_langpackage->a_flink_list; ?></a></li>
							<?php }?>
							<?php if($right_array["sys_sitemap"]){?>
							<li><a href="#" onclick="return showpage('m.php?app=sys_sitemap','m.php?app=menu&value=promotions','promotions','sys_sitemap');" target="main-frame"><?php echo $a_langpackage->a_m_sitemap; ?></a></li>
					        <?php }?>
					</ul>
				</div>
			</div>
		</li>
		<li class="clearfix">
			<div class="mg12b clearfix">
				<h3 id="title_07" class="ttlm"><a href="m.php?app=menu&value=application" target="menu-frame"><?php echo $a_langpackage->a_application_management; ?></a></h3>
				<div class="listPan">
					<ul class="clearfix">
						<?php if($right_array["template_mana"]){?>
						<li><a href="m.php?app=manage_template" onclick="return showpage('m.php?app=manage_template','m.php?app=menu&value=application','application','template_mana');" target="main-frame"><?php echo $a_langpackage->a_m_template_management; ?></a></li>
						<?php }?>
						<?php if($right_array["plugin"]){?>
						<li><a href="m.php?app=plugin_list" onclick="return showpage('m.php?app=plugin_list','m.php?app=menu&value=application','application','plugin');" target="main-frame"><?php echo $a_langpackage->a_m_plugin_management; ?></a></li>
						<?php }?>
						<?php if($right_array["tools_list"]){?>
						<li><a href="m.php?app=tool_list" onclick="return showpage('m.php?app=tool_list','m.php?app=menu&value=application','application','tools_list');" target="main-frame"><?php echo $a_langpackage->a_m_tool_list; ?></a></li>
						<?php }?>
						<?php if($right_array["tools_mana"]){?>
						<li><a href="m.php?app=m_tool" onclick="return showpage('m.php?app=m_tool','m.php?app=menu&value=application','application','tools_mana');" target="main-frame"><?php echo $a_langpackage->a_m_tools_management; ?></a></li>
					   <?php }?>
					</ul>
				</div>
			</div>
		</li>
	</ul>
</div></div>
</div>
</body>
</html>
