<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/search.html
 * 如果您的模型要进行修改，请修改 models/search.php
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
if(filemtime("templates/default/search.html") > filemtime(__file__) || (file_exists("models/search.php") && filemtime("models/search.php") > filemtime(__file__)) ) {
	tpl_engine("default","search.html",1);
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
require("foundation/module_nav.php");

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
$t_nav = $tablePreStr."nav";
$t_shop_categories = $tablePreStr."shop_categories";
$t_shop_request = $tablePreStr."shop_request";

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();
$k=short_check1(get_args("k"));
$brand_id = intval(get_args("brand_id"));
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
//统计关键词
if($k!="请输入你要搜索的关键字" && $k!=""){
	$k_sql="select * from $t_keywords_count where keywords='$k'";
	$id_row=$dbo->getRow($k_sql);

	if(empty($id_row)){
		$time = $ctime->time_stamp();
		if($k!="请输入你要搜索的关键字"){
			$k_sql="insert into $t_keywords_count(keywords,count,day,week,month,dataline) value('$k',1,1,1,1,$time)";
			$dbo->exeUpdate($k_sql);
		}
	}else{
		$time = $ctime->time_stamp();
		$id=$id_row['id'];
		$day_time=mktime(0,0,0,$ctime->custom('m'),$ctime->custom('d'),$ctime->custom('Y'));
		$w=$ctime->custom('w');
		$week_time=mktime(0,0,0,$ctime->custom('m'),$ctime->custom('d')-$w,$ctime->custom('Y'));
		$month_time=mktime(0,0,0,$ctime->custom('m'),1,$ctime->custom('Y'));
		if($id_row['dataline']>$day_time){
			$k_sql="update $t_keywords_count set count=count+1,day=day+1,week=week+1,month=month+1,dataline=$time where id=$id";
		}
		else if($id_row['dataline']>$week_time){
			$k_sql="update $t_keywords_count set count=count+1,day=1,week=week+1,month=month+1,dataline=$time where id=$id";
		}
		else if($id_row['dataline']>$month_time){
			$k_sql="update $t_keywords_count set count=count+1,day=1,week=1,month=month+1,dataline=$time where id=$id";
		}
		else{
			$k_sql="update $t_keywords_count set count=count+1,day=1,week=1,month=1,dataline=$time where id=$id";
		}
			$dbo->exeUpdate($k_sql);
	}
}
		
if ($search_type==$i_langpackage->i_goods_search) {
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

	$sql="SELECT g.pv,g.is_set_image,g.brand_id,g.transport_price,g.transport_template_price,g.goods_thumb,g.goods_id,g.cat_id,g.goods_name,g.goods_price,g.goods_intro,g.shop_id,s.shop_id,s.shop_name,s.user_id,s.shop_country,s.shop_province,s.shop_district,s.shop_city,u.user_id,u.rank_id,ur.rank_id,ur.rank_name,
				s.shop_province,s.shop_city	FROM `$t_goods` AS g,`$t_users` AS u,`$t_shop_info` AS s,`$t_user_rank` AS ur WHERE g.lock_flg<>1 ";
	if ($brand_id) {
		$sql.="AND g.brand_id='$brand_id'";
	}
	if ($min_price) {
		$sql.=" AND g.goods_price>'$min_price'";
	}
	if ($max_price) {
		$sql.=" AND g.goods_price<'$max_price'";
	}
	if ($province) {
		$sql.=" AND s.shop_province='$province'";
	}
	if ($country) {
		$sql.=" AND s.shop_country='$country'";
	}
	if ($city) {
		$sql.=" AND s.shop_city='$city'";
	}
	if ($district) {
		$sql.=" AND s.shop_district='$district'";
	}
	global $ks;
    global $redks;
	if ($k&&$k!=$i_langpackage->i_search_keyword) {
		$tag_sql="SELECT distinct goods_id FROM $t_tag WHERE tag_name='$k'";
		$tag_list = $dbo->getRs($tag_sql);
		foreach ($tag_list as $key=>$v){
			$tag_list[$key]=$v['goods_id'];
		}
		$goods_sql = "";
		$k=str_replace("　"," ",$k);
		$k=str_replace("'","\'",$k);
		$k=str_replace("\"","\\\"",$k);
		$k=str_replace("%","\%",$k);
		$k=str_replace("#","\#",$k);
		$k=addslashes($k);
		$ks = explode(' ', $k);
		
		$n_conditions = array();
		$k_conditions = array(); 
		
		foreach($ks as $key)
		{
		    if (!empty($key))
		    {
		        $n_conditions[] = "goods_name like '%$key%'";
		     //   $k_conditions[] = "keyword like '%$key%'";
		        $redks[]="<font color='red'>$key</font>";
		    }
		}
		                
		if (!empty($n_conditions) )
		{
		    $filter = '('.implode(' OR ', $n_conditions).')';
		    $goods_sql = " WHERE $filter";
		                        
		  //  $filter = '('.implode(' OR ', $k_conditions).')';
		  //  $goods_sql .= ' OR ' . $filter;
		}
		                                
		$goods_sql = "SELECT distinct goods_id FROM $t_goods" . $goods_sql;

		$goods_list = $dbo->getRs($goods_sql);
		foreach ($goods_list as $key2=>$v2){
			$goods_list[$key2]=$v2['goods_id'];
		}
		$goods_ids=implode(",",$goods_list);
		
		if($goods_list&&$tag_list){
			$goods_ids=$goods_ids.",";
		}
		$goods_ids .= implode(",",$tag_list);
		$arr = explode(",",$goods_ids);
		$arr = array_unique($arr);
		$goods_ids = implode(",",$arr);
		if($goods_ids==""){
			$goods_ids="0";
		}
		$sql.=" AND g.goods_id IN ($goods_ids) ";
	
	}
	if(isset($catids)) {
		$sql.=" AND g.cat_id IN ($catids)";
	}
	$sql.="and g.is_on_sale=1 AND g.shop_id=s.shop_id AND s.user_id=u.user_id AND u.rank_id=ur.rank_id ";
	
	$areainfo = get_areas_kv($dbo,$t_areas);
	$result = $dbo->fetch_page($sql,$SYSINFO['product_page']);
	$goods_list=$result['result'];
	unset($result['result']);
	$type_search=1;
	$k = urlencode($k);
	$result['preurl']=str_replace("?","?k=$k&brand_id=$brand_id&cat_id=$cat_id",$result['preurl']);
	$result['nopage']=str_replace("?","?k=$k&brand_id=$brand_id&cat_id=$cat_id",$result['nopage']);
	$result['nexturl']=str_replace("?","?k=$k&brand_id=$brand_id&cat_id=$cat_id",$result['nexturl']);



//	echo $k;
}else{

	$sql_category = "select * from `$t_shop_categories` order by sort_order asc,cat_id asc";
	$result = $dbo->getRs($sql_category);
	$CATEGORY = array();
	$cat_info = array();
	$is_parent_id = false;
	foreach($result as $v) {
		if($v['cat_id']==$cat_id && $v['parent_id']==0){
			$is_parent_id = true;
			break;
		}
	}
	foreach($result as $v) {
		$CATEGORY[$v['parent_id']][$v['cat_id']] = $v;
		$cat_info[$v['cat_id']] = $v;
	}
	$areainfo = get_areas_kv($dbo,$t_areas);
	if($is_parent_id){
		$sql="SELECT s.shop_id,s.shop_name,s.user_id,s.shop_logo,s.shop_country,s.open_flg,s.lock_flg,s.shop_province,s.shop_district,
			s.shop_city,u.user_name,u.rank_id,ur.rank_id,ur.rank_name,s.goods_num,s.shop_domain 
			FROM imall_shop_info AS s 
			join imall_users AS u on s.user_id=u.user_id
			join imall_user_rank AS ur on u.rank_id=ur.rank_id
			join (SELECT cat_id from imall_shop_categories where parent_id=$cat_id ) as sc  on s.shop_categories =sc.cat_id 
			WHERE s.lock_flg <>'1' and s.open_flg='0'";
	}else if($cat_id){
		$sql="SELECT distinct s.shop_id,s.shop_name,s.user_id,s.shop_logo,s.shop_country,s.open_flg,s.lock_flg,s.shop_province,s.shop_district,
		s.shop_city,u.user_name,u.rank_id,ur.rank_id,ur.rank_name,s.goods_num,s.shop_domain 
		FROM $t_shop_info AS s,$t_users AS u,$t_user_rank AS ur,$t_shop_categories as sc ,$t_shop_request as sr
		WHERE sr.status=1 and sr.user_id=s.user_id and s.lock_flg <>'1' and s.open_flg='0' AND s.user_id=u.user_id AND u.rank_id=ur.rank_id and s.shop_categories = sc.cat_id and s.shop_categories=$cat_id";
	}
	else{
		$sql="SELECT distinct s.shop_id,s.shop_name,s.user_id,s.shop_logo,s.shop_country,s.open_flg,s.lock_flg,s.shop_province,s.shop_district,
		s.shop_city,u.user_name,u.rank_id,ur.rank_id,ur.rank_name,s.goods_num,s.shop_domain 
		FROM $t_shop_info AS s,$t_users AS u,$t_user_rank AS ur ,$t_shop_request as sr
		WHERE sr.status=1 and sr.user_id=s.user_id and s.lock_flg <>'1' and s.open_flg='0' AND s.user_id=u.user_id AND u.rank_id=ur.rank_id";
	}
	
	global $ks;
    global $redks;
    
	if ($k&&$k!=$i_langpackage->i_search_keyword) {
		$goods_sql = "";
		
		$k=str_replace("　"," ",$k);
		$k=str_replace("'","\'",$k);
		$k=str_replace("\"","\\\"",$k);
		$k=str_replace("%","\%",$k);
		$k=str_replace("#","\#",$k);
		$k=addslashes($k);
		$ks = explode(' ', $k);
		
		$n_conditions = array();
		$k_conditions = array(); 
		
		foreach($ks as $key)
		{
		    if (!empty($key))
		    {
		        $n_conditions[] = "s.shop_name like '%$key%'";
		        $redks[]="<font color='red'>$key</font>";
		    }
		}
		                
		if (!empty($n_conditions) )
		{   
		    $filter = '('.implode(' OR ', $n_conditions).')';
		    $sql.=" AND $filter";
		}
	}
	$sql.=" group by s.shop_id ASC";
	$result = $dbo->fetch_page($sql,$SYSINFO['product_page']);
	$type_search=2;
	$k = urlencode($k);
}
$header['title'] = $i_langpackage->i_s_result;//"搜索结果";
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
$tag_list = get_tag_list($dbo,$t_tag,15);
$nav_list = get_nav_list($t_nav,$dbo);

$viewlist="display:block";
$viewwindow="display:none";
$viewselect="";
if(isset($_COOKIE['goodsListClass'])){
	if ($_COOKIE['goodsListClass']=='windowItems'){
		$viewlist="display:none";
		$viewwindow="display:block";
		$viewselect="selected";
	}
}

/* 处理系统分类 */
$sql_category = "select * from `$t_category` order by sort_order asc,cat_id asc,sort_order asc";
$result_category = $dbo->getRs($sql_category);

$CATEGORY1 = array();
if($result_category) {
	foreach($result_category as $v) {
		$CATEGORY1[$v['parent_id']][$v['cat_id']] = $v;

	}
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo  $header['title'];?></title>
<meta name="keywords" content="<?php echo  $header['keywords'];?>" />
<meta name="description" content="<?php echo  $header['description'];?>" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" type="text/css" rel="stylesheet" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/parts.css" type="text/css" rel="stylesheet" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/index.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<base href="<?php echo  $baseUrl;?>" />
</head>
<body>
<!-- wrapper -->
<div id="wrapper">
	<!-- header -->
	<?php  include("shop/index_header.php");?>
	<!-- /header -->
	<!-- contents -->
	<div id="contents" class="clearfix" >
		<div id="channel" class="clearfix">
			<ul class="clearfix">
				<li >
					<h2><img onmouseover="show_obj('category_box1')" onmouseout="hidden_obj('category_box1')" src="skin/default/images/ttl_channel_all.gif" alt="<?php echo $i_langpackage->i_allgoodsheader_category;?>" /></h2>
				</li>
				<?php  foreach($nav_list as  $value){?>
				<li><span><a href="<?php echo  $value['url'];?>"><?php echo  $value['nav_name'];?></a>|</span></li>
				<?php }?>
			</ul>
		</div>
	</div>
	<div id="category_box1" class="allMerchan" style="display:none;" onmouseover="show_obj(this)"  onmouseout="hidden_obj(this)">
		<ul  >
			<?php  foreach(array_slice ($CATEGORY1[0], 0) as $key=>$cat){?>
			<li class="clearfix">
				<h3><a href="<?php echo  category_url($cat['cat_id']);?>" title="<?php echo  $cat['cat_name'];?>"><?php echo  $cat['cat_name'];?></a></h3>
				<?php if(isset($CATEGORY1[$cat['cat_id']]) && $CATEGORY1[$cat['cat_id']]){?>
				<p> <?php  foreach(array_slice ($CATEGORY1[$cat['cat_id']], 0, 8) as $subcat){?> <a href="<?php echo  category_url($subcat['cat_id']);?>" title="<?php echo  $cat['cat_name'];?>"><?php echo  $subcat['cat_name'];?></a>|
					<?php }?> </p>
				<?php }?> </li>
			<?php }?>
		</ul>
	</div>
	<div class="SubCategoryBox mg12b">
		<h3><?php echo $i_langpackage->i_category_filter;?></h3>
		<?php if($search_type==$i_langpackage->i_goods_search){?>
		<ul>
			<?php  foreach(array_slice ($CATEGORY[0], 0) as $key=>$cat){?>
			<li class="clearfix"><span><a href="category.php?id=<?php echo  $cat['cat_id'];?>&k=<?php echo  $k;?>" title="<?php echo  $cat['cat_name'];?>"><?php echo  $cat['cat_name'];?></a>：</span> <?php if(isset($CATEGORY[$cat['cat_id']]) && $CATEGORY[$cat['cat_id']]){?>
				<?php  foreach(array_slice ($CATEGORY[$cat['cat_id']], 0) as $subcat){?> <a href="category.php?id=<?php echo  $subcat['cat_id'];?>&k=<?php echo  $k;?>" title="<?php echo  $cat['cat_name'];?>"><?php echo  $subcat['cat_name'];?></a> <?php }?>
				<?php }?> </li>
			<?php }?>
		</ul>
		<?php }else {?>
		<ul>
			<?php  foreach(array_slice ($CATEGORY[0], 0) as $key=>$cat){?>
			<li class="clearfix"> <span> <?php if($cat['cat_id']==$cat_id){?> <a class='active' href="search.php?cat_id=<?php echo  $cat['cat_id'];?>&k=<?php echo  $k;?>&search_type='<?php echo  $i_langpackage->i_s_company;?>'" title="<?php echo  $cat['cat_name'];?>"><?php echo  $cat['cat_name'];?></a>：
				<?php }else {?> <a href="search.php?cat_id=<?php echo  $cat['cat_id'];?>&k=<?php echo  $k;?>&search_type='<?php echo  $i_langpackage->i_s_company;?>'" title="<?php echo  $cat['cat_name'];?>"><?php echo  $cat['cat_name'];?></a>：
				<?php }?> </span> <?php if(isset($CATEGORY[$cat['cat_id']]) && $CATEGORY[$cat['cat_id']]){?>
				<?php  foreach(array_slice ($CATEGORY[$cat['cat_id']], 0) as $subcat){?>
				<?php if($subcat['cat_id']==$cat_id){?> <a class='active' href="search.php?id=<?php echo  $subcat['cat_id'];?>&k=<?php echo  $k;?>&search_type='<?php echo  $i_langpackage->i_s_company;?>'" title="<?php echo  $cat['cat_name'];?>"><?php echo  $subcat['cat_name'];?></a> <?php }else {?> <a href="search.php?cat_id=<?php echo  $subcat['cat_id'];?>&k=<?php echo  $k;?>&search_type='<?php echo  $i_langpackage->i_s_company;?>'" title="<?php echo  $cat['cat_name'];?>"><?php echo  $subcat['cat_name'];?></a> <?php }?> 
				<?php }?>
				<?php }?> </li>
			<?php }?>
		</ul>
		<?php }?> </div>
	<?php if($type_search==1){?>
	<div id="category_box" class="allMerchan" style="display:none;background-color:#fff;width:690px;padding:10px;position:absolute; top:147px; left:0; z-index:100" onmouseover="show_obj(this)"  onmouseout="hidden_obj(this)">
		<ul>
			<?php  foreach(array_slice ($CATEGORY[0], 0) as $key=>$cat){?>
			<li class="clearfix">
				<h3><a href="<?php echo  category_url($cat['cat_id']);?>" title="<?php echo  $cat['cat_name'];?>"><?php echo  $cat['cat_name'];?></a></h3>
				<?php if(isset($CATEGORY[$cat['cat_id']]) && $CATEGORY[$cat['cat_id']]){?>
				<p> <?php  foreach(array_slice ($CATEGORY[$cat['cat_id']], 0) as $subcat){?> <a href="<?php echo  category_url($subcat['cat_id']);?>" title="<?php echo  $cat['cat_name'];?>"><?php echo  $subcat['cat_name'];?></a> <?php }?> </p>
				<?php }?> </li>
			<?php }?>
		</ul>
	</div>
	<!-- leftColumn -->
	<div id="leftColumn">
		<div id="leftMian">
			<div class="top clearfix">
				<h3 class="ttlm_selitems"><?php echo $i_langpackage->i_choice_good;?></h3>
				<div class="toolbar"> <a id="list" class="<?php echo  $viewselect?'':'selected' ;?>"  hidefocus="true" href="javascript:void(0);" onclick="changeStyle2('list',this)"><?php echo $i_langpackage->i_list;?></a> <a id="window" class="<?php echo  $viewselect ;?>" hidefocus="true" href="javascript:void(0);" onclick="changeStyle2('window',this)"><?php echo $i_langpackage->i_show_window;?></a> </div>
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
						<div class="photo"><a target="_blank" href="<?php echo  goods_url($v['goods_id']);?>"><img onmouseout="hidebox(<?php echo $v['goods_id'];?>)" onmouseover="showbox(<?php echo $v['goods_id'];?>)" src="<?php echo  $v['is_set_image'] ? $v['goods_thumb'] : 'skin/default/images/nopic.gif';?>"  width="<?php echo $SYSINFO['width1'];?>" height="<?php echo $SYSINFO['height1'];?>"  alt="<?php echo $v['goods_name'];?>" onerror="this.src='skin/default/images/nopic.gif'"/></a></div>
						<div class="smmery">
							<h4><a href="<?php echo  goods_url($v['goods_id']);?>"><?php echo  str_replace($ks,$redks,sub_str($v['goods_name'],40));?></a></h4>
							<p class="des">[<?php echo $i_langpackage->i_description;?>]<?php echo  sub_str($v['goods_name'],30);?></p>
							<p class="shopinfo"><?php echo $i_langpackage->i_shop;?>：<a class="seller" href="<?php echo  shop_url($v['shop_id']);?>"><?php echo  $v['shop_name'];?></a> <?php echo  $v['rank_name'];?></p>
						</div>
						<div class="price"> <em><?php echo $i_langpackage->i_money_sign;?><?php echo  $v['goods_price']=='0.00' ? $i_langpackage->i_price_discuss : $v['goods_price'];?></em>
							<p class="ship"><?php echo $i_langpackage->i_freight;?>：<?php echo $v['transport_price']>0?$v['transport_price']:$v['transport_template_price'];?></p>
						</div>
						<div class="address">
							<p><?php echo  $areainfo[$v['shop_province']];?>.<?php echo  $areainfo[$v['shop_city']];?></p>
						</div>
						<div class="operating"> <a class="addfavorite" title="<?php echo $i_langpackage->i_collection;?>" href="javascript:addFavorite(<?php echo  $v['goods_id'];?>,<?php echo  $v['shop_id'];?>,<?php echo $USER['user_id']!=''?$USER['user_id']:'0';?>);"></a> <?php if($v['goods_price']=='0.00'){?> <a class="ask" title="<?php echo $i_langpackage->i_inquiry;?>" href="modules.php?app=user_order_adress&gid=<?php echo $v['goods_id'];?>&v=1"></a> <?php }else{?> <a class="itembuy" title="<?php echo $i_langpackage->i_buy;?>" href="modules.php?app=user_order_adress&gid=<?php echo $v['goods_id'];?>&v=1"></a> <?php }?> <a class="compare" title="<?php echo $i_langpackage->i_contrast;?>" href="javascript:;" onclick="initFloatTips('<?php echo $v['goods_id'];?>','<?php echo sub_str($v['goods_name'],10);?>',1,'<?php echo $v['cat_id'];?>')"></a> </div>
						<div style="display: none;" id="showbox_<?php echo $v['goods_id'];?>" class="showbox">
							<div class="subbox"><img id="showimg_<?php echo $v['goods_id'];?>" src="<?php echo  $v['is_set_image'] ? $v['goods_thumb'] : 'skin/default/images/nopic.gif';?>" width="234" height="234" alt="<?php echo $i_langpackage->i_loading_img;?>" onerror="this.src='skin/default/images/nopic.gif'"/></div>
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
						<div class="photo"><a target="_blank" href="<?php echo  goods_url($v['goods_id']);?>"><img onmouseout="hidebox(<?php echo $v['goods_id'];?>)" onmouseover="showbox(<?php echo $v['goods_id'];?>)" src="<?php echo  $v['is_set_image'] ? str_replace('thumb_','',$v['goods_thumb']) : 'skin/default/images/nopic.gif';?>"  width="190" height="190"  alt="<?php echo $v['goods_name'];?>" onerror="this.src='skin/default/images/nopic.gif'"/></a></div>
						<div class="smmery">
							<h4><a href="<?php echo  goods_url($v['goods_id']);?>"><?php echo  str_replace($ks,$redks,sub_str($v['goods_name'],40));?></a></h4>
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
								<li> <a class="ask" title="<?php echo $i_langpackage->i_inquiry;?>" href="inquiry.php?gid=<?php echo  $v['goods_id'];?>"></a></li>
								<?php }else{?>
								<li><a class="itembuy" title="<?php echo $i_langpackage->i_buy;?>" href="modules.php?app=user_order_adress&gid=<?php echo $v['goods_id'];?>&v=1"></a> </li>
								<?php }?>
								<li><a class="compare" title="<?php echo $i_langpackage->i_contrast;?>" href="javascript:;" onclick="initFloatTips('<?php echo $v['goods_id'];?>','<?php echo sub_str($v['goods_name'],10);?>',1,'<?php echo $v['cat_id'];?>')"></a></li>
							</ul>
						</div>
						<div style="display: none;" id="showbox_<?php echo $v['goods_id'];?>" class="showbox">
							<div class="subbox"><img id="showimg_<?php echo $v['goods_id'];?>" src="<?php echo  $v['is_set_image'] ? $v['goods_thumb'] : 'skin/default/images/nopic.gif';?>" width="234" height="234" alt="<?php echo $i_langpackage->i_loading_img;?>" onerror="this.src='skin/default/images/nopic.gif'"/></div>
						</div>
					</li>
					<?php }?>
				</ul>
				<!-- 橱窗 -->
			</div>
			<div class="clearfix"></div>
			<div class="pagenav clearfix"> <?php if($result['countpage']>0){?>
				<?php  include("modules/page.php");?>
				<?php  } else {?>
				<?php echo $i_langpackage->i_no_product;?>！
				<?php }?> </div>
		</div>
		<!-- leftColumn -->
		<?php }?>
		<!-- leftColumn -->
		<?php if($type_search==2){?>
		<div id="leftColumn">
			<div id="leftMian">
				<div class="top clearfix">
					<h3 class="ttlm_listshop"><?php echo $i_langpackage->i_like_storelist;?></h3>
				</div>
				<div id="listShop" class="c_m">
					<ul class="list_title clearfix">
						<li class="summary"><?php echo $i_langpackage->i_shop_infomation;?></li>
						<li class="quantity "><?php echo $i_langpackage->i_goods_num;?></li>
						<li class="shopower"><?php echo $i_langpackage->i_shopour;?></li>
						<li class="level"><?php echo $i_langpackage->i_is_vis;?></li>
						<li class="address"><?php echo $i_langpackage->i_locus;?></li>
					</ul>
					<ul class="list_view">
						<?php foreach($result['result'] as $key=>$val){?>
						<li id="showli_<?php echo  isset($e)?$e:'';?>" class="clearfix">
							<div class="photo"> <a target="_blank" href="<?php echo  shop_url($val['shop_id'],'index',$val['shop_domain']);?>"> <img src="<?php echo $val['shop_logo'];?>" alt="<?php echo $val['shop_name'];?>" width="100" height="50" onerror="this.src='skin/default/images/nopic.gif'"/></a></div>
							<div class="smmery">
								<h4><a href="<?php echo  shop_url($val['shop_id'],'index',$val['shop_domain']);?>"><?php echo  str_replace($ks,$redks, $val['shop_name']);?></a></h4>
							</div>
							<div class="quantity"><?php echo $val['goods_num'];?><?php echo $i_langpackage->i_jian;?> </div>
							<div class="shopower"> <?php echo $val['user_name'];?></div>
							<div class="operating"> <?php echo $val['rank_name'];?> </div>
							<div class="address"><?php echo  $areainfo[$val['shop_province']];?>.<?php echo  $areainfo[$val['shop_city']];?></div>
							<div style="display: none;" id="showbox_4" class="showbox">
								<div class="subbox"><img width="234" height="234" alt="" src="docs/goods/2010/04/09/m_2010040910382776.jpg" id="showimg_3" onerror="this.src='skin/default/images/nopic.gif'"> </div>
							</div>
						</li>
						<?php }?>
					</ul>
				</div>
				<div class="pagenav clearfix"> <?php if($result['countpage']>0){?> <a class="upPage"  href="<?php echo 'search.php?search_type='.$i_langpackage->i_s_company.'&k='.$k.'&page='.$result['prepage'];?>"><?php echo $i_langpackage->i_page_pre;?></a> <?php for($i=1;$i<=$result['countpage'];$i++){?> <a <?php if($i==$result['page']){?> class="now" <?php }?> href="<?php echo 'search.php?search_type='.$i_langpackage->i_s_company.'&k='.$k.'&page='.$i;?>" ><?php echo $i;?></a> <?php }?> <a class="nextPage" href="<?php echo 'search.php?search_type='.$i_langpackage->i_s_company.'&k='.$k.'&page='.$result['nextpage'];?>" ><?php echo $i_langpackage->i_page_next;?></a> <?php  } else {?>
					<?php echo $i_langpackage->i_no_shop_1;?>！
					<?php }?> </div>
			</div>
			<!-- leftColumn -->
			<?php }?> </div>
		<!-- rightColumn -->
		<div id="rightColumn">
			<div class="tagSet bg_gary mg12b">
				<h3 class="ttlm_hottag"><?php echo $i_langpackage->i_hot_label;?></h3>
				<div class="tags"> <?php foreach($tag_list as $value){?> <a href="<?php echo $value['url'];?>" style="color:<?php echo $value['tag_color'];?>;<?php if($value['is_blod']){?>font-weight:bold;<?php }?>"><?php echo $value['tag_name'];?></a> <?php }?> </div>
			</div>
			<div class="hotgoods bg_gary mg12b">
				<h3 class="ttlm_hotgoods"><?php echo $i_langpackage->i_goods_commend;?></h3>
				<ul>
					<?php foreach($goods_hot as $k=> $v){?>
					<li  <?php if($k%2!=0){?>class="doublenum"<?php }?>>
						<p class="photo"><a href="<?php echo  goods_url($v['goods_id']);?>" target="_blank"><img src="<?php echo  $v['is_set_image'] ? $v['goods_thumb'] : 'skin/default/images/nopic.gif';?>" alt="" width="58" height="58" onerror="this.src='skin/default/images/nopic.gif'"/></a></p>
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
						<p class="photo"><a href="<?php echo  goods_url($v['goods_id']);?>" target="_blank"><img src="<?php echo  $v['is_set_image'] ? $v['goods_thumb'] : 'skin/default/images/nopic.gif';?>" alt="" width="58" height="58" onerror="this.src='skin/default/images/nopic.gif'"/></a></p>
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
	<!-- /wrapper -->
</div>
</body>
<div id="contrastbox" style="z-index:999;position:absolute;right:0;border:1px solid #ccc; background:#FFF; display:none; width:188px;">
	<form action="modules.php?app=contrast" method="post" target="_blank" id="contrastform">
		<input type="hidden" name="contrast_goods_num" id="contrast_goods_num" value="0" /><input type="hidden" name="contrast_goods_id" id="contrast_goods_id" value="" /><input type="hidden" name="contrast_cid" id="contrast_cid" value="" /><input type="hidden" name="contrast_goods_name" id="contrast_goods_name" value="" />
		<div style="padding-bottom:12px;">
			<h2 style="padding:6px 10px;display:block;background:url(skin/default/images/ttlm_01_bg.gif) repeat-x left top;font-size:14px;font-weight:bolder;color:#F77A07;border-bottom:1px solid #ccc"><?php echo $i_langpackage->i_contract_goods;?></h2>
			<a onclick="clearItems()" style="float:right; position:relative; top:-23px;right:10px" href="javascript:void(0);"><?php echo $i_langpackage->i_close;?></a>
			<div id="contrast_goods_name_show"></div>
		</div>
		<a onclick="document.getElementById('contrastform').submit();return false;" href="javascript:;" class="button_4" style=" position:relative;top:25px;display:block;margin-left:100px; width:76px;height:24px;"><img src="skin/default/images/icon_contrast.gif" alt="<?php echo $i_langpackage->i_start_compare;?>"  /></a>
	</form>
</div>
<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
<!--
function clearItems(){

	document.getElementById("contrastbox").style.display='none';
	document.getElementById("contrast_goods_name_show").innerHTML=''
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