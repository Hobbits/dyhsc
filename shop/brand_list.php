<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/brand_list.html
 * 如果您的模型要进行修改，请修改 models/brand_list.php
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
if(filemtime("templates/default/brand_list.html") > filemtime(__file__) || (file_exists("models/brand_list.php") && filemtime("models/brand_list.php") > filemtime(__file__)) ) {
	tpl_engine("default","brand_list.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
header("content-type:text/html;charset=utf-8");
$IWEB_SHOP_IN = true;

require("foundation/asession.php");
require("configuration.php");
require("includes.php");
require_once("foundation/fstring.php");
require("foundation/module_brand.php");

/* 用户信息处理 */
//require 'foundation/alogin_cookie.php';
if(get_sess_user_id()) {
	$USER['login'] = 1;
	$USER['user_name'] = get_sess_user_name();
	$USER['user_id'] = get_sess_user_id();
	$USER['user_email'] = get_sess_user_email();
	$USER['shop_id'] = get_sess_shop_id();
} else {
	$USER['login'] = 0;
	$USER['user_name'] = '';
	$USER['user_id'] = '';
	$USER['user_email'] = '';
	$USER['shop_id'] = '';
}

//引入语言包
$i_langpackage=new indexlp;

$header['title'] = $i_langpackage->i_index." - ".$SYSINFO['sys_title'];
$header['keywords'] = $SYSINFO['sys_keywords'];
$header['description'] = $SYSINFO['sys_description'];

/* 定义文件表 */

$t_brand = $tablePreStr."brand";


/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();

$result = get_brand_list($dbo,$t_brand,'',12);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" type="text/css" rel="stylesheet" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/parts.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<title>iWebMall</title>
</head>
<body>
<!-- wrapper -->
<div id="wrapper">
<?php  include("shop/index_header.php");?>
  <!-- contents -->
	<div id="contents" class="clearfix" >
		<div id="sub_channel">
	      <ul class="clearfix">
	      	<li>
	          <h3><img src=" " alt="<?php echo $i_langpackage->i_index;?>"  onerror="this.src='skin/default/images/nopic.gif'"/></h3>
        </li>
        <li><a href=""><?php echo $i_langpackage->i_brand_list;?></a></li>
      </ul>
    </div>
    <div class="all_brand blank">
    <?php  foreach($result['result'] as $value){?>
      <div class="goodsbox clearfix">
        <h4><span><a href="<?php echo $value['site_url'];?>"><?php echo $value['brand_name'];?></a></span>&nbsp;</h4>
        <div class="imgbox"><a href="brand_info.php?brand_id=<?php echo $value['brand_id'];?>"><img alt=" " src="<?php echo $value['brand_logo'];?>" width="110" height="42"  onerror="this.src='skin/default/images/nopic.gif'"/></a> </div>
      <!--  <p class="phone"></p>-->
        <p class="internet"><a href="<?php echo $value['site_url'];?>"><?php echo $value['site_url'];?></a> </p>
      </div>
     <?php }?>
     </div>
    <!-- /contents -->
  </div>


  <div class="pagenav clearfix">
	<?php if($result['countpage']>0){?>
	<?php  include("modules/page.php");?>
    <?php  } else {?>
    <?php echo $i_langpackage->i_no_product;?>！
    <?php }?>
  </div>
<?php  require("shop/index_footer.php");?>
  <!-- /wrapper -->
</div>
</body>
<script language="JavaScript">
<!--
function showbox(id) {
	document.getElementById("showbox_"+id).style.display = '';
}
function hidebox(id) {
	document.getElementById("showbox_"+id).style.display = 'none';
}
</script>
</html>
<?php } ?>