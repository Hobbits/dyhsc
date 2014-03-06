<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/shop/ucategory.html
 * 如果您的模型要进行修改，请修改 models/shop/ucategory.php
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
if(filemtime("templates/default/shop/ucategory.html") > filemtime(__file__) || (file_exists("models/shop/ucategory.php") && filemtime("models/shop/ucategory.php") > filemtime(__file__)) ) {
	tpl_engine("default","shop/ucategory.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}
/* 公共信息处理 header, left, footer */
require("foundation/module_shop.php");
require("foundation/module_goods.php");
require("foundation/module_users.php");
require("foundation/module_shop_category.php");


//引入语言包
$s_langpackage=new shoplp;
$i_langpackage=new indexlp;

/* 定义文件表 */
$t_shop_info = $tablePreStr."shop_info";
$t_user_info = $tablePreStr."user_info";
$t_users = $tablePreStr."users";
$t_shop_category = $tablePreStr."shop_category";
$t_goods = $tablePreStr."goods";
$t_shop_categories = $tablePreStr."shop_categories";

$s = short_check(get_args('s'));
$k = urldecode(get_args('k'));

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();
/* 用户分类信息获取 */
$sql = "select * from `$t_shop_category` where shop_cat_id='$shop_cat_id'";
$catinfo = $dbo->getRow($sql);
if(!$catinfo && $s) {
	$catinfo['shop_id'] = $s;
	$catinfo['shop_cat_name'] =$s_langpackage->s_search;
}

$ids = $shop_cat_id;
$sql = "select shop_cat_id from `$t_shop_category` where parent_id='$shop_cat_id'";
$rows = $dbo->getRs($sql);
if($rows) {
	foreach($rows as $v){
		$ids .= ','.$v['shop_cat_id'];
	}
}

$goods_sql = "";
$ks = explode(' ', $k);
$n_conditions = array();
$k_conditions = array();
foreach($ks as $key)
{
    if (!empty($key))
    {
       $n_conditions[] = "goods_name like '%$key%'";
        $k_conditions[] = "keyword like '%$key%'";
    }
}
if (!empty($n_conditions) && !empty($k_conditions))
{
    $filter = '('.implode(' OR ', $n_conditions).')';
    $goods_sql = "and $filter";
    $filter = '('.implode(' OR ', $k_conditions).')';
   $goods_sql .= ' OR ' . $filter;
}
$goods_sql .= " order by sort_order asc,goods_id desc";

if($shop_cat_id){
	$goods_sql = "select goods_id,goods_name,goods_price,goods_thumb,is_set_image from $t_goods where shop_id={$catinfo['shop_id']} and ucat_id=$shop_cat_id " . $goods_sql;
}else{
	$goods_sql = "select goods_id,goods_name,goods_price,goods_thumb,is_set_image from $t_goods where shop_id=$s " . $goods_sql;
}
$result = $dbo->fetch_page($goods_sql,20);

/* 商铺信息处理 */
$shop_id = $catinfo['shop_id'];
$SHOP = get_shop_info($dbo,$t_shop_info,$shop_id);
if(!$SHOP) { trigger_error($s_langpackage->s_shop_error);}
//商铺分类
$shop_rank = $SHOP['shop_categories'];
$shop_rank_arr = get_categories_rank($shop_rank,$dbo,$t_shop_categories);
if ($shop_rank_arr){
	$num = count($shop_rank_arr) - 1;
}
$sql = "select rank_id,user_name,last_login_time from $t_users where user_id='".$SHOP['user_id']."'";
$ranks = $dbo->getRow($sql);
$SHOP['rank_id'] = $ranks['rank_id'];
$SHOP['user_name'] = $ranks['user_name'];

$header['title'] = $catinfo['shop_cat_name']." - ".$SHOP['shop_name'];
$header['keywords'] = $catinfo['shop_cat_name'].','.$SHOP['shop_name'];
$header['description'] = $SHOP['shop_name'].$catinfo['shop_cat_name'];

$nav_selected=3;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo  $header['title'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo  $header['keywords'];?>" />
<meta name="description" content="<?php echo  $header['description'];?>" />
<base href="<?php echo  $baseUrl;?>" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" type="text/css" rel="stylesheet" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/shop.css" rel="stylesheet" type="text/css" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/shop_<?php echo  $SHOP['shop_template'];?>.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<!--<style>
.shop_header {background:#4A9DA5;}
<?php if($SHOP['shop_template_img']){?>
.shop_header {background:transparent url(<?php echo  $SHOP['shop_template_img'];?>) no-repeat scroll 0 0;}
<?php }?>
</style>-->
</head>
<body>
<div id="wrapper">
	<?php  require("shop/index_header.php");?>
  <!-- contents -->
  <div id="contents" class="clearfix" >
 <div id="pkz">

<!--    	<?php echo $s_langpackage->s_this_location;?><a href="index.php"><?php echo  $SYSINFO['sys_name'];?></a> &gt; <a href=""><?php echo $s_langpackage->s_shop_category;?></a> &gt;-->
<!--    	<?php foreach($shop_rank_arr as $k=>$value){?>-->
<!--    		<?php  if($num == $k){?>-->
<!--    			<a href="" ><?php echo $value['cat_name'];?></a>-->
<!--    		<?php  } else{?>-->
<!--    			<a href="" ><?php echo $value['cat_name'];?></a> &gt;-->
<!--    		<?php }?>-->
<!--    	<?php }?>-->

    </div>

<div id="shopHeader" class="mg12b clearfix">
  <p><img src="<?php echo  $SHOP['shop_template_img'];?>" alt="" width="960" height="150" onerror="this.src='skin/default/images/nopic.gif'"/></p>
 <p class="shopName"><?php echo  $SHOP['shop_name'];?></p>
 <div class="shop_nav"><?php  require("shop/menu.php");?></div>
</div>
	<?php  require("shop/left.php");?>
<div id="rightCloumn">
 <h3 class="ttlm_font"><?php echo $s_langpackage->s_shop_allgoods;?></h3>
	<div id="winItems">
       <!-- <div class="top"><h2><a class="highlight" href="<?php echo  shop_url($shop_id,'products');?>"><?php echo $s_langpackage->s_shop_allgoods;?></a></h2><span class="right"><a id="window" onclick="changeStyle_index('window',this)" href="javascript:void(0);"  class="selected" hidefocus="true"><?php echo $s_langpackage->s_shop_smallimg;?></a><a id="list" onclick="changeStyle_index('list',this)"  href="javascript:void(0);" hidefocus="true"><?php echo $s_langpackage->s_shop_bigimg;?></a></span></div>-->

		 <ul class="clearfix">
		 <?php if($result['result']) {foreach($result['result'] as $v){?>
			<li>
   <div class="photo"><a href="<?php echo  goods_url($v['goods_id']);?>">
   <img src="<?php echo  $v['is_set_image'] ? str_replace('thumb_','',$v['goods_thumb']) : 'skin/default/images/nopic.gif';?>" width="190" height="190" alt="<?php echo  $v['goods_name'];?>"  onerror="this.src='skin/default/images/nopic.gif'"/></a> </div>
   <div class="smmery">
              <h4><a class="pro_name" href="<?php echo  goods_url($v['goods_id']);?>" title="<?php echo  $v['goods_name'];?>"><?php echo  sub_str($v['goods_name'],50,false);?></a></h4>
            </div>
            <div class="price"><span><?php echo $s_langpackage->s_money_sign;?><?php echo  $v['goods_price'];?><?php echo  $s_langpackage->s_yan;?></span> </div>
          </li>

		<?php }?>
		 <?php  }else {
			echo $s_langpackage->s_no_goods;
		}?>
		</ul>
		<?php  if($result['result']){?>
	        <div class="pagenav clearfix">
	        	<?php  include("modules/page.php");?>
	        </div>
        <?php }?>

	</div>
</div></div></div>
	<?php   require("shop/index_footer.php");?>
</div>
</body>
</html><?php } ?>