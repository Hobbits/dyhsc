<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/shop/shop_rank.html
 * 如果您的模型要进行修改，请修改 models/shop/shop_rank.php
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
if(filemtime("templates/default/shop/shop_rank.html") > filemtime(__file__) || (file_exists("models/shop/shop_rank.php") && filemtime("models/shop/shop_rank.php") > filemtime(__file__)) ) {
	tpl_engine("default","shop/shop_rank.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}
error_reporting(0);
require("foundation/module_article.php");
//引入语言包
$s_langpackage=new shoplp;

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();
/* 定义文件表 */

$t_integral = $tablePreStr."integral";

$t_article_cat = $tablePreStr."article_cat";

$sql = "SELECT * FROM `$t_article_cat` order by sort_order ";
$article_cat = $dbo->getRs($sql);
if(!$article_cat) {
	trigger_error($s_langpackage->s_no_category,E_USER_ERROR);
}

foreach ($article_cat as $val){
	if($val['cat_id']==2){
		$cat_name=$val['cat_name'];
	}
}

$sql = "SELECT * FROM `$t_integral` order by int_grade";
$integral = $dbo->getRs($sql);

$header=array('title'=>'商铺信用等级','keywords'=>'商铺信用等级','description'=>'商铺信用等级');

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<style type="text/css">
.knowledge_content p{
	margin:10px 0;}
.knowledge_content table{
	width:70%;
	border:1px solid #ccc;
	}	
.knowledge_content  th,
.knowledge_content  td{
	padding:8px;}
.knowledge_content th{
	background-color:#F1F1F1}	
.knowledge_content td{
	border-bottom:1px dashed #ddd;}	
</style>
</head>
<body>
<div id="wrapper">
	<?php  require("shop/index_header.php");?>
<!--search end -->
  <!-- contents -->
  <div id="contents" class="clearfix" >
<div id="pkz"> <?php echo $i_langpackage->i_location;?>：<a href="index.php"><?php echo $i_langpackage->i_index;?></a> > <a href="<?php echo article_list_url(2);?>"><?php echo $cat_name;?></a> > 商铺信用等级</div>
    <div id="mall_banner"  class="mg12b"><script language="JavaScript" src="uploadfiles/asd/5.js"></script></div>
    <!--  contents  -->
    <h3 class="ttlm_infoContents"><?php echo $s_langpackage->s_message_center;?></h3>
    <div id="artContents" class=" clearfix">
        <ul class="artlist_ttlm">
        <?php foreach($article_cat as $val){?>
            <li <?php if($val['cat_id']==2){?>class="now"<?php }?>><a href="<?php echo article_list_url($val['cat_id']);?>"><?php echo $val['cat_name'];?></a></li>
        <?php }?>
        </ul>
      <div class="artpan">
    <h4 class="artTitle">
		商铺信用等级说明
	</h4>
	 <div class="artInfo">

      </div>
      <div class="knowledge_content">
	  <p>成功交易一次，就可以对交易对象作一次信用评价。评价分为“好评”、“中评”、“差评”三类，每种评价对应一个信用积分，具体为：“好评”加一分，“中评”不加分，“差评”扣一分。</p>

      	<table >
		 <colgroup>
		 	<col width="17%" />
		 	<col width="27%" />
		 	<col width="47%" />
		 </colgroup>
          <tr>
            <th width="30">级别</th>
            <th width="100">最小信用度</th>
            <th width="110">最大信用度</th>
            <th width="120">级别图显</th>
          </tr>

		<?php foreach($integral as $val){?>
             <tr>
            <td><?php echo $val['int_grade'];?></td>
            <td><?php echo $val['int_min'];?></td>
            <td><?php echo $val['int_max'];?></td>
            <td><img src="<?php echo $val['int_img'];?>" /></td>
          </tr>
        <?php }?>
        </table>
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
<?php } ?>