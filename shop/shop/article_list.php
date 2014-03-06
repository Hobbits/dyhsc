<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/shop/article_list.html
 * 如果您的模型要进行修改，请修改 models/shop/article_list.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
/*
 * 此段代码由debug模式下生成运行，请勿改动！
 * 如果debug模式下出错不能再次自动编译时，请进入后台手动编译！
 */
/* debug模式运行生成代码 开始 */
if(!function_exists("tpl_engine")) {
	require("foundation/ftpl_compile.php");
}
if(filemtime("templates/default/shop/article_list.html") > filemtime(__file__) || (file_exists("models/shop/article_list.php") && filemtime("models/shop/article_list.php") > filemtime(__file__)) ) {
	tpl_engine("default","shop/article_list.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require("foundation/module_shop.php");
require("foundation/module_users.php");
require("foundation/module_article.php");

//引入语言包
$s_langpackage=new shoplp;

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();

/* 定义文件表 */
$t_shop_info = $tablePreStr."shop_info";
$t_user_info = $tablePreStr."user_info";
$t_users = $tablePreStr."users";
$t_shop_category = $tablePreStr."shop_category";
$t_goods = $tablePreStr."goods";
$t_article = $tablePreStr."article";
$t_article_cat = $tablePreStr."article_cat";

$cat_id = intval(get_args('id'));

$sql = "SELECT * FROM `$t_article_cat` order by sort_order asc";
$article_cat = $dbo->getRs($sql);
if(!$article_cat) {
	trigger_error($s_langpackage->s_no_category);
}

foreach ($article_cat as $val){
	if($val['cat_id']==$cat_id){
		$cat_name=$val['cat_name'];
	}
}
$result = get_article_list($dbo,$t_article,$cat_id,$SYSINFO['article_page']);

if(!$result) {
	trigger_error($s_langpackage->s_no_message);
}

$header = get_header_info($cat_name);

/*导航位置*/
$nav_selected=5;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo  $header['title'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo  $header['keywords'];?>" />
<meta name="description" content="<?php echo  $header['description'];?>" />
<base href="<?php echo  $baseUrl;?>" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/index.css" rel="stylesheet" type="text/css" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" type="text/css" rel="stylesheet" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/article.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
</head>
<body>
<div id="wrapper">
	<?php  require("shop/index_header.php");?>

  <div id="contents" class="clearfix" >
  <div id="pkz"> <?php echo $i_langpackage->i_location;?>：<a href="index.php"><?php echo $i_langpackage->i_index;?></a> > <?php echo $cat_name;?> </div>
  <div id="mall_banner" class="mg12b"><script language="JavaScript" src="uploadfiles/asd/5.js"></script></div>
  <h3 class="ttlm_infoContents"><?php echo $s_langpackage->s_message_center;?></h3>
    <div id="artContents" class=" clearfix">
        <ul class="artlist_ttlm">
        <?php foreach($article_cat as $val){?>
            <li <?php if($val['cat_id']==$cat_id){?>class="now"<?php }?>><a href="<?php echo article_list_url($val['cat_id']);?>"><?php echo $val['cat_name'];?></a></li>
        <?php }?>
        </ul>
<!--main right end-->
    <div class="artpan">
        <ul class="artlist_txt" >
        <?php if($result['result']){?>
        <?php foreach($result['result'] as $val){?>
            <li class="clearfix"><span class="right"><?php echo  $val['add_time'];?></span>
            <a href="<?php echo article_list_url($val['cat_id']);?>">[<?php echo $cat_name;?>]</a>
            <a class="ttls" href="<?php echo article_url($val['article_id']);?>"><font style="color:<?php echo  $val['tag_color'];?> "><?php echo  $val['title'];?></font></a></li>
        <?php }?>
        <?php }else{ ;?>
        <?php echo $i_langpackage->i_none_articles;?>
        <?php }?>
        </ul>
		<div class="pagenav clearfix">
        	<?php if($result['countpage']>0){?>
        	<?php  include("modules/page.php");?>
            <?php }?>
		</div>
    </div>
	</div>
</div>
<!-- main end -->
<?php  require("shop/index_footer.php");?>
<!--footer end-->
</div>
</body>
</html>
<?php } ?>