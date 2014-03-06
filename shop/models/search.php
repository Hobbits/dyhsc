<?php
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
?>