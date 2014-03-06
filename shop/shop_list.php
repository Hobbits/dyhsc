<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/shop_list.html
 * 如果您的模型要进行修改，请修改 models/shop_list.php
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
if(filemtime("templates/default/shop_list.html") > filemtime(__file__) || (file_exists("models/shop_list.php") && filemtime("models/shop_list.php") > filemtime(__file__)) ) {
	tpl_engine("default","shop_list.html",1);
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

require_once("foundation/module_areas.php");

/* 用户信息处理 */
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

/* 定义文件表 */
$t_shop_info = $tablePreStr."shop_info";
$t_users = $tablePreStr."users";
$t_goods = $tablePreStr."goods";
$t_areas = $tablePreStr."areas";
$t_user_rank = $tablePreStr."user_rank";
$t_shop_categories = $tablePreStr."shop_categories";

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();

/* 处理商铺分类 */
$sql_category = "select * from `$t_shop_categories` order by sort_order asc,cat_id asc";
$result_category = $dbo->getRs($sql_category);

$CATEGORY = array();
if($result_category) {
	foreach($result_category as $v) {
		$CATEGORY[$v['parent_id']][$v['cat_id']] = $v;

	}
}

/* 地区信息 */
$areainfo = get_areas_kv($dbo,$t_areas);
/* 获得省级地址 */
$area_arr = "select area_id,area_name from `$t_areas` where area_type='1'";
$area_list = $dbo->getRs($area_arr);
$area_id = intval(get_args('areaid'));

/* 列表处理 */
$k = short_check(get_args('k'));

$sql = "SELECT * FROM `$t_shop_info` as a, `$t_users` as b ,$t_user_rank as c WHERE a.user_id=b.user_id and open_flg=0 and b.rank_id=c.rank_id ";

if($k) {
	$sql .= " and a.shop_name LIKE '%$k%' ";
}
if ($area_id){
	$sql .= " and a.shop_province = '$area_id'";
}

$sql .= " ORDER BY shop_creat_time DESC";
$result = $dbo->fetch_page($sql,$SYSINFO['seller_page']);

$header['title'] = $i_langpackage->i_s_company." - ".$SYSINFO['sys_title'];
$header['keywords'] = $i_langpackage->i_s_company.','.$SYSINFO['sys_keywords'];
$header['description'] = $SYSINFO['sys_description'];
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo  $header['title'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta name="keywords" content="<?php echo  $header['keywords'];?>" />
<meta name="description" content="<?php echo  $header['description'];?>" />
<base href="<?php echo  $baseUrl;?>" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/index.css" rel="stylesheet" type="text/css" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" type="text/css" rel="stylesheet" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/article.css" type="text/css" rel="stylesheet" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/parts.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<script type="text/javascript" src="js/changeStyle.js"></script>
</head>
<body>
<div id="wrapper">
<?php  include("shop/index_header.php");?>
<!--search end -->
	<div id="contents" class="clearfix" >
		<div id="sub_channel">
	      <ul class="clearfix">
	      	<li>
	          <h3><img src="skin/default/images/part/ttl_channel_all.gif" alt="<?php echo $i_langpackage->i_index;?>" /></h3>
	        </li>
	        <li><a href="shop_list.php"><?php echo $i_langpackage->i_store_list;?></a></li>
	      </ul>
	    </div>

		<div id="leftbar">
	    <ul id="listShopType">
			 <?php  foreach(array_slice ($CATEGORY[0], 0, 3) as $key=>$cat){?>
	        	<li>
	            <h3><a href="<?php echo  category_url($cat['cat_id']);?>" title="<?php echo  $cat['cat_name'];?>"><?php echo  $cat['cat_name'];?></a></h3>
	            <?php if(isset($CATEGORY[$cat['cat_id']]) && $CATEGORY[$cat['cat_id']]){?>
	            <ul class="per_items clearfix">
	                <?php  foreach(array_slice ($CATEGORY[$cat['cat_id']], 0, 3) as $subcat){?>
	                    <li><a href="" title="<?php echo  $cat['cat_name'];?>"><?php echo  $subcat['cat_name'];?></a></li>
	                <?php }?>
	             </ul>
	             <?php }?>
	            </li>
			<?php }?>
    	</ul>
	    </div>
	<div id="rightbar">
      	<div id="leftMian">
			  <div class="top clearfix">
				  <h3 class="ttlm_listshop"><?php echo $i_langpackage->i_like_storelist;?></h3>
				  <div class="sel_address">
					<select name="area_select" onchange="area_change(this.value);">
						<option value="0"><?php echo $i_langpackage->i_locus;?></option>
						<?php  foreach($area_list as $k=>$v){?>
							<option value="<?php echo  $v['area_id'];?>" <?php  if($v['area_id']==$area_id){echo 'selected';}?>><?php echo  $v['area_name'];?></option>
						<?php }?>
					</select>
				  </div>
			 </div>
				<div id="listShop" class="c_m">
			 	 <ul class="list_title clearfix">
					<li class="summary" width="300px;"><?php echo $i_langpackage->i_s_com;?></li>
	                <li class="quantity "><?php echo $i_langpackage->i_goods_num;?></li>
	                <li class="shopower"><?php echo $i_langpackage->i_shopour;?></li>
	                <li class="level"><?php echo $i_langpackage->i_is_vis;?></li>
					<li class="address"><?php echo $i_langpackage->i_in_area;?></li>
			 	 </ul>
				  <ul class="list_view">
						<?php  if($result['result']) {
							foreach($result['result'] as $v) {?>
						<li id="showli_4" class="clearfix">
						  <div class="photo"><a target="_blank" href="<?php echo  shop_url($v['shop_id']);?>"><img src="<?php echo  $v['shop_logo'] ? $v['shop_logo'] : 'skin/default/images/shop/shop_logo.gif';?>" width="112" height="112" alt="" onerror="this.src='skin/default/images/nopic.gif'"/></a></div>
						  <div class="smmery">
							<h4><a href="<?php echo  shop_url($v['shop_id']);?>"><?php echo  $v['shop_name'];?></a></h4>
							<p class="des">[<?php echo  $i_langpackage->i_info;?>]<?php echo  sub_str(strip_tags($v['shop_intro']),28);?></p>
						  </div>
						  <div class="quantity"><?php echo  $v['goods_num'];?></div>
						  <div class="shopower"> <a class="" href="<?php echo  shop_url($v['shop_id']);?>"><?php echo  $v['user_name'];?></a> </div>
						  <div class="operating">  <a href="javascript:;" title="<?php echo $v['rank_name'];?>"  class="addfavorite"><?php echo $v['rank_name'];?></a> </div>
						  <div class="address"><?php echo  $areainfo[$v['shop_province']];?>.<?php echo  $areainfo[$v['shop_city']];?></div>
						</li>

						<?php   }} else {
						echo "<li>".$i_langpackage->i_comapny_none."</li>";
						}?>
				  </ul>
				</div>
				<div class="pagenav clearfix">
					<?php  require("modules/page.php");?>
				</div>
      	</div>
      </div>
	</div>
</div>
<!--main right end-->
<?php  require("shop/index_footer.php");?>
<!--footer end-->
</body>
<script language="JavaScript">
<!--

function area_change(value){
	location.href = "shop_list.php?areaid="+value;
}

//-->
</script>
</html>
<?php } ?>