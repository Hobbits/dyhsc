<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/brand_info.html
 * 如果您的模型要进行修改，请修改 models/brand_info.php
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
if(filemtime("templates/default/brand_info.html") > filemtime(__file__) || (file_exists("models/brand_info.php") && filemtime("models/brand_info.php") > filemtime(__file__)) ) {
	tpl_engine("default","brand_info.html",1);
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
require_once("foundation/module_tag.php");
require("foundation/module_goods.php");
//引入语言包
$i_langpackage = new indexlp;
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
//print_r($_GET);

/* 定义文件表 */
$t_shop_info = $tablePreStr."shop_info";
$t_category = $tablePreStr."category";
$t_goods = $tablePreStr."goods";
$t_areas = $tablePreStr."areas";
$t_users = $tablePreStr."users";
$t_keywords_count = $tablePreStr."keywords_count";
$t_goods_attr = $tablePreStr."goods_attr";
$t_brand = $tablePreStr."brand";
$t_brand_category = $tablePreStr."brand_category";
$t_attribute = $tablePreStr."attribute";
$t_user_rank = $tablePreStr."user_rank";
$t_tag = $tablePreStr."tag";

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();
$brand_id = intval(get_args("brand_id"));
//$brand_id=18;

$sql="select * from $t_brand where brand_id=$brand_id and is_show=1";
$brand_info=$dbo->getRow($sql);

$sql="SELECT g.pv,g.is_set_image,g.brand_id,g.transport_price,g.transport_template_price,g.goods_thumb,g.goods_id,g.cat_id,g.goods_name,g.goods_price,g.goods_intro,g.shop_id,s.shop_id,s.shop_name,s.user_id,s.shop_country,s.shop_province,s.shop_district,s.shop_city,u.user_id,u.rank_id,ur.rank_id,ur.rank_name,
		s.shop_province,s.shop_city	FROM `$t_goods` AS g,`$t_users` AS u,`$t_shop_info` AS s,`$t_user_rank` AS ur WHERE g.brand_id='$brand_id' and g.shop_id=s.shop_id and g.shop_id=u.user_id and u.rank_id=ur.rank_id";
$result = $dbo->fetch_page($sql,$SYSINFO['product_page']);

$tag_list = get_tag_list($dbo,$t_tag,15);

//print_r($result);

$areainfo = get_areas_kv($dbo,$t_areas);

$k=short_check(get_args("k"));
$cat_id = intval(get_args("cat_id"));
$min_price = intval(get_args("min_price"));
$max_price = intval(get_args("max_price"));
$country = intval(get_args("country"));
$province = intval(get_args("province"));
$city	= intval(get_args("city"));
$district = intval(get_args("district"));
$search_type = short_check(get_args("search_type"));
$search_type = !empty($search_type)?$search_type:$i_langpackage->i_goods_search;
/* 处理系统分类 */
$sql_category = "select c.* from `$t_category` as c, $t_brand_category as b where b.brand_id=$brand_id and c.cat_id=b.cat_id";
$cat_rs = $dbo->getRs($sql_category);



$header['title'] = $i_langpackage->i_brand_detail;
$header['keywords'] = $SYSINFO['sys_keywords'];
$header['description'] = $SYSINFO['sys_description'];
/* 浏览记录 */
$getcookie = get_hisgoods_cookie();
$goodshistory = array();
if($getcookie) {
	$goodshistory = get_good_shistory($dbo,$getcookie,$t_goods);
}
$sql_best = "SELECT * FROM $t_goods WHERE is_on_sale=1 AND is_best=1 and lock_flg=0 order by pv desc limit 4";
$goods_best = $dbo->getRs($sql_best);
$goods_hot = get_hot_goods($dbo,$t_goods,4);
?>																																								<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo  $header['title'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta name="keywords" content="<?php echo  $header['keywords'];?>" />
<meta name="description" content="<?php echo  $header['description'];?>" />
<base href="<?php echo  $baseUrl;?>" />

<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" type="text/css" rel="stylesheet" />

<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/parts.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>

</head>
<body>
<div id="wrapper">
<?php  include("shop/index_header.php");?>
<!--search end -->
  <div id="contents" class="clearfix" >
		<div id="sub_channel">
	      <ul class="clearfix">
	      	<li>
	          <h3><img src="skin/default/images/part/ttl_channel_all.gif" alt="<?php echo $i_langpackage->i_index;?>" onerror="this.src='skin/default/images/nopic.gif'"/></h3>
	        </li>
	        <li><a href="brand_list.php"><?php echo $i_langpackage->i_brand_list;?></a></li><li><a><?php echo $brand_info['brand_name'];?></a></li>
	      </ul>
	    </div>
    <div class="pro_class brand_intro mg12b">
      <img alt="<?php echo  $brand_info['brand_name'];?>" src="<?php echo  $brand_info['brand_logo'];?>"  onerror="this.src='skin/default/images/no_page.jpg'"><p><span><?php echo $i_langpackage->i_service_tel;?>：</span>400-880-0123<br><span><?php echo $i_langpackage->i_company_website;?>：</span><?php echo  $brand_info['site_url'];?>
  </p><p><?php echo  $brand_info['brand_desc'];?></p></div>

    	<!-- leftColumn -->
		<div id="leftColumn">
			  <div class="SubCategoryBox mg12b">
				<h3><?php echo $i_langpackage->i_category_filter;?></h3>
				<ul>
				  <li><span><?php echo $i_langpackage->i_category;?>：</span><a class="active" > <?php echo $i_langpackage->i_all;?></a>
				  <?php foreach($cat_rs as $k=>$v){?>
				  <a href="category.php?id=<?php echo $v['cat_id'];?>&brand_id=<?php echo  $brand_info['brand_id'];?>"> <?php echo  $v['cat_name'];?></a>
				  <?php }?>
				  </li>
				</ul>
			  </div>
		  	  <div id="leftMian">
        <div class="top clearfix ">
          <h3 class="ttlm_selitems"><?php echo $i_langpackage->i_choice_good;?></h3>
          <ul class="toolbar">
            <a id="list" class="selected"  hidefocus="true" href="javascript:void(0);" onclick="changeStyle2('list',this)"><?php echo $i_langpackage->i_list;?></a><a id="window" hidefocus="true" href="javascript:void(0);" onclick="changeStyle2('window',this)"><?php echo $i_langpackage->i_show_window;?></a>
          </ul>
        </div>
        <div id="listItems" class="c_m">
          <ul class="list_title clearfix">
            <li class="summary"><?php echo $i_langpackage->i_goods_infos;?></li>
            <li class="price"><?php echo $i_langpackage->i_price;?></li>
            <li class="address"><?php echo $i_langpackage->i_in_area;?></li>
            <li class="operating"><?php echo $i_langpackage->i_handle;?></li>
          </ul><?php foreach($result['result'] as $k=>$v){?>
          <ul class="list_view">

            <li id="showli_<?php echo $v['goods_id'];?>" class="clearfix">
              <div class="photo"><a target="_blank" href="<?php echo  goods_url($v['goods_id']);?>"><img onmouseout="hidebox(<?php echo $v['goods_id'];?>)" onmouseover="showbox(<?php echo $v['goods_id'];?>)" src="<?php echo  $v['is_set_image'] ? $v['goods_thumb'] : 'skin/default/images/nopic.gif';?>"  width="<?php echo $SYSINFO['width1'];?>" height="<?php echo $SYSINFO['height1'];?>"  alt="<?php echo $v['goods_name'];?>" onerror="this.src='skin/default/images/nopic.gif'"/></a></div>
              <div class="smmery">
                <h4><a href="<?php echo  goods_url($v['goods_id']);?>"><?php echo  sub_str($v['goods_name'],40);?></a></h4>
                <p class="des">[<?php echo $i_langpackage->i_description;?>]<?php echo  sub_str($v['goods_name'],30);?></p>
                <p class="shopinfo"><?php echo $i_langpackage->i_shop;?>：<a class="seller" href="<?php echo  shop_url($v['shop_id']);?>"><?php echo  $v['shop_name'];?></a> <?php echo  $v['rank_name'];?></p>
              </div>
              <div class="price"> <em><?php echo $i_langpackage->i_money_sign;?><?php echo  $v['goods_price']=='0.00' ? $i_langpackage->i_price_discuss : $v['goods_price'];?></em>
                <p class="ship"><?php echo $i_langpackage->i_freight;?>：<?php echo $v['transport_price']>0?$v['transport_price']:$v['transport_template_price'];?></p>
              </div>
              <div class="address">
                <p><?php echo  $areainfo[$v['shop_province']];?>.<?php echo  $areainfo[$v['shop_city']];?></p>
              </div>
              <div class="operating"> <a class="addfavorite" title="<?php echo $i_langpackage->i_collection;?>" href="<?php echo  goods_url($v['goods_id']);?>"></a>
              <a class="itembuy" title="<?php echo $i_langpackage->i_buy;?>" href="modules.php?app=user_order&gid=<?php echo $v['goods_id'];?>&v=1"></a>
              <a class="compare" title="<?php echo $i_langpackage->i_contrast;?>" href="javascript:;" onclick="initFloatTips('<?php echo $v['goods_id'];?>','<?php echo sub_str($v['goods_name'],10);?>',1,'<?php echo $v['cat_id'];?>')"></a> </div>
              <div style="display: none;" id="showbox_<?php echo $v['goods_id'];?>" class="showbox">
				<div class="subbox"><img id="showimg_<?php echo $v['goods_id'];?>" src="<?php echo  $v['is_set_image'] ? $v['goods_thumb'] : 'skin/default/images/nopic.gif';?>" width="234" height="234" alt="<?php echo $i_langpackage->i_loading_img;?>" onerror="this.src='skin/default/images/nopic.gif'"/></div>
			  </div>
            </li>

          </ul>
          <?php }?>

        </div>
		 <div class="pagenav clearfix">
			<?php if($result['countpage']>0){?>
        	<?php  include("modules/page.php");?>
            <?php  } else {?>
            <p style="padding:20px 0 0 20px"><?php echo $i_langpackage->i_no_product;?>！</p>
            <?php }?>
         </div>
    </div>
    </div>
		<div id="rightColumn">

			  <div class="tagSet bg_gary mg12b">
				<h3 class="ttlm_hottag"><?php echo $i_langpackage->i_hot_label;?></h3>
				<div class="tags">
			<?php foreach($tag_list as $value){?>
        	<a href="<?php echo $value['url'];?>" style="color:<?php echo $value['tag_color'];?>;<?php if($value['is_blod']){?>font-weight:bold;<?php }?>"><?php echo $value['tag_name'];?></a>
        	<?php }?> </div>
			  </div>
			  <div class="hotgoods bg_gary mg12b">
				<h3 class="ttlm_hotgoods"><?php echo $i_langpackage->i_hot;?></h3>
				<ul>
					<?php  foreach($goods_hot as $k=> $value){?>
						<li <?php if($k%2!=0){?>class="doublenum"<?php }?>>
						<p class="photo"><a href="<?php echo  goods_url($value['goods_id']);?>" target="_blank"><img src="<?php echo  $value['is_set_image'] ? $value['goods_thumb'] : 'skin/default/images/nopic.gif';?>" alt="<?php echo  $value['goods_name'];?>" width="58" height="58" onerror="this.src='skin/default/images/nopic.gif'"/></a></p>
						<h4><a href="<?php echo  goods_url($value['goods_id']);?>" target="_blank"><?php echo  sub_str($value['goods_name'],14,false);?></a></h4>
						<p class="price"><?php echo $i_langpackage->i_money_sign;?><?php echo $value['goods_price'];?></p>
				    </li>
				  	<?php }?>
				</ul>
			  </div>
			  <div class="viewrecord bg_gary mg12b">
				<h3 class="ttlm_viewrecord"><?php echo $i_langpackage->i_new;?></h3>
				<ul class="clearfix">
				  <?php  foreach($goodshistory as $k => $value){?>
	              	  	<li <?php if($k%2!=0){?>class="lst"<?php }?>>
	              	  	<p class="photo">
		              	  	<a href="<?php echo  goods_url($value['goods_id']);?>">
		              	  		<img src="<?php echo  $value['is_set_image'] ? $value['goods_thumb'] : 'skin/default/images/nopic.gif';?>" width="58" height="58" onerror="this.src='skin/default/images/nopic.gif'"/>
		              	  	</a>
	              	  	</p>
						<p class="price"><?php echo $i_langpackage->i_money_sign;?><?php echo $value['goods_price'];?></p>
	              	  </li>
				  <?php }?>
				</ul>
			</div>
      <!-- /rightColumn -->
    	</div>
     </div>
<!--main right end-->
<?php  require("shop/index_footer.php");?>
<!--footer end-->
</div>
</body>
<div id="contrastbox" style="z-index:999;position:absolute;right:0; border:1px solid #f1f1f1; background:#f8f8f8; display:none; width:188px;margin-right:10px;padding:10px 0 12px 13px; ">
	<form action="modules.php?app=contrast" method="post" target="_blank" id="contrastform">
		<input type="hidden" name="contrast_goods_num" id="contrast_goods_num" value="0" />
		<input type="hidden" name="contrast_goods_id" id="contrast_goods_id" value="" />
		<input type="hidden" name="contrast_cid" id="contrast_cid" value="" />
		<input type="hidden" name="contrast_goods_name" id="contrast_goods_name" value="" />
		<div id="contrast_goods_name_show"></div>
		<!--<input type="submit" name="sub" value="对比" /> -->
        <a class="control" onclick="document.getElementById('contrastform').submit();return false;" href="javascript:;" class="button_4"><?php echo $i_langpackage->i_start_compare;?></a>
	</form>
</div>

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