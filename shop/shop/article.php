<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/shop/article.html
 * 如果您的模型要进行修改，请修改 models/shop/article.php
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
if(filemtime("templates/default/shop/article.html") > filemtime(__file__) || (file_exists("models/shop/article.php") && filemtime("models/shop/article.php") > filemtime(__file__)) ) {
	tpl_engine("default","shop/article.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}
error_reporting(0);
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

$sql = "SELECT * FROM `$t_article_cat` order by sort_order ";
$article_cat = $dbo->getRs($sql);
if(!$article_cat) {
	trigger_error($s_langpackage->s_no_category,E_USER_ERROR);
}
$article_info = get_article_info($dbo,$t_article,$article_id);
if(!$article_info) {
	trigger_error($s_langpackage->s_no_news,E_USER_ERROR);
}

foreach ($article_cat as $val){
	if($val['cat_id']==$article_info['cat_id']){
		$cat_name=$val['cat_name'];
	}
}
$up_article = get_flip_info($dbo,$t_article,$article_id,'up');
$down_article = get_flip_info($dbo,$t_article,$article_id,'down');

if($article_info['is_link'] && $article_info['link_url']) {
	echo "<script>location.href = '".$article_info['link_url']."'</script>";
	exit;
}

$header = get_header_info($article_info);

$sql = "SELECT article_id,title FROM $t_article WHERE  cat_id='8'";
$left_article_list =$dbo->getRs($sql);
?><?php if($article_info['cat_id']==8 ) {?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo  $header['title'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo  $header['keywords'];?>" />
<meta name="description" content="<?php echo  $header['description'];?>" />
<base href="<?php echo  $baseUrl;?>" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" type="text/css" rel="stylesheet" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/about.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
</head>
<body>
<!-- wrapper -->
<div id="wrapper">
  <?php  require("shop/index_header.php");?>
  <!-- contents -->
  <div id="contents" class="clearfix" ><div id="pkz"> <?php echo $s_langpackage->s_this_location;?><a href="index.php"><?php echo $i_langpackage->i_index;?></a>> <?php echo  $article_info['title'];?></div>
    <div class="top"><img src="skin/<?php echo  $SYSINFO['templates'];?>/images/about/about_img_top.jpg" alt="<?php echo $s_langpackage->s_mall_intro;?>"  width="960" height="160" />
    </div>
    <div id="aboutContents" class="clearfix">
    	<div id="leftColumn">
       <h3 class="ttlm_aboutMall"><?php echo $s_langpackage->s_mall_intro2;?></h3>
       <ul class="list_about">
       <?php foreach($left_article_list as $value){?>
       <li <?php if($value['article_id']==$article_info['article_id']){?>class="now"<?php }?> ><a href="article.php?id=<?php echo $value['article_id'];?>" <?php if($value['article_id']==$article_info['article_id']){?>class="now"<?php }?>><?php echo sub_str($value['title'],10);?></a></li>
       <?php }?>
       </ul>
     </div>
     <div id="rightColumn">
     <p><img class="float_l" src="images/about/about_img_01.jpg" alt="" width="220" height="177" /></p>
     <?php echo $article_info['content'];?>
     </div>
    </div><!-- /contents -->
  </div>
  <!-- footer -->
  <?php  require("shop/index_footer.php");?>
    <!-- /footer -->
  </div>
  <!-- /wrapper -->
</div>
</body>
<!-- InstanceEnd -->
</html>
<?php }else{?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo  $header['title'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo  $header['keywords'];?>" />
<meta name="description" content="<?php echo  $header['description'];?>" />
<base href="<?php echo  $baseUrl;?>" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" type="text/css" rel="stylesheet" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/article.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
</head>
<body>
<div id="wrapper">
	<?php  require("shop/index_header.php");?>
<!--search end -->
  <!-- contents -->
  <div id="contents" class="clearfix" >
<div id="pkz"> <?php echo $i_langpackage->i_location;?>：<a href="index.php"><?php echo $i_langpackage->i_index;?></a> > <a href="<?php echo article_list_url($article_info['cat_id']);?>"><?php echo $cat_name;?></a> > <?php echo  $article_info['title'];?> </div>
    <div id="mall_banner"  class="mg12b"><script language="JavaScript" src="uploadfiles/asd/5.js"></script></div>
    <!--  contents  -->
    <h3 class="ttlm_infoContents"><?php echo $s_langpackage->s_message_center;?></h3>
    <div id="artContents" class=" clearfix">
        <ul class="artlist_ttlm">
        <?php foreach($article_cat as $val){?>
            <li <?php if($val['cat_id']==$article_info['cat_id']){?>class="now"<?php }?>><a href="<?php echo article_list_url($val['cat_id']);?>"><?php echo $val['cat_name'];?></a></li>
        <?php }?>
        </ul>
      <div class="artpan">
      <h4 class="artTitle"><font style="color:<?php echo  $article_info['tag_color'];?> "><?php echo  $article_info['title'];?></font></h4>
      <div class="artInfo">
        <span><?php echo  $s_langpackage->s_time;?>: <?php echo  substr($article_info['add_time'],0,10);?></span>

      </div>
      <div class="artTxt">
      	<p><?php echo  $article_info['content'];?></p>
      </div>
      <div class="link">
       <p ><?php echo $i_langpackage->i_up_article;?>：<?php if(empty($up_article)){?> <?php echo $i_langpackage->i_none_article;?> <?php }?><a href="<?php echo article_url($up_article['article_id']);?>"><?php echo $up_article['title'];?></a><br/><?php echo $i_langpackage->i_down_article;?>：<?php if(empty($down_article)){?> <?php echo $i_langpackage->i_none_article;?> <?php }?><a href="<?php echo article_url($down_article['article_id']);?>"><?php echo $down_article['title'];?></a></p>
      </div>
      </div>
      <!--  contents  -->
    </div>
    <!-- /contents -->
  </div>

<!-- main end -->
<?php  require("shop/index_footer.php");?>
<!--footer end-->
</div>
</body>
</html>
<?php }?>
</body>
</html>
<?php } ?>