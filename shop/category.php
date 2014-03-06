<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/category.html
 * 如果您的模型要进行修改，请修改 models/category.php
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
if(filemtime("templates/default/category.html") > filemtime(__file__) || (file_exists("models/category.php") && filemtime("models/category.php") > filemtime(__file__)) ) {
	tpl_engine("default","category.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
header("content-type:text/html;charset=utf-8");
$IWEB_SHOP_IN = true;
require("foundation/asession.php");
require("configuration.php");
require("foundation/module_category.php");
require("foundation/module_tag.php");
require("includes.php");
require_once("foundation/fstring.php");
require_once("foundation/module_areas.php");
error_reporting(1);
/* URL信息处理 */
$cat_id = intval(get_args('id'));
//引入语言包
$i_langpackage = new indexlp;

if(empty($cat_id)) {
	trigger_error($i_langpackage->i_illegal);
}

/* 用户信息处理 */
require 'foundation/alogin_cookie.php';
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
$brand_id=get_args("brand_id");
$attr_arr = get_args("attr");


/* 定义文件表 */
$t_shop_info = $tablePreStr."shop_info";
$t_category = $tablePreStr."category";
$t_goods = $tablePreStr."goods";
$t_users = $tablePreStr."users";
$t_areas = $tablePreStr."areas";
$t_attribute = $tablePreStr."attribute";
$t_goods_attr = $tablePreStr."goods_attr";
$t_brand = $tablePreStr."brand";
$t_brand_category = $tablePreStr."brand_category";
$t_user_rank = $tablePreStr."user_rank";
$t_tag = $tablePreStr."tag";

$viewlist="display:block";
$viewwindow="display:none";

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();
/* 处理系统分类 */
$sql_category = "select * from `$t_category` order by sort_order asc,cat_id asc";
$result = $dbo->getRs($sql_category);
$CATEGORY = array();
$cat_info = array();
foreach($result as $v) {
	$CATEGORY[$v['parent_id']][$v['cat_id']] = $v;
}
foreach($result as $v) {
	$cat_info[$v['cat_id']] = $v;
}

/* 列表处理 */
if(!function_exists('getsubcats')) {
	function getsubcats($catinfo, $id) {
		$str = '';
		if(isset($catinfo[$id]) && $catinfo[$id]) {
			foreach($catinfo[$id] as $v) {
				$str .= ",".$v['cat_id'];
				$str .= getsubcats($catinfo, $v['cat_id']);
			}
		}
		return $str;
	}
}
if($cat_id){
	$catids = $cat_id;
	$catids .= getsubcats($CATEGORY, $cat_id);
	$this_catinfo = $cat_info[$cat_id];
	$this_parent_info = '';
	if($cat_info[$cat_id]['parent_id']>0){
		$this_parent_info = $cat_info[$cat_info[$cat_id]['parent_id']];
	}
}
if(isset($attr_arr)&&$attr_arr){
	foreach ($attr_arr as $k=>$v){
		$attr_arr[$k]=short_check($v);
		$attr_id_arr[]="attr[".$k."]";
	}
}
$areainfo = get_areas_kv($dbo,$t_areas);
/* 产品处理 */
$sql_best = "SELECT * FROM $t_goods WHERE is_on_sale=1 AND is_best=1 and lock_flg=0 order by pv desc limit 5";
$sql_hot = "SELECT * FROM $t_goods WHERE is_on_sale=1 AND is_hot=1 and lock_flg=0 order by pv desc limit 5";
$goods_best = $dbo->getRs($sql_best);
$goods_hot = $dbo->getRs($sql_hot);
$areainfo = get_areas_kv($dbo,$t_areas);
$get_arr = $_GET;
$where  = "";
$from = "";
//print_r($get_arr);
$and = '';
foreach($get_arr as $k=>$value){
	if(substr($k,0,4) == 'attr'){
		$num = substr($k,4,strlen($k));
		$and .= "g".$num.".goods_id and g".$num.".goods_id=";
		$where .= " and g".$num.".attr_values = '$value'";
		$from .= "$t_goods_attr as g".$num.",";
	}
}
if($where){
	$sta_num = strpos($and,'and');
	$end_num = strrpos($and,'and');
	$and = substr($and,$sta_num,$end_num-$sta_num);
	$sql = "select * from ".substr($from,0,-1)." where g".$num.".attr_values != ''".$where." ".$and." group by g".$num.".goods_id";
	$result = $dbo->getRs($sql);
	$goods_id = '';
	foreach($result as $value){
		$goods_id .= $value['goods_id'].",";
	}
	if($goods_id != ''){
		$goods_id = substr($goods_id,0,-1);
	}else{
		$goods_id = 0;
	}
	$sql = "SELECT g.pv,g.is_set_image,g.brand_id,g.transport_price,g.transport_template_price,g.goods_thumb,g.goods_id,g.cat_id,g.goods_name,g.goods_price,g.goods_intro,g.shop_id,s.shop_id,s.shop_name,s.user_id,u.user_id,u.rank_id,ur.rank_id,ur.rank_name,
			s.shop_province,s.shop_city	FROM `$t_goods` AS g,`$t_users` AS u,`$t_shop_info` AS s,`$t_user_rank` AS ur WHERE g.lock_flg<>1 and  
		g.goods_id IN ($goods_id) and g.is_on_sale=1 AND g.shop_id=s.shop_id AND s.user_id=u.user_id AND u.rank_id=ur.rank_id ";
}else{
	$sql = "SELECT g.pv,g.is_set_image,g.brand_id,g.transport_price,g.transport_template_price,g.goods_thumb,g.goods_id,g.cat_id,g.goods_name,g.goods_price,g.goods_intro,g.shop_id,s.shop_id,s.shop_name,s.user_id,u.user_id,u.rank_id,ur.rank_id,ur.rank_name,
			s.shop_province,s.shop_city	FROM `$t_goods` AS g,`$t_users` AS u,`$t_shop_info` AS s,`$t_user_rank` AS ur WHERE g.lock_flg<>1 and g.cat_id IN ($catids) AND g.is_on_sale=1 AND g.shop_id=s.shop_id AND s.user_id=u.user_id AND u.rank_id=ur.rank_id ";
}
if ($brand_id>0) {
	$sql.=" AND g.brand_id='$brand_id'";
}
$k=short_check(get_args("k"));
$kk=$k;
//echo $k;

	if ($k&&$k!=$i_langpackage->i_search_keyword) {
		$tag_sql="SELECT distinct goods_id FROM $t_tag WHERE tag_name LIKE '%$k%'";
		$tag_list = $dbo->getRs($tag_sql);
		foreach ($tag_list as $key=>$v){
			$tag_list[$key]=$v['goods_id'];
		}
		$goods_sql="SELECT distinct goods_id FROM $t_goods WHERE goods_name LIKE '%$k%'";
		$goods_list = $dbo->getRs($goods_sql);
		foreach ($goods_list as $key2=>$v2){
			$goods_list[$key2]=$v2['goods_id'];
		}
		$goods_ids=implode(",",$goods_list);
		$goods_ids .= implode(",",$tag_list);
		$arr = explode(",",$goods_ids);
		$arr = array_unique($arr);
		$goods_ids = implode(",",$arr);
		if($goods_ids==""){
			$goods_ids="0";
		}
		$sql.=" AND g.goods_id IN ($goods_ids) ";
//		$k_sql="select * from $t_keywords_count where keywords='$k'";
//		$id_row=$dbo->getRow($k_sql);

	}else{
		$kk='无';
	}
if($_POST){
	$order_name=$_POST['name'];
	$order=$_POST['order'];
	if($order_name){
		$sql.= "ORDER BY g.$order_name $order,g.pv DESC ";
	}else{
		$sql.= "ORDER BY g.pv DESC ";
	}
}else{
	$sql.= "ORDER BY g.goods_price asc,g.pv DESC ";
}

if($cat_id == ''){
	$sql = "SELECT g.pv,g.is_set_image,g.brand_id,g.transport_price,g.transport_template_price,g.goods_thumb,g.goods_id,g.cat_id,g.goods_name,g.goods_price,g.goods_intro,g.shop_id,s.shop_id,s.shop_name,s.user_id,u.user_id,u.rank_id,ur.rank_id,ur.rank_name,
			s.shop_province,s.shop_city	FROM `$t_goods` AS g WHERE g.is_on_sale=1 AND g.shop_id=s.shop_id AND s.user_id=u.user_id AND u.rank_id=ur.rank_id ";

}
$result = $dbo->fetch_page($sql,$SYSINFO['product_page']);
$goods_list=$result['result'];
unset($result['result']);
/* 浏览记录 */
$getcookie = get_hisgoods_cookie();
$goodshistory = array();
if($getcookie) {
	arsort($getcookie);
	$getcookie = array_keys($getcookie);
	$gethisgoodsid = implode(",",array_slice($getcookie, 0, 4));
	$sql = "select is_set_image,goods_id,goods_name,goods_thumb,goods_price from $t_goods where goods_id in ($gethisgoodsid)";
	$goodshistory = $dbo->getRs($sql);
}
$header['title'] = $this_catinfo['cat_name']." - ".$SYSINFO['sys_title'];
$header['keywords'] = $this_catinfo['cat_name'].','.$SYSINFO['sys_keywords'];
$header['description'] = $SYSINFO['sys_description'];
$url_this = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
//print_r($_SERVER);
/* 属性 */
$sql = "select * from $t_attribute where cat_id='$cat_id' order by sort_order ";
$attr_info = $dbo->getRs($sql);
foreach($attr_info as $key => $value){
	$values_after=str_replace(array("\r\n","\r","\n"),',',$value['attr_values']);
	$attr_info[$key]['attr_values']=explode(',',$values_after);

	foreach($attr_info[$key]['attr_values'] as $k => $va){
		$va=trim($va);
		$sql = "select count(*) AS attr_count from $t_goods_attr AS ga, $t_goods AS g where ga.attr_values='$va' and g.is_on_sale=1 and
		g.goods_id=ga.goods_id ";
		$goods_attr_info = $dbo->getRow($sql);
		$attr_info[$key]['values_count'][$k]=$goods_attr_info["attr_count"];
	}
}
//品牌列表
$sql = "SELECT distinct brand_id FROM $t_brand_category WHERE cat_id='$cat_id'";
$list = $dbo->getRs($sql);
$brand_list=array();
if (is_array($list)) {
	foreach ($list as $value){
		$sql="SELECT brand_id,brand_name FROM $t_brand WHERE brand_id='{$value['brand_id']}'";
		$row=$dbo->getRow($sql);
		$brand_list[$row['brand_id']]['brand_id']=$row['brand_id'];
		$brand_list[$row['brand_id']]['brand_name']=$row['brand_name'];
		if(get_args('brand_id')){
        	$url = preg_replace("/brand_id=([^&]+)/","brand_id=".$row['brand_id'],$url_this);
        }else{
        	$url = $url_this."&brand_id=".urlencode($row['brand_id']);
		}
		$brand_list[$row['brand_id']]['url']=$url;
	}
}
array_push($brand_list,array("brand_id"=>0,"brand_name"=>$i_langpackage->i_all,"url"=>preg_replace("/&brand_id=([^&]+)/","",$url_this)));
$brand_list = array_reverse($brand_list);
$nav_selected =4;
$sub_category=get_parent_cats($cat_id,$dbo,$t_category);
$tag_list = get_tag_list($dbo,$t_tag,15);

	/* 处理系统分类 */
$sql_category = "select * from `$t_category` order by sort_order asc,cat_id asc,sort_order asc";
$result_category = $dbo->getRs($sql_category);

$CATEGORY = array();
if($result_category) {
	foreach($result_category as $v) {
		$CATEGORY[$v['parent_id']][$v['cat_id']] = $v;

	}
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta name="keywords" content="<?php echo  $header['keywords'];?>" />
<meta name="description" content="<?php echo  $header['description'];?>" />
<base href="<?php echo  $baseUrl;?>" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" type="text/css" rel="stylesheet" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/index.css" rel="stylesheet" type="text/css" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/parts.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>

<title><?php echo  $header['title'];?></title>
</head>
<body>
<!-- wrapper -->
<div id="wrapper">
  <!-- header -->
  <?php  include("shop/index_header.php");?>
  <!-- /header -->
  <!-- contents -->
  <div id="contents" class="clearfix" >
<div id="sub_channel">
    <ul class="clearfix">
      <li >
        <h3><img onmouseover="show_obj('category_box')" onmouseout="hidden_obj('category_box')" src="skin/<?php echo  $SYSINFO['templates'];?>/images/part/ttl_channel_all.gif" alt="<?php echo $i_langpackage->i_all_category2;?>"  onerror="this.src='skin/default/images/nopic.gif'"/></h3>
      </li>
      <?php foreach($sub_category as $value){?>
      <li><a href="<?php echo $value['url'];?>"><?php echo $value['cat_name'];?></a></li>
      <?php }?>
    </ul>
    </div>
	    <div id="category_box" class="allMerchan" style="display:none" onmouseover="show_obj(this)"  onmouseout="hidden_obj(this)">
        <ul >
        <?php  foreach(array_slice ($CATEGORY[0], 0) as $key=>$cat){?>
        	<li class="clearfix">
            <h3><a href="<?php echo  category_url($cat['cat_id']);?>" title="<?php echo  $cat['cat_name'];?>"><?php echo  $cat['cat_name'];?></a></h3>
            <?php if(isset($CATEGORY[$cat['cat_id']]) && $CATEGORY[$cat['cat_id']]){?>
            <p>
                <?php  foreach(array_slice ($CATEGORY[$cat['cat_id']], 0, 8) as $subcat){?>
                    <a href="<?php echo  category_url($subcat['cat_id']);?>" title="<?php echo  $cat['cat_name'];?>"><?php echo  $subcat['cat_name'];?></a>|
                <?php }?>
             </p>
             <?php }?>
            </li>
		<?php }?>
        </ul>
    </div>
    <!-- leftColumn -->
    <div id="leftColumn">
      <div class="SubCategoryBox mg12b">
        <h3><?php echo $this_catinfo['cat_name'];?>-<?php echo $i_langpackage->i_shop_filter;?></h3>
        <ul>
          <li><span><?php echo $i_langpackage->i_brand;?>：</span>
          	<?php foreach($brand_list as $value){?>
          		<?php if(!empty($value['brand_name'])) {?>
          		<?php if($brand_id==$value['brand_id']) {?>
	                <a class="active" ><?php echo  $value['brand_name'];?></a>
	            <?php }else{?>
	                <a title="<?php echo  $value['brand_name'];?>" href="<?php echo $value['url'];?>"><?php echo  $value['brand_name'];?></a>
	            <?php }?>
	            <?php }?>
          	<?php }?>
          </li>
          <!--<li> <span>价格：</span> <a class="active" href="">全部</a> <a href="">1-999</a> <a href="">999-4500</a> <a href="">4500-9999</a> <a href="">10000以上</a> </li>-->
          <?php  foreach($attr_info as $key => $value){?>
		    <li>
		        <span><?php echo  $value['attr_name'];?>:</span>
	                <?php if(get_args('attr'.$value['attr_id'])) {?>
	                    <a href=<?php echo preg_replace("/&attr".$value['attr_id']."=([^&]+)/","",$url_this);?>><?php echo $i_langpackage->i_all;?></a>
	                <?php }else{?>
	                    <font class="active"><?php echo $i_langpackage->i_all;?></font>
	                <?php }?>
		        <?php  foreach($value['attr_values'] as $k => $v){?>
		            <?php if(get_args('attr'.$value['attr_id'])) {?>
		            <?php $url = preg_replace("/attr".$value['attr_id']."=([^&]+)/","attr".$value['attr_id']."=".urlencode($v),$url_this);?>
		            <?php }else {?>
		            <?php $url = $url_this."&attr".$value['attr_id']."=".urlencode($v);?>
		            <?php }?>
		            <?php if(get_args('attr'.$value['attr_id'])==$v) {?>
		                <a class="active" ><?php echo  $v;?></a>
		            <?php }else{?>
		                <a title="<?php echo  $v;?>" href="<?php echo $url;?>"><?php echo  $v;?></a>
		            <?php }?>
	            <?php }?>
		    </li>
    	<?php }?>
        <li><span><?php echo $i_langpackage->i_keywords;?>：</span><?php echo $kk;?></li>
		</ul>
      </div>
      <div id="leftMian">
        <div class="top clearfix">
          <h3 class="ttlm_selitems"><?php echo $i_langpackage->i_choice_good;?></h3>
          <ul class="toolbar">
            <a id="list" class="selected"  hidefocus="true" href="javascript:void(0);" onclick="changeStyle2('list',this)"><?php echo $i_langpackage->i_list;?></a>
            <a id="window" hidefocus="true" href="javascript:void(0);" onclick="changeStyle2('window',this)"><?php echo $i_langpackage->i_show_window;?></a>
          </ul>
        </div>
        <div id="listItems" class="c_m" style="<?php echo  $viewlist;?>; position:relative">
          <ul class="list_title clearfix">
            <li class="summary"><?php echo $i_langpackage->i_goods_infos;?></li>
            <li class="price"><?php echo $i_langpackage->i_price;?></li>
            <li class="address"><?php echo $i_langpackage->i_in_area;?></li>
            <li class="operating"><?php echo $i_langpackage->i_handle;?></li>
          </ul>
          <ul class="list_view">
         <?php foreach($goods_list as $k=>$v){?>
            <li id="showli_<?php echo $v['goods_id'];?>" class="clearfix">
              <div class="photo"><a target="_blank" href="<?php echo  goods_url($v['goods_id']);?>"><img onmouseout="hidebox(<?php echo $v['goods_id'];?>)" onmouseover="showbox(<?php echo $v['goods_id'];?>)" src="<?php echo  $v['is_set_image'] ? $v['goods_thumb'] : 'skin/default/images/nopic.gif';?>"  width="<?php echo $SYSINFO['width1'];?>" height="<?php echo $SYSINFO['height1'];?>"  alt="<?php echo $v['goods_name'];?>"  onerror="this.src='skin/default/images/nopic.gif'" /></a></div>
              <div class="smmery">
                <h4><a href="<?php echo  goods_url($v['goods_id']);?>"><?php echo  sub_str($v['goods_name'],40);?></a></h4>
                <p class="des">[<?php echo $i_langpackage->i_description;?>]<?php echo  sub_str($v['goods_name'],30);?></p>
                <p class="shopinfo"><?php echo $i_langpackage->i_shop;?>:<a class="seller" href="<?php echo  shop_url($v['shop_id']);?>"><?php echo  $v['shop_name'];?></a> <?php echo  $v['rank_name'];?></p>
              </div>
              <div class="price"> <em><?php echo $i_langpackage->i_money_sign;?><?php echo  $v['goods_price']=='0.00' ? $i_langpackage->i_price_discuss : $v['goods_price'];?></em>
                <p class="ship"><?php echo $i_langpackage->i_freight;?>：<?php echo $v['transport_price']>0?$v['transport_price']:$v['transport_template_price'];?></p>
              </div>
              <div class="address">
                <p><?php echo  $areainfo[$v['shop_province']];?>.<?php echo  $areainfo[$v['shop_city']];?></p>
              </div>
              <div class="operating"> <a class="addfavorite" title="<?php echo $i_langpackage->i_collection;?>" href="javascript:addFavorite(<?php echo  $v['goods_id'];?>,<?php echo  $v['shop_id'];?>,<?php echo $USER['user_id']!=''?$USER['user_id']:'0';?>);"></a> 
              <?php if($v['goods_price']=='0.00') {?>
	               <a class="ask" title="<?php echo $i_langpackage->i_inquiry;?>" href="inquiry.php?gid=<?php echo  $v['goods_id'];?>"></a>
	            <?php }else{?>
	                <a class="itembuy" title="<?php echo $i_langpackage->i_buy;?>" href="modules.php?app=user_order_adress&gid=<?php echo $v['goods_id'];?>&v=1"></a>
	            <?php }?>
               <a class="compare" title="对比" href="javascript:;" onclick="initFloatTips('<?php echo $v['goods_id'];?>','<?php echo sub_str($v['goods_name'],10);?>',1,'<?php echo $v['cat_id'];?>')"></a> </div>
              <div style="display: none;" id="showbox_<?php echo $v['goods_id'];?>" class="showbox">
				<div class="subbox"><img id="showimg_<?php echo $v['goods_id'];?>" src="<?php echo  $v['is_set_image'] ? $v['goods_thumb'] : 'skin/default/images/nopic.gif';?>" width="234" height="234" alt="<?php echo $i_langpackage->i_loading_img;?>"   onerror="this.src='skin/default/images/nopic.gif'"/></div>
			  </div>
            </li>
             <?php }?>
          </ul>
        </div>
        <!-- 橱窗 -->
			<div id="windowItems" class="window_type" style="<?php echo  $viewwindow;?>">
				<ul class="list_view">
					<?php foreach($goods_list as $k=>$v){?>
					<li id="showli_<?php echo $v['goods_id'];?>" class="clearfix">
						<div class="photo"><a target="_blank" href="<?php echo  goods_url($v['goods_id']);?>"><img onmouseout="hidebox(<?php echo $v['goods_id'];?>)" onmouseover="showbox(<?php echo $v['goods_id'];?>)" src="<?php echo  $v['is_set_image'] ? str_replace('thumb_','',$v['goods_thumb']) : 'skin/default/images/nopic.gif';?>"  width="190" height="190"  alt="<?php echo $v['goods_name'];?>"   onerror="this.src='skin/default/images/nopic.gif'"/></a></div>
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
						<div class="operating">
							<ul class="clearfix">
								<li><a class="addfavorite" title="<?php echo $i_langpackage->i_collection;?>" href="javascript:addFavorite(<?php echo  $v['goods_id'];?>,<?php echo  $v['shop_id'];?>,<?php echo $USER['user_id']!=''?$USER['user_id']:'0';?>);"></a></li>
								<?php if($v['goods_price']=='0.00') {?>
					               <li><a class="ask" title="<?php echo $i_langpackage->i_inquiry;?>" href="inquiry.php?gid=<?php echo  $v['goods_id'];?>"></a></li>
					            <?php }else{?>
					                <li><a class="itembuy" title="<?php echo $i_langpackage->i_buy;?>" href="modules.php?app=user_order_adress&gid=<?php echo $v['goods_id'];?>&v=1"></a></li>
					            <?php }?>
								<li><a class="compare" title="<?php echo $i_langpackage->i_contrast;?>" href="javascript:;" onclick="initFloatTips('<?php echo $v['goods_id'];?>','<?php echo sub_str($v['goods_name'],10);?>',1,'<?php echo $v['cat_id'];?>')"></a></li>
							</ul>
						</div>
						<div style="display: none;" id="showbox_<?php echo $v['goods_id'];?>" class="showbox">
							<div class="subbox"><img id="showimg_<?php echo $v['goods_id'];?>" src="<?php echo  $v['is_set_image'] ? $v['goods_thumb'] : 'skin/default/images/nopic.gif';?>" width="234" height="234" alt="<?php echo $i_langpackage->i_loading_img;?>"   onerror="this.src='skin/default/images/nopic.gif'"/></div>
						</div>
					</li>
					<?php }?>
				</ul>
				<!-- 橱窗 -->
			</div>
        <div class="clearfix"></div>
        <div class="pagenav clearfix">
        	<?php if($result['countpage']>0){?>
        	<?php  include("modules/page.php");?>
            <?php  } else {?>
            <?php echo $i_langpackage->i_no_product;?>！
            <?php }?>
          </div>
      </div>
      <!-- leftColumn -->
    </div>
    <!-- rightColumn -->
    <div id="rightColumn">
    <div class="tagSet bg_gary mg12b">
        <h3 class="ttlm_hottag"><?php echo $i_langpackage->i_hot_label;?></h3>
        <div class="tags">
        	<?php foreach($tag_list as $value){?>
        	<a href="<?php echo $value['url'];?>" style="color:<?php echo $value['tag_color'];?>;<?php if($value['is_blod']){?>font-weight:bold;<?php }?>"><?php echo $value['tag_name'];?></a>
        	<?php }?>
		</div>
      </div>
       <div class="hotgoods bg_gary mg12b">
        <h3 class="ttlm_hotgoods"><?php echo $i_langpackage->i_goods_commend;?></h3>
        <ul>
        <?php foreach($goods_hot as $key => $v){?>
        	<li <?php if($key%2!=0){?> class="doublenum"<?php }?>>
	         	 <p class="photo"><a href="<?php echo  goods_url($v['goods_id']);?>" target="_blank"><img src="<?php echo  $v['is_set_image'] ? $v['goods_thumb'] : 'skin/default/images/nopic.gif';?>" alt="" width="58" height="58"  onerror="this.src='skin/default/images/nopic.gif'"/></a></p>
	           <h4><a href="<?php echo  goods_url($v['goods_id']);?>" target="_blank"><?php echo  sub_str($v['goods_name'],38);?></a></h4>
	           <p class="price"><?php echo $i_langpackage->i_money_sign;?><?php echo $v['goods_price'];?></p>
	         </li>
         <?php }?>
        </ul>
        </div>
        <div class="viewrecord bg_gary mg12b">
        <h3 class="ttlm_viewrecord"><?php echo $i_langpackage->i_brower_register;?></h3>
        <ul class="clearfix">
        <?php foreach($goodshistory as $k=> $v){?>
	    	<li <?php if($k%2!=0){?>class="lst"<?php }?>>
	         	<p class="photo"><a href="<?php echo  goods_url($v['goods_id']);?>" target="_blank"><img src="<?php echo  $v['is_set_image'] ? $v['goods_thumb'] : 'skin/default/images/nopic.gif';?>" alt="" width="58" height="58"  onerror="this.src='skin/default/images/nopic.gif'"/></a></p>
	          	<p class="price"><?php echo $i_langpackage->i_money_sign;?><?php echo $v['goods_price'];?></p>
	       </li>
         <?php }?>
        </ul>
        </div>
    <!-- /rightColumn -->
    </div>
    <!-- /contents -->
</div>
  <!-- footer -->
 <?php  require("shop/index_footer.php");?>
    <!-- /footer -->
  </div>
  <!-- /wrapper -->
</div>
</body>
<div id="contrastbox" style="z-index:999;position:absolute;right:0;border:1px solid #ccc; background:#FFF; display:none; width:188px;">
	<form action="modules.php?app=contrast" method="post" target="_blank" id="contrastform">
		<input type="hidden" name="contrast_goods_num" id="contrast_goods_num" value="0" />
		<input type="hidden" name="contrast_goods_id" id="contrast_goods_id" value="" />
		<input type="hidden" name="contrast_cid" id="contrast_cid" value="" />
		<input type="hidden" name="contrast_goods_name" id="contrast_goods_name" value="" />
		<div style="padding-bottom:12px;">
  <h2 style="padding:6px 10px;display:block;background:url(skin/default/images/ttlm_01_bg.gif) repeat-x left top;font-size:14px;font-weight:bolder;color:#F77A07;border-bottom:1px solid #ccc"><?php echo $i_langpackage->i_contract_goods;?></h2> <a onclick="clearItems()" style="float:right; position:relative; top:-23px;right:10px" href="javascript:void(0);"><?php echo $i_langpackage->i_close;?></a>
  <div id="contrast_goods_name_show"></div>
  </div>
		<!--<input type="submit" name="sub" value="对比" /> -->
        <a onclick="document.getElementById('contrastform').submit();return false;" href="javascript:;" class="button_4" style=" position:relative;top:25px;display:block;margin-left:100px; width:76px;height:24px;"><img src="skin/default/images/icon_contrast.gif" alt="<?php echo $i_langpackage->i_start_compare;?>"   onerror="this.src='skin/default/images/nopic.gif'"/></a>
	</form>
</div>
<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
function clearItems(){
	document.getElementById('contrast_goods_id').value ="";
	document.getElementById('contrast_goods_name').value="";
	document.getElementById("contrastbox").style.display='none';
	document.getElementById("contrast_goods_name_show").innerHTML='';
	document.getElementById('contrast_cid').value = '';
}
function delNow(linkitem){
	linkitem.parentNode.parentNode.removeChild(linkitem.parentNode);
	}
function showbox(id) {
	document.getElementById("showbox_"+id).style.display = '';
	var showimg = document.getElementById("showimg_"+id);
	if(showimg.alt=='<?php echo $i_langpackage->i_loading_img;?>') {
		ajax("do.php?act=goods_get_imgurl","POST","id="+id,function(data){
			if(data) {
				showimg.src = data;
				showimg.alt = '';
			}
		});
	}
}
function hidebox(id) {
	document.getElementById("showbox_"+id).style.display = 'none';
}
function addFavorite(id,sid,uid) {
	if(uid=='0'){
		alert("<?php echo  $i_langpackage->i_g_addfailed;?>");
		return;
		}
	if (sid == uid){
		alert('<?php echo $i_langpackage->i_mygoods_error;?>');
	}else {
		ajax("do.php?act=goods_add_favorite","POST","id="+id,function(data){
			if(data == 1) {
				alert("<?php echo  $i_langpackage->i_g_addedfavorite;?>");
			} else if(data == -1) {
				alert("<?php echo  $i_langpackage->i_g_stayfavorite;?>");
			} else {
				alert("<?php echo  $i_langpackage->i_g_addfailed;?>");
			}
		});
	}
}
</script>
<script language="JavaScript" type="text/javascript">
var tips; var theTop = 145/*这是默认高度,越大越往下*/;
var old = theTop;
function initFloatTips(goodsid,goodsname,action,cid) {
	tips = document.getElementById('contrastbox');
	document.getElementById('contrastbox').style.display="";
	var goods_cid = document.getElementById('contrast_cid').value;
	if(goods_cid!=''&& goods_cid!=cid&&action==1){
		alert("<?php echo $i_langpackage->i_compare_error1;?>");
		return;
	}else{
		document.getElementById('contrast_cid').value=cid;
	}
	var goods_num = parseInt(document.getElementById('contrast_goods_num').value);
	var goods_id = document.getElementById('contrast_goods_id').value;
	var goods_name= document.getElementById('contrast_goods_name').value;
	var goods_name_show= document.getElementById('contrast_goods_name_show');
	var goods_id_arr = goods_id.split(",");
	var goods_name_arr = goods_name.split(",");
	if(action==1){
		if(goods_num<5){
			var same_num=0;
			for(i=0;i<goods_id_arr.length;i++){
				if(goods_id_arr[i]==goodsid){
					same_num++;
				}
			}
			if(same_num>0){
				alert("<?php echo $i_langpackage->i_compare_error2;?>");
			}else{
				document.getElementById('contrast_goods_id').value+=goodsid+",";
				document.getElementById('contrast_goods_name').value+=goodsname+",";
				document.getElementById('contrast_goods_num').value=parseInt(goods_num+1);
			}
		}else{
			alert("<?php echo $i_langpackage->i_compare_error3;?>");
		}
	}
	if(action==0){
		var str="";
		var namestr="";
		for(i=0;i<goods_id_arr.length;i++){
			if(goods_id_arr[i]!=goodsid&&goods_id_arr[i]!=''){
				str+=goods_id_arr[i]+",";
				namestr+=goods_name_arr[i]+",";
			}
		}
		document.getElementById('contrast_goods_id').value=str;
		document.getElementById('contrast_goods_name').value=namestr;
	}

	var goods_id_arr = document.getElementById('contrast_goods_id').value.split(",");
	var goods_name_arr = document.getElementById('contrast_goods_name').value.split(",");
	goods_name_show.innerHTML="";
	for(i=0;i<goods_id_arr.length-1;i++){
		goods_name_show.innerHTML+="<li style='padding:8px 0 5px 10px; _padding:8px 0 5px;position:relative;border-bottom:1px solid #f1f1f1;margin-right:10px'>"+"<a href='javascript:;' style='position:absolute;right:0;_right:10px;top:8px;' onclick=\"initFloatTips('"+goods_id_arr[i]+"','"+goods_name_arr[i]+"',0)\"><?php echo $i_langpackage->i_remove;?></a>" + goods_name_arr[i]+"</li>";
	}
	document.getElementById('contrast_goods_num').value=goods_id_arr.length-1;
	if(document.getElementById('contrast_goods_num').value==0){
		document.getElementById('contrastbox').style.display="none";
		document.getElementById('contrast_cid').value="";
	}
	moveTips();
}
function moveTips() {
	var tt=55;
	if (window.innerHeight) {
		pos = window.pageYOffset
	}else if (document.documentElement && document.documentElement.scrollTop) {
		pos = document.documentElement.scrollTop
	}else if (document.body) {
		pos = document.body.scrollTop;
	}
	pos=pos-tips.offsetTop+theTop;
	pos=tips.offsetTop+pos/10;
	if (pos < theTop) {
		pos = theTop
	}
	if (pos != old) {
		tips.style.top = pos+"px";
		tt=10;
	}
	old = pos;
	setTimeout(moveTips,tt);
}
</script>
</html>
<?php } ?>